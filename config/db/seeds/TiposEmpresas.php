<?php


use Phinx\Seed\AbstractSeed;

class TiposEmpresas extends AbstractSeed
{

    public function run()
    {
        $tipos_empresas = array(
            array(
                "id" => 0,
                "descricao" => "Empresa Ponta Negra",
                "is_empresa_master" => 1,
            ),
            array(
                "id" => 0,
                "descricao" => "Cliente",
                "is_empresa_master" => 0,
            ),
        );

        $this->table('tipos_empresas')->insert($tipos_empresas)->save();
        
    }
}
