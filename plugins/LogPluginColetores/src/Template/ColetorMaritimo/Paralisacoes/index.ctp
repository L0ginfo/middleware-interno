<div id="paralisacoes" class="lf-content">


<h1 style="width: 100%;">
    <div>
        <?= __('Paralisações') ?>
    </div>
    <div style="margin-top: 5px;">
        <button class="btn btn-primary adicionar" style="width:auto">
            <?=__('New ')?>
        </button>
    </div>
</h1>
<div class="lf-container lf-text-center">
    <div class="lf-table">
        <table class="lf-table-content lf-margin-top">
            <thead>
                <tr>
                    <td scope="col">Porão</td>
                    <td scope="col">Início</td>
                    <td scope="col">Fim</td>
                    <td scope="col">Motivo</td>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody class="lf-table-tbody">
                <tr>
                   <td colspan="5">Vazio</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div>


<style>
    td i{
        cursor: pointer;
    }
</style>
