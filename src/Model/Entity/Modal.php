<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Modal Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 * @property \App\Model\Entity\DocumentosTransporte[] $documentos_transportes
 * @property \App\Model\Entity\Portaria[] $portarias
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Modal extends Entity
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
        'descricao' => true,
        'documentos_mercadorias' => true,
        'documentos_transportes' => true,
        'portarias' => true,
        'resvs' => true
    ];

    public static function getPadrao(){
        $oModal = LgDbUtil::get('Modais')
            ->find()
            ->where(['LOWER(descricao)' => 'rodoviário'])
            ->select(['id', 'descricao'])
            ->first();

        return @$oModal->id;
    }

    public static function criaWhereModalPadrao($aQuery)
    {
        if (@$aQuery['select_modal'])
            return [];

        $sValueParam = ParametroGeral::getParametroWithValue('PARAM_PADRAO_MODAL');
        if (!str_replace(' ', '', $sValueParam))
            return [];

        $aModais = explode(',', str_replace(' ', '', $sValueParam));
        $aModaisIds = [];
        foreach ($aModais as $key => $modal) {
            $aModaisIds[] = EntityUtil::getIdByParams('Modais', 'descricao', $modal);
        }
        $aWhere = ['Modais.id IN' => array_filter($aModaisIds)];

        return $aWhere;
    }
}
