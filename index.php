<?php
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

	// Configuration
	$config = include('config.php');
	date_default_timezone_set('Europe/Amsterdam');

	// Include files
	require_once('application/read-directory.php');
	require_once('application/sanitize.php');

	$all_files = read_directory_by_date("snippets");

	// Get filename
	$filename = array_key_exists('file', $_GET) ? $_GET['file'] : NULL;
	$filename = ( ! $filename AND array_key_exists(0, $all_files)) ? $all_files[0] : $filename;
	$filename = $filename ? sanitize_filename($filename) : $filename;

	$file     = $filename ? $config['install_dir'].'/snippets/'.$filename : NULL;
	$ext      = $file ? preg_replace('/^.*\.([^.]+)$/D', '$1', $file) : NULL;
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="static/js/vendor/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
		<link href="static/css/screen.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div class="files-wrapper">
			<?php foreach($all_files as $available): ?>
				<a <?php if ($filename == $available): ?>class="selected" <?php endif; ?>href="<?php echo $config['url'] .'/'. $available; ?>">
					<span class="title"><?php echo $available; ?></span>
					<span class="mtime"><?php echo date('H:i', filemtime($config['install_dir'] .'/snippets/'. $available)); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="code-wrapper">
		<h1>
			<span class="main"><?php echo $filename; ?></span>
			<span class="sub">Last modified: <?php echo date('d M, Y H:i:s', filemtime($config['install_dir'] .'/snippets/'. $available)); ?></span>
		</h1>
		<?php if($file AND file_exists($file)): ?>
			<pre class="prettyprint lang-<?php echo $ext; ?> linenums"><?php echo htmlentities(file_get_contents($file)); ?></pre>
		<?php else: ?>
			<p>File not found :( </p>
		<?php endif; ?>
		<script type="text/javascript" src="static/js/vendor/google-code-prettify/run_prettify.js?skin=desert"></script>
	</body>
</html>
