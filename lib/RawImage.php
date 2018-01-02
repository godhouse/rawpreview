<?php
namespace OCA\RawPreview;

use OCP\Preview\IProvider;
use Imagick;

class RawImage implements IProvider {

	/**
	* {@inheritDoc}
	*/
	public function getMimeType() {
		return '/image\/x-dcraw/';
	}

	/**
	* {@inheritDoc}
	*/
	public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
		//get fileinfo
		$fileInfo = $fileview->getFileInfo($path);
		if (!$fileInfo) {
			return false;
		}
		$maxSizeForImages = \OC::$server->getConfig()->getSystemValue('preview_max_filesize_image', 50);
		$size = $fileInfo->getSize();
		if ($maxSizeForImages !== -1 && $size > ($maxSizeForImages * 1024 * 1024)) {
			return false;
		}

		$tmpPath = $fileview->toTmpFile($path);
		if (!$tmpPath) {
			\OCP\Util::writeLog('RawImage', 'Raw Preview: Temporary copy failed', \OCP\Util::ERROR);
			return false;
		}

		try {
			$im = $this->getResizedPreview($tmpPath, $maxX, $maxY);
		} catch (\Exception $e) {
			\OCP\Util::writeLog('RawImage', 'Raw Preview: ' . $e->getmessage(), \OCP\Util::ERROR);
    			return false;
		}

		$image = new \OC_Image();
		$image->loadFromData($im);
		$image->fixOrientation();

		unlink($tmpPath);


		if ($image->valid()) {
			$image->scaleDownToFit($maxX, $maxY);
			return $image;
		}

		\OCP\Util::writeLog('RawImage', 'Raw Preview: Image not valid', \OCP\Util::ERROR);
		return false;
	}

	protected function getResizedPreview($tmpPath, $maxX, $maxY) {
		$rotationValues = [
			1 => 0,
			6 => 90,
			8 => 270
		];

		$converter = \OC_Helper::findBinaryPath('exiftool');
		if (empty($converter)) {
			$converter = \OC::$server->getConfig()->getSystemValue('rawpreview_exiftool', '/usr/local/bin/exiftool');
		}

		$imStr = shell_exec($converter . " -b -PreviewImage " . escapeshellarg($tmpPath));
		$rotation = shell_exec($converter . " -n -Orientation " . escapeshellarg($tmpPath));

		if(preg_match('/Orientation\s*:\s*(\d+)/', $rotation, $match)){
			$rotation = $match[1];
		} else $rotation = 1;

		$im = new Imagick();
		$im->readImageBlob($imStr);

		if (!$im->valid()) {
			\OCP\Util::writeLog('RawImage', 'Raw Preview: Failed conversion', \OCP\Util::ERROR);
			return false;
		}
		$im = $this->resize($im, $maxX, $maxY);
		if($rotation != 1) $im->rotateImage('#000', $rotationValues[$rotation]);

		return $im;
	}

	protected function resize($im, $maxX, $maxY) {
		list($previewWidth, $previewHeight) = array_values($im->getImageGeometry());
		if ($previewWidth > $maxX || $previewHeight > $maxY) {
			$im->resizeImage($maxX, $maxY, \imagick::FILTER_CATROM, 1, true);
		}
		return $im;
	}

	/**
	* {@inheritDoc}
	*/
	public function isAvailable(\OCP\Files\FileInfo $file) {
		return true;
	}

}
