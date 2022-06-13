<div class="lf-header">
    <div>
        <?= $this->Form->button('Menu', [
            'type' => 'button', 
            'class' => 'btn btn-menu btn-primary btn-option',
            'id' => 'menu-btn' 
        ]) ?>
    </div>
    <div>
        <div class="lf-logo" style="background: url('<?= $sLogoImgMenuHover; ?>')"></div>
    </div>
    <div>
        <?= $this->Html->link(__('Sair'), ['controller' => 'usuarios', 'action' => 'logout'], [
            'class' => 'btn btn-menu btn-danger'
        ]) ?>
    </div>
</div>
