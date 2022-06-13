<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity.
 *
 * @property int $id
 * @property string $ncm
 * @property string $ncm_descricao
 * @property string $descricao
 * @property string $codigo
 * @property string $codigo_referencia
 * @property string $descricao_produto
 * @property float $peso_liquido
 * @property float $peso_bruto
 * @property int $quantidade
 * @property int $embalagem_id
 * @property \App\Model\Entity\Embalagem $embalagem
 * @property int $codigo_onu_id
 * @property \App\Model\Entity\CodigoOnus $codigo_onus
 * @property int $container_id
 * @property \App\Model\Entity\Container $container
 * @property int $lote_id
 * @property \App\Model\Entity\Lote $lote
 * @property \App\Model\Entity\ItemAgendamento[] $item_agendamentos
 */
class Item extends Entity {

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
        '*' => true,
        'id' => false,
    ];

    public function _getQuantidadeAgendado() {
        $retorno = 0;
        foreach ($this->_properties['item_agendamentos'] as $i) {
            $retorno += $i->quantidade;
        }
        return $retorno;
    }

    public function _descricao() {
        if (trim($this->_properties['descricao'])) {
            return $this->_properties['descricao'];
        }
        if (trim($this->_properties['descricao_produto'])) {
            return $this->_properties['descricao_produto'];
        }
        if (trim($this->_properties['ncm_descricao'])) {
            return $this->_properties['ncm_descricao'];
        }
        return 'Não Definido';
    }

}
