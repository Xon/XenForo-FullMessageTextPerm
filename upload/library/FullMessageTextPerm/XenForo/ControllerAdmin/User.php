<?php

class FullMessageTextPerm_XenForo_ControllerAdmin_User extends XFCP_FullMessageTextPerm_XenForo_ControllerAdmin_User
{
    public function actionSave()
    {
        FullMessageTextPerm_Globals::$alwaysEmailNotify = $this->_input->filterSingle('fmp_always_email_notify', XenForo_Input::UINT);
        return parent::actionSave();
    }
}
