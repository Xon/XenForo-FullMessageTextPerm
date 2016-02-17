<?php

class FullMessageTextPerm_XenForo_DataWriter_User extends XFCP_FullMessageTextPerm_XenForo_DataWriter_User
{
    protected function _getFields()
    {
        $fields = parent::_getFields();
        $fields['xf_user_option']['fmp_always_email_notify'] = array('type' => self::TYPE_BOOLEAN, 'default' => 1);
        return $fields;
    }

    protected function _preSave()
    {
        if (!empty(FullMessageTextPerm_Globals::$PublicAccountController))
        {
            $input = FullMessageTextPerm_Globals::$PublicAccountController->getInput();
            $fmp_always_email_notify = $input->filterSingle('fmp_always_email_notify', XenForo_Input::UINT);
            $this->set('fmp_always_email_notify', $fmp_always_email_notify);
        }

        parent::_preSave();
    }
}
