<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * BloqueioContainer Entity
 *
 * @property int $id
 * @property string $container_numero
 * @property string $motivo
 * @property int $ativo
 */
class BloqueioContainer extends Entity
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
        
        'container_numero' => true,
        'motivo' => true,
        'ativo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'numero',
                'divClass' => 'col-lg-3',
                'label' => 'Número Container',
                'table' => [
                    'className' => 'BloqueioContainers',
                    'field'     => 'container_numero',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function verifyIfContainerBlocked($sContainer)
    {
        if ($sContainer)
            $oBloqueioContainer = LgDbUtil::getFind('BloqueioContainers')
                ->where([
                    'lower(container_numero)' => strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $sContainer)),
                    'ativo' => 1
                ])
                ->first();

        $oParamListaAceite = ParametroGeral::getParameterByUniqueName('PARAM_BLOQUEIA_ENTRADA_CONTAINER_LISTA_ACEITE');
        if ($oParamListaAceite->valor == 1) {
            $oAceiteContainer = LgDbUtil::getFind('AceiteContainers')
                ->where([
                    'lower(container_numero)' => strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $sContainer)),
                    'ativo' => 1
                ])
                ->first();

            if (!$oAceiteContainer)
                return (new ResponseUtil())
                    ->setTitle('Container não aceito')
                    ->setMessage('O container "' . $sContainer . '" não está na lista de containers aceitos!');
        }

        if (isset($oBloqueioContainer))
            return (new ResponseUtil())
                ->setTitle('Container Bloqueado')
                ->setMessage($oBloqueioContainer->motivo);

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Container sem bloqueio');
    }

    public static function generateByCsv($aDataInsert)
    {
        $oResponse = new ResponseUtil();

        $oBloqueioContainers = LgDbUtil::getFind('BloqueioContainers')->toArray();
        if ($oBloqueioContainers && !LgDbUtil::get('BloqueioContainers')->deleteAll(['1' => '1']))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Erro ao apagar registros já existentes!');

        foreach ($aDataInsert as $aData) {

            if (!LgDbUtil::saveNew('BloqueioContainers', $aData))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Erro ao cadastrar um dos registros desse CSV! Favor revisar os dados.');

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Registros importados com sucesso!');
    }
}
