<?php


use Phinx\Seed\AbstractSeed;

class Continentes extends AbstractSeed
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
            [
                'id'    => 1,
                'descricao'  => 'América do Sul'
            ]
        ];

        $table = $this->table('continentes');
        $table->insert($data)->save();

    }
}
