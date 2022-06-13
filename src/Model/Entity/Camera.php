<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Camera Entity
 *
 * @property int $id
 * @property int|null $id_coluna
 * @property string|null $tabela
 * @property string|null $codigo_cftv
 * @property string|null $codigo_camera
 * @property string|null $azimute
 * @property int|null $georreferenciamento_id
 *
 * @property \App\Model\Entity\Georreferenciamento $georreferenciamento
 */
class Camera extends Entity
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
        
        'id_coluna' => true,
        'tabela' => true,
        'codigo_cftv' => true,
        'codigo_camera' => true,
        'azimute' => true,
        'georreferenciamento_id' => true,
        'georreferenciamento' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getTabelas()
    {
        return [
            'Empresas' => 'Empresas',
            'ControleAcessoControladoras' => 'ControleAcessoControladoras',
            'Locais' => 'Locais',
            'Balancas' => 'Balancas',
            'Areas' => 'Areas',
            'Portarias' => 'Portarias',
            'Cameras' => 'Cameras',
        ];
    }
}
