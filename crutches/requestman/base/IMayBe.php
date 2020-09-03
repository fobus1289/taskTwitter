<?php

namespace crutch;

interface IMayBe 
{

    /**
     * @return void
    */
    function valid();

    /**
     * @param string $key
     * @return \crutch\IMayBe
     */
    function lazyRequired($key);

     /**
     * @param string $key
     * @return \crutch\IMayBe
     */
    function lazyDate($key);
    
    /** 
     * @param string $key
     * @param int $value
     * @return \crutch\IMayBe
     */
    function lazyMin($key,$value);

    /**
     * @param string $key
     * @param int $value
     * @return \crutch\IMayBe
     */
    function lazyMax($key,$value);

    /** 
     * @param string $key
     * @param boolean $isFloat
     * @return \crutch\IMayBe
     */
    function lazyNumber($key,$isFloat = false);
    
    /**
     * @param string $key
     * @return \crutch\IMayBe
     */
    function lazyEmail($key);
    
    /**
     * @param string $key
     * @param array|string $needle
     * @param int $size
     * @return \crutch\IMayBe
     */
    function lazyFileCheck($key, $needle = '*',$size = -1);
    
    /**
     * 
     * @param string $key
     * @param string $key2
     * @return \crutch\IMayBe
     */
    function lazyConfirmation($key,$key2);
    
    /**
     * 
     * @param string $key
     * @param string $tableAndColumn
     * @param type $isUnique
     * @return \crutch\IMayBe
     */
    function lazyUnique($key,$tableAndColumn,$isUnique = true);
}
