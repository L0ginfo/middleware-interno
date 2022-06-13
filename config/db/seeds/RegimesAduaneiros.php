<?php


use Phinx\Seed\AbstractSeed;

class RegimesAduaneiros extends AbstractSeed
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
        $aData = array(
            array(
                "id" => 1,
                "descricao" => "COMUM IMPORTAÇÃO",
                "dias_vencimento" => 2,
            ),
            array(
                "id" => 2,
                "descricao" => "COMUM EXPORTAÇÃO",
                "dias_vencimento" => 4,
            ),
            array(
                "id" => 3,
                "descricao" => "ENTREPOSTO IMPORTAÇÃO",
                "dias_vencimento" => 4,
            ),
            array(
                "id" => 4,
                "descricao" => "ENTREPOSTO EXPORTAÇÃO",
                "dias_vencimento" => 2,
            ),
            array(
                "id" => 5,
                "descricao" => "DAC - DEPOS. ALFAND. CERTIFICADO",
                "dias_vencimento" => 3,
            ),
            array(
                "id" => 6,
                "descricao" => "DAP",
                "dias_vencimento" => 4,
            ),
        );
        
        $this->table('regimes_aduaneiros')->insert($aData)->save();
    }
}
