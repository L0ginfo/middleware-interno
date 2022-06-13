<?php
namespace App\View\Cell;

use App\Model\Entity\Area;
use App\Model\Entity\Endereco;
use App\Model\Entity\Local;
use App\Util\SessionUtil;
use Cake\Http\Session;
use Cake\View\Cell;
use DateTime;

/**
 * BuscaEndereco cell
 */
class BuscaEnderecoCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($sModo = 'local-area-endereco', $iKey = 1, $aDataExtra = [])
    {
        //diz quais combos deverao vir preenchidos em determinado modo
        $aModos = [
            'local-area-endereco' => ['local'], 
            'local-endereco' => ['local'], 
            'area-endereco' => ['area'], 
            'all-enderecos' => ['endereco']
        ];
        $aCombos = ['locais', 'areas'];

        if (!isset($aModos[$sModo]))
            $sModo = 'local-area-endereco';

        $aEnderecosRestritos =
            array_key_exists('restricoes', $aDataExtra) && array_key_exists('enderecos', $aDataExtra['restricoes'])
            ? $aDataExtra['restricoes']['enderecos']
            : null;

        $iTimeCache = array_key_exists('time-cache', $aDataExtra)
            ? $aDataExtra['time-cache']
            : 2;

        $sTipoComposicao = array_key_exists('tipo-composicao', $aDataExtra)
            ? $aDataExtra['tipo-composicao']
            : 'com_local';

        $iCasasPadding = array_key_exists('casas-padding', $aDataExtra)
            ? $aDataExtra['casas-padding']
            : 4;

        $aCombos = SessionUtil::cacheData('cell-busca-endereco-combos', function() use($sModo, $aEnderecosRestritos, $sTipoComposicao, $iCasasPadding) {

            if ($sModo == 'all-enderecos') {
                $aCombos['enderecos']  = Endereco::getAllList($aEnderecosRestritos, $sTipoComposicao, $iCasasPadding);
            }
            
            $aCombos['locais'] = Local::getList();
            $aCombos['areas']  = Area::getList();

            return $aCombos;
        }, $iTimeCache);

        $this->set(compact(
            'aCombos',
            'iKey',
            'sModo',
            'aModos',
            'aDataExtra'
        ));
    }
}
