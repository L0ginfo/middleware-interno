<?php


use Phinx\Seed\AbstractSeed;

class SeparacaoSituacoes extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "id" => 1,
                "descricao" => "Recebido",
            ),
            array(
                "id" => 2,
                "descricao" => "Planejado",
            ),
            array(
                "id" => 3,
                "descricao" => "Recusado",
            ),
            array(
                "id" => 4,
                "descricao" => "Separado",
            ),
            array(
                "id" => 5,
                "descricao" => "Atendido",
            ),
        );
        
        $table = $this->table('separacao_situacoes');
        $table->insert($data)->save();
    }
}
