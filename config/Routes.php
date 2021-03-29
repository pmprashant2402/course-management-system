<?php

/**
 * Description of Routes
 *
 * @author Prashant Mishra
 Date 28/03/2021
 */
class Routes
{
    /**
     * @var string
     */
    private $relativ2ePath;
    /**
     * @var string
     */
    public $controllerName;
    
    /**
     * @var string
     */
    public $functionName;
    
    /**
     * @var array
     */
    private $pathArray = [];
    
    /**
     * @var string
     */
    public $controllerPath;
    
    /**
     * @param string $relativePath
     */
    public function __construct(string $relativePath)
    {
        $this->relativePath = $relativePath;
        $this->setPathArray();
        $this->controllerName = $this->getController();
        $this->controllerPath = $this->getControllerObject();
        $this->functionName = $this->getFunction();
    }
    
    public function getPathArray(): array
    {
        return $this->pathArray;
    }

    public function setPathArray(array $pathArray = [])
    {
        if(empty($pathArray)){
            $pos = strlen($this->relativePath);
            if(strpos($this->relativePath, '?')){
                $pos = strpos($this->relativePath, '?');
            }
            $pathArray = explode('/', substr($this->relativePath, 0, $pos));
        }
        krsort($pathArray);
        $this->pathArray = array_values($pathArray);
        return $this;
    }
    
    public function getController()
    {
        $controllerName = !empty($this->pathArray[1]) ? $this->pathArray[1] : DEFAULT_CONTROLLER;
        $this->controllerName = ucfirst($controllerName) . 'Controller';
        return $this->controllerName;
    }
    
    public function getControllerObject()
    {
        $controllerPath = '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . $this->getController();
        if (null !== $this->getDirectory()) {
            $controllerPath = '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getController();
        }
        return str_replace('\\\\', '\\', $controllerPath);
    }

    public function getFunction()
    {
        $functionName = !empty($this->pathArray[0]) ? $this->pathArray[0] : DEFAULT_METHOD;
         return $functionName;   
    }
    
    public function getDirectory()
    {
        $pathArray = $this->pathArray;
        if (isset($pathArray[0])) {
            unset($pathArray[0]);
        }
        if (isset($pathArray[1])) {
            unset($pathArray[1]);
        }
        return implode(DIRECTORY_SEPARATOR, $pathArray);
    }

}
