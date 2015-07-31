<?php

class FullMessageTextPerm_Listener
{
    const AddonNameSpace = 'FullMessageTextPerm';

    public static function load_class($class, array &$extend)
    {
        $extend[] = self::AddonNameSpace . '_' . $class;
    }
}