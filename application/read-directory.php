<?php
function read_directory_by_date($directory_string)
{
	$directory = opendir($directory_string);

	$array = array();
	while($file = readdir($directory))
	{
		// Skip files starting with '.'
		if(strpos($file, '.') == 0) continue;

		$array[filemtime($directory_string .'/'. $file)] = $file;
	}
	closedir($directory);

	krsort($array);

	return array_values($array);
}
