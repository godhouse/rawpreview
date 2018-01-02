<?php OCP\Util::addScript('rawpreview', 'admin'); ?>

<div class="section">
    <h2><?php p($l->t('Raw Preview')); ?></h2>
    <label for="exiftoolPosition"><?php p($l->t( 'Position of exiftool command' )); ?> </label>
    <br />
    <input type="text" name='exiftoolPosition' id="exiftoolPosition" value='<?php p($_['exiftoolPosition']) ?>' />
    <br />
    <label for="ffmpegPosition"><?php p($l->t( 'Position of ffmpeg command' )); ?> </label>
    <br />
    <input type="text" name='ffmpegPosition' id="ffmpegPosition" value='<?php p($_['ffmpegPosition']) ?>' />
    <br />
    <label for="libreofficePosition"><?php p($l->t( 'Position of libreoffice command' )); ?> </label>
    <br />
    <input type="text" name='libreofficePosition' id="libreofficePosition" value='<?php p($_['libreofficePosition']) ?>' />
    <br />
    <input type="submit" id="submitRawPreview" value="<?php p($l->t( 'Save' )); ?>" />
    <span id="rawPreviewSettingsMsg" class="msg"></span>
</div>
