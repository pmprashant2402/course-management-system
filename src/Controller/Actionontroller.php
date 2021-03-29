<?php


/**
 * Description of Actionontroller
 */
class Actionontroller
{
   
    public function loadView(string $viewName)
    {
        __autoload('..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $viewName . EXT);
        include_once ('..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $viewName . EXT);
    }
}
