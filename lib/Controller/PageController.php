<?php
namespace OCA\Preview\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
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
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		return new TemplateResponse('camerarawpreviews', 'index');  // templates/index.php
	}

    public function setExif($exif){
        $ret = $this->config->setAppValue('rawpreview', 'exiftool', $exif);
		if ($ret === false) {
			return new JSONResponse([], Http::STATUS_BAD_REQUEST);
		} else {
			return new JSONResponse([
				'exiftool' => $exif
			]);
		}
    }

}
