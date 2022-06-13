<?php
/**
* Creator: Silvio Regis 16:45 19/06/2020
*/

use Phinx\Migration\AbstractMigration;

/**
* Author: Silvio Regis 2020-06-25 16:10:16
*/

class AddFieldMacrosGraph extends AbstractMigration
{
    public function change() 
    {
        $this->table('dashboard_graficos')
            ->addColumn('campo_macro_dt_inicio', 'string', ['null' => true])
            ->addColumn('campo_macro_dt_fim', 'string', ['null' => true])
            ->addColumn('extra_classes', 'string', ['null' => true])
            ->update();            
    }
    
}
