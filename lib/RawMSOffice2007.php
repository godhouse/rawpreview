<?php
/**
 * Created by PhpStorm.
 * User: daniele
 * Date: 02/01/18
 * Time: 15.20
 */
namespace OCA\RawPreview;
//.odt, .ott, .oth, .odm, .odg, .otg, .odp, .otp, .ods, .ots, .odc, .odf, .odb, .odi, .oxt
class RawMSOffice2007 extends RawOffice {
    /**
     * {@inheritDoc}
     */
    public function getMimeType() {
        return '/application\/vnd.openxmlformats-officedocument.*/';
    }
}