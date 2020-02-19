<?php
/**
 * Class: DocUpload model
 *
 * 
 * 
 */

class DocUpload extends Model{
	//class properties
        private $db;
        private $user;
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $SESSION;
        
 
	
        
	function __construct($user,$postArray,$pageTitle,$pageHead,$database)
	{   
            parent::__construct($user->getLoggedinState());
            
            $this->db=$database;

            $this->user=$user;     
            
            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //get the postArray
            $this->postArray=$postArray;
            
            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();

	}
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){                
                $this->panelHead_1='<h3>Document Upload</h3>'; 
            }
            else{        
                $this->panelHead_1='<h3>Please Log in to Use this feature</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){ 
                   $this->panelContent_1 = file_get_contents('forms/form_upload.html');      
                }
                else{ //if user is not logged in they see some info about bootstrap                                   
                    $this->panelHead_1='<h3>Please Log in to Use this feature</h3>'; 
                   
                } 
        }//end METHOD - //set the panel 1 content        

       
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getUser(){return $this->user;}

        
}