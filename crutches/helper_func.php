<?php


if(! function_exists('validation_error')) {
    
    /**
     * @param strig $code
     * @param array $messages
     * @throws \yii\web\HttpException
     */
    function validation_error($code,$messages)
    {
       $tmp = require config_path('extensions.php');
       $exeption = $tmp[$code];
       throw new $exeption(\serialize($messages));
    }

}


if(! function_exists('get')) {
    function get($key)
    {
        return yii_request()->get($key);
    }
}

if(! function_exists('post')) {
    function post($key)
    {
        return yii_request()->post($key);
    }
}

if(! function_exists('day_unix')) {
    function day_unix($day)
    {
        return time() + ($day * 24 * 60 * 60);
    }
}

if(! function_exists('bcrypt')) {
    
    function bcrypt($str)
    {
        return \password_hash($str,PASSWORD_BCRYPT); 
    }
    
}

    
if(! function_exists('filter')) {
    
    /**
     * @param array|object[] $array
     * @param Closure $func
     */
    function filter($array , $func)
    {
        if(\is_array($array)) {
            foreach ($array as $key => $value){
                $func($key,$value);
            } 
        }
    }
    
}

   
if(! function_exists('map')) {
    
    /**
     * @param array|object[] $array
     * @param Closure $func
     * @return array|object[] 
     */
    function map($array ,$func)
    {
        $result = [];
        
        if(\is_array($array)) {
            foreach ($array as $key => $value ){
                $result[$key] = $func($key,$value);
            } 
        }
        
        return $result;
    }
    
}


if(! function_exists('user')) {
    
    function &user($user = null)
    {
        return \crutch\AuthMan::user($user);
    }
    
}

if(! function_exists('uploaded_file')) {
    
    function uploaded_file($key)
    {
        return \yii\web\UploadedFile::getInstanceByName($key);
    }
    
}

if(! function_exists('yii_request')) {
    
    function yii_request()
    {
        return \Yii::$app->request;
    }
    
}

if(! function_exists('yii_get_db')) {
    
    function yii_get_db()
    {
        return \Yii::$app->getDb();
    }
    
}



if(! function_exists('middleware_config')) {
    
    function middleware_config($key = null)
    {
        static $config;
        
        if($config == null) {
           $config = require_once config_path('middleware.php');
        }
        
        return $key ? $config[$key] : $config;
    }
    
}

if(! function_exists('jwt_config')) {
    
    function jwt_config($key = null)
    {
        static $config;
        
        if($config == null) {
            $config = require_once config_path('jwt_auth_config.php');
            $headerKey = yii_request()->headers[$config['header_key']];
            if($headerKey) {
                $prefix = $config['prefix'];
                $config['token'] = \str_replace($prefix, '', $headerKey);  
            }else{
                $config['token'] = yii_request()->get('token');
            }
        }
        return $key ? $config[$key] : $config;
    }
    
}



if(! function_exists('base_path')) {
    
    function base_path($path = '')
    {
        return \Yii::$app->basePath."/$path";
    } 
}

if(!function_exists('config_path')) {
    
    function config_path($append = '')
    {
        return base_path("config/$append");
    }
    
}

if(!function_exists('public_path')) {
    
    function public_path($append = '')
    {
        return base_path("web/$append");
    }
    
}
