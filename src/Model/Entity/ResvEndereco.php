<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;

/**
 * ResvEndereco Entity
 *
 * @property int $id
 * @property int|null $resv_id
 * @property int|null $endereco_id
 * @property int|null $usuario_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Usuario $usuario
 */
class ResvEndereco extends Entity
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
        
        'resv_id' => true,
        'endereco_id' => true,
        'usuario_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'resv' => true,
        'endereco' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function gravarEndereco($aData)
    {
        $oResponse = new ResponseUtil;

        if (!$aData || !$aData['resv_id'])
            return false;

        $aData['resv_id'] = (int) intval(@$aData['resv_id']);
        $aData['endereco_digitado'] = (int) intval(@$aData['endereco_digitado']);

        $oResv = LgDbUtil::getByID('Resvs', $aData['resv_id']);

        if (!$oResv)
            return $oResponse
                ->setMessage('Essa RESV não existe!');

        $aResvEnderecos = LgDbUtil::getAll('ResvEnderecos', [
            'resv_id' => $aData['resv_id']
        ]);

        $oResponse
            ->setStatus(202)
            ->setDataExtra([
                'resv_enderecos' => $aResvEnderecos
            ]);

        if (!$aData['endereco_digitado'])
            return $oResponse;

        $oEndereco = LgDbUtil::getByID('Enderecos', $aData['endereco_digitado']);

        if (!$oEndereco)
            return $oResponse
                ->setStatus(404)
                ->setMessage('Este endereço não existe na base de dados!');

        $aData = [
            'resv_id' => $aData['resv_id'],
            'endereco_id' => $aData['endereco_digitado'],
        ];

        //Enderecos possiveis para carregamento
        if (Resv::isCarga($oResv)) {
            $aEnderecoIDs = ResvsLiberacoesDocumental::getEstoqueEnderecosPossiveis($oResv, true);
            
            if (!in_array($aData['endereco_id'], $aEnderecoIDs))
                return $oResponse
                    ->setStatus(404)
                    ->setMessage('Este endereço não tem este produto! <br> Endereços possíveis: ' . implode(', ', $aEnderecoIDs));
        }

        $oResvEnderecos = LgDbUtil::getFirst('ResvEnderecos', $aData);

        if ($oResvEnderecos)
            return $oResponse
                ->setStatus(404)
                ->setMessage('Este endereço já foi vinculado!');

        LgDbUtil::saveNew('ResvEnderecos', $aData + [
            'usuario_id' => SessionUtil::getUsuarioConectado(),
            'via_coletor' => 1
        ]);

        $aResvEnderecos = LgDbUtil::getAll('ResvEnderecos', [
            'resv_id' => $aData['resv_id']
        ]);

        $oResponse
            ->setStatus(202)
            ->setDataExtra([
                'resv_enderecos' => $aResvEnderecos
            ]);

        return $oResponse
            ->setStatus(200)
            ->setMessage('Endereço gravado!');
    }

    public static function getResvEndrecos($iResvID)
    {
        if (!$iResvID)
            return [];
        
        $aEnderecos = LgDbUtil::getFind('ResvEnderecos')
            ->distinct('endereco_id')
            ->where([
                'resv_id' => $iResvID
            ])
            ->extract('endereco_id')
            ->toArray();

        return $aEnderecos;
    }

    public static function setByQrCode($iResvID, $iEnderecoID, $iUsuarioID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'resv_id'     => $iResvID,
            'endereco_id' => $iEnderecoID,
            'usuario_id'  => $iUsuarioID
        ];

        $oResvEndereco = LgDbUtil::getOrSaveNew('ResvEnderecos', $aDataInsert, true);
        if ($oResvEndereco->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao gravar a Resv Endereço!');

        return $oResponse
            ->setStatus(200);
    }
}
