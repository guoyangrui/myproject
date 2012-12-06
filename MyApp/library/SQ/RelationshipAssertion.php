<?php
class SQ_RelationshipAssertion implements Zend_Acl_Assert_Interface
{

	public function assert(Zend_Acl $acl,
			Zend_Acl_Role_Interface $role = null,
			Zend_Acl_Resource_Interface $resource = null,
			$privilege = null)
	{
		return $this->areFriends();
	}
	
	public function areFriends()
	{
		// get UserID of current logged in user
		// assumes Zend_Auth has stored a User object of the logged in user
		$auth = Zend_Auth::getInstance();
	
		// get the ID of the user profile they are trying to view
		// assume you can pull it from the URL
		// or your controller or a plugin can set this value another way
		$userToView = $this->getRequest()->getParam('id', null);
	
		// call your function that checks the database for the friendship
	    $relationshipMapper = new Application_Model_RelationshipMapper();
        if ($auth->getIdentity()->GUID != $guid) {
        	$row = $relationshipMapper->getRelationship($auth->getIdentity()->GUID, $guid);
            if (count($row) > 0 ) {
            	if ($row->APPROVED == 1) return true;
            }
        }
			
		return false;
	}
	
}