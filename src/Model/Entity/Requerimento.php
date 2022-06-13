<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requerimento Entity.
 *
 * @property int $id
 * @property string $bl_awb
 * @property string $cnpj_cliente
 * @property string $numero_documento
 * @property \Cake\I18n\Time $data_emissao
 * @property string $ce_mercante
 * @property string $cnpj_representante
 * @property float $valor_cif
 * @property string $referencia_cliente
 * @property string $observacoes
 * @property int $empresa_id
 * @property \App\Model\Entity\Empresa $empresa
 * @property int $moeda_id
 * @property \App\Model\Entity\Moeda $moeda
 * @property int $documento_id
 * @property \App\Model\Entity\Documento $documento
 * @property int $navio_viagem_id
 * @property \App\Model\Entity\NavioViagem $navio_viagem
 * @property \App\Model\Entity\Anexo[] $anexos
 * @property \App\Model\Entity\CargaGerai[] $carga_gerais
 * @property \App\Model\Entity\Container[] $containers
 */
class Requerimento extends Entity {

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

    /**
      Ex. String DTA:
      201630000000000767785ITJ999999

      Ex. String DTC:
      201600000000000767858NVT999999

      Regras

      Pos. Ini. Pos. Fim Conteúdo
      1 4 Pegar os dois primeiros digitos do "numero_documento" e adiciona 20 na frente (Ex.: "2016")
      5 5 (se documento_id igual a DTA recebe Fixo "3" ) ou ( DTC recebe "0")
      6 21 Pegar o terceiro digito do numero_documento, remover caracteres especiais (Ex.: Doc. = /76778-5 então Conteúdo = "0000000000767785")
      22 24 Prefixo da Procedência proveniente da procedencia- criando na tarefa #391.
      25 30 Fixo "99999"
     */
    public function _getValorCIF($formatado_BR = true) {
        $valor_soma = 0;
        foreach ($this->_properties['lotes'] as $l) {
            $valor = $l->valor_cif;
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);

            $valor_soma+= floatval($valor);
        }
        if ($formatado_BR) {
            return number_format($valor_soma, 2, ',', '.');
        } else {
            return number_format($valor_soma, 2);
        }
    }

    public function _getIdentificacaoDocumento() {

        $caracteres_especiais = ['/', '-']; // para remover
        $retorno = 20;
        $retorno .= substr($this->_properties['numero_documento'], 0, 2);
        $retorno .= $this->_properties['documento']['nome'] == 'DTA' ? 3 : 0;
        $retorno .= str_pad(substr(str_replace($caracteres_especiais, "", $this->_properties['numero_documento']), 2), 16, "0", STR_PAD_LEFT);
        $retorno .= substr($this->_properties['procedencia']['codigo'], 0, 3);
        $retorno .= '999999';
        return $retorno;
    }

    public function _getQuantidadeVolumeTotal() {
        $retorno = 0;
        foreach ($this->_properties['lotes'] as $l) {
            foreach ($l->containers as $c) {
                if ($c->itens) {
                    foreach ($c->itens as $i) {
                        $retorno += $i->quantidade;
                    }
                }
            }
        }
        return $retorno;
    }

    public function _getPesoBrutoTotal() {
        $retorno = 0;
        foreach ($this->_properties['lotes'] as $l) {
            foreach ($l->containers as $c) {
                if ($c->itens) {
                    foreach ($c->itens as $i) {
                        $retorno += $i->peso_bruto;
                    }
                }
            }
        }
        return $retorno;
    }

    public function _getPesoLiquidoTotal() {
        $retorno = 0;
        foreach ($this->_properties['lotes'] as $l) {
            foreach ($l->containers as $c) {
                if ($c->itens) {
                    foreach ($c->itens as $i) {
                        $retorno += $i->peso_liquido;
                    }
                }
            }
        }
        return $retorno;
    }

    public function _getFobTotal($formatado_BR = true) {
        $valor_soma = 0;

        foreach ($this->_properties['lotes'] as $l) {
            $valor = $l->valor_fob;
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);

            $valor_soma+= floatval($valor);
        }
        if ($formatado_BR) {
            return number_format($valor_soma, 2, ',', '.');
        } else {
            return number_format($valor_soma, 2);
        }
    }

    public function _getFreteTotal($formatado_BR = true) {
        $valor_soma = 0;
        foreach ($this->_properties['lotes'] as $l) {
            $valor = $l->valor_frete;
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);

            $valor_soma+= floatval($valor);
        }
        if ($formatado_BR) {
            return number_format($valor_soma, 2, ',', '.');
        } else {
            return number_format($valor_soma, 2);
        }
    }

    public function _getSeguroTotal($formatado_BR = true) {
        $valor_soma = 0;
        foreach ($this->_properties['lotes'] as $l) {
            $valor = $l->valor_seguro;
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);

            $valor_soma+= floatval($valor);
        }
        if ($formatado_BR) {
            return number_format($valor_soma, 2, ',', '.');
        } else {
            return number_format($valor_soma, 2);
        }
    }

    public function _getQuantidadeConhecimento() {
        $retorno = 0;
        foreach ($this->_properties['lotes'] as $l) {

            $retorno++;
        }
        return $retorno;
    }

    public function _getEmbalagemSara() {
        $retorno = 'null';

        foreach ($this->_properties['lotes'] as $l) {
            foreach ($l->containers as $c) {
                if ($c->itens) {
                    foreach ($c->itens as $i) {

                        if ($i->embalagem) {

                            foreach ($i->embalagem as $e) {
                                return $e['valor'];
                            }
                        }
                    }
                }
            }
        }

        return $retorno;
    }
   
}
