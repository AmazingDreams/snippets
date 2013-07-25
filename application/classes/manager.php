<?php

class Manager {

	public static $snippets = 'snippets';

	private static $_config = NULL;

	public static function config($key = NULL)
	{
		if( ! self::$_config)
		{
			self::$_config = include(INSTALL_DIR . '/config.php');
		}

		if( ! $key)
		{
			return self::$_config;
		}

		return isset(self::$_config[$key]) ? self::$_config[$key] : NULL;
	}
}
