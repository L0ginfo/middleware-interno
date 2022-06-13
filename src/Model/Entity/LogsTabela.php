<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Log Entity.
 *
 * @property int $id
 * @property string $tabela
 * @property int $id_coluna
 * @property string $operacao
 * @property string $valor
 * @property int $created_by
 * @property \Cake\I18n\Time $create_at
 */
class LogsTabela extends Entity
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

    public static function insertLog($tabela, $id_coluna = null, $operacao, $dados){
        if (!$tabela)
            return '';
        
        $id_user = @$_SESSION['Auth']['User']['id'];
        
        if(empty($id_user) && ($tabela === 'Usuarios' || $tabela === 'ReportResponses')){
            $id_user = 1;
        }

        $logs = TableRegistry::getTableLocator()->get('LogsTabelas');
        $grava = $logs->newEntity();
        $grava->tabela = $tabela;
        $grava->id_coluna = $id_coluna;
        $grava->operacao = $operacao;
        $grava->valores = $dados;
        $grava->created_by = $id_user;
        $grava->create_at = date('Y-m-d H:i:s');
        $logs->save($grava);
    }

    public static function saveLog($entity){
        if($entity->isNew()){
            $operacao = 'CREATE';
        }else{
            $operacao = 'UPDATE';
        }
        $dados = json_encode($entity->extract($entity->visibleProperties(), true), JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        self::insertLog($entity->source(), $entity->id, $operacao , $dados);
    }

    public static function deleteLog($entity){
        self::insertLog($entity->source(), $entity->id, 'DELETE' ,'Deletado com sucesso a entidade.');
    }
}
