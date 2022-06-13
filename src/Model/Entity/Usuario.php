<?php

namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity,
    Cake\Auth\DefaultPasswordHasher,
    Cake\ORM\TableRegistry;

/**
 * Usuario Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property int $ativo
 * @property string $cpf
 * @property int $empresa_id
 * @property int $perfil_id
 * @property \App\Model\Entity\Perfi $perfi
 * @property \App\Model\Entity\Empresa[] $empresas
 */
class Usuario extends Entity {

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

    /**
     * hash da senha ao salvar
     * @param type $password
     * @return type
     */
    protected function _setSenha($password) {
        if (!empty($password)) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    public function parentNode() {
        if (!$this->id) {
            return null;
        }
        if (isset($this->perfil_id)) {
            $group_id = $this->perfil_id;
        } else {
            $users_table = TableRegistry::get('Usuarios');
            $user = $users_table->find('all', ['fields' => ['perfil_id']])->where(['id' => $this->id])->first();
            $group_id = $user->perfil_id;
        }
        if (!$group_id) {
            return null;
        }

        return ['Perfis' => ['id' => $group_id]];
    }

    public function getEmpresas($perfil = null, $cnpj_padrão = null) {

        //  debug($this);die();
        $EmpresasUsuarios = TableRegistry::get('EmpresasUsuarios');
        $empresas = $EmpresasUsuarios->find('all')
                ->where([$perfil ? 'EmpresasUsuarios.perfil_id = ' . $perfil : ''])
                ->contain(['Empresas'])
                ->where(['usuario_id' => $this->id])
                ->orWhere(['Empresas.cnpj' => $cnpj_padrão])
                ->orWhere(['1 = ' => $this->perfil_id]) //perfil administrador
                ->orWhere([$perfil=='6'?'1=1':'']) //libera representante
                ->order(['Empresas.nome'])
                ->distinct(['Empresas.id']);
     //   debug ($empresas->first());die();    
/*debug($empresas);
        if ($perfil == 4) {
            foreach ($empresas as $i) {
                debug($this);
                debug($i);
               
            }
        }
         die();*/
        return $empresas;
    }

    public static function getVinculos($iUsuarioID)
    {
        return [
            'usuario' => LgDbUtil::getByID('Usuarios', $iUsuarioID),
            'veiculo' => LgDbUtil::getFind('UsuarioVeiculos')
                ->where(['UsuarioVeiculos.usuario_id' => $iUsuarioID])
                ->order([
                    'UsuarioVeiculos.id' => 'DESC'
                ])
                ->first(),
            'motorista' => LgDbUtil::getFind('UsuarioPessoas')
                ->where(['UsuarioPessoas.usuario_id' => $iUsuarioID])
                ->order([
                    'UsuarioPessoas.id' => 'DESC'
                ])
                ->first()
        ];
    }

}
