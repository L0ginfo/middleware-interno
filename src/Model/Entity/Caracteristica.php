<?php
namespace App\Model\Entity;

use App\Util\LgConnDbUtil;
use App\Util\LgDbUtil;
use App\Util\StringUtil;
use Cake\ORM\Entity;

/**
 * Caracteristica Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $tipo_caracteristica_id
 *
 * @property \App\Model\Entity\TipoCaracteristica $tipo_caracteristica
 * @property \App\Model\Entity\PlanoCargaCaracteristica[] $plano_carga_caracteristicas
 */
class Caracteristica extends Entity
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
        
        'descricao' => true,
        'tipo_caracteristica_id' => true,
        'tipo_caracteristica' => true,
        'plano_carga_caracteristicas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public static function getListValor($oCaracteristica){

        if(empty($oCaracteristica->tabela)){
            return [];
        }

        if(empty($oCaracteristica->coluna)){
            return [];
        }

        if(empty($oCaracteristica->valor)){
            return [];
        }

        try {
            
            return LgDbUtil::get(@$oCaracteristica->tabela)
                ->find('list', ['keyField' => 'id', 'valueField' => @$oCaracteristica->coluna])
                ->where(['id' => @$oCaracteristica->valor])
                ->limit(1)
                ->toArray();
        } catch (\Throwable $th) {
            return [];
        }

    }

    public function getValor(){

        if(empty($this->tabela)){
            return '';
        }

        if(empty($this->coluna)){
            return '';
        }

        if(empty($this->valor)){
            return '';
        }

        try {

            $oValue = LgDbUtil::get($this->tabela)
                ->find()
                ->where([ 'id' => $this->valor])
                ->first();
            
            return @$oValue[$this->coluna];
            
        } catch (\Throwable $th) {
            return '';
        }

    }


    public static function getTabelas($aWhere = []){

        $oConn = LgConnDbUtil::getConn();
        $oLgConnDbUtil  = new LgConnDbUtil($oConn);

        $results = $oLgConnDbUtil
            ->find('information_schema.tables')
            ->select(['table_name'])
            ->where([
                'table_schema' => env('DB_NAME', ''),
                $aWhere,
            ])
            ->limit(10)
            ->toArray();

        $aResults = [];
        foreach ($results as $value) {
            $sName = StringUtil::toCamelCase($value['table_name'], '_');
            $aResults[$sName] = $sName;
        }
        return $aResults;
    }

    public static function getColunas($sTableName, $aWhere = []){
        $oConn = LgConnDbUtil::getConn();
        $oLgConnDbUtil = new LgConnDbUtil($oConn);
        $sTableName = StringUtil::fromCamelCase($sTableName, '_');

        $results = $oLgConnDbUtil
            ->find('information_schema.columns')
            ->select(['column_name'])
            ->where([
                'table_schema' => env('DB_NAME', ''),
                'table_name' => $sTableName,
                $aWhere
            ])
            ->limit(10)
            ->toArray();

        $aResults= [];

        foreach ($results as $value) {
            $sName = $value['column_name'];
            $aResults[$sName] = $sName;
        }

        return $aResults;
    }

    public static function getValores($sTableName, $sColunaName,  $aWhere = []){

        try {
            
            return  LgDbUtil::get($sTableName)
                ->find('list', ['keyField' => 'id', 'valueField' => $sColunaName])
                ->where($aWhere)
                ->limit(10)
                ->toArray();

        } catch (\Throwable $th) {
            return [];
        }

    }
}
