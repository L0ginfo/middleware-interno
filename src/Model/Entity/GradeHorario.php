<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * GradeHorario Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $tipo_grade
 * @property int $ativo
 * @property \Cake\I18n\Date $data_inicio
 * @property \Cake\I18n\Time $hora_inicio
 * @property \Cake\I18n\Date $data_fim
 * @property \Cake\I18n\Time $hora_fim
 * @property int|null $exec_minuto
 * @property int|null $exec_hora
 * @property array|null $exec_dia_do_mes
 * @property array|null $exec_mes
 * @property array|null $exec_dia_da_semana
 * @property int|null $exec_ano_limite
 * @property int $ordem
 * @property int $qtde_veiculos_intervalo
 * @property int $limite_minutos_antecedencia
 * @property int $grade_horario_master_id
 * @property int|null $operacao_id
 * @property int|null $regime_aduaneiro_id
 * @property int|null $produto_id
 * @property int|null $drive_espaco_tipo_id
 * @property int|null $drive_espaco_classificacao_id
 *
 * @property \App\Model\Entity\Operacao $operacao
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\DriveEspacoTipo $drive_espaco_tipo
 * @property \App\Model\Entity\DriveEspacoClassificacao $drive_espaco_classificacao
 * @property \App\Model\Entity\GradeHorario $grade_horario_master
 * @property \App\Model\Entity\GradeHorario[] $grade_horario_liberados
 * @property \App\Model\Entity\GradeHorario[] $grade_horario_bloqueados
 */
