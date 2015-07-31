<?php

class FullMessageTextPerm_Mail extends XFCP_FullMessageTextPerm_Mail
{
	protected $_messageTextTemplatesWatched = array(
		'watched_forum_message', 'watched_forum_thread',
		'watched_thread_reply', 'watched_forum_message_messagetext',
		'watched_forum_thread_messagetext', 'watched_thread_reply_messagetext'
	);

	/**
	 * Constructor.
	 *
	 * @param string $emailTitle Title of the email template
	 * @param array $params Key-value params to pass to email template
	 * @param integer|null $languageId Language of email; if null, uses language of current user (if setup)
	 */
	public function __construct($emailTitle, array $params, $languageId = null)
	{
		parent::__construct($emailTitle, $params, $languageId);

		if (in_array($emailTitle, $this->_messageTextTemplatesWatched))
		{
			$permissions = XenForo_Permission::unserializePermissions($params['receiver']['node_permission_cache']);

			$includeMessage = XenForo_Permission::hasContentPermission($permissions, 'emailWatchIncludeMessage');

			if ($this->_isMessageTextTemplate($emailTitle))
			{
				if (!$includeMessage)
				{
					$emailTitle = str_replace('_messagetext', '', $emailTitle);

					$params['reply']['messageText'] = '';
				}
			}
			else
			{
				if ($includeMessage)
				{
					$emailTitle .= '_messagetext';

					$bbCodeParserText = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('Text'));
					$params['reply']['messageText'] = new XenForo_BbCode_TextWrapper($params['reply']['message'], $bbCodeParserText);

					$bbCodeParserHtml = XenForo_BbCode_Parser::create(XenForo_BbCode_Formatter_Base::create('HtmlEmail'));
					$params['reply']['messageHtml'] = new XenForo_BbCode_TextWrapper($params['reply']['message'], $bbCodeParserHtml);
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

	protected function _isMessageTextTemplate($emailTitle)
	{
		return (strpos($emailTitle, 'messagetext'));
	}
}