<?php

class Url {

	public static function site($path)
	{
		return Manager::config('url') .'/'. trim($path, '/');
	}
}
