<?php

use Phinx\Seed\AbstractSeed;
use \Cake\Auth\DefaultPasswordHasher;

class Usuarios extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Perfis',
        ];
    }

    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nome' => 'Admin',
                'email' => 'silvio@loginfo.com.br',
                'senha' => (new DefaultPasswordHasher)->hash('cpdc010408'),
                'ativo' => 1,
                'cpf' => '02227689919',
                'perfil_id' => 1,
                'created_by' => NULL,
                'sincronizado' => NULL,
                'token' => NULL
            ]
        ];

        $table = $this->table('usuarios');
        $table->insert($data)->save();
    }
}
