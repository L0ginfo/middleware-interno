<?php

namespace LogPluginColetores\Controller;

use App\Controller\AppController as BaseController;
use App\Model\Entity\ParametroGeral;
use App\Util\PermissionUtil;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Util\Core\ResponseUtil;

class AppController extends BaseController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->setConfig([
            'authorize' => 'Controller',
            'unauthorizedRedirect' => false,
            'loginAction' => [
                'controller' => 'Usuarios', 'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Usuarios', 'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'ColetorMaritimo', 'action' => 'index'
            ],
            'authError' => ( isset($_SESSION['Auth']['User']['id']) )
                ? 'Ops, parece que você não tem permissão para acessar essa funcionalidade :('
                : 'Por favor, faça o login antes ok',
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Usuarios',
                    'fields' => ['username' => 'cpf', 'password' => 'senha']
                ]
            ],
            'storage' => 'Session'
        ]);
    }

    public function configApp(){
        // Default images
        $sLogoImgLogin      =  Router::url('/', true) . 'img/' . Configure::read('LOGO.LOGIN');
        $sLogoImgMenu       =  Router::url('/', true) . 'img/' . Configure::read('LOGO.MENU');
        $sLogoImgMenuHover  =  Router::url('/', true) . 'img/' . Configure::read('LOGO.MENU_HOVER');
        $sLogoImgTab        =  Router::url('/', true) . 'img/' . Configure::read('LOGO.TAB');

        // Set new images
        $oLogoLogin       = ParametroGeral::getParametroForLogin($this, 'LOGO_LOGIN');
        $oLogoMenu        = ParametroGeral::getParametroForLogin($this, 'LOGO_MENU');
        $oLogoMenuHover   = ParametroGeral::getParametroForLogin($this, 'LOGO_MENU_HOVER');
        $oLogoTab         = ParametroGeral::getParametroForLogin($this, 'LOGO_TAB');

        // Set new colors
        $oMainColor       = ParametroGeral::getParametroForLogin($this, 'MAIN_COLOR');
        $oMainColorDarker = ParametroGeral::getParametroForLogin($this, 'MAIN_COLOR_DARK');
        $oMainColorBorder = ParametroGeral::getParametroForLogin($this, 'MAIN_COLOR_BORDER');

        if($oLogoLogin)
            $sLogoImgLogin = Router::url('/', true) . 'img/' . $oLogoLogin->valor;

        if($oLogoMenu)
            $sLogoImgMenu = Router::url('/', true) . 'img/' . $oLogoMenu->valor;

        if($oLogoMenuHover)
            $sLogoImgMenuHover = Router::url('/', true) . 'img/' . $oLogoMenuHover->valor;

        if($oLogoTab)
            $sLogoImgTab = Router::url('/', true) . 'img/' . $oLogoTab->valor;


        $aRemoveCache = [
            'css' => env('DEBUG') ? '.css?v=' . date('Ymdmis') : '',
            'js' => env('DEBUG') ? '.js?v=' . date('Ymdmis') : '',
        ];

        $this->set(compact('aRemoveCache', 'sLogoImgLogin', 'sLogoImgMenu', 'sLogoImgMenuHover', 'sLogoImgTab', 'oMainColor', 'oMainColorDarker', 'oMainColorBorder'));
        $this->viewBuilder()->setLayout('coletor');
    }

    public function isAuthorized($user)
    {
        $this->configApp();
        $retorno = PermissionUtil::checkDefault($this, $user);

        if ($retorno) {
            return true;
        }
        else {
            $sMessage = 'Ops, parece que você não tem permissão para acessar essa funcionalidade :(';
            if (!$this->request->isAjax()) {
                $this->Flash->error(__($sMessage));
            }else {
                header('Content-Type: application/json');
                echo json_encode((new ResponseUtil())->setMessage($sMessage));
                die;
            }
            // $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            $_SESSION['redirect_error_permission'] = $this->referer();
            $this->redirect($this->referer());
            return false;
        }
    }
    
    public function disableSQLMode()
    {
        $sSql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";

        $connection = ConnectionManager::get('default');
        $connection->execute( $sSql );

    }
}
