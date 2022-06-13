<?php

namespace App\TraitClass;

/**
 * Faz com que Propriedades com Closures de Classes que usam essa Trait
 * possam ser chamadas como métodos das mesmas.
 * 
 * Por exemplo: $oClass->test = function() {
 *      echo 'oi';
 * }
 * 
 * // Isto só será possivel se a class desse Object chamar a Trait ClosureAsMethodTrait
 * $oClass->test()
 */
trait ClosureAsMethodTrait
{
    public function __call($name, $args)
    {
        return call_user_func_array($this->$name, $args);
    }
}
