<?php

namespace App\Model\Entity;

use App\Util\SessionUtil;
use Cake\ORM\Entity;

/**
 * Perfil Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 */
class Perfil extends Entity
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

    public function parentNode()
    {
        return null;
    }

    public static function listaPermissoes($user) 
    {
        $usuarioGrupos = \Cake\ORM\TableRegistry::get('Perfis');
        return @$usuarioGrupos->find('all')->where(['id' => $user['perfil_id'], 'sistema_id' => SISTEMA])->first()->acl;
    }


    public static function precisaEmpresasVinculadas(){
        $iPerfil = SessionUtil::getPerfilUsuario();
        $value = json_decode(ParametroGeral::getParametroWithValue('PARAM_PERFIS_PRECISAM_EMPRESAS_VINCULADAS'), true);

        if(empty($value) && $value['perfis']){
            return false;
        }

        return in_array($iPerfil, $value['perfis']);
    }

    public static function isAdmin(){
        return  SessionUtil::getPerfilUsuario() == 1;
    }
}
