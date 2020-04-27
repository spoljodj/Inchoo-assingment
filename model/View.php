<?php

class View
{
    private $layout;

    public function __construct($layout='base')
    {
        $this->layout=$layout;
    }

    public function render($pagetorender, $parameters=[])
    {
        ob_start();
        extract($parameters);
        include BP . 'view' . DIRECTORY_SEPARATOR . $pagetorender . '.phtml';
        $content= ob_get_clean();

        include BP . 'view' . DIRECTORY_SEPARATOR . $this->layout . '.phtml';
    }
}