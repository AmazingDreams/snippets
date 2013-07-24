<?php
	function site_url($path)
	{
		global $config;

		return $config['url'] .'/'. $path;
	}

