<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Http\Session;

/**
 * ParametroGeral Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $nome_unico
 * @property string $valor
 */
class ParametroGeral extends Entity
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
        '*' => true,
        'id' => false
    ];

    public static function getParametro( $that, $sParam )
    {
        $empresa_id = $that->getEmpresaAtual();
        $that->loadModel('ParametroGerais');

        if (!$sParam)
            return null;

        $oParametroGerais = $that->ParametroGerais->find()
            ->where([
                'nome_unico' => $sParam,
                'empresa_id' => $empresa_id
            ])
            ->first();

        if ($oParametroGerais)
            return $oParametroGerais;

        return $oParametroGerais;
    }

    public static function getParametroWithValue( $sParam )
    {
        $empresa_id = @$_SESSION['empresa_atual'] ?: 1;

        $oParametroGerais = TableRegistry::get('ParametroGerais')->find()
            ->where([
                'nome_unico' => $sParam,
                'empresa_id' => $empresa_id
            ])
            ->first();

        if ($oParametroGerais)
            return $oParametroGerais->valor;

        return null;
    }


    public static function getParameterByUniqueName($SuniqueName){
        $empresa_id = @$_SESSION['empresa_atual'] ?: 1;
        
        try {
            return TableRegistry::locator()
                ->get('ParametroGerais')
                ->find()
                ->where([
                    'nome_unico' => $SuniqueName,
                    'empresa_id' => $empresa_id
                ])
                ->first();
        } catch (\Throwable $th) {
            return false;
        }
    }


    public static function getParameterByUniqueNameWithExternalTable($table, $SuniqueName){
        $empresa_id = $_SESSION['empresa_atual'];
        try {
            return $table->find()
                ->where([
                    'nome_unico' => $SuniqueName,
                    'empresa_id' => $empresa_id
                ])
                ->first();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getParametroForLogin( $that, $sParam )
    {
        $that->loadModel('ParametroGerais');

        if (!$sParam)
            return null;

        $oParametroGerais = $that->ParametroGerais->find()
            ->where([
                'nome_unico' => $sParam,
            ])
            ->first();

        if ($oParametroGerais)
            return $oParametroGerais;

        return $oParametroGerais;
    }

    public static function saveValueParametro($sUniqueName, $sNewValue)
    {
        $oParam = self::getParameterByUniqueName($sUniqueName);
        
        if (!$oParam)
            return false;

        $oParam->valor = $sNewValue;

        return LgDbUtil::save('ParametroGerais', $oParam);
    }

    public static function getFilters()
    {
        
        
        return [
            [
                'name'  => 'descricao',
                'divClass' => 'col-lg-3',
                'label' => 'Descricao',
                'table' => [
                    'className' => 'ParametroGerais',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'nome_unico',
                'divClass' => 'col-lg-3',
                'label' => 'Nome Unico',
                'table' => [
                    'className' => 'ParametroGerais',
                    'field'     => 'nome_unico',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'integracao_codigo',
                'divClass' => 'col-lg-3',
                'label' => 'Integração código',
                'table' => [
                    'className' => 'ParametroGerais',
                    'field'     => 'integracao_codigo',
                    'operacao'  => 'igual'
                ]
            ]
        ];
    }
}
