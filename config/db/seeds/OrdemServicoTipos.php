<?php


use Phinx\Seed\AbstractSeed;

class OrdemServicoTipos extends AbstractSeed
{
    
    public function getDependencies()
    {
        return [
            'Empresas',
        ];
    }

    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "Descarga",
                "empresa_id" => 1,
            ),
            array(
                "id" => 2,
                "descricao" => "Carga",
                "empresa_id" => 1,
            ),
            array(
                "id" => 3,
                "descricao" => "Outros",
                "empresa_id" => 1,
            ),
            array(
                "id" => 4,
                "descricao" => "Desconsolidação",
                "empresa_id" => 1,
            ),
            array(
                "id" => 5,
                "descricao" => "Separação",
                "empresa_id" => 1,
            ),
            array(
                "id" => 6,
                "descricao" => "ESTUFAGEM",
                "empresa_id" => 1,
            ),
            array(
                "id" => 7,
                "descricao" => "DESUNITIZACAO",
                "empresa_id" => 1,
            ),
            array(
                "id" => 8,
                "descricao" => "UNITIZACAO",
                "empresa_id" => 1,
            ),
            array(
                "id" => 9,
                "descricao" => "Adequação",
                "empresa_id" => 1,
            ),
        );
        
        $table = $this->table('ordem_servico_tipos');
        $table->insert($data)->save();
    }
}
