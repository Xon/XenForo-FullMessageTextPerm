<?php

class FullMessageTextPerm_XenForo_ControllerPublic_Member extends XFCP_FullMessageTextPerm_XenForo_ControllerPublic_Member
{
    public function actionWarn()
    {
        FullMessageTextPerm_Globals::$alwaysSendFullText = XenForo_Application::getOptions()->FMP_AlwaysSendWarning;

        return parent::actionWarn();
    }
}