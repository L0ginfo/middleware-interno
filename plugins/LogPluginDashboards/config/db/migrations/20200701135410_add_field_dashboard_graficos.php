<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-07-01 13:54:10
*/

class AddFieldDashboardGraficos extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboard_graficos')
            ->addColumn('usa_macros_periodos', 'integer', ['default' => 1])
            ->update();
    }
    
}
