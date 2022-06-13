<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-24 18:00:43
*/

class AddFieldGraficos extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboard_graficos')
            ->addColumn('extra_script', 'text', ['null' => true])
            ->update();
    }
    
}
