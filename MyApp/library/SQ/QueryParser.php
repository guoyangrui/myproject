<?php
class SQ_QueryParser
{
	protected $_result;
	protected $_solrQuery;
	
	public function __construct($query) {
		$this->connect($query);
	}
	
	public function connect($query) {
		$fp = fsockopen('127.0.0.1', 9191, $errno, $errstr, 30);
		if (!$fp) {
			echo "$errstr ($errno)<br />\n";
		} 
		else {
		    $out = "sqparse " . $query . "\r\n";
			$out .= "Host: www.example.com\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
		    while (!feof($fp)) {
		            $this->_result .= fgets($fp, 128) . "|";
		    }
		    fclose($fp);
		}
		echo $this->_result;
		$token = explode("|", $this->_result);
		Zend_Debug::dump($token);
	}
	
	public function makeSolrQuery() {
		
	}
}