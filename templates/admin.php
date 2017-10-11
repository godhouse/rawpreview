<?php
/** @var $l \OCP\IL10N */
/** @var $_ array */

?>

<div id="rawpreview_settings" class="section">
        <h2><?php p($l->t('Raw Preview')); ?></h2>

        <h3><?php p($l->t('Things to define')); ?></h3>
        <p>
            <input type="text" class="rawpreview_exiftool" id="rawpreview_exiftool_position" name="rawpreview_exiftool_position" value="<?php p($_['exiftool_position']) ?>">
        </p>

</div>
