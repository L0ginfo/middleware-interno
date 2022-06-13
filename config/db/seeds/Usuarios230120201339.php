<?php


use Phinx\Seed\AbstractSeed;
use \Cake\Auth\DefaultPasswordHasher;

class Usuarios230120201339 extends AbstractSeed
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
                'id' => 150,
                'nome' => 'CronUser',
                'email' => 'silvio@loginfo.com.br',
                'senha' => (new DefaultPasswordHasher)->hash('cpdc010408'),
                'ativo' => 1,
                'cpf' => '00000000000',
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
