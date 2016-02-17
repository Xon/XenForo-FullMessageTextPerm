<?php

class FullMessageTextPerm_Listener
{
    const AddonNameSpace = 'FullMessageTextPerm_';

    public static function load_class($class, array &$extend)
    {
        $extend[] = self::AddonNameSpace . $class;
    }
}