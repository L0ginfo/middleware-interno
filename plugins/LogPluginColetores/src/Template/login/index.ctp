<div class="lf-login-container">
    <div class="lf-logo-container">
        <div class="lf-logo" style="background: url('<?= $sLogoImgLogin; ?>')"></div>
    </div>

    <?= $this->Form->create($this) ?>
        <?= $this->Form->control('cpf', ['class' => 'form-control']); ?>
        <?= $this->Form->control('senha', ['type' => 'password', 'class' => 'form-control']); ?>
        <div class="lf-text-center">
            <?= $this->Flash->render() ?>
        </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-login']) ?>
    <?= $this->Form->end() ?>
</div>
