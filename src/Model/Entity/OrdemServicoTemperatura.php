<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * OrdemServicoTemperatura Entity
 *
 * @property int $id
 * @property int|null $entrada_saida_container_id
 * @property string|null $lote_codigo
 * @property int|null $endereco_id
 * @property int|null $unidade_medida_id
 * @property int|null $produto_id
 * @property int|null $ordem_servico_id
 * @property string|null $temperatura
 *
 * @property \App\Model\Entity\EntradaSaidaContainer $entrada_saida_container
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 */
class OrdemServicoTemperatura extends Entity
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
        
        'entrada_saida_container_id' => true,
        'lote_codigo' => true,
        'endereco_id' => true,
        'unidade_medida_id' => true,
        'produto_id' => true,
        'ordem_servico_id' => true,
        'temperatura' => true,
        'entrada_saida_container' => true,
        'endereco' => true,
        'unidade_medida' => true,
        'produto' => true,
        'ordem_servico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveByOrdemServico($iID, $aContainers)
    {
        $oResponse = new ResponseUtil();

        if (!$aContainers)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Nenhum Container selecionado!');

        foreach ($aContainers as $iKey => $iContainerID) {

            $oEntradaSaidaContainer = EntradaSaidaContainer::getLastByContainerId((int)$iContainerID);

            $aDataInsert = [
                'entrada_saida_container_id' => $oEntradaSaidaContainer->id,
                'ordem_servico_id'           => $iID
            ];

            $oOsTemperatura = LgDbUtil::saveNew('OrdemServicoTemperaturas', $aDataInsert, true);
            if ($oOsTemperatura->hasErrors())
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu um erro ao salvao o container!');

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function setTemperatura($aData, $iOrdemServicoID)
    {
        $oResponse = new ResponseUtil();

        if (!$aData)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Sem temperatura informada!');

        $oEntradaSaidaContainer = EntradaSaidaContainer::getLastByContainerId($aData['container']);

        $aDataInsert = [
            'entrada_saida_container_id'        => $oEntradaSaidaContainer->id,
            'ordem_servico_id'                  => $iOrdemServicoID,
            'temperatura'                       => $aData['temperatura'],
            'data_hora_medicao'                 => DateUtil::dateTimeToDB($aData['data_hora_medicao']),
            'ordem_servico_temperatura_tipo_id' => $aData['ordem_servico_temperatura_tipo_id'],
            'set_point'                         => $aData['set_point'],
            'suply'                             => $aData['suply'],
            'retorno'                           => $aData['retorno'],
            'observacoes'                       => $aData['observacoes']
        ];

        $oOsTemperatura = LgDbUtil::saveNew('OrdemServicoTemperaturas', $aDataInsert, true);
        if ($oOsTemperatura->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao salvao o container!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Temperatura (as) alterada (as) com sucesso!');
    }
}
