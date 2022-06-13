<?php


use Phinx\Seed\AbstractSeed;

class TipoFaturamentoDapeSemCarga extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 4,
                "descricao" => "DAPESC",
            )
        );
        
        $this->table('tipos_faturamentos')->insert($data)->save();
    }
}
