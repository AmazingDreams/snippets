<!DOCTYPE html>
<?php
/**
 * Configuration
 */
define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);

$config = require_once 'config.php';

echo $config['install_dir'];

// Get filename
$file = "{$config['install_dir']}/snippets/{$_GET['file']}";
$ext  = preg_replace('/^.*\.([^.]+)$/D', '$1', $file);
?>

<html>
	<head>
		<link href="static/js/vendor/google-code-prettify/prettify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="static/js/vendor/google-code-prettify/run_prettify.js"></script>
	</head>
	<body>
		<pre class="prettyprint lang-css">
			div.some-css { 
				width: test; 
			}
		</pre>


		<pre class="prettyprint lang-sql">
			SELECT * FROM some_table
		</pre>

		<pre class="prettyprint lang-js">
			$.each(dummy, function() { alert('hello'); });
		</pre>

		<?php if(file_exists($file)): ?>
			<pre class="prettyprint lang-<?php echo $ext; ?> linenums">
<?php echo htmlentities(file_get_contents("$file")); ?>
			</pre>
		<?php else: ?>
			<h3>File not found :( </h3>
		<?php endif; ?>
	</body>
</html>
