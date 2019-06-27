<?php
    include_once 'libs/Model.php';
    include_once 'libs/View.php';

    class Controller
{
		private $model;
		private $view;
		public function __construct()
		{		
		    $this->model = new Model();
			$this->view = new View(TEMPLATE);	
			$this->pageDefault();	
    			  
	  $this->view->templateRender();
	  }	
		  
		private function pageDefault()
		{   
		  	$mArray = $this->model->getArray();		
	    	$this->view->addToReplace($mArray);			   
		}				
}
					

?>