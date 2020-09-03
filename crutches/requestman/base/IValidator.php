<?php

namespace crutch;

/**
 * @example request validator
 * @author Xotam <fobus1289@mail.ru>
 */
interface IValidator
{
    
    /**
     * @param array $array 
     * @return \void
    */
    function removeAny($array);
    
    /**
     * @param string $key
     * @return \crutch\IValidator
     */
    function required($key);

     /**
     * @param string $key
     * @return \crutch\IValidator
     */
    function date($key);
    
    /** 
     * @param string $key
     * @param int $value
     * @return \crutch\IValidator
     */
    function min($key,$value);

    /**
     * @param string $key
     * @param int $value
     * @return \crutch\IValidator
     */
    function max($key,$value);

    /** 
     * @param string $key
     * @param boolean $isFloat
     * @return \crutch\IValidator
     */
    function number($key,$isFloat = false);
    
    /**
     * @param string $key
     * @param string $key2
     * @return \crutch\IValidator
     */
    function confirmation($key,$key2);

    /**
     * @param string $key
     * @param string $tableAndColumn
     * @param boolean $isUnique
     * @return \crutch\IValidator
     */
    function unique($key,$tableAndColumn,$isUnique = true);
     
    /**
     * @param string $key
     * @return \crutch\IValidator
     */
    function email($key);
    
    /**
     * @param string $key
     * @param array|string $needle
     * @param int $size
     * @return \crutch\IValidator
     */
    function fileCheck($key,$needle = '*',$size = -1);
    
}