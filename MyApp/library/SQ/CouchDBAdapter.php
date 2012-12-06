<?php

require_once "PhpOnCouch/lib/couch.php";
require_once "PhpOnCouch/lib/couchClient.php";
require_once "PhpOnCouch/lib/couchDocument.php";

class SQ_CouchDBAdapter
{
	
	public function __construct($dbName)
	{
		$this->connectCouchDB($dbName);		
		$this->createDocument($dbName);
	}
	
	public function connectCouchDB($dbName)
	{
		$client = new couchClient('localhost:5984', $dbName);
		
		if (!$client->databaseExists()) {
			try {
				$client->createDatabase();
			} catch (Exception $e) {
				die('Unable to create the database: ' . $e->getMessage());
			}
		}
		
		try {
			$info = $client->getDatabaseInfos();
		} catch (Exception $e) {
			echo "Error:".$e->getMessage()." (errcode=".$e->getCode().")\n";
			exit(1);
		}
	}
	
	public function createDocument($dbName)
	{
		$song = new stdClass();
		$fields = array(
				'title' => 'My Song 2', 
				'genre' => 'Pop', 
				'artist' => 'Myself'
				);
		foreach ($fields as $key => $value) {
			$song->$key = $value;
    	}    	   	
		
    	Zend_Debug::dump($song);
    	
    	$client = new couchClient('localhost:5984', $dbName);
    	     	 	     	
		try {
			$response = $client->storeDoc($song);
		} catch (Exception $e) {
			echo "Error: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
			exit(1);
		}
		
	}
}