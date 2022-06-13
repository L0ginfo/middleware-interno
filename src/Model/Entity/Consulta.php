<?php

namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Consulta Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $detalhes
 * @property string $cabesario
 * @property string $conteudo
 */
class Consulta extends Entity
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
        'id' => false,
    ];

    private static $heards = [];

    public static $__iPaginatorActivated = 0;
    public static $__iCountTotalRegistersPaginator = 0;
    public static $__iMaxRegistersPerPagePaginator = 10;
    public static $__iMaxLinksPerPaginator = 10;
    public static $__iTotalPagesPaginator = 0;
    public static $__iActualPagePaginator = 0;
    public static $__iOffsetQueryPaginator = 0;
    public static $__iStartQueryPaginator = 0;
    public static $__iEndQueryPaginator = 0;

    private static function setHeadersOfDataSet($content){
        if(empty($content)){
            return;
        }
        $keys = array_keys($content[0]);
        self::$heards = $keys;
    }

    private static function getDataSet($text){
        $connection = ConnectionManager::get('default_consultas');

        try {
            $connection->disconnect();
            $connection->connect();
        } catch (\Throwable $th) {}
        
        $aContents = $connection->execute($text)->fetchAll('assoc');
        return $aContents;
    }

    public static function getHeadersOfDataSet(){
        return self::$heards;
    }

    public static function getClasses($sql){
        return [];
    }


    public static function getContents($sql, $that){
        $aContents = self::getDataSet($sql);
        self::dataSetIsNull($aContents);
        self::setHeadersOfDataSet($aContents);
        return $aContents;
    }

    public static function beautifyHeader($header){
        return ucwords(str_replace('_', ' ', ($header)));
    }

    public static function getContentsForView($text, $that = null){
        return self::getDataSet($text);
    }

    public static function getHeadersForView($text, $that){
        self::$heards = json_decode($text);
        return self::$heards;
    }

    public static function dataSetIsNull($aContents){

        if(empty($aContents)){
            return [];
        }

        return $aContents;
    }

    public static function addParameters($sql, $that = null){
        $parameters = TableRegistry::getTableLocator()->get('ParametroConsultas')->find()->toArray();
        foreach ($parameters as $parametro) {
            $sql = str_replace($parametro->codigo, $parametro->conteudo, $sql);
        }
        return $sql;
    }

    public static function doParameters($sql, $that = null){
        $sql = self::addParameters($sql, $that);
        return self::processDinamicVariables($sql, $that); 
    }

    public static function processDinamicVariables($context, $that){
        preg_match_all('/\{{(.*?)\}}/', $context, $elements);

        if(empty($elements[0]) || empty($elements[1])){
            return ['sucesso'=>true, 'context' => strtolower($context)];
        }

        $data['sucesso'] = true; 
        $keys = array_keys($that->request->getQuery() + $that->request->getData());
        unset($keys['limit']);
        unset($keys['page']);

        foreach ($elements[1] as $key => $element) {
            $values = explode('/', $element);

            $value = $that->request->getQuery(strtolower(@$values[1])) ?: $that->request->getData(strtolower(@$values[1]));

            $value = !$value ? '' : $value;

            $type = $values[0];
            $name = strtolower($values[1]);
            $class = @$values[2];
            $extra = @$values[3];
            if(!in_array($name, $keys)) {
                $data['sucesso'] = false;
            }
            if(isset($value)){
                $data['elements'][$key]['value'] =  $value;
            }

            if(empty($name)){
                continue;
            }

            if(empty($type)){
                continue;
            }

            if($extra){
                $pattern = $extra;
            }

            if($type == 'select'){
                $options = [];
                $pattern = null;
            }

            // if($type == 'datepiker'){
            //     $type = 'text';
            //     $class = 'form-control datepicker mask-date';
            //     $pattern = '[0-9]{2}\/[0-9]{2}\/[0-9]{4}';
            // }

            // if($type == 'datetimepiker'){
            //     $type = 'text';
            //     $class = 'form-control datepicker mask-date_time';
            //     $pattern = null;
            // }

            $data['elements'][$key]['code'] = $elements[0][$key];
            $data['elements'][$key]['name'] = $name;
            $data['elements'][$key]['type'] = strtolower($type);
            $data['elements'][$key]['class'] = @$class;
            $data['elements'][$key]['pattern'] = @$pattern;
            $data['elements'][$key]['pattern'] = @$pattern;
        }
        if(!$data['sucesso']){
            return $data;
        }
        
        foreach ($data['elements'] as $key => $value) {
            switch ($value['type']) {
                case 'datepicker':
                    $value['value'] = !empty($value['value']) ? DateUtil::dateTimeToDB($value['value'])->format('Y-m-d') : '';
                    break;
                case 'datetimepicker':
                    $value['value'] = !empty($value['value']) ? DateUtil::dateTimeToDB($value['value']) : '';
                    $value['value'] = $value['value'] ? $value['value']->format('Y-m-d H:i') : '';
                break;
                default:
                    break;
            }
            if ($value['type'] == 'text' && !empty($value['value'])) {
                $context = str_replace($value['code'], "'%" . strtolower($value['value']) . "%'", $context);
            } elseif ($value['type'] == 'number' && !empty($value['value']))  {
                $context = str_replace($value['code'], "" . strtolower($value['value']) . "", $context);
            } else {
                $context = str_replace($value['code'], "'" . strtolower($value['value']) . "'", $context);
            }
        }
        @$_SESSION['sql_executado'] = @strtolower($context);
        return ['sucesso'=>true, 'context' => strtolower($context)];
    }

    public static function exportDataExcel($oConsulta, $aConsultaDataParams, $oThat)
    {
        $aDados = Consulta::getContentsForView($aConsultaDataParams['context'], $oThat);

        $oConsulta->ultima_consulta_executada = $aConsultaDataParams['context'];
        $oConsulta->modified_at = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', '');
        LgDbUtil::save('Consultas', $oConsulta);

        header("Content-type: application/vnd.ms-excel, charset=utf-8");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=\""
            .$oConsulta->detalhes . '__' . date('Y-m-d_H:i:s') ."\".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $out = fopen("php://output", 'w');

        $aHeadersData = @array_keys(@$aDados[0]) ?: [];
        $aHeaders = [];

        foreach (@$aHeadersData as $sCabecario) {
            $aHeaders[] = @Consulta::beautifyHeader($sCabecario);
        }

        $sContent = '<meta charset="utf-8">';
        $sContent .= '<table border="1px solid #ddd">';

        if(!empty($aHeaders)){

            $sContent .= '<tr>';

            foreach ($aHeaders as $key => $value) {
                $sContent .= '<th border="1px solid #ddd">'.$value.'</th>';
            }

            $sContent .= '</tr>';
        }


        foreach ($aDados as $aDado) {
            $sContent .= '<tr>';
                foreach ($aDado as $value) {
                    $value =  is_double($value) ? $value : '="'.$value.'"';
                    $sContent .= '<td border="1px solid #ddd">'.$value.'</td>';
                }
            $sContent .= '</tr>';
        }

        $sContent .= '</table></body>';

        echo $sContent; 
        die;
    }

    public static function managePaginator($oConsulta, $sConsulta)
    {
        if (!$oConsulta->habilita_paginacao)
            return $sConsulta;

        self::$__iPaginatorActivated = 1;

        $sSqlTotal = 'SELECT COUNT(*) total_registers FROM (' . $sConsulta . ') t' ;

        self::$__iCountTotalRegistersPaginator = @self::getDataSet($sSqlTotal)[0]['total_registers'];
        
        // How many pages will there be
        self::$__iTotalPagesPaginator = ceil(self::$__iCountTotalRegistersPaginator / self::$__iMaxRegistersPerPagePaginator);

        // What page are we currently on?
        self::$__iActualPagePaginator = min(self::$__iTotalPagesPaginator, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));
        
        // Calculate the offset for the query
        self::$__iOffsetQueryPaginator = (self::$__iActualPagePaginator - 1) * self::$__iMaxRegistersPerPagePaginator;

        // Some information to display to the user
        self::$__iStartQueryPaginator = self::$__iOffsetQueryPaginator + 1;
        self::$__iEndQueryPaginator = min((self::$__iOffsetQueryPaginator + self::$__iMaxRegistersPerPagePaginator), self::$__iCountTotalRegistersPaginator);

        
        $sConsulta = 'SELECT *
                FROM
                    ('.$sConsulta.') query
                LIMIT
                    '.self::$__iMaxRegistersPerPagePaginator.'
                OFFSET
                    '.self::$__iOffsetQueryPaginator.'
        ';

        return $sConsulta;
    }

}
