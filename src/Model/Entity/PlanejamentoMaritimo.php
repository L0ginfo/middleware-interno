<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use Cake\ORM\Entity;
use Cake\I18n\Time;

/**
 * PlanejamentoMaritimo Entity
 *
 * @property int $id
 * @property int $situacao_id
 * @property int $faturar_id
 * @property int $berco_id
 * @property int $navio_id
 * @property int $ncm_id
 * @property int $afreteador_id
 * @property int $agente_armador_id
 * @property int $oper_portuaria_id
 * @property int $carga_id
 * @property int $tipo_viagem_id
 * @property int $sentido_id
 * @property int $porto_origem_id
 * @property int $porto_destino_id
 * @property string $numero
 * @property string $viagem_numero
 * @property string $versao
 * @property string $carpeta
 * @property string $escala
 * @property string $loa
 * @property bool $fundeado
 * @property \Cake\I18n\Time $data_fundeio
 * @property \Cake\I18n\Date $data_registro
 * @property string $observacao
 *
 * @property \App\Model\Entity\SituacaoProgramacaoMaritima $situacao_programacao_maritima
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Berco $berco
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Ncm $ncm
 * @property \App\Model\Entity\TiposCarga $tipos_carga
 * @property \App\Model\Entity\TiposViagem $tipos_viagem
 * @property \App\Model\Entity\Sentido $sentido
 * @property \App\Model\Entity\Procedencia $procedencia
 * @property \App\Model\Entity\Evento[] $eventos
 */
class PlanejamentoMaritimo extends Entity
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
        'id' => false,
        '*' => true
    ];


    public function saveLineUP($that, $data){
        $keys = array_keys($data);
        $eventKeys = preg_grep('~'.'data-evento-id'. '~', array_keys($data));
        $elements =  array_filter(array_intersect_key($data, array_flip($eventKeys)));
        
        if($data['versao-line-up'] > $data['versao-atual-line-up']){
            return;
        }

        if($data['versao-line-up'] < $data['versao-atual-line-up']){
            $this->insertEventos($that, $elements,  $data['situacao_line_up'], ($data['versao-line-up']+1));
            return;
        }

        $this->updateEventos(
            $that, $elements, $data['situacao_line_up'], $data['versao-atual-line-up']);
    }

    private function insertEventos($that, $array, $situacao = 1, $versao = 1){
        
        $entities = array_map(function($value, $index) use ($versao, $situacao){
            return [
                'planejamento_maritimos_id'=> $this->id, 
                'evento_id'=>intval(preg_replace('/[^0-9]+/', '', $index)), 
                'data_hora_evento'=>DateUtil::dateTimeToDB($value),
                'situacao_id'=> $situacao,
                'versao'=>(int) $versao
            ];
        }, $array, array_keys($array));

        $entities = $that
            ->PlanejamentoMaritimos
            ->PlanejamentoMaritimosEventos
            ->newEntities($entities);

        $that
            ->PlanejamentoMaritimos
            ->PlanejamentoMaritimosEventos
            ->saveMany($entities);
    }

    private function updateEventos($that, $array, $situacao = 1, $versao = 1){
        //get elemtos já salvos
        $entities = $that
            ->PlanejamentoMaritimos
            ->PlanejamentoMaritimosEventos
            ->find()->where([
                'planejamento_maritimos_id' =>$this->id,
                'versao' => $versao
            ])->toArray();
        
        //gerar um array valores de PlanejamentoMaritimosEventos
        $newEntities = array_map(function($value, $index) use ($versao, $situacao){
            return [
                'planejamento_maritimos_id'=> $this->id, 
                'evento_id'=>intval(preg_replace('/[^0-9]+/', '', $index)), 
                'data_hora_evento'=>DateUtil::dateTimeToDB($value),
                'situacao_id'=> $situacao,
                'versao'=>(int) $versao
            ];
        }, $array, array_keys($array));

        // remove os já cadastrados
        foreach ($entities as $entity) {
            foreach ($newEntities as $key => $value) {
                if($entity->evento_id == $value['evento_id']){
                    $entity->data_hora_evento = $value['data_hora_evento'];
                    $entity->situacao_id = $situacao;
                    unset($newEntities[$key]);
                    continue;  
                }
            }
        }
        
        //converte em entidades
        $newEntities = $that
            ->PlanejamentoMaritimos
            ->PlanejamentoMaritimosEventos
            ->newEntities($newEntities);

        //junta os vetores
        $entities = array_merge($entities, $newEntities);

        //salva
        $that
            ->PlanejamentoMaritimos
            ->PlanejamentoMaritimosEventos
            ->saveMany($entities);
    }


    function efetivada(){
        return @$this->situacao_programacao_maritima->codigo == 'EFETIVADO';
    }

    function cancelado(){
        return @$this->situacao_programacao_maritima->codigo == 'CANCELADO';
    }

    function updateEntityVersao($that, $update){

        if(
            empty($update['nova_versao']) || 
            empty($update['numero']) || 
            empty($update['viagem_numero'])){

            $this->versao = 1;
            return;
        }

        $this->numero = $update['numero'];
        $this->viagem_numero = $update['viagem_numero'];

        $entity = $that->PlanejamentoMaritimos
        ->find()
        ->select('versao')
        ->where([
            'viagem_numero'=>$this->viagem_numero,
            'numero'=>$this->numero
        ])
        ->order(['versao'=>'DESC'])
        ->first();

        $this->versao = $entity ? $entity->versao + 1 : 1;
    }

    function updateOthersPlanementos($that){
        if($this->versao === 1){
            return;
        }
    }

    public static function getFilters()
    {    
        return [
            [
                'name'  => 'planejamento_maritimo',
                'divClass' => 'col-lg-3',
                'label' => 'Planejamento Maritimo',
                'table' => [
                    'className' => 'PlanejamentoMaritimos',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'navio',
                'divClass' => 'col-lg-2',
                'label' => 'Navio',
                'table' => [
                    'className' => 'PlanejamentoMaritimos.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'viagem_numero',
                'divClass' => 'col-lg-2',
                'label' => 'Viagem',
                'table' => [
                    'className' => 'PlanejamentoMaritimos',
                    'field'     => 'viagem_numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'carga_id',
                'divClass' => 'col-lg-2',
                'label' => 'Carga',
                'table' => [
                    'className' => 'PlanejamentoMaritimos.TiposCargas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
