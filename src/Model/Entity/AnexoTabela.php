<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use App\Model\Entity\Anexo;

/**
 * AnexoTabela Entity
 *
 * @property int $id
 * @property int $anexo_id
 * @property int $id_tabela
 * @property string $tabela
 * @property int|null $anexo_tipo_id
 * @property int|null $anexo_situacao_id
 *
 * @property \App\Model\Entity\Anexo $anexo
 * @property \App\Model\Entity\AnexoTipo $anexo_tipo
 * @property \App\Model\Entity\AnexoSituacao $anexo_situacao
 */
class AnexoTabela extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'anexo_id' => true,
        'id_tabela' => true,
        'tabela' => true,
        'anexo_tipo_id' => true,
        'anexo_situacao_id' => true,
        'anexo' => true,
        'anexo_tipo' => true,
        'anexo_situacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getAnexos($aData)
    {
        $oResponse = new ResponseUtil();

        if (!$aData['tabela'] || !$aData['id'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parametro de fluxo faltante!');

        $aAnexosTabelas = LgDbUtil::getFind('AnexoTabelas')
            ->select([
                'anexo_tabela_id'          => 'AnexoTabelas.id',
                'anexo_id'                 => 'Anexos.id',
                'anexo_nome'               => 'Anexos.nome',
                'anexo_tipo_id'            => 'AnexoTipos.id',
                'anexo_tipo_descricao'     => 'AnexoTipos.descricao',
                'anexo_situacao_id'        => 'AnexoSituacoes.id',
                'anexo_situacao_descricao' => 'AnexoSituacoes.descricao',
            ])
            ->leftJoinWith('Anexos')
            ->leftJoinWith('AnexoTipos')
            ->leftJoinWith('AnexoSituacoes')
            ->where([
                'AnexoTabelas.tabela'    => $aData['tabela'],
                'AnexoTabelas.id_tabela' => $aData['id']
            ])
            ->toArray();

        $default_association = ['keyField' => 'id', 'valueField' => 'descricao'];

        $aAnexoSituacoes = LgDbUtil::getFind('AnexoSituacoes')
            ->select([
                'id'        => 'AnexoSituacoes.id',
                'descricao' => 'AnexoSituacoes.descricao',
            ])
            ->toArray();

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['AnexoTabelas' => $aAnexosTabelas, 'AnexoSituacoes' => $aAnexoSituacoes]);
    }

    public static function setAnexoSituacao($aData)
    {
        $oResponse = new ResponseUtil();

        if (!$aData['iSituacaoID'] || !$aData['iAnexoTabelaID'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parametro de fluxo faltante!');

        $oAnexoTabela = LgDbUtil::getFirst('AnexoTabelas', ['AnexoTabelas.id' => $aData['iAnexoTabelaID']]);
        $oAnexoTabela->anexo_situacao_id = $aData['iSituacaoID'];

        $oAnexoTabelaSave = LgDbUtil::save('AnexoTabelas', $oAnexoTabela, true);
        if ($oAnexoTabelaSave->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Erro ao alterar a situação do anexo!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Situação alterada com sucesso!');
    }

    public static function getInfoRemove($that, $aData)
    {
        $oResponse = new ResponseUtil();

        if (!$aData)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parametro de fluxo faltante!');

        $oAnexoTabela = LgDbUtil::getFind('AnexoTabelas')
            ->contain('Anexos')
            ->where(['AnexoTabelas.id' => $aData])
            ->first();

        $path                   = $oAnexoTabela->anexo->arquivo;
        $id                     = $aData;
        $caminho                = str_replace('/', DS, $oAnexoTabela->anexo->diretorio);
        $tipo                   = $oAnexoTabela->anexo->mime;
        $sCaminho               = ROOT . DS;
        $tabela                 = 'AnexoTabelas';
        $anexo_id               = $oAnexoTabela->anexo->id;

        return $oResponse
            ->setStatus(200)
            ->setDataExtra([
                'path'     => $path,
                'id'       => $id,
                'caminho'  => $caminho,
                'tipo'     => $tipo,
                'sCaminho' => $sCaminho,
                'tabela'   => $tabela,
                'anexo_id' => $anexo_id,
            ]);

        // $that->removeFile($path, $sCaminho, $tipo);

        // return $that->response->withType("application/json")->withStringBody(json_encode(AnexoTabela::removerArquivoBD($that, $tabela, $anexo_id)));

    }

    private static function removerArquivoBD($that, $tabela, $id)
    {
        $that->loadModel($tabela);

        $aReturn = Anexo::removeFileDB($that, $tabela, $id);
        
        return $aReturn;
    }

}
