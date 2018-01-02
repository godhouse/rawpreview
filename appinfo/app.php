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
//$previewManager->registerProvider('/image\/x-dcraw/', function() { return new \OCA\RawPreview\Raw; });
