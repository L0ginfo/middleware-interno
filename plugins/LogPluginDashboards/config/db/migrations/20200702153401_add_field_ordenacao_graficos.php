<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-07-02 15:34:01
*/

class AddFieldOrdenacaoGraficos extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboard_graficos')
            ->addColumn('ordenacao_eixo_x', 'string')
            ->update();
    }
    
/*
    public function up() 
    {
        
    }

    public function down() 
    {
        
    }
*/
}
