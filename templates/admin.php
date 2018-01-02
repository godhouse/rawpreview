<?php OCP\Util::addScript('rawpreview', 'admin'); ?>

<div class="section">
    <h2><?php p($l->t('Raw Preview')); ?></h2>
    <label for="exiftoolPosition"><?php p($l->t( 'Position of exiftool command' )); ?> </label>
    <span id="exiftoolPositionSettingsMsg" class="msg"></span>
    <br />
    <input type="text" name='exiftoolPosition' id="exiftoolPosition" value='<?php p($_['exiftoolPosition']) ?>' />
    <br />
    <label for="ffmpegPosition"><?php p($l->t( 'Position of ffmpeg command' )); ?> </label>
    <span id="ffmpegPositionSettingsMsg" class="msg"></span>
    <br />
    <input type="text" name='ffmpegPosition' id="exiftoolPosition" value='<?php p($_['ffmpegPosition']) ?>' />
    <br />
    <label for="libreofficePosition"><?php p($l->t( 'Position of exiftool command' )); ?> </label>
    <span id="libreofficePositionSettingsMsg" class="msg"></span>
    <br />
    <input type="text" name='libreofficePosition' id="exiftoolPosition" value='<?php p($_['libreofficePosition']) ?>' />
    <br />
    <input type="submit" id="submitExiftoolPosition" value="<?php p($l->t( 'Save' )); ?>" />
</div>
