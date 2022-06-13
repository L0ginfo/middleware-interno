<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coleta Entity.
 *
 */
class Coleta extends Entity
{

    public function getDocumentosLiberacao( $that )
    {
        $aData = array();

        $tipo = $that->request->getQuery('tipo');
        $documento = $that->request->getQuery('documento');
        $where = [];
        $whereFilter = [];


        if($tipo){
            $where = ['LiberacoesDocumentais.tipo_documento_id' => $tipo];
        }

        if($documento){
            $where[] = ['LiberacoesDocumentais.numero' => $documento];
        }


        $oLiberacoesDocumentaisPendentes = $that->LiberacoesDocumentais->find('all');

        $subquery = $oLiberacoesDocumentaisPendentes->newExpr()->add(
            '((SELECT 1
                 FROM resvs_liberacoes_documentais x
                    , ordem_servicos os 
                    , resvs r
                WHERE x.liberacao_documental_id = LiberacoesDocumentais.id
                  AND os.resv_id = x.resv_id
                  AND os.data_hora_inicio IS NOT NULL
                  AND os.data_hora_fim IS NOT NULL
                  AND r.id = x.resv_id
                  AND r.data_hora_chegada IS NOT NULL
                  AND r.data_hora_saida IS NOT NULL )
             )'
        );

        if(empty($where)){
            $whereFilter = [function($exp , $q) use($subquery) {
                return $exp->notExists($subquery);
            }];
        }

        $oSituacaoCase = $oLiberacoesDocumentaisPendentes->newExpr()
            ->addCase(
                [
                    $oLiberacoesDocumentaisPendentes->newExpr()->add(
                        '((SELECT 1
                             FROM resvs_liberacoes_documentais x
                                , ordem_servicos os 
                            WHERE x.liberacao_documental_id = LiberacoesDocumentais.id
                              AND os.resv_id = x.resv_id
                              AND os.data_hora_inicio IS NOT NULL
                              AND os.data_hora_fim IS NULL ) IS NOT NULL
                         )'
                    ),
                    $oLiberacoesDocumentaisPendentes->newExpr()->add(
                        '((SELECT 1
                             FROM resvs_liberacoes_documentais x
                                , ordem_servicos os 
                                , resvs r
                            WHERE x.liberacao_documental_id = LiberacoesDocumentais.id
                              AND os.resv_id = x.resv_id
                              AND os.data_hora_inicio IS NOT NULL
                              AND os.data_hora_fim IS NOT NULL
                              AND r.id = x.resv_id
                              AND r.data_hora_chegada IS NOT NULL
                              AND r.data_hora_saida IS NULL ) IS NOT NULL
                         )'
                    ),
                    
                    $oLiberacoesDocumentaisPendentes->newExpr()->add(
                        '((SELECT 1
                             FROM resvs_liberacoes_documentais x
                                , ordem_servicos os 
                                , resvs r
                            WHERE x.liberacao_documental_id = LiberacoesDocumentais.id
                              AND os.resv_id = x.resv_id
                              AND os.data_hora_inicio IS NOT NULL
                              AND os.data_hora_fim IS NOT NULL
                              AND r.id = x.resv_id
                              AND r.data_hora_chegada IS NOT NULL
                              AND r.data_hora_saida IS NOT NULL ) IS NOT NULL
                         )'
                    ),

                    $oLiberacoesDocumentaisPendentes->newExpr()->add(
                        '((SELECT 1
                             FROM resvs_liberacoes_documentais x
                            WHERE x.liberacao_documental_id = LiberacoesDocumentais.id) IS NULL
                         )'
                    ),
                    $oLiberacoesDocumentaisPendentes->newExpr()->add(
                        '((SELECT 1
                             FROM resvs_liberacoes_documentais x
                            WHERE x.liberacao_documental_id = LiberacoesDocumentais.id) IS NOT NULL
                         )'
                    )
                ],
                ['os_carga_iniciada', 'informar_saida', 'os_carga_finalizada', 'aguardando_chegada', 'chegada_informada', ''],
                ['string', 'string', 'string', 'string', 'string', 'string']
            );

        $oResvsFinalizar = $oLiberacoesDocumentaisPendentes->newExpr()->add(
            '(SELECT CONCAT(resv_id, ",", liberacao_documental_id) resv_lib
                FROM resvs_liberacoes_documentais x
               WHERE x.liberacao_documental_id = LiberacoesDocumentais.id
             )'
        );

        $oLiberacoesDocumentaisPendentes
            ->select([
                'doc_lib_id'     => 'LiberacoesDocumentais.id',
                'numero_doc_lib' => 'LiberacoesDocumentais.numero',
                'data_liberacao' => 'LiberacoesDocumentais.data_desembaraco',
                'situacao'       => $oSituacaoCase,
                'resvs_lib'      => $oResvsFinalizar
            ])
            ->where([
                'aftn_id                     IS NOT NULL',
                'data_desembaraco            IS NOT NULL',
                'canal_id                    IS NOT NULL',
                'tipo_documento_liberacao_id IS NOT NULL',
                'numero_documento_liberacao  IS NOT NULL',
                $where 
            ])
            ->where($whereFilter);

        $aLiberacoesDocumentaisPendentes = $oLiberacoesDocumentaisPendentes->toArray();

        /*if (!$aLiberacoesDocumentaisPendentes)
            return array();

        $aRetornos = array();

        foreach ($aLiberacoesDocumentaisPendentes as $key => $aLiberacaoDocumentalPendente) {
            $oOSjaExecutada = $that->OrdemServicos->find()
                ->contain([
                    'Resvs'
                ])
                ->innerJoinWith('Resvs.ResvsLiberacoesDocumentais')
                ->where([
                    'OrdemServicos.data_hora_fim IS NOT NULL',
                    'OrdemServicos.ordem_servico_tipo_id' => 2, // CARGA
                    'ResvsLiberacoesDocumentais.liberacao_documental_id' => $aLiberacaoDocumentalPendente->doc_lib_id
                ])
                ->first();
                
            if (!$oOSjaExecutada)
                $aRetornos[] = $aLiberacaoDocumentalPendente;
        }*/

        return $aLiberacoesDocumentaisPendentes;
    }

}
