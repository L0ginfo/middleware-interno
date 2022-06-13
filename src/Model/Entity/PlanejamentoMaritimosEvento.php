<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimosEvento Entity
 *
 * @property int $id
 * @property int|null $planejamento_maritimos_id
 * @property int|null $situacao_id
 * @property int|null $evento_id
 * @property string|null $versao
 * @property \Cake\I18n\Time|null $data_hora_evento
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\SituacaoProgramacaoMaritima $situacao_programacao_maritima
 * @property \App\Model\Entity\Evento $evento
 */
class PlanejamentoMaritimosEvento extends Entity
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
        'planejamento_maritimos_id' => true,
        'situacao_id' => true,
        'evento_id' => true,
        'versao' => true,
        'data_hora_evento' => true,
        'planejamento_maritimo' => true,
        'situacao_programacao_maritima' => true,
        'evento' => true
    ];


    public function efetivadoLineUP(){
        if(isset($this->situacao_programacao_maritima)){
            return $this->situacao_programacao_maritima->codigo == 'EFETIVADO';
        }

        $iId = EntityUtil::getIdByParams(
            'SituacaoProgramacaoMaritimas', 'codigo', 'EFETIVADO');

        return $this->situacao_id == $iId;
    }
}
