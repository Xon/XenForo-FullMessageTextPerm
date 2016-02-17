<?php

class FullMessageTextPerm_XenForo_Model_ThreadWatch extends XFCP_FullMessageTextPerm_XenForo_Model_ThreadWatch
{
    public function getUsersWatchingThread($threadId, $nodeId)
    {
        $users = parent::getUsersWatchingThread($threadId, $nodeId);

        if (XenForo_Application::getOptions()->fmp_allowAlwaysEmailWatched)
        {
            $now = XenForo_Application::$time;
            foreach($users as &$user)
            {
                $permissions = XenForo_Permission::unserializePermissions($user['node_permission_cache']);
                if (XenForo_Permission::hasContentPermission($permissions, 'alwaysEmailWatchedThread'))
                {
                    $user['thread_read_date'] = $now;
                }
            }
        }

        return $users;
    }
}