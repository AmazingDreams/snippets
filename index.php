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
		<h1><?php echo $filename; ?></h1>

		<?php if(file_exists($file)): ?>
			<pre class="prettyprint lang-<?php echo $ext; ?> linenums">
<?php echo htmlentities(file_get_contents("$file")); ?>
			</pre>
		<?php else: ?>
			<h3>File not found :( </h3>
		<?php endif; ?>
	</body>
</html>
