<?php

class FullMessageTextPerm_Listener
{
	public static function extendMail($class, array &$extend)
	{
		$extend[] = 'FullMessageTextPerm_Mail';
	}
}