<?php

namespace OCA\RawPreview;

use OCP\Preview\IProvider;

class RawMovie extends IProvider {
    /**
     * {@inheritDoc}
     */
    public function getMimeType() {
        return '/video\/.*/';
    }
    /**
     * {@inheritDoc}
     */
    public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
        // TODO: use proc_open() and stream the source file ?
        $fileInfo = $fileview->getFileInfo($path);
        $useFileDirectly = (!$fileInfo->isEncrypted() && !$fileInfo->isMounted());
        if ($useFileDirectly) {
            $absPath = $fileview->getLocalFile($path);
        } else {
            $absPath = \OC::$server->getTempManager()->getTemporaryFile();
            $handle = $fileview->fopen($path, 'rb');
            // we better use 5MB (1024 * 1024 * 5 = 5242880) instead of 1MB.
            // in some cases 1MB was no enough to generate thumbnail
            $firstmb = stream_get_contents($handle, 5242880);
            file_put_contents($absPath, $firstmb);
        }
        $result = $this->generateThumbNail($maxX, $maxY, $absPath, 5);
        if ($result === false) {
            $result = $this->generateThumbNail($maxX, $maxY, $absPath, 1);
            if ($result === false) {
                $result = $this->generateThumbNail($maxX, $maxY, $absPath, 0);
            }
        }
        if (!$useFileDirectly) {
            unlink($absPath);
        }
        return $result;
    }
    /**
     * @param int $maxX
     * @param int $maxY
     * @param string $absPath
     * @param int $second
     * @return bool|\OCP\IImage
     */
    private function generateThumbNail($maxX, $maxY, $absPath, $second) {
        $ffmpegBinary = \OC::$server->getConfig()->getSystemValue('ffmpeg_libreoffice', '/usr/local/bin/ffmpeg');
        $tmpPath = \OC::$server->getTempManager()->getTemporaryFile();

        $cmd = $ffmpegBinary . ' -y -ss ' . escapeshellarg($second) .
            ' -i ' . escapeshellarg($absPath) .
            ' -f mjpeg -vframes 1' .
            ' ' . escapeshellarg($tmpPath) .
            ' > /dev/null 2>&1';

        exec($cmd, $output, $returnCode);
        if ($returnCode === 0) {
            $image = new \OC_Image();
            $image->loadFromFile($tmpPath);
            unlink($tmpPath);
            if ($image->valid()) {
                $image->scaleDownToFit($maxX, $maxY);
                return $image;
            }
        }
        unlink($tmpPath);
        return false;
    }
}
