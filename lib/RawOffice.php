<?php

namespace OCA\RawPreview;

use OCP\Preview\IProvider;

class RawOffice implements IProvider {
    private $cmd;
    private $gs;
    /**
     * {@inheritDoc}
     */
    public function getThumbnail($path, $maxX, $maxY, $scalingup, $fileview) {
        $this->initCmd();
        if (is_null($this->cmd)) {
            return false;
        }
        $absPath = $fileview->toTmpFile($path);
        $tmpDir = \OC::$server->getTempManager()->getTempBaseDir();

//        $defaultParameters = ' -env:UserInstallation=file://' . escapeshellarg($tmpDir . '/owncloud-' . \OC_Util::getInstanceId() . '/') . ' --headless --nologo --nofirststartwizard --invisible --norestore --convert-to pdf --outdir ';
//        $clParameters = \OC::$server->getConfig()->getSystemValue('preview_office_cl_parameters', $defaultParameters);

        $clParameters =
            ' -env:UserInstallation=file://' . escapeshellarg($tmpDir . '/owncloud-' .
            \OC_Util::getInstanceId() . '/') .
            ' --headless --nologo --nofirststartwizard --invisible --norestore --convert-to pdf --outdir ';

        $exec = $this->cmd . $clParameters . escapeshellarg($tmpDir) . ' ' . escapeshellarg($absPath);
        shell_exec($exec);

        //create imagick object from pdf
        $pdfPreview = null;

        list($dirname, , , $filename) = array_values(pathinfo($absPath));
        $pdfPreview = $dirname . '/' . $filename . '.pdf';

        $exec = $this->gs . " -dNOPAUSE -sDEVICE=jpeg -r200 -dJPEGQ=60  -dFirstPage=1 -dLastPage=1 -sOutputFile=$pdfPreview.jpg $pdfPreview -dBATCH";
        shell_exec($exec);

        try {
            list($dirname, , , $filename) = array_values(pathinfo($absPath));
            $pdfPreview = $dirname . '/' . $filename . '.pdf';
            $pdf = new \Imagick();
            $pdf->readImage($pdfPreview . ".jpg");
            //$pdf = new \imagick($pdfPreview . '[0]');
            //$pdf->setImageFormat('jpg');
        } catch (\Exception $e) {
            unlink($absPath);
            unlink($pdfPreview);
            \OCP\Util::writeLog('core', $e->getMessage(), \OCP\Util::ERROR);
            return false;
        }
        $image = new \OC_Image();
        $image->loadFromData($pdf);
        unlink($absPath);
        unlink($pdfPreview);
        if ($image->valid()) {
            $image->scaleDownToFit($maxX, $maxY);
            return $image;
        }
        return false;
    }
    private function initCmd() {
        $cmd = \OC::$server->getConfig()->getSystemValue('rawpreview_libreoffice', '/usr/local/bin/libreoffice');

        $this->cmd = $cmd;
        $this->gs = '/usr/local/bin/gs';
    }

    /**
     * {@inheritDoc}
     */
    public function getMimeType() {
        return '/application\/vnd.oasis.opendocument.*/';
    }

    public function isAvailable(\OCP\Files\FileInfo $file) {
        return true;
    }


}
