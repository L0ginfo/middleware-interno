<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FaturamentoFechamento Entity
 *
 * @property int $id
 * @property int $sequencia
 * @property \Cake\I18n\Time $periodo_inicial
 * @property \Cake\I18n\Time $periodo_final
 * @property int $created_by
 * @property \Cake\I18n\Time $created
 * @property int|null $updated_by
 * @property \Cake\I18n\Time|null $updated
 *
 * @property \App\Model\Entity\FaturamentoFechamentoItem[] $faturamento_fechamento_itens
 */
class FaturamentoFechamento extends Entity
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
        'sequencia' => true,
        'periodo_inicial' => true,
        'periodo_final' => true,
        'created_by' => true,
        'created' => true,
        'updated_by' => true,
        'updated' => true,
        'faturamento_fechamento_itens' => true
    ];

    public function saveItens($that, $aFechamentoItens){
        $fechamento = $this->id;
        $created_by = $this->created_by;
        $datatime = new \Datetime('now');
        $entities = array_map(function($dados) use($fechamento, $created_by, $datatime) {
            return [
                'faturamento_fechamento_id'=> $fechamento, 
                'faturamento_id'=> $dados->that['id'],
                'created_by'=> $created_by,
                'created'=> $datatime,
            ];
        }, $aFechamentoItens);

        $entities = $that
            ->FaturamentoFechamentos
            ->FaturamentoFechamentoItens
            ->newEntities($entities);

        $result = $that
            ->FaturamentoFechamentos
            ->FaturamentoFechamentoItens
            ->saveMany( $entities);

        return $result;
    }


    public function deleteItens($that){
        return $that
            ->FaturamentoFechamentos
            ->FaturamentoFechamentoItens
            ->deleteAll([
            'faturamento_fechamento_id'=> $this->id,
        ]);
    }
}
