<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use App\Util\ErrorUtil;
use Cake\I18n\Time;
use Cake\Routing\Router;

class SearchFilterUtil
{
    public static $oView;
    public static $aFormOpts;
    public static $aFilters;
    public static $oThat;
    public static $oQuery;
    public static $aDataPost;
    public static $aFiltersUsed;
    public static $aOptions;
    public static $aTypes = [
        'date' => [
            'params' => [
                'pattern' => '[0-9]{2}\/[0-9]{2}\/[0-9]{4}'
            ]
        ],
        'datetime-local' => [
            'params' => [
                'pattern' => '[0-9]{2}\/[0-9]{2}\/[0-9]{4} [0-9]{2}:[0-9]{2}'
            ]
        ]
    ];

    /**
     * @param $oView - corresponde ao $this da view que solicitou
     * @param $aOptions - opcoes de filtros
     */
    public static function create($oView, $aFilters = [], $aFormOpts = []) 
    {
        self::$oView = $oView;
        self::$aFormOpts = $aFormOpts;
        self::$aFilters = !$aFilters ? self::$aFilters : $aFilters;
        self::$aFilters = self::validateFilters();
        self::$aFiltersUsed = ArrayUtil::getDepth(ObjectUtil::get($oView, 'viewVars', []), ['log_filter'], []);

        self::setValuesFromPost();
        $aFiltersStructured = self::structureOptions();

        return implode(self::render($aFiltersStructured));
    }

    public static function setValuesFromPost() 
    {
        foreach (self::$aFiltersUsed as $aFilterPost) 
            foreach(self::$aFilters as $key => $aFilter) 
                if ($aFilter['name'] == $aFilterPost['name'] && $x = ArrayUtil::getDepth($aFilterPost, ['values'], ''))
                    self::$aFilters[$key]['values'] = $x;
    }

    public static function validateFilters()
    {
        return array_map(function($aArr) {
            
            $aFilters = array_merge($aArr, [
                'name'       => ArrayUtil::getDepth($aArr, ['name'], ''),
                'inputClass' => ArrayUtil::getDepth($aArr, ['inputClass'], ArrayUtil::getDepth($aArr, ['name'], '')),
                'label'      => ArrayUtil::getDepth($aArr, ['label'], ''),
                'table'      => [
                    'className' => ArrayUtil::getDepth($aArr, ['table', 'className'], ''),
                    'field'     => ArrayUtil::getDepth($aArr, ['table', 'field'], ''),
                    'operacao'  => ArrayUtil::getDepth($aArr, ['table', 'operacao'], ''),
                    'type'      => ArrayUtil::getDepth($aArr, ['table', 'type'], 'text'),
                    'typeVar'   => ArrayUtil::getDepth($aArr, ['table', 'typeVar'], 'string'),
                    'options'   => ArrayUtil::getDepth($aArr, ['table', 'options'], ''),
                    'arrayParamns' => ArrayUtil::getDepth($aArr, ['table', 'arrayParamns'], ''),
                    'required'     => ArrayUtil::getDepth($aArr, ['table', 'required'], ''),
                ]
            ]);

            return $aFilters;
        }, self::$aFilters, []);
    }

    public static function render($aFiltersStructured)
    {
        $bShowFilter = (self::$aFiltersUsed || @self::$aOptions['active']);  

        $aHtml = [];

        $aHtml[] = '<div class="row">';

        $aHtml[] = '<div class="col-lg-12">';

        $aHtml[] = '<fieldset class="lf-margin-bottom-10">';

        $aHtml[] = '<legend class="lf-margin-bottom-5">Filtros ';

        $aHtml[] = self::$oView->Form
            ->button('<span class="badge badge-light"><i class="glyphicon glyphicon-eye-'. ($bShowFilter ? 'open' : 'close') .'"></i></span>', [
                'class' => 'btn btn-default mini invert-color lf-margin-negative-top-4 lf-log-accordion-pull',
                'type'  => 'button'
            ]);

        $aHtml[] = '</legend>';

        $aHtml[] = '<div class="lf-log-accordion ' . ($bShowFilter ? 'active' : '') . '">';

        $aHtml[] = self::$oView->Form->create(null, ['class' => 'lf-log-filter', 'type' => 'GET']);

        foreach ($aFiltersStructured as $sFilter) {
            $aHtml[] = $sFilter;
        }

        $aHtml[] = self::$oView->Form->end();
        
        $aHtml[] = '</div>';

        $aHtml[] = '</fieldset>';

        $aHtml[] = '</div>';

        $aHtml[] = '</div>';

        return $aHtml;
    }

