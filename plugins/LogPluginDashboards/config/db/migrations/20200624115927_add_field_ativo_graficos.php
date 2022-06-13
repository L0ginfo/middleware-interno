<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-24 11:59:27
*/

class AddFieldAtivoGraficos extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboards')
            ->addColumn('ativo', 'integer', ['default' => 1])
            ->update();

        $this->table('dashboard_cards')
            ->addColumn('ativo', 'integer', ['default' => 1])
            ->update();

        $this->table('dashboard_graficos')
            ->addColumn('ativo', 'integer', ['default' => 1])
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
