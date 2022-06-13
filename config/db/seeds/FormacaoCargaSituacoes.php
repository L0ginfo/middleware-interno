<?php


use Phinx\Seed\AbstractSeed;

class FormacaoCargaSituacoes extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            ["descricao" => "Pendente"],
            ["descricao" => "Finalizado"],
        ];

        $table = $this->table('formacao_carga_situacoes');
        $table->insert($data)->save();
    }
}
