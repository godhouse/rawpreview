<?php

namespace OCA\MyPreview\AppInfo;


$previewManager = \OC::$server->getPreviewManager();
$previewManager->registerProvider('/image\/x-dcraw/', function() { return new \OCA\MyPreview\Raw; });
