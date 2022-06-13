<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\RequestUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * Moeda Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $sigla
 *
 * @property \App\Model\Entity\Entrada[] $entradas
 */
class Moeda extends Entity
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
        'descricao' => true,
        'sigla' => true,
        'entradas' => true
    ];

    public static function realizaCotacao()
    {
        $oIntegracao = LgDbUtil::getFirst('Integracoes', [
            'codigo_unico' => 'integracao-cotacao-moedas'
        ]);

        $aMoedas = LgDbUtil::getFind('Moedas')->toArray();

        $sHost = $oIntegracao->url_endpoint;
        $aCotacoesIntegracao = json_decode(file_get_contents($sHost));
        $aCotacoes = [];
        
        foreach ($aCotacoesIntegracao->Result->Taxas as $oCotacao) {
            $aCotacoes[$oCotacao->codigo] = $oCotacao->taxaFiscal;
        }

        foreach ($aMoedas as $oMoeda) {

            if (!$oMoeda->codigo || !@$aCotacoes[$oMoeda->codigo])
                continue;

            EntityUtil::getOrSave([
                'tipo_cotacao'  => 'API',
                'data_cotacao'  => DateUtil::dateTimeToDB(date('Y-m-d'), 'Y-m-d', ''),
                'valor_cotacao' => $aCotacoes[$oMoeda->codigo],
                'moeda_id'      => $oMoeda->id
            ], 'MoedasCotacoes', ['tipo_cotacao', 'data_cotacao', 'moeda_id']);
        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Cotações salvas com sucesso.');
    }
}
