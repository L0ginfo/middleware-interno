<?php
namespace Util\Core;

use Cake\I18n\Time;
use Cake\Routing\Router;
use Util\Model\Entity\Operador;

class SearchFilterUtil 
{
    public static $oView;
    public static $aFormOpts;
    public static $aFilters;
    public static $oThat;
    public static $oQuery;
    public static $aDataPost;
    public static $aFiltersUsed;

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
    public static function create($oView, $aFilters, $aFormOpts) 
    {
        self::$oView = $oView;
        self::$aFormOpts = $aFormOpts;
        self::$aFilters = $aFilters;
        self::$aFilters = self::validateFilters();
        self::$aFiltersUsed = ArrayUtil::getDepth(ObjectUtil::get($oView, 'viewVars', []), ['log_filter'], []);

        self::setValuesFromPost();
        $aFiltersStructured = self::structureOptions();

        return implode(self::render($aFiltersStructured));
    }

    public static function setValuesFromPost() 
    {
        foreach (self::$aFiltersUsed as $aFilterPost) {
            foreach(self::$aFilters as $key => $aFilter) {
                $uValue = ArrayUtil::getDepth($aFilterPost, ['values'], null);
                if ($aFilter['name'] == $aFilterPost['name'] && isset($uValue)) {
                    self::$aFilters[$key]['values'] = $uValue;
                }
            }
        }
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
                ]
            ]);

            return $aFilters;
        }, self::$aFilters, []);
    }

    public static function render($aFiltersStructured)
    {
        $aHtml = [];

        $aHtml[] = '<div class="row">';

        $aHtml[] = '<div class="col-lg-12">';

        $aHtml[] = '<fieldset class="lf-margin-bottom-10">';

        $aHtml[] = '<legend class="lf-margin-bottom-5">Filtros ';

        $aHtml[] = self::$oView->Form
            ->button('<span class="badge badge-light"><i class="glyphicon glyphicon-eye-'. (self::$aFiltersUsed ? 'open' : 'close') .'"></i></span>', [
                'class' => 'btn btn-default mini invert-color lf-margin-negative-top-4 lf-log-accordion-pull'
            ]);

        $aHtml[] = '</legend>';

        $aHtml[] = '<div class="lf-log-accordion '. (self::$aFiltersUsed ? 'active' : '') .'">';

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

            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][name]', ['value' => $aFilter['name']]);
            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][className]', ['value' => $aFilter['table']['className']]);
            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][field]', ['value' => $aFilter['table']['field']]);
            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][operacao]', ['value' => $aFilter['table']['operacao']]);
            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][type]', ['value' => $aFilter['table']['type']]);
            $aHtmlFilters[] = self::$oView->Form->hidden( $sName . '['.$aFilter['name'].'][typeVar]', ['value' => $aFilter['table']['typeVar']]);

            $aHtmlFilters[] = '<label>' . __($aFilter['label']) . '</label>';

            if ($aFilter['table']['operacao'] != 'entre') {

                $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][0]', [
                    'class' => 'form-control ' . $aFilter['inputClass'],
                    'type'  => $aFilter['table']['type'],
                    'value' => self::setValueFormated($aFilter, 0)
                ] + $aTypeParams);

            }else {
                $aHtmlFilters[] = '<div class="flex-no-wrap justify-space-between">';

                $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][0]', [
                    'class' => 'form-control ' . $aFilter['inputClass'],
                    'type'  => $aFilter['table']['type'],
                    'value' => self::setValueFormated($aFilter, 0)
                ] + $aTypeParams);

                $aHtmlFilters[] = '<div class="flex-no-wrap lf-margin-6-6">';
                $aHtmlFilters[] = '<b>Entre</b>';
                $aHtmlFilters[] = '</div>';

                $aHtmlFilters[] = self::$oView->Form->text($sName . '['.$aFilter['name'].'][values][1]', [
                    'class' => 'form-control ' . $aFilter['inputClass'],
                    'type'  => $aFilter['table']['type'],
                    'value' => self::setValueFormated($aFilter, 1)
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

    public static function setValueFormated($aFilter, $iIndex)
    {
        $uValue = ArrayUtil::get(ArrayUtil::getDepth($aFilter, ['values'], []), $iIndex);

        if (!isset($uValue))
            return '';

        if ($aFilter['table']['type'] == 'date')
            $uValue = DateUtil::dateTimeFromDB($uValue, 'Y-m-d', '');
        elseif ($aFilter['table']['type'] == 'datetime-local')
            $uValue = DateUtil::dateTimeFromDB($uValue, 'Y-m-d H:i', 'T');

        return $uValue;
    }
    
    public static function getButtons()
    {
        $aHtmlButons = [];

        $aHtmlButons[] = '<div class="clearfix"></div>';

        $aHtmlButons[] = '<div class="col-xs-12">';

        $aHtmlButons[] = '<div class="col-xs-12">';

        $aHtmlButons[] = '<div class="btn-group flex-no-wrap">';

        $aHtmlButons[] = self::$oView->Form->button('Pesquisar &nbsp;<i class="glyphicon glyphicon-search"></i>', [
            'class' => 'btn btn-primary log_filter_submit',
            'name'  => 'log_filter_submit'
        ]);

        if (self::$aFiltersUsed) {
            $aHtmlButons[] = self::$oView->Form->button('Limpar &nbsp;<i class="glyphicon glyphicon-remove"></i>', [
                'class'    => 'btn btn-danger log_filter_remove lf-log-refresh-page',
                'data-url' => Router::url( ['controller' => self::$oView->name, 'action' => self::$oView->request->action] , true ),
                'type' => 'button',
                'name'     => 'log_filter_remove'
            ]);
        }

        $aHtmlButons[] = '</div>';

        $aHtmlButons[] = '</div>';

        $aHtmlButons[] = '</div>';

        return implode($aHtmlButons);
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

    public static function filter($oThat, $oQuery, $aDataPost = [])
    {
        self::$oThat = $oThat;
        self::$aDataPost = isset($aDataPost) && $aDataPost ? $aDataPost : self::$oThat->request->getQuery();
        self::$oQuery = $oQuery;

        $aUsedFilters = self::getUsedFilters();
        if ($aUsedFilters){
            self::$oThat->paginate = [
                'limit' => 20
            ];

            self::$oThat->set(['log_filter' => $aUsedFilters]);

            return self::setFiltersOnQuery($aUsedFilters);
        }

        return self::$oQuery;
    }

    public static function getUsedFilters()
    {
        $aUsedFilters = [];

        if (!self::$aDataPost)
            return $aUsedFilters;
            
        foreach (ArrayUtil::get(self::$aDataPost, 'log_filter') as $aDataFilter) {

            $aValues = ArrayUtil::get($aDataFilter, 'values');
            
            $iCountValues = array_reduce($aValues, function ($acumulador, $value) {
                if (isset($value))
                    $acumulador++;

                return $acumulador;
            }, 0);

            if (count($aValues) === $iCountValues) 
                $aUsedFilters[] = $aDataFilter;
        }

        return $aUsedFilters;
    }

    public static function setFiltersOnQuery($aUsedFilters)
    {
        $aExps = [];
        
        foreach ($aUsedFilters as $aUsedFilter){
            $sExpressionFormat = Operador::getSymbolExpression($aUsedFilter['operacao']);
            $sExpression = self::setFilterOnExpression($aUsedFilter, $sExpressionFormat);
            $aExps[] = $sExpression;
        }

        return self::$oQuery->where($aExps);
    }

    public static function setFilterOnExpression($aFilter, $sExpression)
    {
        $sFindWhere  = $aFilter['className']; //table
        $sFindWhere .= '.'; 
        $sFindWhere .= $aFilter['field']; //column

        if (strpos($aFilter['type'], 'date') === false)
            $sFindWhere = 'LOWER('. $sFindWhere .')';
            
        $aValues = $aFilter['values'];
        $iCount = 0;

        $sExpressionMount = str_replace('[field]', $sFindWhere, $sExpression);

        for ($i = 0; $i < substr_count($sExpression, '[field_value]'); $i++) {

            $isString = ArrayUtil::get($aFilter, 'typeVar') == 'string' ? true : false;

            if ($aFilter['type'] == 'datetime-local')
                $sValueFormated = (new Time(StringUtil::replaceFirst('T', ' ', $aValues[$iCount])))->format('Y-m-d H:i:s');
            elseif ($aFilter['type'] == 'date')
                $sValueFormated = DateUtil::dateTimeToDB($aValues[$iCount], 'Y-m-d', '')->format('Y-m-d');
            else
                $sValueFormated = strtolower($aValues[$iCount]);

            $sExpressionMount = StringUtil::replaceFirst('[field_value]', $sValueFormated, $sExpressionMount);

            if ($isString) 
                $sExpressionMount = str_replace('[aspas]', "'", $sExpressionMount);

            $iCount++;
        }

        return $sExpressionMount;
    }
}