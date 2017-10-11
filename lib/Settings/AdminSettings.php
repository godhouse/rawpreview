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

        $exiftool_pos = $this->config->getSystemValue('rawpreview', 'exiftool');
        $from_helper_pos = \OC_Helper::findBinaryPath('exiftool');
        $default_pos = '';
        if(empty($exiftool_pos)) {
		$exiftool_pos = (empty($from_helper_pos)) ? $default_pos : $from_helper_pos;
        }

		$parameters = [
			'exiftoolPosition' => $exiftool_pos,
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
