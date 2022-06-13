<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Entrada Entity.
 *
 * @property int $id
 * @property int $quantidade_veiculo
 * @property string $cnpj_cliente
 * @property \App\Model\Entity\Empresa $cliente
 * @property string $numero_documento
 * @property \Cake\I18n\Time $data_emissao
 * @property string $cnpj_representante
 * @property \App\Model\Entity\Empresa $representante
 * @property string $cnpj_despachante
 * @property \App\Model\Entity\Empresa $despachante
 * @property string $cnpj_destinatario
 * @property string $referencia_cliente
 * @property int $status
 * @property string $observacoes
 * @property int $empresa_id
 * @property \App\Model\Entity\Empresa $empresa
 * @property int $documento_id
 * @property \App\Model\Entity\Documento $documento
 * @property int $navio_viagem_id
 * @property \App\Model\Entity\NavioViagem $navio_viagem
 * @property int $procedencia_id
 * @property \App\Model\Entity\Procedencia $procedencia
 * @property string $cfop
 * @property string $serie
 * @property \App\Model\Entity\TipoNatureza $tipo_natureza
 * @property \App\Model\Entity\Agendamento[] $agendamentos
 * @property \App\Model\Entity\ItemAgendamento[] $item_agendamentos
 * @property \App\Model\Entity\Lote[] $lotes
 */
class Entrada extends Entity {

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

    public function _getIdentificacaoDocumento() {

        //  debug($this->_properties);
        $procedencia = '0000';
        if (@$this->_properties['Containers'][0]['lote']['procedencia']['codigo']) {
            $procedencia = $this->_properties['Containers'][0]['lote']['procedencia']['codigo'];
        }
        if (@$this->_properties['Lotes'][0]['procedencia']['codigo']) {
            $procedencia = $this->_properties['Lotes'][0]['procedencia']['codigo'];
        }
        $tipo = 0;

        if ($this->_properties['documento']['nome'] == 'DTA') {
            $tipo = 3;
        }
        if ($this->_properties['documento']['nome'] == 'NF') {
            $tipo = 7;
        }

        $caracteres_especiais = ['/', '-']; // para remover
        $retorno = 20;
        $retorno .= substr($this->_properties['numero_documento'], 0, 2);
        $retorno .=$tipo;
        $retorno .= str_pad(substr(str_replace($caracteres_especiais, "", $this->_properties['numero_documento']), 2), 16, "0", STR_PAD_LEFT);
        $retorno .= substr($this->_getProcedencia(), 0, 3);
        $retorno .= '999999';
        return $retorno;
    }

    public function _getProcedencia() {

        //  debug($this->_properties);
        $procedencia = '0000';
        if (@$this->_properties['Containers'][0]['lote']['procedencia']['codigo']) {
            $procedencia = $this->_properties['Containers'][0]['lote']['procedencia']['codigo'];
        }
        if (@$this->_properties['Lotes'][0]['procedencia']['codigo']) {
            $procedencia = $this->_properties['Lotes'][0]['procedencia']['codigo'];
        }

        return $procedencia;
    }

    public function _getPesoBrutoTotal() {
        // debug($this);die();

        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            foreach ($c['itens'] as $i) {
                $retorno +=  $i->peso_bruto;
            }
        }
        foreach (@$this->_properties['Lotes'] as $l) {
            foreach ($l['itens'] as $i) {
                $retorno += $i->peso_bruto;
            }
        }

        
        return $retorno;
    }

    public function _getPesoLiquidoTotal() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            foreach ($c['itens'] as $i) {
                $retorno +=  $i->peso_liquido;
            }
        }
        foreach (@$this->_properties['Lotes'] as $l) {
            foreach ($l['itens'] as $i) {
                $retorno +=  $i->peso_liquido;
            }
        }
        return $retorno;
    }

    public function _getQuantidadeVolumeTotal() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            foreach ($c['itens'] as $i) {
                $retorno = $this->_SomaFloat($retorno, $i->quantidade);
            }
        }
        foreach (@$this->_properties['Lotes'] as $l) {
            foreach ($l['itens'] as $i) {
                $retorno = $this->_SomaFloat($retorno, $i->quantidade);
            }
        }
        return $retorno;
    }

    public function _getFreteTotal() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            $retorno = $this->_SomaFloat($retorno, $c['lote']['valor_frete']);
        }
        foreach (@$this->_properties['Lotes'] as $i) {
            $retorno = $this->_SomaFloat($retorno, $i->valor_frete);
        }
        return $retorno;
    }

    public function _getSeguroTotal() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {

            $retorno = $this->_SomaFloat($retorno, $c['lote']['valor_seguro']);
        }
        foreach (@$this->_properties['Lotes'] as $i) {
            $retorno = $this->_SomaFloat($retorno, $i->valor_seguro);
        }
        return $retorno;
    }

    public function _getFobTotal() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            $retorno = $this->_SomaFloat($retorno, $c['lote']->valor_fob);
        }
        foreach (@$this->_properties['Lotes'] as $i) {
            $retorno = $this->_SomaFloat($retorno, $i->valor_fob);
        }
        return $retorno;
    }

    public function _getValorCIF() {
        $retorno = 0;

        foreach (@$this->_properties['Containers'] as $c) {
            $retorno = $this->_SomaFloat($retorno, $c['lote']['valor_cif']);
        }
        foreach (@$this->_properties['Lotes'] as $i) {
            $retorno = $this->_SomaFloat($retorno, $i->valor_cif);
        }
        return $retorno;
    }

    public function _getEmbalagemSara() {
        $retorno = 'null';

        if (@$this->_properties['Containers'][0]['itens'][0]['embalagem']['valor']) {
            $retorno = $this->_properties['Containers'][0]['itens'][0]['embalagem']['valor'];
        }
        //debug($this->_properties['Lotes'][0]);
        if (@$this->_properties['Lotes'][0]['itens'][0]['embalagem']['valor']) {
            $retorno = $this->_properties['Lotes'][0]['itens'][0]['embalagem']['valor'];
        }
        return $retorno;
    }

    public function _getQuantidadeLotes() {
        $lotes = [];

       
        foreach (@$this->_properties['Containers'] as $c) {
            $lotes[$c['lote']['id']] = 1;
        }
        foreach (@$this->_properties['Lotes'] as $i) {

            $lotes[$i['id']] = 1;
        }
   //      debug($lotes);
        return count($lotes);
    }

    private function _SomaFloat($valorsoma, $valor) {
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);

        $valorsoma+= floatval($valor);
        return $valorsoma;
    }


}
