<?php 

$aLinks = isset($aLinks) ? $aLinks : [];
$sTitle = isset($sTitle) ? $sTitle : [];
$sDirOpen = isset($sDirOpen) ? $sDirOpen : 'right';
$sDirOpen = $sDirOpen == 'right' ? 'lf-position-absolute-pull-right' : 'lf-position-absolute-pull-left';

?>
<div class="btn-group lf-dropdown-fix-overflow">
    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= __($sTitle) ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu <?= $sDirOpen ?>">
            <?php foreach ($aLinks as $sLink) : ?>
                <?php if ($sLink == 'separator') : ?>
                    <li style="padding-top: 5px"><?= $sLink ?></li>
                <?php else : ?>
                    <li><?= $sLink ?></li>
                <?php endif; ?>
                
            <?php endforeach; ?>
        </ul>
    </div>
</div>