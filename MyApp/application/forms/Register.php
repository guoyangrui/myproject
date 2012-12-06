<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	$this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
    	  	
    	$this->addElement('text', 'email', array(
    			'label'      => 'Your email address:',
    			'required'   => true,
    			'filters'    => array('StringTrim'),
    			'validators' => array(
    					'EmailAddress',
    			)
    	));
    	
    	$this->addElement('password', 'password', array(
    			'label'      => 'Password:',
    			'required'   => true,
    			'maxlength'  => 16,
    			'filters'    => array('StringTrim'),
    			'validators' => array(
    					array('stringLength',true, array(6, 16)))
    	));
    	
    	$this->addElement('text', 'firstName', array(
    			'label'      => 'First Name:',
    			'required'   => true,
    			'filters'    => array('StringTrim'),
    	));
    	
    	$this->addElement('text', 'lastName', array(
    			'label'      => 'Last Name:',
    			'required'   => true,
    			'filters'    => array('StringTrim'),
    	));
    	  	
    	$this->addElement('submit', 'submit', array(
    			'ignore'   => true,
    			'label'    => 'Submit',
    	));
    	
    	/*$this->addElement('hash', 'csrf', array(
    			'salt' => 'unique',
    	));*/
    
    }

}

