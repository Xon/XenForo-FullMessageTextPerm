<?php

class FullMessageTextPerm_XenForo_ControllerPublic_Account extends XFCP_FullMessageTextPerm_XenForo_ControllerPublic_Account
{
    public function actionPreferencesSave()
    {
        FullMessageTextPerm_Globals::$alwaysEmailNotify = $this->_input->filterSingle('fmp_always_email_notify', XenForo_Input::UINT);
        return parent::actionPreferencesSave();
    }
}
