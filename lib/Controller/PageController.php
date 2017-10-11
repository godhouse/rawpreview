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
    public function setExif($exiftool){
        $ret = $this->config->setAppValue('rawpreview', 'exiftool', $exiftool);
		if ($ret === false) {
			return new JSONResponse([], Http::STATUS_BAD_REQUEST);
		} else {
			return new JSONResponse([
				'exiftool' => $exiftool
			]);
		}
    }

}
