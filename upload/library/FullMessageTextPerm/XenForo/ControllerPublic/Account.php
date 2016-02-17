<?php

class FullMessageTextPerm_XenForo_ControllerPublic_Account extends XFCP_FullMessageTextPerm_XenForo_ControllerPublic_Account
{
    public function actionPreferencesSave()
    {
        FullMessageTextPerm_Globals::$PublicAccountController = $this;

        return parent::actionPreferencesSave();
    }
}