class GradeHorario extends Entity
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
        'tipo_grade' => true,
        'ativo' => true,
        'data_inicio' => true,
        'hora_inicio' => true,
        'data_fim' => true,
        'hora_fim' => true,
        'exec_minuto' => true,
        'exec_hora' => true,
        'exec_dia_do_mes' => true,
        'exec_mes' => true,
        'exec_dia_da_semana' => true,
        'exec_ano_limite' => true,
        'ordem' => true,
        'qtde_veiculos_intervalo' => true,
        'limite_minutos_antecedencia' => true,
        'grade_horario_master_id' => true,
        'operacao_id' => true,
        'regime_aduaneiro_id' => true,
        'produto_id' => true,
        'drive_espaco_tipo_id' => true,
        'drive_espaco_classificacao_id' => true,
        'operacao' => true,
        'regimes_aduaneiro' => true,
        'produto' => true,
        'drive_espaco_tipo' => true,
        'drive_espaco_classificacao' => true,
        'grade_horario_master' => true,
        'grade_horario_liberados' => true,
        'grade_horario_bloqueados' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];



    public static $aWeek = 
        array( 1 => "Segunda", 2 => "Terça", 3 => "Quarta", 4 => "Quinta", 5 => "Sexta", 6 => "Sábado", 0 => "Domingo");


    public function getListOfMonths(){
        return array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
    }

    public function getListOfDaysInMonth(){

        $aDay = [];

        for ($i=1; $i <= 31; $i++) { 
            $aDay[$i] = $i;
        }
        
        return $aDay;
    }


    public function setTipoGrade($sTipo){
        switch($sTipo){

            case 'LIBERCAO':
                $this->tipo_grade =  1;
                break;

            case 'BLOQUEIO':
                $this->tipo_grade =  2;
                break;

            default:
                $this->tipo_grade =  0;
                break;
        }
    }

    public function setDataOfMaster($oMaster){
        $this->data_inicio = $oMaster->data_inicio;
        $this->hora_inicio = $oMaster->hora_inicio;
        $this->data_fim = $oMaster->data_fim;
        $this->hora_fim = $oMaster->hora_fim;
        $this->grade_horario_master_id = $oMaster->id;
    }


    public function getListOfDaysInWeek(){
        return array(1 => "Segunda-Feira", 2 => "Terça-Feira", 3 => "Quarta-Feira", 4 => "Quinta-Feira", 5 => "Sexta-Feira", 6 => "Sábado", 0 => "Domingo");
    }

    public function setAtivo($ativo = 1){
        $this->ativo = 1;
    }

    public function setJsonOfMonths($aMouths){
        
        if(empty($aMouths)){
            $this->exec_mes = null;
            return ;
        }

        $this->exec_mes =  $aMouths;
    }

    public function setJsonDaysOfMonth($aDays){

        if(empty($aDays)){
            $this->exec_dia_do_mes = null; 
            return;
        }

        $this->exec_dia_do_mes =  $aDays;
    }

    public function setJsonOfDayOfWeek($aDaysOfWeek){
        
        if(empty($aDaysOfWeek)){
            $this->exec_dia_da_semana = null;
            return;
        }

        if(is_array($aDaysOfWeek)  && is_numeric(array_search(7, $aDaysOfWeek))){
            $aDaysOfWeek = array_diff($aDaysOfWeek, [7]);
            array_push($aDaysOfWeek, 0);
        }

        $this->exec_dia_da_semana = $aDaysOfWeek;
    }


    public static function save($aPost, $oMaster, $sType = '', $oGradeHorario = null){
        $aPost['ordem'] = isset($aPost['ordem']) ? $aPost['ordem'] : 1;

        if(empty($oMaster)){
            return false;
        }

        if(empty($oGradeHorario)){
            $oGradeHorario = LgDbUtil::get('GradeHorarios')->newEntity();
        }

        if (@$aPost['exec_dia_do_mes'])
            $aPost['exec_dia_do_mes'] = json_encode($aPost['exec_dia_do_mes']);

        if (@$aPost['exec_dia_da_semana'])
            $aPost['exec_dia_da_semana'] = json_encode($aPost['exec_dia_da_semana']);

        $oGradeHorario = LgDbUtil::get('GradeHorarios')
            ->patchEntity($oGradeHorario, $aPost);

        $oGradeHorario->setAtivo();
        $oGradeHorario->setTipoGrade($sType);
        $oGradeHorario->setDataOfMaster($oMaster);
        $oGradeHorario->setJsonDaysOfMonth(@$aPost['exec_dia_do_mes']);
        $oGradeHorario->setJsonOfDayOfWeek(@$aPost['exec_dia_da_semana']);
        $oGradeHorario->setJsonOfMonths(@$aPost['exec_mes']);

        return LgDbUtil::get('GradeHorarios')->save($oGradeHorario);
    }


    public static function saveBloqueio($aPost, $oMaster, $oGradeHorario = null){

        $aPost['inicio']['descricao'] = $aPost['descricao'];
        $aPost['fim']['descricao'] = $aPost['descricao'];

        $oFather = self::save($aPost['inicio'], $oMaster, 'BLOQUEIO', $oGradeHorario);

        if(empty($oFather)){
            return false;
        }

        $oChild = self::save($aPost['fim'], $oFather, 'BLOQUEIO',
             @$oGradeHorario->grade_horario_bloqueados_fim
        );

        if(empty($oChild) && empty($oGradeHorario)){
            LgDbUtil::get('GradeHorarios')->delete($oFather);
            return false;
        }

        if(empty($oChild)){
            return false;
        }

        return true;

    }

    public function getDays(){
        
        if(empty($this->exec_dia_do_mes)){
            return [];
        }

        if(is_array($this->exec_dia_do_mes)){
            return $this->exec_dia_do_mes;
        }


        if(is_string($this->exec_dia_do_mes)){

            $exec_dia_do_mes = json_decode($this->exec_dia_do_mes);

            if(empty($exec_dia_do_mes)){
                return [];
            }
    
            if(is_array($exec_dia_do_mes)){
                return $exec_dia_do_mes;
            }

            return [$exec_dia_do_mes];

        }

        return $this->exec_dia_do_mes;

    }


    public function getWeek(){

        if(empty($this->exec_dia_da_semana)){
            return [];
        }

        if(is_array($this->exec_dia_da_semana)){
            return $this->exec_dia_da_semana;
        }


        if(is_string($this->exec_dia_da_semana)){

            $exec_dia_da_semana = json_decode($this->exec_dia_da_semana);

            if(empty($exec_dia_da_semana)){
                return [];
            }
    
            if(is_array($exec_dia_da_semana)){
                return $exec_dia_da_semana;
            }
        }

        return [$exec_dia_da_semana];
    }


    public function getMonths(){

        if(empty($this->exec_mes)){
            return [];
        }

        if(is_array($this->exec_mes)){
            return $this->exec_mes;
        }


        if(is_string($this->exec_mes)){

            $exec_mes = json_decode($this->exec_mes);

            if(empty($exec_mes)){
                return [];
            }
    
            if(is_array($exec_mes)){
                return $exec_mes;
            }

            return [$exec_mes];
        }

        return $this->exec_mes;
    }


    public function getListWeek(){
        return array_map(function($value) {return self::$aWeek[$value];}, $this->getWeek());
    }


    public function getWeekToSelect(){
        $aLocalWeek = $this->getWeek();
        if(is_numeric(array_search(0, $aLocalWeek))){
            $aLocalWeek = array_diff($aLocalWeek, [0]);
            array_push($aLocalWeek, 7);
        }
        return $aLocalWeek;
    }

    public static function checkGeraProgramacaoAuto($iGradeHorarioID)
    {
        if (!$iGradeHorarioID)
            return;

        $oGradeHorario = LgDbUtil::getByID('GradeHorarios', $iGradeHorarioID);

        if ($oGradeHorario->gera_programacao_auto == 1)
            return true;

        return false;
    }

    public static function getGradeRedirecionamento($iGradeHorarioID, $aData)
    {
        $oResponse = new ResponseUtil();

        if (!$iGradeHorarioID)
            return $oResponse
                ->setStatus(204);

        $oGradeHorario = LgDbUtil::getByID('GradeHorarios', $iGradeHorarioID);
        if (!$oGradeHorario->grade_redirecionamento)
            return $oResponse
                ->setStatus(204);

        if (!$oGradeHorario->controller || !$oGradeHorario->action)
            return $oResponse
                ->setStatus(204);

        $sParametro = null;
        if ($oGradeHorario->controller == 'DocumentacaoEntrada' && $oGradeHorario->action == 'index' && @$aData['planejamento_maritimo_id'])
            $sParametro = @$aData['planejamento_maritimo_id'];

        if ($oGradeHorario->controller == 'DocumentacaoEntrada' && $oGradeHorario->action == 'add' && $oGradeHorario->tipo_documento_id)
            $sParametro = $oGradeHorario->tipo_documento_id;

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['grade' => $oGradeHorario, 'parametro' => $sParametro]);
    }

}
