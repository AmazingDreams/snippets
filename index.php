<?php
	define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

	// Configuration
	$config = include('config.php');

	// Get filename
	$filename = array_key_exists('file', $_GET) ? $_GET['file'] : NULL;
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
			<?php $directory = opendir('snippets'); ?>
			<?php while($iterator = readdir($directory)): ?>
				<?php if(strpos($iterator, '.') == 0) continue;  ?>

				<a href="<?php echo $config['url'] .'?file='. $iterator; ?>"><?php echo $iterator; ?></a>
			<?php endwhile; ?>
		</div>

		<div class="code-wrapper">
		<h1><?php echo $filename; ?></h1>
		<?php if($file AND file_exists($file)): ?>
			<pre class="prettyprint lang-<?php echo $ext; ?> linenums"><?php echo htmlentities(file_get_contents($file)); ?></pre>
		<?php else: ?>
			<p>File not found :( </p>
		<?php endif; ?>

		<script type="text/javascript" src="static/js/vendor/google-code-prettify/run_prettify.js?skin=desert"></script>
	</body>
</html>
