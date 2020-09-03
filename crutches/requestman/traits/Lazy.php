<?php

namespace crutch;

trait Lazy
{
    
    private $willPostpone = [];

    public function lazyDate($key)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['date']=[$key];
        }
        
        return $this;
    }

    public function lazyEmail($key)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['email']=[$key];
        }
        
        return $this;
    }

    public function lazyFileCheck($key, $needle = '*', $size = -1)
    {
        $tmpKey = \explode('.',$key)[0];
        
        $tmpFile = $this->file($tmpKey);
        
        if($tmpFile) {
            $this->willPostpone[]['fileCheck']=[$key,$needle,$size];
        }else{
            $this->removeAny([$tmpKey]);
        }
            
        return $this;
    }

    public function lazyMax($key, $value)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['max']=[$key, $value];
        }
        
        return $this;
    }

    public function lazyMin($key, $value)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['min']=[$key, $value];
        }
        
        return $this;
    }

    public function lazyNumber($key, $isFloat = false)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['number']=[$key, $isFloat];
        }
        
        return $this;
    }

    public function lazyRequired($key)
    {
        $tmpKey = $this->$key;
        
        if($tmpKey) {
            $this->willPostpone[]['required']=[$key];
        }
        
        return $this;
    }
    
    function lazyConfirmation($key,$check)
    {
        $key1 = $this->$key;
        $key2 = $this->$check;
        
        if($key1 && $key2) {
            $this->willPostpone[]['confirmation']=[$key,$key2];
        }
        
        return $this;
    }
    
    function lazyUnique($key,$tableAndColumn,$isUnique = true)
    {
        $tmpKey = $this->key;
        
        if($tmpKey) {
            $this->willPostpone[]['unique']=[$key,$tableAndColumn,$isUnique];  
        }
    }
    
    public function valid()
    {
        if(! empty($this->willPostpone)) {
            foreach ($this->willPostpone as $key => $value) {
                foreach ($value as $method => $params) {
                    $this->$method(...$params);  
                }
            }
        }
    }
    
}
