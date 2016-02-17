<?php

class FullMessageTextPerm_XenForo_Model_ThreadWatch extends XFCP_FullMessageTextPerm_XenForo_Model_ThreadWatch
{
    public function getUsersWatchingThread($threadId, $nodeId)
    {
        $users = parent::getUsersWatchingThread($threadId, $nodeId);

        if (XenForo_Application::getOptions()->fmp_allowAlwaysEmailWatched)
        {
            
        }

        return $users;
    }
}