<?php

//require_once("java/Java.inc");

class SQ_StanfordDependencyParser
{
	protected $_parser;
	
	public function __construct($query) 
	{
		java_require("C:/Users/G2/Desktop/stanford-parser-2012-07-09/SQParser.jar");
		
		$this->_parser = new Java("SQParser");
		echo $this->_parser->test_print();
	}	
	
}