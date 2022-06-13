<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * AceiteContainer Entity
 *
 * @property int $id
 * @property string $container_numero
 * @property string|null $motivo
 * @property int $ativo
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property int|null $created_by
 */
class AceiteContainer extends Entity
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
        'created_at' => true,
        'updated_at' => true,
        'created_by' => true,
    
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
                    'className' => 'AceiteContainers',
                    'field'     => 'container_numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'usuario',
                'divClass' => 'col-lg-3',
                'label' => 'Usuário',
                'table' => [
                    'className' => 'AceiteContainers.Usuarios',
                    'field'     => 'nome',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function generateByCsv($aDataInsert)
    {
        $oResponse = new ResponseUtil();

        $oAceiteContainers = LgDbUtil::getFind('AceiteContainers')->toArray();
        if ($oAceiteContainers && !LgDbUtil::get('AceiteContainers')->deleteAll(['1' => '1']))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Erro ao apagar registros já existentes!');

        foreach ($aDataInsert as $aData) {

            if (!LgDbUtil::saveNew('AceiteContainers', $aData))
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
