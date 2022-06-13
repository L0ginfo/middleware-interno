<?php

use Phinx\Seed\AbstractSeed;
use \Cake\Auth\DefaultPasswordHasher;

class EmpresasUsuarios extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Empresas',
            'Usuarios',
        ];
    }

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'validade' => '2020-12-30',
                'master' => 1,
                'empresa_id' => 1,
                'usuario_id' => 1,
                'perfil_id' => 1            ]
        ];

        $table = $this->table('empresas_usuarios');
        $table->insert($data)->save();
    }
}
