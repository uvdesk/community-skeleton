<?php
require __DIR__.'/../lib/SqlFormatter.php';

// Force SqlFormatter to run in non-CLI mode for tests
SqlFormatter::$cli = false;

class SqlFormatterTest extends PHPUnit_Framework_TestCase {
	protected $sqlData;
	
	/**
	 * @dataProvider formatHighlightData
	 */
	function testFormatHighlight($sql, $html) {
		$this->assertEquals(trim($html), trim(SqlFormatter::format($sql)));
	}
	/**
	 * @dataProvider formatData
	 */
	function testFormat($sql, $html) {
		$this->assertEquals(trim($html), trim(SqlFormatter::format($sql, false)));
	}
	/**
	 * @dataProvider highlightData
	 */
	function testHighlight($sql, $html) {
		$this->assertEquals(trim($html), trim(SqlFormatter::highlight($sql)));
	}
	/**
	 * @dataProvider highlightCliData
	 */
	function testCliHighlight($sql, $html) {
		SqlFormatter::$cli = true;
		$this->assertEquals(trim($html), trim(SqlFormatter::format($sql)));
		SqlFormatter::$cli = false;
	}
	/**
	 * @dataProvider compressData
	 */
	function testCompress($sql, $html) {
		$this->assertEquals(trim($html), trim(SqlFormatter::compress($sql)));
	}
	
	function testUsePre() {
		SqlFormatter::$use_pre = false;
		$actual = SqlFormatter::highlight("test");
		$expected = '<span style="color: #333;">test</span>';
		$this->assertEquals($actual,$expected);
		
		SqlFormatter::$use_pre = true;
		$actual = SqlFormatter::highlight("test");
		$expected = '<pre style="color: black; background-color: white;"><span style="color: #333;">test</span></pre>';
		$this->assertEquals($actual,$expected);
	}
	
	function testSplitQuery() {
		$expected = array(
			"SELECT 'test' FROM MyTable;",
			"SELECT Column2 FROM SomeOther Table WHERE (test = true);"
		);
		
		$actual = SqlFormatter::splitQuery(implode(';',$expected));
		
		$this->assertEquals($expected, $actual);
	}
	
	function testSplitQueryEmpty() {
		$sql = "SELECT 1;SELECT 2;\n-- This is a comment\n;SELECT 3";
		$expected = array("SELECT 1;","SELECT 2;","SELECT 3");
		$actual = SqlFormatter::splitQuery($sql);
		
		$this->assertEquals($expected, $actual);
	}
	
	function testRemoveComments() {
		$expected = SqlFormatter::format("SELECT\n * FROM\n MyTable",false);
		$sql = "/* this is a comment */SELECT#This is another comment\n * FROM-- One final comment\n MyTable";
		$actual = SqlFormatter::removeComments($sql);
		
		$this->assertEquals($expected, $actual);
	}
	
	function testCacheStats() {
		$stats = SqlFormatter::getCacheStats();
		$this->assertGreaterThan(1,$stats['hits']);
	}
	
	function formatHighlightData() {
		$formatHighlightData = explode("\n\n",file_get_contents(__DIR__."/format-highlight.html"));
		$sqlData = $this->sqlData();
		
		$return = array();
		foreach($formatHighlightData as $i=>$data) {
			$return[] = array(
				$sqlData[$i],
				$data
			);
		}
		
		return $return;
	}
	
	function highlightCliData() {
		$clidata = explode("\n\n",file_get_contents(__DIR__."/clihighlight.html"));
		$sqlData = $this->sqlData();
		
		$return = array();
		foreach($clidata as $i=>$data) {
			$return[] = array(
				$sqlData[$i],
				$data
			);
		}
		
		return $return;
	}
	
	function formatData() {
		$formatData = explode("\n\n",file_get_contents(__DIR__."/format.html"));
		$sqlData = $this->sqlData();
		
		$return = array();
		foreach($formatData as $i=>$data) {
			$return[] = array(
				$sqlData[$i],
				$data
			);
		}
		
		return $return;
	}
	
	function compressData() {
		$compressData = explode("\n\n",file_get_contents(__DIR__."/compress.html"));
		$sqlData = $this->sqlData();
		
		$return = array();
		foreach($compressData as $i=>$data) {
			$return[] = array(
				$sqlData[$i],
				$data
			);
		}
		
		return $return;
	}
	
	function highlightData() {
		$highlightData = explode("\n\n",file_get_contents(__DIR__."/highlight.html"));
		$sqlData = $this->sqlData();
		
		$return = array();
		foreach($highlightData as $i=>$data) {
			$return[] = array(
				$sqlData[$i],
				$data
			);
		}
		
		return $return;
	}
	
	
	
	function sqlData() {
		if(!$this->sqlData) {
			$this->sqlData = explode("\n\n",file_get_contents(__DIR__."/sql.sql"));
		}
		
		/**
		$formatHighlight = array();
		$highlight = array();
		$format = array();
		$compress = array();
		$clihighlight = array();
		
		foreach($this->sqlData as $sql) {
			$formatHighlight[] = trim(SqlFormatter::format($sql));
			$highlight[] = trim(SqlFormatter::highlight($sql));
			$format[] = trim(SqlFormatter::format($sql, false));
			$compress[] = trim(SqlFormatter::compress($sql));
			
			SqlFormatter::$cli = true;
			$clihighlight[] = trim(SqlFormatter::format($sql));
			SqlFormatter::$cli = false;
		}
		
		file_put_contents(__DIR__."/format-highlight.html", implode("\n\n",$formatHighlight));
		file_put_contents(__DIR__."/highlight.html", implode("\n\n",$highlight));
		file_put_contents(__DIR__."/format.html", implode("\n\n",$format));
		file_put_contents(__DIR__."/compress.html", implode("\n\n",$compress));
		file_put_contents(__DIR__."/clihighlight.html", implode("\n\n",$clihighlight));
		/**/
		
		return $this->sqlData;
	}
	
}
