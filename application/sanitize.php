<?php
	function sanitize_filename($string)
	{
		return preg_replace('~(^|\s)([^[a-zA-Z0-9]+|[.]+]?[/|\\\]+)~', '', $string);
	}
