<?php


use Phinx\Seed\AbstractSeed;

class RegimeAduaneiroTipoFaturamento extends AbstractSeed
{

    public function getDependencies()
    {
        return [
            'RegimesAduaneiros',
            'TiposFaturamentos'
        ];
    }

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
        $data = array(
            array(
                "id" => 1,
                "descricao" => "normal",
                "regime_aduaneiro_id" => 2,
                "tipo_faturamento_id" => 1,
            ),
            array(
                "id" => 2,
                "descricao" => "normal",
                "regime_aduaneiro_id" => 1,
                "tipo_faturamento_id" => 2,
            ),
        );

        $table = $this->table('regime_aduaneiro_tipo_faturamentos');
        $table->insert($data)->save();

        
    }
}
