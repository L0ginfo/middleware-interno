<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Integracao $integracao
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Integracao') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracoes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="integracoes view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Nome') ?></dt>
            <dd><?= h($integracao->nome) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Codigo Unico') ?></dt>
            <dd><?= h($integracao->codigo_unico) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Json Header') ?></dt>
            <dd><?= h($integracao->json_header) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Url Endpoint') ?></dt>
            <dd><?= h($integracao->url_endpoint) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Private Key') ?></dt>
            <dd><?= h($integracao->private_key) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Tipo') ?></dt>
            <dd><?= h($integracao->tipo) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Db Host') ?></dt>
            <dd><?= h($integracao->db_host) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Db Database') ?></dt>
            <dd><?= h($integracao->db_database) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Db User') ?></dt>
            <dd><?= h($integracao->db_user) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Db Pass') ?></dt>
            <dd><?= h($integracao->db_pass) ?></dd>
        </dl>
    </div>


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($integracao->id) ?></dd>
        </dl>
    </div>
        


    
    <div class="col-lg-3">
        <dl>
            <dt><?= __('Ativo') ?></dt>
            <dd><?= $integracao->ativo ? __('Yes') : __('No'); ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Gravar Log') ?></dt>
            <dd><?= $this->Number->format($integracao->gravar_log) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Db Porta') ?></dt>
            <dd><?= $this->Number->format($integracao->db_porta) ?></dd>
        </dl>
    </div>
        


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Data Integracao') ?></dt>
            <dd><?= h($integracao->data_integracao) ?></dd>
        </dl>
    </div>

    </table>

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Descricao') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($integracao->descricao)); ?></dd>
        </dl>
    </div>


<div class="clearfix"></div>

    <!--div class="related">
        <h4><?= __('Related Integracao Logs') ?></h4>
        <?php if (!empty($integracao->integracao_logs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Integracao Id') ?></th>
                <th scope="col"><?= __('Integracao Traducao Id') ?></th>
                <th scope="col"><?= __('Url Requisitada') ?></th>
                <th scope="col"><?= __('Header Enviado') ?></th>
                <th scope="col"><?= __('Header Recebido') ?></th>
                <th scope="col"><?= __('Json Enviado') ?></th>
                <th scope="col"><?= __('Json Recebido') ?></th>
                <th scope="col"><?= __('Json Traduzido') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Descricao') ?></th>
                <th scope="col"><?= __('Stackerror') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($integracao->integracao_logs as $integracaoLogs): ?>
            <tr>
                <td><?= h($integracaoLogs->id) ?></td>
                <td><?= h($integracaoLogs->integracao_id) ?></td>
                <td><?= h($integracaoLogs->integracao_traducao_id) ?></td>
                <td><?= h($integracaoLogs->url_requisitada) ?></td>
                <td><?= h($integracaoLogs->header_enviado) ?></td>
                <td><?= h($integracaoLogs->header_recebido) ?></td>
                <td><?= h($integracaoLogs->json_enviado) ?></td>
                <td><?= h($integracaoLogs->json_recebido) ?></td>
                <td><?= h($integracaoLogs->json_traduzido) ?></td>
                <td><?= h($integracaoLogs->status) ?></td>
                <td><?= h($integracaoLogs->descricao) ?></td>
                <td><?= h($integracaoLogs->stackerror) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IntegracaoLogs', 'action' => 'view', $integracaoLogs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IntegracaoLogs', 'action' => 'edit', $integracaoLogs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IntegracaoLogs', 'action' => 'delete', $integracaoLogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $integracaoLogs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
    <!--div class="related">
        <h4><?= __('Related Integracao Traducoes') ?></h4>
        <?php if (!empty($integracao->integracao_traducoes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Integracao Id') ?></th>
                <th scope="col"><?= __('Nested Json Translate') ?></th>
                <th scope="col"><?= __('Observacao') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($integracao->integracao_traducoes as $integracaoTraducoes): ?>
            <tr>
                <td><?= h($integracaoTraducoes->id) ?></td>
                <td><?= h($integracaoTraducoes->integracao_id) ?></td>
                <td><?= h($integracaoTraducoes->nested_json_translate) ?></td>
                <td><?= h($integracaoTraducoes->observacao) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IntegracaoTraducoes', 'action' => 'view', $integracaoTraducoes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IntegracaoTraducoes', 'action' => 'edit', $integracaoTraducoes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IntegracaoTraducoes', 'action' => 'delete', $integracaoTraducoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $integracaoTraducoes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
</div>
