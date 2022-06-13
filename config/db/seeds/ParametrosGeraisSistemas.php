<?php


use Phinx\Seed\AbstractSeed;

class ParametrosGeraisSistemas extends AbstractSeed
{
    public function run()
    {
        $data = array(
            array(
                "descricao" => "Parâmetro utilizado para informar Diretorio Logo do Menu.",
                "nome_unico" => "LOGO_MENU",
                "valor" => "loginfo/menu_logo.png",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar Diretorio Logo do Menu, quando houver hover.",
                "nome_unico" => "LOGO_MENU_HOVER",
                "valor" => "loginfo/menu_logo_hover.png",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar Diretorio Logo da Aba.",
                "nome_unico" => "LOGO_TAB",
                "valor" => "loginfo/tab_logo.png",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar Diretorio Logo do Login.",
                "nome_unico" => "LOGO_LOGIN",
                "valor" => "loginfo/login_logo.png",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar cor principal.",
                "nome_unico" => "MAIN_COLOR",
                "valor" => "#008ec4",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar cor principal escura.",
                "nome_unico" => "MAIN_COLOR_DARK",
                "valor" => "#014d91",
                'empresa_id' => 1,
            ),
            array(
                "descricao" => "Parâmetro utilizado para informar cor principal bordas.",
                "nome_unico" => "MAIN_COLOR_BORDER",
                "valor" => "#244869",
                'empresa_id' => 1,
            ),
        );
        
        $table = $this->table('parametro_gerais');
        $table->insert($data)->save();
    }
}

