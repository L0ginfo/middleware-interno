<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sentido Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo[] $planejamento_maritimos
 */
class Sentido extends Entity
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
    protected $_accessible = [
        'codigo' => true,
        'descricao' => true,
        'planejamento_maritimos' => true
    ];

    public function getTipoOperacaoAtracacao(){

        switch ($this->codigo) {
            case 'DESEMBARQUE':
                return 1;
                
            case 'EMBARQUE':
                return 1;
        }
    }

    public function getMovimentoMercadoria(){

        switch ($this->codigo) {

            case 'EXPORTAÇÃO':
                return 1;
                
            case 'EMBARQUE':
                return 2;

            case 'IMPORTAÇÃO':
                return 3;

            case 'DESEMBARQUE':
                return 4;

            case 'REMOÇÃO':
                return 6;

            case 'SAFAMENTO':
                return 7;

            default:
                return 0;
        }

    }

}
