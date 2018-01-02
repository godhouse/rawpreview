<?php

namespace OCA\RawPreview\AppInfo;

// $app = new App('rawpreview');
// $container = $app->getContainer();
// $container->registerService('ConfigService', function($c){
//     return new ConfigService(
//         $c->query('Config'),
//         $c->query('AppName')
//     );
// });
//$previewManager = $container->getServer()->query('PreviewManager');

$previewManager = \OC::$server->getPreviewManager();
$previewManager->registerProvider('/image\/x-dcraw/', function() { return new \OCA\RawPreview\RawImage; });
$previewManager->registerProvider('/video\/.*/', function() { return new \OCA\RawPreview\RawMovie; });
$previewManager->registerProvider('/application\/vnd.oasis.opendocument.*/', function() { return new \OCA\RawPreview\RawOpenDocument; });
$previewManager->registerProvider('/application\/msword/', function() { return new \OCA\RawPreview\RawMSOfficeDoc; });
$previewManager->registerProvider('/application\/vnd.ms-.*/', function() { return new \OCA\RawPreview\RawMSOffice2003; });
$previewManager->registerProvider('/application\/vnd.openxmlformats-officedocument.*/', function() { return new \OCA\RawPreview\RawMSOffice2007; });
