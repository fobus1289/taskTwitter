<?php

namespace crutch;

/**
 * @example request helper
 * @author Xotam <fobus1289@mail.ru>
 */
trait Validator
{
     
    function removeAny($names) 
    {
        foreach ($names as $name) {   
            unset(self::$data[$name]);
        }
    }
    
    function required($key)
    {
        $value = $this->$key;
        
        if (empty($value)) {
            $message = $this->message["$key.required"];
            $this->error([$key => $message ?? 'required']);
        }

        return $this;
    }

    function min($key, $value)
    {
        if (@strlen($this->$key) < $value) {
            $message = $this->message["$key.min"];
            $this->error([$key => $message ?? 'min']);
        }

        return $this;
    }

    function max($key,$value)
    {
        if (@strlen($this->$key) > $value) {
            $message = $this->message["$key.max"];
            $this->error([$key => $message ?? 'max']);
        }

        return $this;
    }

    function number($key, $isFloat = false)
    {

        if (! \is_numeric($this->$key)) {
            $message = $this->message["$key.number"];
            $this->error([$key => $message ?? 'is not number']);
        }
        
        if($isFloat && !\is_float((float)$this->$key)) {
            $message = $this->message["$key.float"];
            $this->error([$key => $message ?? 'this number but expected float number '.$this->$key]);  
        }
        
        return $this;
    }
    
    function date($key)
    {
        //checkdate(12, 31, 2000);
       return $this; 
    }

    function confirmation($key, $key2)
    {
        if ($this->$key !== $this->$key2) {
            $message = $this->message["$key.confirmation"];
            $this->error([$key => $message ?? 'confirmation error']);
        }
        return $this;
    }
    
    function unique($key,$tableAndColumn,$isUnique = true)
    {
        
        list($table,$column) = explode('.',$tableAndColumn);
        
        $sql = "SELECT COUNT($column) FROM {$table} WHERE {$column} = '{$this->$key}'";
        
        $connection = yii_get_db();
        
        $command = $connection->createCommand($sql);
        $stm = $command->queryColumn();
        
        if($stm[0] > 0 && $isUnique) {
            $message = $this->message["$key.unique"];
            $this->error([$key => $message ?? 'This data cannot be repeated']);
        }else if($stm[0] == 0 && !$isUnique) {
            $message = $this->message["$key.unique.no"];
            $this->error([$key => $message ?? 'No such data exists']);
        }
        
        return $this;
    }
    
    function email($key)
    {
        if (! \filter_var($this->$key, FILTER_VALIDATE_EMAIL)) {
            $message = $this->message["$key.email"];
            $this->error([$key => $message ?? 'Is not a valid email address']);
        }
        
        return $this;
    }
    
    function fileCheck($key,$needle = '*',$size = -1)
    {
        
        list($key,$type) = \explode('.',$key);
        
        $file = $this->file($key);
 
        if($file == null) {
            $message = $this->message["$key.file"];
            $this->error([$key => $message ?? 'such file does not exist']);
        }

        if($size != -1 && $size < $file->size / 1024) {
            $message = $this->message["$key.file.size"];
            $this->error([$key => $message ?? 'the maximum file size can be kilobyte '.$size]);
        }


        $mimes = $this->specialCheckFile()[$type];
        
        if(! empty($mimes)){
            
            $mime = @\mime_content_type($file->tempName);
            
            if(! \in_array($mime, $mimes)) {
                $message = $this->message["$key.file.type"];
                $this->error([$key => $message ?? 'invalid file type']);  
            }
            
        }

        $ext = \end(\explode('.',$file->name));
        
        if(is_array ($needle) && ! \in_array($ext, $needle)) {
            $message = $this->message["$key.file.extension"];
            $this->error([$key => $message ?? 'invalid file extension']);  
        }
        
        return $this;
        
    }
   
}