<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $form = new Application_Form_Search();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost())
        {
        	if ($form->isValid($this->getRequest()->getPost()))
        	{
        		$query = $form->getValue('search');        		
                $parser = new SQ_QueryParser($query);
        	}
        }
    }


}

