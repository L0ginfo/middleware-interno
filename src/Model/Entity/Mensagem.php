<?php
namespace App\Model\Entity;

use App\Util\EmailUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Mensagem Entity
 *
 * @property int $id
 * @property int $tipo_mensagem_id
 * @property int $usuario_id
 * @property string $assunto
 * @property \Cake\I18n\Time $data
 * @property string|null $texto
 * @property string|null $emails
 *
 * @property \App\Model\Entity\TipoMensagem $tipo_mensagem
 * @property \App\Model\Entity\Usuario $usuario
 */
class Mensagem extends Entity
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
        
        'tipo_mensagem_id' => true,
        'usuario_id' => true,
        'assunto' => true,
        'data' => true,
        'texto' => true,
        'emails' => true,
        'tipo_mensagem' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public static function send($oMensagem){
        EmailUtil::newEmail('MENSAGENS', [
            'mensagem_id' => $oMensagem->id
        ]);
    }
}