    public static function structureOptions()
    {
        $aHtmlFilters = [];

        $aHtmlFilters[] = '<div class="clearfix"></div>';

        $aHtmlFilters[] = '<div class="col-lg-12">';

        foreach (self::$aFilters as $aFilter) {
            $aTypeParams = self::getTypeParams($aFilter['table']['type']);

            $sName = 'log_filter';

            $aHtmlFilters[] = '<div class="' . $aFilter['divClass'] . '">';

            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][name]', ['value' => $aFilter['name']]);
            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][className]', ['value' => $aFilter['table']['className']]);
            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][field]', ['value' => $aFilter['table']['field']]);
            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][operacao]', ['value' => $aFilter['table']['operacao']]);
            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][type]', ['value' => $aFilter['table']['type']]);
            // $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][typeVar]', ['value' => $aFilter['table']['typeVar']]);

            $aHtmlFilters[] = '<label>' . __($aFilter['label']) . '</label>';

            if ($aFilter['table']['operacao'] != 'entre') {

                if ($aFilter['table']['type'] == 'select' && $aFilter['table']['operacao'] == 'in') {
                    
                    $aHtmlFilters[] = self::$oView->Form->control($sName . '['.$aFilter['name'].'][values][]', [
                        'options'  => $aFilter['table']['options'],
                        'required' => $aFilter['table']['required'],
                        'class'    => 'selectpicker form-control not-fix-width ' . $aFilter['inputClass'],
                        'label'    => false,
                        'value'    => self::setValueFormated($aFilter),
                        'multiple'
                    ] + $aTypeParams);

                } else if ($aFilter['table']['type'] == 'select-ajax') {

                    $aFilter['table']['arrayParamns']['name'] = $sName . '['.$aFilter['name'].'][values][]';
                    $aHtmlFilters[] = ElementUtil::getHtmlElement('Element/selectpicker-ajax', $aFilter['table']['arrayParamns'], self::setValueFormated($aFilter, 0));

                } else {

                    $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][0]', [
                        'class' => 'form-control ' . $aFilter['inputClass'],
                        'type'  => $aFilter['table']['type'],
                        'value' => self::setValueFormated($aFilter, 0),
                        'style' => 'margin-bottom:10px'
                    ] + $aTypeParams);

                }

            }else {
                $aHtmlFilters[] = '<div class="flex-no-wrap justify-space-between">';

                $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][0]', [
                    'class' => 'form-control ' . $aFilter['inputClass'],
                    'type'  => $aFilter['table']['type'],
                    'value' => self::setValueFormated($aFilter, 0),
                    'style' => 'margin-bottom:10px'
                ] + $aTypeParams);

                $aHtmlFilters[] = '<div class="flex-no-wrap lf-margin-6-6">';
                $aHtmlFilters[] = '<b>Entre</b>';
                $aHtmlFilters[] = '</div>';

                $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][1]', [
                    'class' => 'form-control ' . $aFilter['inputClass'],
                    'type'  => $aFilter['table']['type'],
                    'value' => self::setValueFormated($aFilter, 1),
                    'style' => 'margin-bottom:10px'
                ] + $aTypeParams);

                $aHtmlFilters[] = '</div>';
            }

            $aHtmlFilters[] = '</div>';
        }

        $aHtmlFilters[] = '</div>';

        $aHtmlFilters[] = self::getButtons();

        $aHtmlFilters[] = '<div class="clearfix"></div>';

        return $aHtmlFilters;
    }

    public static function setValueFormated($aFilter, $iIndex = null)
    {
        if ($iIndex === null)
            $uValue = array_key_exists('values', $aFilter) ? $aFilter['values'] : '';
        else
            $uValue = ArrayUtil::get(ArrayUtil::getDepth($aFilter, ['values'], []), $iIndex);

        if (!$uValue)
            return '';

        if ($aFilter['table']['type'] == 'date')
            $uValue = DateUtil::dateTimeFromDB($uValue, 'Y-m-d', '');
        elseif ($aFilter['table']['type'] == 'datetime-local')
            $uValue = DateUtil::dateTimeFromDB($uValue, 'Y-m-d H:i', 'T');
        elseif ($aFilter['table']['type'] == 'select')
            $uValue = $uValue;
        elseif ($aFilter['table']['type'] == 'select-ajax')
            $uValue = $uValue;

        return $uValue;
    }
    
    public static function getButtons()
    {
        $aHtmlButons = [];

        $aHtmlButons[] = '<div class="clearfix"></div>';

        $aHtmlButons[] = '<div class="col-xs-12">';

        $aHtmlButons[] = '<div class="col-xs-2">';

        $aHtmlButons[] = '<label>&nbsp;</label>';

        $aHtmlButons[] = '<div class="btn-group flex-no-wrap">';

        $aHtmlButons[] = self::$oView->Form->button('Pesquisar &nbsp;<i class="glyphicon glyphicon-search"></i>', [
            'class' => 'btn btn-primary log_filter_submit',
            'name'  => 'log_filter_submit',
            'value' => '1'
        ]);

        if (self::$aFiltersUsed) {
            $aHtmlButons[] = self::$oView->Form->button('Limpar &nbsp;<i class="glyphicon glyphicon-remove"></i>', [
                'class'    => 'btn btn-danger log_filter_remove lf-log-refresh-page',
                'data-url' => Router::url( self::$oView->request->here , true ),
                'type' => 'button',
                'name' => 'log_filter_remove',
                'value' => '1'
            ]);
        }

        $aHtmlButons[] = '</div>';

        $aHtmlButons[] = '</div>';

        $aHtmlButons[] = '</div>';

        return implode('',$aHtmlButons);
    }

    public static function getTypeParams($sType)
    {
        $aType = self::getType($sType);
        $aTypeParams = ArrayUtil::getDepth($aType, ['params'], []);

        return $aTypeParams;
    }

    public static function getType($sType)
    {
        $aTypes = self::$aTypes;
        $aType = ArrayUtil::getDepth($aTypes, [$sType], []);

        return $aType;
    }

    /**
     * Undocumented function
     *
     * @param $this $oThat
     * @param $object $oQuery
     * @param array $aFilters
     * @param array $aOptions = [
     *    'paginate_limit' => 50,
     *    'active' => false
     * ]
     * @return void
     */
    public static function filter($oThat, $oQuery, $aFilters = [], $aOptions = ['paginate_limit' => 50])
    {
        self::$aFilters = $aFilters;
        self::$aFilters = self::validateFilters();
        self::$oThat = $oThat;
        self::$aDataPost = self::$oThat->request->getQuery();
        self::$oQuery = $oQuery;
        self::$aOptions = $aOptions;

        $aUsedFilters = self::getUsedFilters();

        if ($aUsedFilters){

            if(isset($aOptions['paginate_limit'])){ 
                self::$oThat->paginate = [
                    'limit' => $aOptions['paginate_limit']
                ];
            }

            self::$oThat->set(['log_filter' => $aUsedFilters]);

            return self::setFiltersOnQuery($aUsedFilters);
        }

        return self::$oQuery;
    }

    public static function getUsedFilters()
    {
        $aUsedFilters = [];

        if (!self::$aDataPost || !ArrayUtil::get(self::$aDataPost, 'log_filter'))
            return $aUsedFilters;

        foreach (ArrayUtil::get(self::$aDataPost, 'log_filter') as $sNameKey => $aDataFilter) {

            $aValues = ArrayUtil::get($aDataFilter, 'values');
            
            $iCountValues = array_reduce($aValues, function ($acumulador, $value) {
                if ($value)
                    $acumulador++;

                return $acumulador;
            }, 0);

            $aFilterOriginal = array_reduce(self::$aFilters, function ($aCarry, $aItem) use ($sNameKey) {
                if ($sNameKey == $aItem['name'] && !$aCarry)
                    $aCarry = $aItem;

                return $aCarry;
            }, []);

            $aFilterOriginal['values']    = $aValues;
            $aFilterOriginal['className'] = $aFilterOriginal['table']['className'];
            $aFilterOriginal['field']     = $aFilterOriginal['table']['field'];
            $aFilterOriginal['operacao']  = $aFilterOriginal['table']['operacao'];
            $aFilterOriginal['type']      = $aFilterOriginal['table']['type'];
            $aFilterOriginal['typeVar']   = $aFilterOriginal['table']['typeVar'];

            if (count($aValues) === $iCountValues) 
                $aUsedFilters[] = $aFilterOriginal;
        }

        return $aUsedFilters;
    }

    public static function setFiltersOnQuery($aUsedFilters)
    {
        foreach ($aUsedFilters as $aUsedFilter){
            $sExpressionFormat = self::getSymbolExpression($aUsedFilter['operacao']);
            $aFilterExpression = self::setFilterOnExpression($aUsedFilter, $sExpressionFormat);
            
            if ($aFilterExpression['type_condition'] == 'where'){
                
                self::$oQuery->where($aFilterExpression['expression']);

            }elseif  ($aFilterExpression['type_condition'] == 'contain') {

                //Remove a ligação da entity principal pra fazer o matching
                if (strpos($aUsedFilter['className'], self::$oQuery->repository()->alias()) !== false) {
                    $aUsedFilter['className'] = StringUtil::replaceFirst(
                        self::$oQuery->repository()->alias() . '.',
                        '',
                        $aUsedFilter['className']
                    );
                }
                
                self::$oQuery->matching(
                    $aUsedFilter['className'], 
                    function($q) use ($aFilterExpression) {
                        $q->where($aFilterExpression['expression']);
                        return $q;
                    }
                );

            }
        }
        
        return self::$oQuery;
    }

    public static function setFilterOnExpression($aFilter, $sExpression)
    {
        $sTypeCondition = 'where';

        if (strpos($aFilter['className'], '.') !== false) {
            $sTypeCondition = 'contain';
            $aRelation = explode('.', $aFilter['className']);
            $sFindWhere  = array_pop($aRelation); //table
        }else {
            $sFindWhere  = $aFilter['className']; //table
        }

        $sFindWhere .= '.'; 
        $sFindWhere .= $aFilter['field']; //column

        if (strpos($aFilter['type'], 'date') === false)
            $sFindWhere = self::findWhereByDb($sFindWhere);
            
        $aValues = $aFilter['values'];
        $iCount = 0;

        $sExpressionMount = str_replace('[field]', $sFindWhere, $sExpression);

        for ($i = 0; $i < substr_count($sExpression, '[field_value]'); $i++) {

            $isString = ArrayUtil::get($aFilter, 'typeVar') == 'string' ? true : false;

            if ($aFilter['type'] == 'datetime-local')
                $sValueFormated = (new Time(StringUtil::replaceFirst('T', ' ', $aValues[$iCount])))->format('Y-m-d H:i:s');
            elseif ($aFilter['type'] == 'date')
                $sValueFormated = DateUtil::dateTimeToDB($aValues[$iCount], 'Y-m-d', '')->format('Y-m-d');
            elseif ($aFilter['operacao'] == 'in' && $aFilter['type'] == 'select')
                $sValueFormated = implode(',', $aValues);
            else
                $sValueFormated = strtolower($aValues[$iCount]);

            $sExpressionMount = StringUtil::replaceFirst('[field_value]', $sValueFormated, $sExpressionMount);

            if ($isString) 
                $sExpressionMount = str_replace('[aspas]', "'", $sExpressionMount);

            $iCount++;
        }

        return [
            'type_condition' => $sTypeCondition,
            'expression' => $sExpressionMount
        ];
    }

    public static function getSymbolExpression($sOperador = 'null')
    {
        $sSymbol = '';

        switch ($sOperador) {
            case 'igual':
                $sSymbol = '[field] = [aspas][field_value][aspas]';
                break;

            case 'diferente':
                $sSymbol = '[field] <> [aspas][field_value][aspas]';
                break;

            case 'menor':
                $sSymbol = '[field] < [aspas][field_value][aspas]';
                break;

            case 'maior':
                $sSymbol = '[field] > [aspas][field_value][aspas]';
                break;

            case 'entre':
                $sSymbol = '[field] BETWEEN [aspas][field_value][aspas] and [aspas][field_value][aspas]';
                break;

            case 'menor ou igual':
                $sSymbol = '[field] <= [aspas][field_value][aspas]';
                break;

            case 'maior ou igual':
                $sSymbol = '[field] >= [aspas][field_value][aspas]';
                break;

            case 'contem':
                $sSymbol = '[field] LIKE([aspas]%[field_value]%[aspas])';
                break;

            case 'in':
                $sSymbol = '[field] in([field_value])';
                break;
            
            default:
                ErrorUtil::custom(__('O Operador condicional') . ' '. __('"' . $sOperador . '"') . ' ' . __('não está parametrizado!'));
                break;
        }

        return $sSymbol;
    }
    
    private static function findWhereByDb($sFindWhere)
    {
        if (env('DB_ADAPTER', 'mysql') == 'mysql')
            $sFindWhere = 'LOWER('. $sFindWhere .')';
        else
            $sFindWhere = 'LOWER(convert(varchar(max), '. $sFindWhere .'))';

        return $sFindWhere;
    }
}