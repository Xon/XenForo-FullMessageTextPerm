<?php

class FullMessageTextPerm_Installer
{
    public static function install($existingAddOn, $addOnData)
    {
        $version = isset($existingAddOn['version_id']) ? $existingAddOn['version_id'] : 0;

        self::addColumn('xf_user_option', 'fmp_always_email_notify', 'tinyint(3) unsigned NOT NULL DEFAULT 1');

        return true;
    }

    public static function uninstall()
    {
        self::dropColumn('xf_user_option', 'fmp_always_email_notify');

        $db = XenForo_Application::get('db');

        $db->query("
            DELETE FROM xf_permission_entry
            where permission_id in ('emailIncludeMessage', 'alwaysEmailWatchedThread')
        ");

        $db->query("
            DELETE FROM xf_permission_entry_content
            where permission_id in ('emailIncludeMessage', 'alwaysEmailWatchedThread')
        ");

        return true;
    }


    public static function dropColumn($table, $column)
    {
        $db = XenForo_Application::get('db');
        if ($db->fetchRow('SHOW COLUMNS FROM `'.$table.'` WHERE Field = ?', $column))
        {
            $db->query('ALTER TABLE `'.$table.'` drop COLUMN `'.$column.'` ');
            return true;
        }
        return false;
    }

    public static function addColumn($table, $column, $definition)
    {
        $db = XenForo_Application::get('db');
        if (!$db->fetchRow('SHOW COLUMNS FROM `'.$table.'` WHERE Field = ?', $column))
        {
            $db->query('ALTER TABLE `'.$table.'` ADD COLUMN `'.$column.'` '.$definition);
            return true;
        }
        return false;
    }
}
