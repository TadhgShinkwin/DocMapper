<?php


class Login extends Model{
	//class properties
        private $db;
        private $user;
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $panelHead_2;
        private $panelContent_2;
        private $panelHead_3;
        private $panelContent_3;
 
	
        
	function __construct($postArray,$pageTitle,$pageHead,$database, $user)
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


            //set the DECOND panel content
            $this->setPanelHead_2();
            $this->setPanelContent_2();
        
           
            
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
                $this->panelHead_1='<br><br><br><br><h3>Login Successful</h3>'; 
            }
            else{        
                $this->panelHead_1='<h3>Login Form</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){ 
                    $this->panelContent_1='<h3>Welcome - your login has been successful<h3>';      
                }
                else{ //if user is not logged in they see some info about bootstrap 
                    if($this->postArray['btnLogin']==TRUE){
                        $this->panelContent_1 ='<h3>Your login was not successful - Please try again';
                        $this->panelContent_1.= file_get_contents('forms/form_login.html');  //this reads an external form file into the string
                        $this->panelContent_1.='';
                    }
                    else{
                    $this->panelContent_1 = file_get_contents('forms/form_login.html');  //this reads an external form file into the string
                    $this->panelContent_1.='';
                    }
                } 
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading
            if($this->loggedin){
                $this->panelHead_2='<h3>Welcome</h3>';   
            }
            else{        
                $this->panelHead_2='<h3>Welcome</h3>'; 
            }
        }//end METHOD - //set the panel 2 heading     
        
        public function setPanelContent_2(){//set the panel 2 content
       
            if($this->loggedin){
                 $this->panelContent_2= "<h3>Welcome ".$this->user->getUserID()." - Your Login has been successful!<h3>";
            }
            else{
                
                $this->panelContent_2='Please enter your login details.';
            }
            
            
                 

        }//end METHOD - //set the panel 2 content  
        
        //Panel 3
       
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        public function getUser(){return $this->user;}

        
}//end class
        