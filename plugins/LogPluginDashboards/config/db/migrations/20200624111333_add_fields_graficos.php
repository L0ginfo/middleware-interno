<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-24 11:13:33
*/

class AddFieldsGraficos extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboard_graficos')
            ->addColumn('titulo', 'string')
            ->addColumn('descricao', 'string')
            ->update();
    }
    
}
