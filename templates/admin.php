<?php OCP\Util::addScript('rawpreview', 'admin'); ?>

<div class="section">
    <h2><?php p($l->t('Raw Preview')); ?></h2>
    <label for="exiftoolPosition"><?php p($l->t( 'Position of exiftool command' )); ?> </label>
    <span id="exiftoolPositionSettingsMsg" class="msg"></span>
    <br />
    <input type="text" name='exiftoolPosition' id="exiftoolPosition" value='<?php p($_['exiftoolPosition']) ?>' />
    <input type="hidden" value="<?php p($_['requesttoken']); ?>" name="exifreqtoken" />
    <input type="submit" id="submitExiftoolPosition" value="<?php p($l->t( 'Save' )); ?>"/>
</div>
