<?php

namespace OCA\RawPreview;

use OCP\Preview\IProvider;

class RawPDF implements IProvider {
    private $gs;
    /**
     * {@inheritDoc}
     */
    public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
        $this->initCmd();
        if (is_null($this->gs)) {
            return false;
        }
        $absPath = $fileview->toTmpFile($path);
        $tmpDir = \OC::$server->getTempManager()->getTempBaseDir();

        $folder = \OC::$server->getAppDataDir('rawpreview');
        \OCP\Util::writeLog('core', "folder " . $folder, \OCP\Util::ERROR);
        //create imagick object from pdf
        $pdfPreview = null;

        list($dirname, , , $filename) = array_values(pathinfo($absPath));
        $pdfPreview = $tmpDir . '/' . $filename . '.jpg';

        $exec = $this->gs . " -dNOPAUSE -sDEVICE=jpeg -r75 -dJPEGQ=60  -dFirstPage=1 -dLastPage=1 -sOutputFile=" . escapeshellarg($pdfPreview) . " " . escapeshellarg($absPath) . " -dBATCH";
        shell_exec($exec);

        try {
            $pdf = new \Imagick();
            $pdf->readImage($pdfPreview);
            $pdf->resizeImage(32,32,\Imagick::FILTER_LANCZOS,1);
            $overlay = new \Imagick();
            $overlay->readImage("$folder/img/pdf.png");
            $pdf->compositeImage($overlay, \Imagick::COMPOSITE_OVER, 0, 0);
            //$pdf = new \imagick($pdfPreview . '[0]');
            //$pdf->setImageFormat('jpg');
        } catch (\Exception $e) {
            unlink($absPath);
            unlink($pdfPreview);
            //unlink($pdfPreview . ".jpg");
            \OCP\Util::writeLog('core', $e->getMessage(), \OCP\Util::ERROR);
            return false;
        }
        $image = new \OC_Image();
        $image->loadFromData($pdf);
        unlink($absPath);
        unlink($pdfPreview);
        //unlink($pdfPreview . ".jpg");
        if ($image->valid()) {
            $image->scaleDownToFit($maxX, $maxY);
            return $image;
        }
        return false;
    }

    private function initCmd() {
        $gs = \OC::$server->getConfig()->getSystemValue('rawpreview_ghostscript', '/usr/local/bin/gs');

        $this->gs = $gs;
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType() {
        return '/application\/pdf/';
    }

    public function isAvailable(\OCP\Files\FileInfo $file) {
        return true;
    }


}
