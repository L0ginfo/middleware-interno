<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\AceiteContainer;
use Cake\Core\Configure;
use App\Util\SaveBackUtil;
use App\Model\Entity\Empresa;
use App\Util\CsvUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\RequestUtil;
use App\Util\SearchFilterUtil;

/**
 * Ocrs Controller
 *
 * @property \App\Model\Table\AceiteContainersTable $AceiteContainers
 *
 * @method \App\Model\Entity\AceiteContainer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OcrsController extends AppController
{
    
    public $customTitlePage = 'Ocrs';

    /**
    * beforeRender method
    *
    * @param Event $event
    * @return void
    */
    public function beforeRender(\Cake\Event\Event $event)
    {
        if (!isset($this->viewVars['customTitlePage']))
            $this->set('customTitlePage', __($this->customTitlePage));
    }
    /**
    * Initialize method
    *
    * @param array $config The configuration for the Table.
    * @return void
    */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['buscaPassagens']);

        $aModels = [
            
        ];

        foreach ($aModels as $aModel) {
            $this->loadModel($aModel);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function buscaPassagens($iFluxoId, $bUltimo)
    {
        if (!$iFluxoId)
            return (new ResponseUtil())
                ->setMessage('Parâmetro de fluxo faltante!');

        $sHost = env('BASE_URL_OCR') . '/ocr/session/' . $iFluxoId . ($bUltimo ? '/ultima' : '');

        $sHost = str_replace('IDFLUXO', $iFluxoId, $sHost);

        $oRequestUtil = new RequestUtil(10);
        $oRequestUtil->setUrl($sHost);
        $oRequestUtil->setType('GET');
        curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYPEER,  false);
        curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYHOST,  0);
        $oRequestUtil->send();
        $aResponse = $oRequestUtil->getResponseDatas();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra($aResponse)
            ->setJsonResponse($this);
    }
}
