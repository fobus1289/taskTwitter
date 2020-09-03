<?php

namespace crutch;

/**
 * @method void rules(\crutch\IValidator $validator)
 * @method void rulesLazy(\crutch\IMayBe $validator)
 */
abstract class AbstractRequest  implements IValidator,IMayBe
{
    use HttpRequest, Validator ,Lazy;

    protected array $message;
    
    public final function __construct()
    {
        (new \request\middleware\Cross())->handle(yii_request());
        static::initRequest();
        static::validCurrentRoute();
        
        if (method_exists($this, 'rules')) {
            $this->message = $this->messages();
            $this->rules($this);
        }
        
        if (method_exists($this, 'rulesLazy')) {
            $this->message = empty($this->message) ? 
                             $this->messages() : $this->message;
            $this->rulesLazy($this);
            $this->valid();
        }
        
    }
    
    /**
     * @return array
     */
    protected function methodsAllowed()
    {
        return [];
    }

    private final function validCurrentRoute()
    {
        $valid = $this->methodsAllowed();
        
        if(! empty($valid)) {
            if(! \in_array(self::$method, $valid)) {
                
                $message = $valid['message'];
                $default = 'This method is not supported '.self::$method;
                
                validation_error('405', ['message' => $message ?? $default]);
            }  

        }
    }
        
    /**
     * @return array
     */
    protected function messages()
    {
        return [];
    }

    /**
     * @throws \yii\web\HttpException
     */
    protected function error($array)
    {
        validation_error('400', ['message' => $array]);
    }
    
}