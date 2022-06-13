<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * LogAcesso Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property string|null $controller
 * @property string|null $action
 * @property \Cake\I18n\Time $create_at
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class LogAcesso extends Entity
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
        
        'usuario_id' => true,
        'controller' => true,
        'action' => true,
        'create_at' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public static function execute(){
      
        try {
            
            $oRequest = Router::getRequest();
            $bfazLog = $oRequest->getSession()->read('log_acessos');
            $iUsuarioId = SessionUtil::getUsuarioConectado();
            
            if(empty($iUsuarioId) && empty($bfazLog)) return;

            $aLink = explode('/', $oRequest->url);
            $sController = @$aLink[0] == 'inicio' ? 'Pages' : @$aLink[0];
            $sAction = @$aLink[1] ?: 'index';
            $sUrl = $oRequest->url;

            $oSucesso = LgDbUtil::saveNew('LogAcessos',  [
                'url' => $sUrl,
                'action' => $sAction,
                'controller' => ucfirst($sController),
                'usuario_id' => $iUsuarioId,
                'create_at' => DateUtil::getNowTime()
            ]);

        } catch (\Throwable $th) {
        }
    
    }
}
