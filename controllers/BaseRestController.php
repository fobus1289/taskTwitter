<?php

namespace app\controllers;

use yii\web\Controller;
use yii\base\InlineAction;
use crutch\IMiddleMan;
use app\controllers\traits\ControllerAssistant;

abstract class BaseRestController extends Controller implements IMiddleMan
{
    use ControllerAssistant;
    
    public    $enableCsrfValidation = false;
    protected $requestActionName = '';
    protected $middlewareClass = [];
    protected $authoBindingParams = false;
    private   $miidelwareFile = null;
        
    /**
     * @param array $names
     * @param array|string $actions
     * @return \AppCrutch\IMiddleMan|null
     */
    protected final function middleware($names, $actions = null)
    {
        $this->miidelwareFile = middleware_config();
       
        foreach($names as $name) {
            if(empty($this->miidelwareFile[$name])){
                validation_error('500', ['Missing middleware' => $name]);
            }
            $this->middlewareClass[$name] = $this->miidelwareFile[$name]; 
        }
        
        if($actions == '*') {
            
            $classes = &$this->middlewareClass;
            
            foreach($classes as &$class) {
                (new $class())->handle($this->request);
            }
            return null;
        }
        $this->requestActionName = $this->action->actionMethod;
        
        return $this;
    }
    
    public function init() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        parent::init();
    }
    
    protected function postConstruct()
    {
        
    }
   
    private final function initMiddleware($actions)
    { 
        return \in_array($this->requestActionName, $actions);
    }
    
    /**
     * 
     * @param array $actions
     * @return \AppCrutch\IMiddleMan
     */
    public final function only($actions)
    {
        if($this->initMiddleware($actions)) {
            $classes = &$this->middlewareClass;
            foreach($classes as &$class) {
               (new $class())->handle($this->request);
            }
        }   
        
        return $this;
    }
        
    public final function bindActionParams($action, $params) {
        $this->postConstruct();
        if($this->authoBindingParams){
            if($action instanceof InlineAction) {
                $method = new \ReflectionMethod($this, $action->actionMethod);
            }else{
                $method = new \ReflectionMethod($action, 'run');
            }

            $methodParams = $method->getParameters();

            /**
            * @var \ReflectionParameter $datum
            */
            foreach ($methodParams as $datum) {
                $class = $datum->getClass();
                if ($class) {
                    $tmpParams[$datum->name] = $class->newInstance();  
                }else{
                    $tmpParams[$datum->name] = $params[$datum->name];  
                }
            }

            $params = $tmpParams ?? $params;
        }

        return parent::bindActionParams($action, $params);
        
    }

}
