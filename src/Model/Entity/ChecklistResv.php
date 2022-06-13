<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;

/**
 * ChecklistResv Entity
 *
 * @property int $id
 * @property int $resv_id
 * @property int $checklist_id
 * @property \Cake\I18n\Time|null $data_inicio
 * @property \Cake\I18n\Time|null $data_fim
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\Checklist $checklist
 * @property \App\Model\Entity\ChecklistPerguntaFoto[] $checklist_pergunta_fotos
 * @property \App\Model\Entity\ChecklistResvPergunta[] $checklist_resv_perguntas
 * @property \App\Model\Entity\ChecklistResvResposta[] $checklist_resv_respostas
 */
class ChecklistResv extends Entity
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
        
        'resv_id' => true,
        'checklist_id' => true,
        'data_inicio' => true,
        'data_fim' => true,
        'resv' => true,
        'checklist' => true,
        'checklist_pergunta_fotos' => true,
        'checklist_resv_perguntas' => true,
        'checklist_resv_respostas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters($aDataQuery)
    {
        $aVeiculosWhere = [];
        if ($aDataQuery['placa']['values'][0])
            $aVeiculosWhere += ['Veiculos.id' => $aDataQuery['placa']['values'][0]];
        $aVeiculos = LgDbUtil::get('Veiculos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aVeiculosWhere)
            ->limit(1);

        return [
            [
                'name'  => 'placa',
                'divClass' => 'col-lg-2',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'veiculo_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Veiculos', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aVeiculos,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
        ];
    }

    public static function getFiltersChecklistResvs($aDataQuery)
    {
        $aVeiculosWhere = [];
        if ($aDataQuery['placa']['values'][0])
            $aVeiculosWhere += ['Veiculos.id' => $aDataQuery['placa']['values'][0]];
        $aVeiculos = LgDbUtil::get('Veiculos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aVeiculosWhere)
            ->limit(1);

        $aChecklistsWhere = [];
        if ($aDataQuery['checklist']['values'][0])
            $aChecklistsWhere += ['Checklists.id' => $aDataQuery['checklist']['values'][0]];
        $aChecklists = LgDbUtil::get('Checklists')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aChecklistsWhere)
            ->limit(1);

        return [
            [
                'name'  => 'placa',
                'divClass' => 'col-lg-2',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Resvs.Veiculos',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'veiculo_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Veiculos', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aVeiculos,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'checklist',
                'divClass' => 'col-lg-2',
                'label' => 'Checklist',
                'table' => [
                    'className' => 'Checklists',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'veiculo_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Checklists', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aChecklists,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
        ];
    }

    public static function saveChecklistResvs($aDataPost, $iResvID)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'resv_id'      => $iResvID,
            'checklist_id' => $aDataPost['checklist_id']
        ];

        $oChecklistResvs = LgDbUtil::saveNew('ChecklistResvs', $aDataInsert, true);
        if (!$oChecklistResvs) 
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao salvar o Checklist Resvs.');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oChecklistResvs);
    }

    public static function saveChecklistResvsPerguntasAndRespostas($oChecklistResvs)
    {
        $oResponse = new ResponseUtil();

        $oChecklist = LgDbUtil::getFind('Checklists')
            ->contain([
                'ChecklistPerguntas' => [
                    'ChecklistPerguntaRespostas'
                ]
            ])
            ->where(['Checklists.id' => $oChecklistResvs->checklist_id])
            ->first();

        if (!$oChecklist || !$oChecklist->checklist_perguntas)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que o checklist selecionado está incompleto!');

        foreach ($oChecklist->checklist_perguntas as $oChecklistPergunta) {
            
            $aDataInsert = [
                'checklist_pergunta_id' => $oChecklistPergunta->id,
                'checklist_resv_id'     => $oChecklistResvs->id
            ];
    
            $oChecklistResvPergunta = LgDbUtil::saveNew('ChecklistResvPerguntas', $aDataInsert, true);
            if (!$oChecklistResvPergunta) 
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao atualizar as perguntas desse checklist.');
                    
            foreach ($oChecklistPergunta->checklist_pergunta_respostas as $oChecklistPerguntaResposta) {
                        
                $aDataInsert = [
                    'checklist_resv_id'              => $oChecklistResvs->id,
                    'checklist_pergunta_resposta_id' => $oChecklistPerguntaResposta->id,
                    'checklist_resv_pergunta_id'     => $oChecklistResvPergunta->id
                ];
        
                $oChecklistResvResposta = LgDbUtil::saveNew('ChecklistResvRespostas', $aDataInsert, true);
                if (!$oChecklistResvResposta) 
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Ocorreu algum erro ao atualizar as respostas desse checklist.');

            }

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function getDadosChecklistResvImprimir($iChecklistResvID)
    {
        $oChecklistResvs = LgDbUtil::getFind('ChecklistResvs')
            ->contain([
                'Resvs' => [
                    'Veiculos'
                ],
                'Checklists',
                'ChecklistResvPerguntas' => [
                    'ChecklistPerguntas',
                    'ChecklistResvRespostas' => [
                        'ChecklistPerguntaRespostas'
                    ]
                ]
            ])
            ->where(['ChecklistResvs.id' => $iChecklistResvID])
            ->first();

        $aDadosChecklistResv = [
            'oChecklistResvs'               => $oChecklistResvs,
            'checklist_descricao'           => $oChecklistResvs->checklist->descricao,
            'checklist_descricao_detalhada' => $oChecklistResvs->checklist->descricao_detalhada,
            'resv_placa'                    => $oChecklistResvs->resv->veiculo->descricao,
            'resv_reboques'                 => $oChecklistResvs->resv->veiculo->descricao,
            'resv_data_entrada'             => $oChecklistResvs->resv->data_hora_entrada ? date_format($oChecklistResvs->resv->data_hora_entrada, 'd/m/Y H:i') : '',
            'resv_data_saida'               => $oChecklistResvs->resv->data_hora_saida ? date_format($oChecklistResvs->resv->data_hora_saida, 'd/m/Y H:i') : '',
            'resv_documentos_entrada'       => self::getDadosDocumentosResv($oChecklistResvs->resv, 'Entrada'),
            'resv_documentos_saida'         => self::getDadosDocumentosResv($oChecklistResvs->resv, 'Saida'),
        ];


        return $aDadosChecklistResv;

    }

    private static function getDadosDocumentosResv($oResv, $sTipo)
    {
        $sDocumentos = '';

        if (Resv::isCarga($oResv) && $sTipo == 'Saida') {

            $oResvLiberacoesDocumentais = LgDbUtil::getFind('ResvsLiberacoesDocumentais')
                ->contain(['LiberacoesDocumentais'])
                ->where(['ResvsLiberacoesDocumentais.resv_id' => $oResv->id])
                ->toArray();

            foreach ($oResvLiberacoesDocumentais as $oResvLiberacaoDocumental)
                $sDocumentos .= $oResvLiberacaoDocumental->liberacoes_documental->numero . '; ';

        } else if (Resv::isDescarga($oResv) && $sTipo == 'Entrada') {

            $oResvDocumentosTransportes = LgDbUtil::getFind('ResvsDocumentosTransportes')
                ->contain(['DocumentosTransportes'])
                ->where(['ResvsDocumentosTransportes.resv_id' => $oResv->id])
                ->toArray();

            foreach ($oResvDocumentosTransportes as $oResvDocumentoTransporte)
                $sDocumentos .= $oResvDocumentoTransporte->documentos_transporte->numero . '; ';
        }

        return $sDocumentos;
    }

}
