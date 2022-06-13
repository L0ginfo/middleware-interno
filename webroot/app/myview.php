<?php

class myViewInternal {

    public $params = [];

    public function __get($columnName)
    {
        if (array_key_exists($columnName, $this->params)) {
            return $this->params[$columnName];
        } else {
            return '???';
        }
    }

	public function render($filename, $params)
	{
        $this->params = $params;

        ob_start();
        include $filename;
        return ob_get_clean();
	}
}

class myView {
	
	public static function render($filename, $params)
	{
		$view = new myViewInternal();
		return $view->render($filename, $params);
	}
}
