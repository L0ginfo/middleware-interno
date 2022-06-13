<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ModalUsuario Entity
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $modal_id
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Modal $modal
 */
class ModalUsuario extends Entity
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
        'modal_id' => true,
        'usuario' => true,
        'modal' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getModal()
    {
        $oModalUsuario = LgDbUtil::getFind('ModalUsuarios')
            ->where([
                'usuario_id IS' => @$_SESSION['Auth']['User']['id']
            ])->first();

        if (!$oModalUsuario)
            return null;

        return $oModalUsuario->modal_id;
    }
}
