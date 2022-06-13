<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RetornoLeitura Entity
 *
 * @property int $id
 * @property string $arquivo_nome
 * @property \Cake\I18n\Time $data_leitura
 * @property \Cake\I18n\Time|null $data_processamento
 * @property \Cake\I18n\Time|null $data_reprocessamento
 * @property \Cake\I18n\Time|null $data_conclusao
 * @property string|null $dados
 * @property string|null $erros
 * @property int $status
 * @property int $tipo
 *
 * @property \App\Model\Entity\FaturamentoBaixa[] $faturamento_baixas
 */
class RetornoLeitura extends Entity
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
        'arquivo_nome' => true,
        'data_leitura' => true,
        'data_processamento' => true,
        'data_reprocessamento' => true,
        'data_conclusao' => true,
        'dados' => true,
        'erros' => true,
        'status' => true, 
        'tipo' => true,
        'faturamento_baixas' => true,
    ];

    /**
     * Status
     * -2 = falhou em processar os dados, 
     * -1 = falhou em ler o arquivos, 
     *  1 = sucesso em ler e fica aguardando a ser processado
     *  2 = sucesso em processar o arquivo
     *  3 = alguns (ou nenhum) retorno(s) processado(s), mas que ainda faltam retornos a serem processados
     */
}
