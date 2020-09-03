<?php

namespace crutch;

trait HttpRequest
{
    
    protected static $method = null;
    
    protected static $data   = [];
    
    protected static $file   = [];

    /**
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        return self::$data[$name];
    }

    public function __set($name, $value)
    {
        self::$data[$name] = $value;
    }    
    
    /**
     * @param string $key
     * @return array|mixed
     */
    public final function get($key = null)
    {
        return yii_request()->get($key);
    }
    
    /**
     * @param array|null $names
     * @return array
     */
    public final function all($names = null)
    {
        
        if($names == null) {
            return self::$data;
        }
        
        $result = [];
        
        foreach ($names as $key) {
           $result[$key] = $this->$key; 
        }
        
        return $result;
    }

    /** 
     * @param string $key
     * @return null|\yii\web\UploadedFile the instance of the uploaded file.
     */
    public final function file($key)
    {
        if(self::$file[$key] == null) {
            self::$file[$key] = uploaded_file($key);
        }
        return self::$file[$key];
    }
    
    public final function store($filename)
    { 
        try{     
            $file = $this->file($filename);
            $hash = \md5(\time().\microtime(true).$file->name);
            $ext = \end(\explode('.', $file->name));
            $hashname = "$hash.$ext" ;            
            $file->saveAs(public_path("images/$hashname"));
            return "web/images/$hashname";
        } catch (\Throwable $ex) {
            return null;
        }
        
    }

    protected static function initRequest() {
       self::$method = yii_request()->method;
       
       if(\in_array(self::$method, ['GET','POST'])) {
          self::$data = yii_request()->{self::$method}();
       }else{
          self::$data = yii_request()->getBodyParams();
       }
       
       self::$method = strtolower(self::$method);
    }
        
}