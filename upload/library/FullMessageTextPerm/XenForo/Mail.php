<?php

class FullMessageTextPerm_XenForo_Mail extends XFCP_FullMessageTextPerm_XenForo_Mail
{
    protected $_messageTextRegex = '/^(conversation|watched_thread|watched_forum)_([^_]*)(_messagetext){0,1}$/';

    public function __construct($emailTitle, array $params, $languageId = null)
    {
        parent::__construct($emailTitle, $params, $languageId);

        if (preg_match($this->_messageTextRegex, $emailTitle))
        {
            // determine how to get the text
            $key = '';
            if (!empty($params['message']))
            {
                $key = 'message';
            }
            if (!empty($params['reply']))
            {
                $key = 'reply';
            }
            if (empty($key))
            {
                return;
            }

            // checking permissions
            $includeMessage = false;
            if (!empty($params['receiver']['node_permission_cache']))
            {
                $permissions = XenForo_Permission::unserializePermissions($params['receiver']['node_permission_cache']);
                $includeMessage = XenForo_Permission::hasContentPermission($permissions, 'emailIncludeMessage');
            }
            if (strpos($emailTitle, 'conversation_') === 0 && !empty($params['receiver']['permission_combination_id']))
            {
                $permissions = $this->_getPermissions($params['receiver']['permission_combination_id']);
                $includeMessage = XenForo_Permission::hasPermission($permissions, 'conversation', 'emailIncludeMessage') || FullMessageTextPerm_Globals::$alwaysSendFullText;
            }

            if ($this->_isMessageTextTemplate($emailTitle))
            {
                if (!$includeMessage)
                {
                    $emailTitle = str_replace('_messagetext', '', $emailTitle);

                    $params[$key]['messageText'] = '';
                }
            }
            else
            {
                if ($includeMessage && !empty($params[$key]['message']))
                {
                    $emailTitle .= '_messagetext';

                    $bbCodeParserText = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('Text'));
                    $params[$key]['messageText'] = new XenForo_BbCode_TextWrapper($params[$key]['message'], $bbCodeParserText);

                    $bbCodeParserHtml = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('HtmlEmail'));
                    $params[$key]['messageHtml'] = new XenForo_BbCode_TextWrapper($params[$key]['message'], $bbCodeParserHtml);
                }
            }

            $this->_emailTitle = $emailTitle;
            $this->_params = $params;

            if (!isset(self::$_emailCache[$emailTitle][$this->_languageId]))
            {
                self::$_preCache[$emailTitle] = true;
            }
        }
    }

    protected static $permissionCache = array();

    protected function _getPermissions($permissionCombinationId)
    {
        if (isset(self::$permissionCache[$permissionCombinationId]))
        {
            return self::$permissionCache[$permissionCombinationId];
        }

        $perms = XenForo_Application::getDb()->fetchRow('
            SELECT cache_value
            FROM xf_permission_combination
            WHERE permission_combination_id = ?
        ', $permissionCombinationId);

        if(empty($perms['cache_value']))
        {
            self::$permissionCache[$permissionCombinationId] = array();
        }
        else
        {
            self::$permissionCache[$permissionCombinationId] = XenForo_Permission::unserializePermissions($perms['cache_value']);
        }
        return self::$permissionCache[$permissionCombinationId];
    }

    protected function _isMessageTextTemplate($emailTitle)
    {
        return (strpos($emailTitle, '_messagetext'));
    }
}