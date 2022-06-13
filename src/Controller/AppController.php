<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

//use Acl\Controller\Component\AclComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Database\Type;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Muffin\Footprint\Auth\FootprintAwareTrait;
use PDO;
use PDOException;
use App\Exception\SaraLoginException;
use App\Model\Entity\Empresa;
use App\Model\Entity\LogAcesso;
use ZipArchive;
use App\Model\Entity\Menu;
use Cake\Filesystem\Folder;
use App\Model\Entity\ParametroGeral;
use App\Model\Entity\Perfil;
use App\Util\DateUtil;
use App\Util\PermissionUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\Core\Configure;
use Cake\Http\Session;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    use FootprintAwareTrait;

    /**
     * Conecta banco
     * @var Conexao ODBC
     */
    public $conn;
    

    /**
     * Get CSV data
     * @param String $file - w/ absolute path file
     * @param String $delimeter - mude se delimitador for diferente de ";"
     * @return Array - dados do CSV
     */
    public function getDataCSV($file, $delimeter = ';')
    {
        $row = 0;
        if (($handle = fopen($file, "r")) !== FALSE) {
            $dados = array();
            while (($data = fgetcsv($handle, 1000, $delimeter)) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $dados[$row][] = trim($data[$c]);
                }
            }

            fclose($handle);
            return $dados;
        }
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        //acl
        //$this->loadComponent('Acl.Acl');
        $this->loadComponent('Acl');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'unauthorizedRedirect' => false,
            'loginAction' => [
                'controller' => 'Usuarios', 'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Usuarios', 'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Pages', 'action' => 'index'
            ],
            'authError' => ( isset($_SESSION['Auth']['User']['id']) )
                ? 'Ops, parece que você não tem permissão para essa funcionalidade.'
                : 'Por favor, faça o login antes',
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Usuarios',
                    'fields' => ['username' => 'cpf', 'password' => 'senha']
                ]
            ],
            'storage' => 'Session'
        ]);

        $path = LOGS . '/' . date('Y-m-d/');
        @mkdir($path);

        if (@$_SESSION['Auth']['User']['id']) {
            // $prefix = @$this->request->session()->read('Auth.User.id').'-'.@$this->request->session()->read('Auth.User.nome').'-';
            $prefix = @$_SESSION['Auth']['User']['id'] . '-' . @$_SESSION['Auth']['User']['nome'] . '-';
        } else {
            $prefix = 'Deslogado';
        }


        $prefix = str_replace(' ', '_', $prefix);

        ini_set('error_log', $path . '/' . $prefix . 'error_log.log');

        Log::drop('debug');
        Log::config('debug', [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => $path,
            'levels' => ['notice', 'info', 'debug'],
            'file' => $prefix . 'debug',
        ]);
        Log::drop('error');
        Log::config('error', [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => $path,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
            'file' => $prefix . 'error',
        ]);
        Log::drop('integracao');
        Log::config('integracao', [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => $path,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
            'file' => $prefix . 'integracao',
        ]);
    }

    /**
     * Faz pesquisa ajax
     * @matching String - quando é hasMany Association
     * @return Query
     */
    protected function filtrarQuery($table = null, $excludeFilter = [])
    {
        $table = $table ?: $this->name;
        $queryData = $this->request->getData();

        $filtros = $this->{$table}->newEntity();
        foreach ($queryData as $key => $value) {
            if(in_array($key, $excludeFilter)){
                unset($queryData[$key]);
            }

            $filtros[$key] = $value;
        }
        $this->set(compact('filtros'));

        $query = $this->{$table}->find()->where(function ($e) use ($table, $queryData) {
            $data = [];
            foreach (array_filter($queryData) as $i => $v) {
                if (is_array($v)) {
                    foreach ($v as $k => $_v) {
                        if ($_v) {
                            $data[] = $e->like($i . '.' . $k, '%' . $_v . '%');
                        }
                    }
                }
                else if (strpos($v, '/') == 2 && strlen($v) == 10) {
                    $data[] = $e->like($table . '.' . $i, DateUtil::dateTimeToDB($v));
                }
                else if (strpos($i, '_id') !== false || $i == 'id') {
                    $data[] = $e->like($table . '.' . $i, $v);
                }
                else if (is_string($v)) {
                    $data[] = $e->like($table . '.' . $i, '%' . $v . '%');
                }
            }
            return $data;
        });
        return $query;
    }

    public function isAuthorized($user)
    {
        $retorno = PermissionUtil::checkDefault($this, $user);
        $aSesson = $this->getRequest()->getSession()->read();

        if ($retorno) {
            $oMenu = new Menu;
            $oMenu = $oMenu->getMenus();
            $sLogoEtiquetaImg =  '/img/'.Configure::read('LOGO.LOGIN');
            $sLogoLoginImg =  '/img/'.Configure::read('LOGO.LOGIN');
            $sLogoImg =  '/img/'.Configure::read('LOGO.MENU');
            $sLogoHeaderCodigoBarras =  '/img/'.Configure::read('LOGO.HEADER_CODIGO_BARRAS');
            $sLogoFooterCodigoBarras =  '/img/'.Configure::read('LOGO.FOOTER_CODIGO_BARRAS');

            $sLogoImgHover =  '/img/'.Configure::read('LOGO.MENU_HOVER');
            $sLogoImgTab =  '/img/'.Configure::read('LOGO.TAB');

            $sPEtiqueta = ParametroGeral::getParametroWithValue('LOGO_ETIQUETA');
            $sPLogin = ParametroGeral::getParametroWithValue('LOGO_LOGIN');
            $sPMenu = ParametroGeral::getParametroWithValue('LOGO_MENU');
            $sPMenuHover = ParametroGeral::getParametroWithValue('LOGO_MENU_HOVER');
            $sPTab = ParametroGeral::getParametroWithValue('LOGO_TAB');
            $sPHeaderCodigoBarras = ParametroGeral::getParametroWithValue('LOGO_HEADER_CODIGO_BARRAS');
            $sPFooterCodigoBarras = ParametroGeral::getParametroWithValue('LOGO_FOOTER_CODIGO_BARRAS');

            $sMainColor = ParametroGeral::getParametroWithValue('MAIN_COLOR');
            $sMainColorDarker = ParametroGeral::getParametroWithValue('MAIN_COLOR_DARK');
            $sMainColorBorder = ParametroGeral::getParametroWithValue('MAIN_COLOR_BORDER');
            $sMainColorFundoMenu   = ParametroGeral::getParametroWithValue('PARAM_COR_FUNDO_MENU');
            $sMainColorFundoTopBar   = ParametroGeral::getParametroWithValue('PARAM_COR_TOP_BAR');
            $sMainColorFonteMenu   = ParametroGeral::getParametroWithValue('PARAM_COR_FONTE_MENU');

            if($sPEtiqueta){
                $sLogoEtiquetaImg = '/img/'.$sPEtiqueta;
            }

            if($sPLogin){
                $sLogoLoginImg = '/img/'.$sPLogin;
            }

            if($sPMenu){
                $sLogoImg = '/img/'.$sPMenu;
            }

            if($sPMenuHover){
                $sLogoImgHover ='/img/'.$sPMenuHover;
            }

            if($sPTab){
                $sLogoImgTab = '/img/'.$sPTab;
            }

            if($sPHeaderCodigoBarras){
                $sLogoHeaderCodigoBarras = '/img/'.$sPHeaderCodigoBarras;
            }

            if($sPFooterCodigoBarras){
                $sLogoFooterCodigoBarras = '/img/'.$sPFooterCodigoBarras;
            }

            if(!isset($aSesson['log_acessos'])){
                $oParametro = ParametroGeral::getParametroWithValue('PARAM_HABILITA_LOG_ACESSO');
                $this->getRequest()->getSession()->write('log_acessos', $oParametro);
            }

            $this->set(compact(
                'oMenu', 
                'sLogoImg', 
                'sLogoImgHover', 
                'sLogoEtiquetaImg', 
                'sLogoLoginImg', 
                'sLogoImgTab', 
                'sMainColor', 
                'sMainColor', 
                'sMainColorDarker', 
                'sMainColorBorder',
                'sMainColorFundoMenu',
                'sMainColorFundoTopBar',
                'sMainColorFonteMenu',
                'sLogoHeaderCodigoBarras',
                'sLogoFooterCodigoBarras'
            ));
            $this->viewBuilder()->layout('admin');
            return true;
        } else {
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

    /**
     * Checar ACL do usuario logado
     * @param string $controller
     * @param string $action
     * @return bool
     */
    /*
    public function checar($controller, $action)
    {
        $acl = new AclComponent(new ComponentRegistry);
        $usuario = new UsuariosController();
        return $acl->check(['Usuarios' => ['id' => $this->getCurrentUserId()]], $controller . '/' . $action);
    }
    */

    /**
     * Retorna Id do usuario atual logado
     * @return int id
     */
    public function getCurrentUserId()
    {
        return $this->Auth->user('id');
    }

    /**
     * Faz pesquisa ajax
     * @matching String - quando é hasMany Association
     * @return Query
     */
    protected function pesquisaAjax($matching = null)
    {
        $this->viewBuilder()->layout(false);
        $query = $this->{$this->name}->find()->matching($matching)->where(function ($e) {
            $data = [];
            foreach (array_filter($this->request->data) as $i => $v) {
                if (is_array($v)) {
                    foreach ($v as $k => $_v) {
                        if ($_v) {
                            $data[] = $e->like($i . '.' . $k, '%' . $_v . '%');
                        }
                    }
                } else {
                    if ($v) {
                        $data[] = $e->like($this->name . '.' . $i, '%' . $v . '%');
                    }
                }
            }

            return $data;
        });

        return $query;
    }

    public function _getData($sql)
    {
        $retorno = [];

        if (strpos(" " . $sql, 'exec ') > 0) {
            $res = $this->conn->query(iconv("UTF-8", "CP1252", $sql));
        } else {
            $res = $this->conn->query($sql);
        }

        if ($res) {
            foreach ($res as $i => $v) {
                foreach ($v as $_i => $_v) {
                    if (!is_int($_i)) {
                        // $retorno[$i][$_i] = utf8_encode($_v);
                        $retorno[$i][$_i] = $_v;
                    }
                }
            }
        }

        // $this->log( $sql, 'bug');
        $executandoSQLProcedure = !(strpos($sql, 'exec') > 0);
        $updateSQLProcedure = !(strpos($sql, 'update') > 0);
        $insertSQLProcedure = !(strpos($sql, 'insert') > 0);

        if (!$retorno || $executandoSQLProcedure || $updateSQLProcedure || $insertSQLProcedure) {
            $this->log(($executandoSQLProcedure ? '' : 'Error -> ' ) . $sql, 'info');
        }

        return $retorno;
    }

    public function conecta_db_sql_server($execException = false)
    {
        return false;

        try {
            $this->conn = new PDO(SQLSERVER_DSN,
                    $this->request->session()->read('SQLSERVER_USER'),
                    $this->request->session()->read('SQLSERVER_PASS')
                    );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            if($e->getCode() == SaraLoginException::EXCEPTION_CODE || $e->getCode() == '18456'){
                if($execException){
                    throw new SaraLoginException();
                }else{
                    $this->Auth->logout();
                    header("Refresh:0");
                    die();
                }
            }
        }
    }

    /*
     * Conecta com SQLServer como usuario SA
     *
     * Em alguns lugares a base "Sara_db" relaciona com a base "portal"
     * Utilizar esse metodo para nao ter problemas de permissão
     *
    **/
    public function conecta_db_sql_server_sa()
    {
        try {
            if (!isset($this->conn)) {
                $this->conn = new PDO(SQLSERVER_DSN, SQLSERVER_USER_SA, SQLSERVER_PASS_SA);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            }
            return $this->conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Before render callback.
     *
     * @param Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {

        LogAcesso::execute();

        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }

        //$this->viewBuilder()->theme('erp');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //$this->Auth->allow();

        $this->Auth->allow('viewIntPagtoConcessionaria');
        $this->Auth->allow('saveLogError');
        $this->Auth->allow('getDriveByContainer');

        $this->_userModel = 'Usuarios';
    }

    public function makeZip($files, $zipFile = '')
    {
        if (!$zipFile) $zipFile = tempnam('', 'zip-');

        $zip = new ZipArchive();
        $zip->open($zipFile, ZIPARCHIVE::CREATE);

        foreach ($files as $name => $filename) {
            if (is_string($name))
                $zip->addFile($filename, $name);
            else
                $zip->addFile($filename, basename($filename));
        }

        @$zip->close();
        return $zipFile;
    }

    public function removeAcentos($palavra)
    {
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

        // matriz de saída
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '', '_', '_', '_', '_', '_', '_', '_', '_', '_');

        // devolver a string
        $palavra = str_replace($what, $by, $palavra);

        while ((strpos($palavra, '__')) !== false) {
            $palavra = str_replace('__', '_', $palavra);
        }

        return $palavra;
    }

    public function getEmpresaAtual()
    {
        return Empresa::getEmpresaAtual();
    }

    public function getCodigoEmpresaAtual()
    {
        $this->loadModel('Empresas');
        $oEmpresa = $this->Empresas->find()
            ->where([
                'id' => $this->getEmpresaAtual()
            ])
            ->first();

        if ($oEmpresa)
            return $oEmpresa->codigo;

        return null;
    }

    public function setEntity($entityName, $aPostData = null, $options=[])
    {
        $Object = null;
        $id = $this->checkEditID($aPostData);

        if ($entityName)
            if ($id)
                $Object = $this->{$entityName}->get($id, $options);
            else
                $Object = $this->{$entityName}->newEntity();

        return $Object;
    }

    private function checkEditID($aPostData)
    {
        if (isset($aPostData['id']) && $aPostData['id'] != '') {
            return $aPostData['id'];
        }

        return null;
    }

    public function disableSQLMode()
    {
        if (!env('DISABLE_SQL_MODE', true)) 
            return;

        $sSql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));";

        $connection = ConnectionManager::get('default');
        $connection->execute( $sSql );

    }

    public function xmlToArray($sCaminho)
    {
        $oFile        = new File($sCaminho);
        $contents = $oFile->read();
        $xmlArray = Xml::toArray(Xml::build($contents));
        $oFile->close();

        return $xmlArray;
    }

    public function moveArchive($sCaminho, $newFolder)
    {
        $dir    = new Folder($sCaminho);
        $newDir = new Folder($newFolder, true, 0755);
        $files  = $dir->find('.*\.xml');

        foreach ($files as $file) {

            $file = new File($dir->pwd() . DS . $file);
            $file->copy($newDir->pwd() . DS . $file->name, true);
            $file->delete();
            $file->close();

        }
    }

    public function getAllFilesFromFolder($sCaminho, $tipo)
    {
        $dir    = new Folder($sCaminho);
        $files  = $dir->find('.*\.' . $tipo);
        $aFiles = [];
        foreach ($files as $file) {

            $file = new File($dir->pwd() . DS . $file);
            $aFiles[] = [
                'path' => $file->path,
                'name' => $file->path
            ];
            $file->close();

        }

        return $aFiles;
    }

    public function removeFile($path, $sCaminho, $tipo)
    {
        $sCaminho .= $path;

        if (file_exists($sCaminho)) {
            unlink($sCaminho);
        }

        return [];

        $dir    = new Folder($sCaminho . 'files' . DS . 'dropzone');
        dd($sCaminho . $path);
        $files  = $dir->find($path);
        $aFiles = [];

        foreach ($files as $file) {

            $file = new File($dir->pwd() . DS . $file);
            if ($file->path == $path) {
                $file->delete();
            }
            $file->close();

        }

        return $aFiles;
    }


    public function saveLogError()
    {
        $oResponse = new ResponseUtil();
        $aData = $this->request->getData();
        $sData = json_encode($aData);

        $sResult = ($sData);
        $aResult = json_decode($sResult, true);
        $aResult['timestamp'] = strtotime(date('Y-m-d H:i:s'));
        $aResult['usuario'] = [
            'id' => @$this->request->getSession()->read('Auth.User.id'),
            'nome' => @$this->request->getSession()->read('Auth.User.nome'),
            'ativo' => @$this->request->getSession()->read('Auth.User.ativo'),
            'perfil_id' => @$this->request->getSession()->read('Auth.User.perfil_id'),
        ];

        $this->log($aResult, 'debug');

        return $oResponse->setStatus(200)
            ->setMessage('OK')
            ->setDataExtra(['timestamp' => $aResult['timestamp']])
            ->setJsonResponse($this, $aResult['timestamp']);
    }

}
