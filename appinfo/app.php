<?php

namespace OCA\RawPreview\AppInfo;


$previewManager = \OC::$server->getPreviewManager();
$previewManager->registerProvider('/image\/x-dcraw/', function() { return new \OCA\MyPreview\Raw; });
