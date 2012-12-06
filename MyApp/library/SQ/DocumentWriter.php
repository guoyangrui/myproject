<?php
class SQ_DocumentWriter
{
	public function init()
	{
		
		$tag = '<document>';
		$tag.= '<document/>';		
		$xml = new SimpleXMLElement($tag);

	}
	
	public function create($name, $data)
	{
		$subject = $data['subject'];
		$verb = explode(',', $data['verb']);
		$entity = $data['entity'];
		$tag = '<'.$name.'>';
		$tag.= '<'.$name.'/>';
		$xml = new SimpleXMLElement($tag);		
		$xml->addChild($name);
		$xml->$name->addChild('subject', $subject);
		//foreach ($verb in $data)
		$xml->$name->subject->addChild('verb', $verb);		
		$xml->$name->subject->verb->addChild('entity', $entity);		
	}
	
	public function addElement()
	{
		$document = n;
		
		
	}
}