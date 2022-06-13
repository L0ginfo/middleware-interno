<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Veiculo Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $veiculo_identificacao
 * @property int $modal_id
 * @property int|null $imo
 * @property float|null $loa
 * @property float|null $boca
 * @property string|null $bandeira
 * @property int|null $armador_id
 * @property int|null $tipo_veiculo_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Veiculo extends Entity
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
        'veiculo_identificacao' => true,
        'modal_id' => true,
        'imo' => true,
        'loa' => true,
        'boca' => true,
        'bandeira' => true,
        'armador_id' => true,
        'tipo_veiculo_id' => true,
        'modal' => true,
        'resvs' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getOrSave($sPlaca, $iModalID = null)
    {
        if (!$iModalID)
            $iModalID = EntityUtil::getIdByParams('Modais', 'descricao', 'Rodoviário');

        $oVeiculo = TableRegistry::getTableLocator()->get('Veiculos')->find()
            ->where([
                'veiculo_identificacao' => $sPlaca,
                'modal_id' => $iModalID,
            ])
            ->first();

        if ($oVeiculo)
            return $oVeiculo;

        $oVeiculo = TableRegistry::getTableLocator()->get('Veiculos')->newEntity([
            'descricao' => $sPlaca,
            'veiculo_identificacao' => $sPlaca,
            'modal_id' => $iModalID,
        ]);

        TableRegistry::getTableLocator()->get('Veiculos')->save($oVeiculo);

        return $oVeiculo;
    }

    public static function checkVeiculoInOpenResv($iVeiculoID, $iResvNot = null)
    {
        $aExtra = [];
        $oVeiculo = LgDbUtil::getByID('Veiculos', $iVeiculoID);
        if (@$oVeiculo->entrada_dupla)
            return false;

        if ($iResvNot) {
            $aExtra['Resvs.id IS NOT'] = $iResvNot;
        }

        return LgDbUtil::getFirst('Resvs', ['data_hora_saida IS NULL', 'veiculo_id' => $iVeiculoID] + $aExtra);
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'desc',
                'divClass' => 'col-lg-2',
                'label' => 'Descrição',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'veic',
                'divClass' => 'col-lg-2',
                'label' => 'Veículo Identificação',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'veiculo_identificacao',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function checkIfExists($oVeiculoToSave)
    {
        $sPlaca = $oVeiculoToSave->veiculo_identificacao;
        $iModalID = $oVeiculoToSave->modal_id;

        $oVeiculo = LgDbUtil::getFirst('Veiculos', [
            'veiculo_identificacao' => $sPlaca,
            'modal_id'              => $iModalID
        ]);

        if ($oVeiculo)
            return true;

        return false;
    }

    public static function validaDataTaraVeiculo($iVeiculoId)
    {
        $oVeiculo = LgDbUtil::getByID('Veiculos', $iVeiculoId);

        if (!$oVeiculo->data_tara)
            return (new ResponseUtil())
                ->setMessage('Não existe pesagem realizada para este veículo.');

        if (DateUtil::dateTimeFromDB($oVeiculo->data_tara, 'Y-m-d H:i:s', ' ') >= date('Y-m-d H:i:s', strtotime('-1 days'))
        && DateUtil::dateTimeFromDB($oVeiculo->data_tara, 'Y-m-d H:i:s', ' ') <= date('Y-m-d H:i:s'))
            return (new ResponseUtil())
                ->setStatus(200)
                ->setDataExtra($oVeiculo->peso_tara)
                ->setMessage('Pesagem dentro do tempo permitido.');

        return (new ResponseUtil())
            ->setMessage('Pesagem fora do tempo permitido. <b>FAVOR PESAR NOVAMENTE A TARA DO VEÍCULO</b>');
    }
}
