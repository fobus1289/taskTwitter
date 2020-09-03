<?php

namespace crutch;

interface IAuth
{
    /** 
     * @return array
     */
    static function credentials();
}
