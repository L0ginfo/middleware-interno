<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\TableRegistry;

/**
 * Lote Entity.
 *
 * @property int $id
 * @property int $tipo_conhecimento_id
 * @property \App\Model\Entity\TipoConhecimento $tipo_conhecimento
 * @property string $conhecimento
 * @property \Cake\I18n\Time $data_conhecimento
 * @property string $ce_mercante
 * @property string $referencia_cliente
 * @property int $moeda_id
 * @property \App\Model\Entity\Moeda $moeda
 * @property string $valor_cif
 * @property string $valor_fob
 * @property string $valor_frete
 * @property string $valor_seguro
 * @property string $familia_codigo
 * @property int $pais_id
 * @property \App\Model\Entity\Pais $pais
 * @property \App\Model\Entity\Entrada $entrada
 * @property \App\Model\Entity\Anexo[] $anexos
 * @property \App\Model\Entity\CargaGeral[] $carga_gerais
 * @property \App\Model\Entity\Container[] $containers
 * @property \App\Model\Entity\Item[] $itens
 */
class Lote extends Entity {

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

    public function _getPesoBrutoTotal() {
        // debug($this);die();

        $retorno = 0;
        foreach ($this->_properties['itens'] as $i) {
            $retorno += $i->peso_bruto;
        }
        return $retorno;
    }

    public function _getPesoLiquidoTotal() {
        $retorno = 0;
        foreach ($this->_properties['itens'] as $i) {
            $retorno += $i->peso_liquido;
        }
        return $retorno;
    }

    public function _getQuantidadeVolumeTotal() {
        $retorno = 0;
        foreach ($this->_properties['itens'] as $i) {
            $retorno += $i->quantidade;
        }
        return $retorno;
    }

    public static function getArraySituacoes()
    {
        return [
            'Em Digitação' => [
                'color' => 'default',
                'width' => '14'
            ],
            'Agendado' => [
                'color' => 'info',
                'width' => '28'
            ],
            'Aguardando Entrada' => [
                'color' => 'warning',
                'width' => '42'
            ],
            'Em Operação' => [
                'color' => 'danger',
                'width' => '56'
            ],
            'Em Estoque' => [
                'color' => 'success',
                'width' => '70'
            ],
            'Aguardando Saida' => [
                'color' => 'warning',
                'width' => '84'
            ],
            'Fechado' => [
                'color' => 'success',
                'width' => '100'
            ]
        ];
    }

    public static function getSituacaoDocMercadoria($oDocumentoMercadoria)
    {
        $oDocumentoSituacao = LgDbUtil::getFind('DocumentosMercadorias')
            ->select([
                'situacao' => "CASE 
                    WHEN EXISTS (SELECT 1
                            FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
                            WHERE DocumentosTransportes.id       = rdt.documento_transporte_id
                                AND rdt.resv_id = r.id
                                AND os.resv_id  = rdt.resv_id
                                AND os.data_hora_inicio IS NOT NULL
                                AND os.data_hora_fim    IS NOT NULL
                                AND r.data_hora_chegada IS NOT NULL
                                AND r.data_hora_saida   IS NOT NULL
                                AND NOT EXISTS (SELECT 1
                                    FROM estoque_enderecos estoque
                                    WHERE estoque.lote_codigo = DocumentosMercadorias.lote_codigo) )
                    THEN 'Fechado'
                    WHEN (SELECT count(1) 
                            FROM resvs_documentos_transportes rdt, resvs r, ordem_servicos os
                            WHERE rdt.documento_transporte_id = DocumentosTransportes.id 
                                AND rdt.resv_id = r.id
                                AND os.resv_id  = rdt.resv_id
                                AND os.data_hora_inicio IS NOT NULL
                                AND r.data_hora_chegada IS NOT NULL
                                AND (SELECT count(1)
                                FROM estoque_enderecos estoque
                                WHERE estoque.lote_codigo = DocumentosMercadorias.lote_codigo) ) = 1
                    THEN 'Aguardando Saida'
                    WHEN (SELECT count(1) 
                            FROM estoque_enderecos estoque
                            WHERE estoque.lote_codigo = DocumentosMercadorias.lote_codigo) = 1
                    THEN 'Em Estoque'
                    WHEN (SELECT count(1) 
                            FROM resvs_documentos_transportes rdt, resvs r
                            WHERE rdt.documento_transporte_id = DocumentosTransportes.id  
                                AND rdt.resv_id = r.id
                                AND data_hora_chegada IS NOT NULL
                                AND data_hora_entrada IS NOT NULL
                                AND data_hora_saida IS NULL) = 1
                    THEN 'Em Operação'
                    WHEN (SELECT count(1) 
                            FROM resvs_documentos_transportes rdt, resvs r
                            WHERE rdt.documento_transporte_id = DocumentosTransportes.id  
                                AND rdt.resv_id = r.id
                                AND data_hora_chegada IS NOT NULL
                                AND data_hora_entrada IS NULL
                                AND data_hora_saida IS NULL) = 1
                    THEN 'Aguardando Entrada'
                    WHEN (SELECT count(1) 
                            FROM programacao_documento_transportes pdt
                                WHERE pdt.documento_transporte_id = DocumentosTransportes.id) = 1
                    THEN 'Agendado'
                    WHEN (SELECT count(1)
                            WHERE NOT EXISTS (SELECT 1
                                FROM resvs_documentos_transportes rdt
                                WHERE rdt.documento_transporte_id = DocumentosTransportes.id) ) = 1
                    THEN 'Em Digitação' 
                    ELSE 'Fechado' end"
            ])
            ->leftJoinWith('DocumentosTransportes.ContainerEntradas.Containers')
            ->leftJoinWith('DocumentosTransportes.Resvs')
            ->where([
                'DocumentosMercadorias.id' => $oDocumentoMercadoria->id
            ])
            ->first();

        return $oDocumentoSituacao->situacao ?? 'Sem Status';
    }

}
