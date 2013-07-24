<?php
	function sanitize_filename($string)
	{
		return preg_replace('~\s?([.]+[/|\\\]+)~', '', $string);
	}
