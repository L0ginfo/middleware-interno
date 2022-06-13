<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * DocumentoTransporteSituacao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\DocumentosTransporte[] $documentos_transportes
 */
class DocumentoTransporteSituacao extends Entity
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
        'documentos_transportes' => true,
    
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

        return $oParam->documentos_transportes;
    }

    public static function setDocumentoTransporteSituacao($iDocTransporteID, $sSituacao)
    {
        $oResponse = new ResponseUtil();

        $oDocTransporte = LgDbUtil::getByID('DocumentosTransportes', $iDocTransporteID);
        if (!$oDocTransporte)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Documento não encontrado!');
        
        $oDocTransporteSituacao = LgDbUtil::getFirst('DocumentoTransporteSituacoes', ['descricao' => $sSituacao]);
        if (!$oDocTransporteSituacao)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Situação não encontrado!');

        $oDocTransporte->documento_transporte_situacao_id = $oDocTransporteSituacao->id;
        $bSaveDocTransporte = LgDbUtil::save('DocumentosTransportes', $oDocTransporte, true);
        if ($bSaveDocTransporte->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível alterar a situação do Documento de Transporte!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Documento de Transporte ' . $sSituacao . ' com sucesso!');
    }
}
