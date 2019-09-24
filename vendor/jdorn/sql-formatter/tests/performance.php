<?php
require '../lib/SqlFormatter.php';

//this is the default value
//set to '0' to disable caching
//a value between 10 and 20 seems to give the best result
SqlFormatter::$max_cachekey_size = 15;

//the sample query file is filled with install scripts for PrestaShop
//and some sample catalog data from Magento
$contents = file_get_contents('sql.sql');

//queries are separated by 2 new lines
$queries = explode("\n\n",$contents);

//track time and memory usage
$start = microtime(true);
$ustart = memory_get_usage(true);

//track number of queries and size of queries
$num = 0;
$chars = 0;

foreach ($queries as $query) {
	//do formatting and highlighting
	SqlFormatter::format($query);
	
	$num++;
	$chars += strlen($query);
}

$uend = memory_get_usage(true);
$end = microtime(true);

echo "<p>Formatted ".$num." queries using a max_cachekey_size of ".SqlFormatter::$max_cachekey_size."</p>";

echo "<p>Average query length of ".number_format($chars/$num,5)." characters</p>";

echo "<p>Took ".number_format($end-$start,5)." seconds total, ".number_format(($end-$start)/$num,5)." seconds per query, ".number_format(1000*($end-$start)/$chars,5)." seconds per 1000 characters</p>";

echo "<p>Used ".number_format($uend-$ustart)." bytes of memory</p>";

echo "<h3>Cache Stats</h3><pre>".print_r(SqlFormatter::getCacheStats(),true)."</pre>";

