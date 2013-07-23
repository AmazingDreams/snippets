<!DOCTYPE html>
<?php
/**
 * Configuration
 */
define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

$config = require_once 'config.php';

// Get filename
$filename = $_GET['file'];
$file     = "{$config['install_dir']}/snippets/$filename";
$ext      = preg_replace('/^.*\.([^.]+)$/D', '$1', $file);
?>

<html>
	<head>
		<link href="static/js/vendor/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="static/js/vendor/google-code-prettify/run_prettify.js"></script>
	</head>
	<body>
		<div class="files">
			<?php $directory = opendir("snippets"); ?>
			<?php while($iterator = readdir($directory)): ?>
				<?php if(strpos($iterator, '.') == 0) continue;  ?>

				<a href="<?php echo $config['url'] .'?file='. $iterator; ?>"><?php echo $iterator; ?></a>
			<?php endwhile; ?>
		</div>

		<div class="selected-file">
			<h1><?php echo $filename; ?></h1>

			<?php if(file_exists($file)): ?>
				<pre class="prettyprint lang-<?php echo $ext; ?> linenums">
<?php echo htmlentities(file_get_contents("$file")); ?>
				</pre>
			<?php else: ?>
				<h3>File not found :( </h3>
			<?php endif; ?>
		</div>
	</body>
</html>
