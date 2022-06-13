<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * LiberacaoDocumentalSituacao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\LiberacoesDocumental[] $liberacoes_documentais
 */
class LiberacaoDocumentalSituacao extends Entity
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
        
        'descricao' => true,
        'liberacoes_documentais' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function verifyParamHabilitado()
    {
        $sParam = ParametroGeral::getParametroWithValue('PARAM_HABILITA_APROVACAO_DOCUMENTO');

        if (!$sParam)
            return false;

        $oParam = json_decode($sParam);

        return $oParam->liberacoes_documentais;
    }

    public static function setLiberacaoDocumentalSituacao($iLiberacaoID, $sSituacao)
    {
        $oResponse = new ResponseUtil();

        $oLiberacao = LgDbUtil::getByID('LiberacoesDocumentais', $iLiberacaoID);
        if (!$oLiberacao)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Documento não encontrado!');
        
        $oLiberacaoSituacao = LgDbUtil::getFirst('LiberacaoDocumentalSituacoes', ['descricao' => $sSituacao]);
        if (!$oLiberacaoSituacao)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Situação não encontrado!');

        $oLiberacao->liberacao_documental_situacao_id = $oLiberacaoSituacao->id;
        $bSaveLiberacao = LgDbUtil::save('LiberacoesDocumentais', $oLiberacao, true);
        if ($bSaveLiberacao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível alterar a situação da Liberação Documental!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Liberação Documental ' . $sSituacao . ' com sucesso!');
    }
}
