<?php

class FullMessageTextPerm_XenForo_DataWriter_User extends XFCP_FullMessageTextPerm_XenForo_DataWriter_User
{
    protected function _getFields()
    {
        $fields = parent::_getFields();
        $fields['xf_user_option']['fmp_always_email_notify'] = array('type' => self::TYPE_BOOLEAN, 'default' => 0);
        return $fields;
    }

    protected function _preSave()
    {
        if (FullMessageTextPerm_Globals::$alwaysEmailNotify !== null)
        {
            $this->set('fmp_always_email_notify', FullMessageTextPerm_Globals::$alwaysEmailNotify);
        }

        parent::_preSave();
    }
}
