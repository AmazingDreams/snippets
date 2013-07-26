<?php
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

	$config = include('config.php');
	define('INSTALL_DIR', $config['install_dir']);

	function __autoload($class)
	{
		$path = str_replace('_', '/', $class);

		include(INSTALL_DIR.'/application/classes/'.$path.'.php');
	}

	// Configuration
	date_default_timezone_set('Europe/Amsterdam');

	// Include files
	require_once('application/sanitize.php');

	// Get filename
	$filename  = array_key_exists('file', $_GET) ? $_GET['file'] : NULL;
	$filename  = $filename ? sanitize_filename($filename) : $filename;

	$filemanager = new File_Manager($filename);
	$all_files   = $filemanager->read_current_working_directory();
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="<?php echo Url::site('static/js/vendor/google-code-prettify/prettify.css'); ?>" type="text/css" rel="stylesheet" />
		<link href="<?php echo Url::site('static/css/screen.css'); ?>" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div class="files-wrapper">
			<h2><?php echo $filemanager->get_snippet_path($filemanager->get_current_working_dir()) .'/'; ?></h2>
			<?php if($filemanager->show_up_link()): ?>
				<a href="<?php echo Url::site($filemanager->get_snippet_path($filemanager->get_up_dir())); ?>">
					<span class="title">..</span>
				</a>
			<?php endif; ?>

			<?php foreach($all_files as $available): ?>
				<a <?php if ($filename == $available): ?>class="selected" <?php endif; ?>href="<?php echo Url::site($filemanager->get_snippet_path($available)); ?>">
					<span class="title"><?php echo $available .(is_dir($filemanager->get_path($available)) ? '/' : ''); ?></span>
					<span class="mtime"><?php echo date('H:i', filectime($filemanager->get_path($available))); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="code-wrapper">
		<?php if($filemanager->get_current_working_file() AND file_exists($filemanager->get_path($filemanager->get_current_working_file()))): ?>
		<h1>
			<span class="main"><?php echo $filemanager->get_current_working_file(); ?></span>
			<span class="sub">Last modified: <?php echo date('d M, Y H:i:s', filemtime($filemanager->get_current_working_file())); ?></span>
		</h1>
			<pre class="prettyprint lang-<?php echo $filemanager->get_current_working_file_extension(); ?> linenums"><?php echo htmlentities(file_get_contents($filemanager->get_path($filemanager->get_current_working_file()))); ?></pre>
		<?php else: ?>
			<p>File not found :( </p>
		<?php endif; ?>
	<script type="text/javascript" src="<?php echo Url::site('static/js/vendor/google-code-prettify/run_prettify.js?skin=desert'); ?>"></script>
	</body>
</html>
