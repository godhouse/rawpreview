<?php

namespace OCA\RawPreview\Settings;

use OCP\IConfig;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

	/** @var IConfig */
	private $config;

	/** @var IRequest */
	private $request;

	public function __construct(IConfig $config, IRequest $request) {
		$this->config = $config;
		$this->request = $request;
	}

	/**
	 * @return TemplateResponse
	 */
	public function getForm() {

        $parameters = [
            "exiftoolPosition" => ($exiftool = $this->config->getAppValue('rawpreview', 'exiftool')) ? $exiftool : '/usr/local/bin/exiftool',
            "ffmpegPosition" => ($ffmpeg = $this->config->getAppValue('rawpreview', 'ffmpeg')) ? $ffmpeg : '/usr/local/bin/ffmpeg',
            "libreofficePosition" => ($libreoffice = $this->config->getAppValue('rawpreview', 'libreoffice')) ? $libreoffice : '/usr/local/bin/libreoffice',
            "ghostscriptPosition" => ($ghostscript = $this->config->getAppValue('rawpreview', 'ghostscript')) ? $libreoffice : '/usr/local/bin/gs'
        ];

		return new TemplateResponse('rawpreview', 'admin', $parameters, '');
	}


    /**
     * @return string the section ID, e.g. 'sharing'
     */
    public function getSection() {
        return 'additional';
    }

    /**
     * @return int whether the form should be rather on the top or bottom of
     * the admin section. The forms are arranged in ascending order of the
     * priority values. It is required to return a value between 0 and 100.
     */
    public function getPriority() {
        return 50;
    }


}
