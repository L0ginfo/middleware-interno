<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * TipoDocumento Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property string $tipo_documento
 *
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 * @property \App\Model\Entity\DocumentosTransporte[] $documentos_transportes
 */
class TipoDocumento extends Entity
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

    public function getIDTipoDocumento($tipo) 
    {
        $aReturn = array();
        $query = TableRegistry::get('TipoDocumentos')->find();
        
        if (is_array($tipo))
            array_walk($tipo, function(&$value){
                $value = strtoupper($value);
            });

        //tipo_documento in (...) 
        $isArray = (is_array($tipo)) ? ['tipo_documento' => 'string[]'] : null;
        $query = $query
                    ->where(['tipo_documento' => $tipo], $isArray)
                    ->order('tipo_documento DESC')
                    ->extract('id');
        
        foreach ($query as $row)
            $aReturn[] = $row;

        if (is_array($tipo) && count($aReturn) != count($tipo))
            return 'need_more_register';

        return $aReturn;
    }

    public static function checkNecessitaMaster($iTipoDocumentoID)
    {
        $oResponse = new ResponseUtil();

        $oTipoDocumentos = LgDbUtil::getByID('TipoDocumentos', $iTipoDocumentoID);
        if (!$oTipoDocumentos)
            return $oResponse
                ->setStatus(400);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oTipoDocumentos->necessita_master);
    }
}
