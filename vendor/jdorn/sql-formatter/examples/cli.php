<?php
if(php_sapi_name() !== "cli") {
	echo "<p>Run this php script from the command line to see CLI syntax highlighting and formatting.  It support Unix pipes or command line argument style.</p>";
	echo "<pre><code>php examples/cli.php \"SELECT * FROM MyTable WHERE (id>5 AND \\`name\\` LIKE \\&quot;testing\\&quot;);\"</code></pre>";
	echo "<pre><code>echo \"SELECT * FROM MyTable WHERE (id>5 AND \\`name\\` LIKE \\&quot;testing\\&quot;);\" | php examples/cli.php</code></pre>";
}

if(isset($argv[1])) {
	$sql = $argv[1];
}
else {
	$sql = stream_get_contents(fopen("php://stdin", "r"));
}

require_once(__DIR__.'/../lib/SqlFormatter.php');

echo SqlFormatter::format($sql);
