<?php
namespace OCA\RawPreview\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IConfig;

class PageController extends Controller {
	private $config;

	public function __construct($AppName, IRequest $request, IConfig $config){
		parent::__construct($AppName, $request);
		$this->config = $config;
	}

	/**
	 * @param string $maxUploadSize
	 * @return JSONResponse
	 */
	public function setExif($exiftool, $ffmpeg, $libreoffice){
		$ret = $this->config->setSystemValue('rawpreview_exiftool', $exiftool);
        if ($ret === false) {
            return new JSONResponse([], Http::STATUS_BAD_REQUEST);
        }
        $ret = $this->config->setSystemValue('rawpreview_ffmpeg', $ffmpeg);
        if ($ret === false) {
            return new JSONResponse([], Http::STATUS_BAD_REQUEST);
        }
        $ret = $this->config->setSystemValue('rawpreview_libreoffice', $libreoffice);
		if ($ret === false) {
			return new JSONResponse([], Http::STATUS_BAD_REQUEST);
		}

		return new JSONResponse([
				'exiftoolPosition' => $exiftool,
				'libreofficePosition' => $libreoffice,
				'ffmpegPosition' => $ffmpeg
        ]);

	}

}
