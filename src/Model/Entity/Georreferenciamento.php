<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Georreferenciamento Entity
 *
 * @property int $id
 * @property string|null $nome
 * @property int|null $ativo
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int|null $id_coluna
 * @property string|null $tabela
 * @property int|null $georreferenciamento_tipo_id
 *
 * @property \App\Model\Entity\GeorreferenciamentoTipo $georreferenciamento_tipo
 * @property \App\Model\Entity\Area[] $areas
 * @property \App\Model\Entity\Balanca[] $balancas
 * @property \App\Model\Entity\Camera[] $cameras
 * @property \App\Model\Entity\ControleAcessoControladora[] $controle_acesso_controladoras
 * @property \App\Model\Entity\Empresa[] $empresas
 * @property \App\Model\Entity\Local[] $locais
 * @property \App\Model\Entity\Portaria[] $portarias
 */
class Georreferenciamento extends Entity
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
        
        'nome' => true,
        'ativo' => true,
        'latitude' => true,
        'longitude' => true,
        'id_coluna' => true,
        'tabela' => true,
        'georreferenciamento_tipo_id' => true,
        'georreferenciamento_tipo' => true,
        'areas' => true,
        'balancas' => true,
        'cameras' => true,
        'controle_acesso_controladoras' => true,
        'empresas' => true,
        'locais' => true,
        'portarias' => true,
    
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
