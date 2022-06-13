<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Endereco Entity
 *
 * @property int $id
 * @property string $descricao
 * @property float|null $comprimento
 * @property float $altura
 * @property float $largura
 * @property float $m2
 * @property float $m3
 * @property int $ativo
 * @property int $cod_composicao1
 * @property int $cod_composicao2
 * @property int|null $cod_composicao3
 * @property int|null $cod_composicao4
 * @property int $area_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Area $area
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\EstoqueEndereco[] $estoque_enderecos
 * @property \App\Model\Entity\EtiquetaProduto[] $etiqueta_produtos
 */
class Endereco extends Entity
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
        'comprimento' => true,
        'altura' => true,
        'largura' => true,
        'm2' => true,
        'm3' => true,
        'ativo' => true,
        'cod_composicao1' => true,
        'cod_composicao2' => true,
        'cod_composicao3' => true,
        'cod_composicao4' => true,
        'area_id' => true,
        'empresa_id' => true,
        'area' => true,
        'empresa' => true,
        'estoque_enderecos' => true,
        'etiqueta_produtos' => true,
        'sob_rodas' => true
    ];

    public static $aDePara = [
        'cod_composicao1' => [
            '1' => 'A',
            '2' => 'B',
            '3' => 'C',
            '4' => 'D',
            '5' => 'E',
            '6' => 'F',
            '7' => 'G',
            '8' => 'H',
            '9' => 'I',
        ],
        'cod_composicao2' => 'Q'
    ];

    public static function aGetListaEtiquetas($iLocal, $iEmpresa){
        return TableRegistry::get('Enderecos')->find()
            ->contain(['Areas'])
            ->where([
                'Enderecos.empresa_id'=>$iEmpresa, 
                'Areas.local_id'=>$iLocal
            ])
            ->select([
                'id', 
                'cod_composicao1', 
                'cod_composicao2', 
                'cod_composicao3', 
                'cod_composicao4',
                'area_descricao' => 'Areas.descricao'
            ])
            ->order([
                'Areas.descricao' => 'ASC',
                'cod_composicao1' => 'ASC', 
                'cod_composicao2' => 'ASC', 
                'cod_composicao3' => 'ASC', 
                'cod_composicao4' => 'ASC',
            ])
            ->toArray();
    }

    /**
     * com_local_area
     * com_local
     * com_area
     */
    public static function getEnderecoCompletoByID( $that, $iEnderecoID, $oEndereco = null, $aDataExtra = [] )
    {
        //alterar para parametro posteriormente, caso houver outras formatações de exibição
        $bConverteComposicao = false;
        $iCasasPadding = array_key_exists('casas_padding', $aDataExtra)
            ? $aDataExtra['casas_padding']
            : 4;
        
        if (!$oEndereco) {
            if ( $that ) {
                $that->loadModel('Enderecos');
                $oEndereco = $that->Enderecos->find()->where(['id' => $iEnderecoID])->first();
            }else {
                $that = TableRegistry::getTableLocator()->get('Enderecos');
                $oEndereco = $that->find()->contain(['Areas' => ['Locais']])->where(['Enderecos.id' => $iEnderecoID])->first();
            }
        }

        if (!$oEndereco)
            return '';

        $aComposicao = [];

        for ($i=1; $i <= 4; $i++) { 

            $property = 'cod_composicao' . $i;

            if (isset($oEndereco->{$property}) && $oEndereco->{$property} != '') 
                if ($bConverteComposicao && $oEndereco->area_id == 1) {
                    if ($i == 1) 
                        $aComposicao[] = self::$aDePara[$property][$oEndereco->{$property}];
                    elseif ($i == 2)
                        $aComposicao[] = self::$aDePara[$property] . str_pad($oEndereco->{$property}, 2, '0', STR_PAD_LEFT);
                    elseif ($i == 3)
                        $aComposicao[] = str_pad($oEndereco->{$property}, 2, '0', STR_PAD_LEFT);
                    elseif ($i == 4)
                        $aComposicao[] = str_pad($oEndereco->{$property}, 1, '0', STR_PAD_LEFT);
                } else {
                    $aComposicao[] = str_pad($oEndereco->{$property}, $iCasasPadding, '0', STR_PAD_LEFT);
                }
        }

        if (array_key_exists('ultima_composicao', $aDataExtra))
            $aComposicao = [end($aComposicao)];

        if ($bConverteComposicao)
            $sEnderecoComposicao = implode('.', $aComposicao);
        else 
            $sEnderecoComposicao = implode(' > ', $aComposicao);

        if (isset($aDataExtra['com_local_area'])) 
            $sEnderecoComposicao = $oEndereco->area->local->descricao . ' ~ ' . $oEndereco->area->descricao . ' ~ ' . $sEnderecoComposicao;
        if (isset($aDataExtra['com_area'])) 
            $sEnderecoComposicao = $oEndereco->area->descricao . ' ~ ' . $sEnderecoComposicao;
        if (isset($aDataExtra['com_local'])) 
            $sEnderecoComposicao = $oEndereco->area->local->descricao . ' ~ ' . $sEnderecoComposicao;
        
        return $sEnderecoComposicao;
    }

    public static function getEnderecoByLoginPattern($aData)
    {
        $sEnderecoDestino = $aData['endereco_destino'];
        $aLocais = is_array($aData['local_id']) ? $aData['local_id'] : [$aData['local_id']];
        $aAreas = is_array($aData['area_id']) ? $aData['area_id'] : [$aData['area_id']];
        $aEnderecoComposicoes = explode('.', $sEnderecoDestino);
        $aEnderecoNewComposicoes = [];
        $aQuery = [];
        foreach ($aEnderecoComposicoes as $key => $sEnderecoComposicao) {
            $i = ($key + 1);
            $property = 'cod_composicao' . $i;
            if ($i == 1)
                $sCodComposicao = array_search(strtoupper($sEnderecoComposicao), self::$aDePara[$property]);
            elseif ($i == 2)
                $sCodComposicao = (int) str_replace(self::$aDePara[$property], '', $sEnderecoComposicao);
            elseif ($i == 3 || $i == 4)
                $sCodComposicao = (int) $sEnderecoComposicao;
            $aEnderecoNewComposicoes[] = $sCodComposicao;
        }
        foreach ($aEnderecoNewComposicoes as $key => $sComposicao) {
            $aQuery += ['cod_composicao' . ($key + 1) => $sComposicao];
        }
        $oEndereco = TableRegistry::get('Enderecos')->find()
            ->contain('Areas.Locais')
            ->where($aQuery + [
                'Enderecos.area_id IN' => $aLocais,
                'Areas.local_id In'    => $aAreas,
                'Enderecos.ativo'   => 1
            ])
            ->first();
        return $oEndereco;
    }

    public static function getAllList($aEnderecosRestritos = [], $sTipoComposicao = 'com_local', $iCasasPadding = 4)
    {
        $aEnderecos = LgDbUtil::getFind('Enderecos')
            ->contain([
                'Areas' => [
                    'Locais'
                ]
            ])
            ->order([
                'cod_composicao1' => 'ASC',
                'cod_composicao2' => 'ASC',
                'cod_composicao3' => 'ASC',
                'cod_composicao4' => 'ASC',
            ])
            ->toArray();
            
        $aList = [];

        $aTipoComposicao = $sTipoComposicao 
            ? [$sTipoComposicao => true]
            : [];

        $aDataExtra = $aTipoComposicao + ['casas_padding' => $iCasasPadding];
        
        foreach ($aEnderecos as $oEndereco) {
            if ($aEnderecosRestritos !== null) {
                if ( in_array($oEndereco->id, $aEnderecosRestritos) ) {
                    $aList[ $oEndereco->id ] = Endereco::getEnderecoCompletoByID(null, null, $oEndereco, $aDataExtra);
                }
            }else {
                $aList[ $oEndereco->id ] = Endereco::getEnderecoCompletoByID(null, null, $oEndereco, $aDataExtra);
            }
        }

        return $aList;
    }

    public static function getEnderecosComposicoes($aEnderecos)
    {
        if (!$aEnderecos)
            return [];

        $aEnderecoComposicoes = [];

        $aEnderecos = LgDbUtil::getAll('Enderecos', [
            'id IN' => $aEnderecos
        ]);

        foreach ($aEnderecos as $oEndereco) {
            $aEnderecoComposicoes[] = Endereco::getEnderecoCompletoByID(null, null, $oEndereco, [
                'casas_padding' => 2
            ]);
        }

        return $aEnderecoComposicoes;
    }
}
