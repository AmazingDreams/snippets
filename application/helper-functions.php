<?php
	function site_url($path)
	{
		global $config;

		return $config['url'] . ((strpos($path, '/') === 0) ? $path : "/$path");
	}

