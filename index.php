<?php
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

	// Configuration
	$config = include('config.php');

	// Include files
	require_once('application/read-directory.php');

	$all_files = read_directory_by_date("snippets");

	// Get filename
	$filename = array_key_exists('file', $_GET) ? $_GET['file'] : NULL;
	$filename = ( ! $filename AND array_key_exists(0, $all_files)) ? $all_files[0] : $filename;

	$file     = $filename ? $config['install_dir'].'/snippets/'.$filename : NULL;
	$ext      = $file ? preg_replace('/^.*\.([^.]+)$/D', '$1', $file) : NULL;
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="static/css/screen.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div class="files-wrapper">
			<?php foreach($all_files as $available): ?>
				<a href="<?php echo $config['url'] .'?file='. $available; ?>"><?php echo $available; ?></a>
			<?php endforeach; ?>
		</div>

		<div class="code-wrapper">
		<h1><?php echo $filename; ?></h1>
		<?php if($file AND file_exists($file)): ?>
			<pre class="prettyprint lang-<?php echo $ext; ?>"><?php echo htmlentities(file_get_contents($file)); ?></pre>
		<?php else: ?>
			<p>File not found :( </p>
		<?php endif; ?>

		<script type="text/javascript" src="static/js/vendor/google-code-prettify/run_prettify.js?skin=desert"></script>
	</body>
</html>
