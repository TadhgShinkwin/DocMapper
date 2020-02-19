<?php
/**
 * Class: Home
 * This class is used to generate text content for the HOME page view.
 * 
 * This is the 'landing' page for the web application. 
 * 
 * It handles bot logged in and not logged in usee cases. 
 *
 * 
 * 
 */

class Home extends Model{
	//class properties
        private $pageTitle;
        private $pageHeading;
        private $panelHead_1;
        private $panelContent_1;
        //private $panelHead_2;
        private $panelContent_2;
        private $user;
	
	//constructor
	function __construct($user,$pageTitle,$pageHead){   
            parent::__construct($user->getLoggedInState());
            $this->user=$user;
            

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);

            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();


            //set the DECOND panel content
//            $this->setPanelHead_2();
            $this->setPanelContent_2();
        
            
	} //end METHOD constructor
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
                $this->panelHead_1='<h3>Welcome to DocMapper</h3>';
        }//end METHOD - //set the panel 1 heading
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){
                
                if ($this->user->getUserTypeID()==='ADMIN'){
                    $this->panelContent_1.='<p>You are logged in as an Admin user.'; 
                    $this->panelContent_1.='<p>You now have access to user records.';
                }
                else{
                    $this->panelContent_1.='<p>You are currently logged in to your user account. You can now upload documents to use our features.'; 
                    $this->panelContent_1.=' Select Documents or Maps to begin uploading and discover links between your documents to help your understanding of the topic.</p>';   
                }
            }
            else{
                $this->panelContent_1.='<p>DocMapper is a free web application to analyse your documents and visualise your data. Please log in or register to use our features.'; 
                    $this->panelContent_1.=' Select Documents or Maps to begin uploading and discover links between your documents to help your understanding of the topic.</p>'; 
            }
        }//end METHOD - //set the panel 1 content        

        //Panel 2
//        public function setPanelHead_2(){ //set the panel 2 heading
//            if($this->loggedin){
//                $this->panelHead_2='<h3>Welcome</h3>';
//            }
//            else{        
//                $this->panelHead_2='<h3>Login required</h3>';
//            }
        //}//end METHOD - //set the panel 2 heading        
        public function setPanelContent_2(){//set the panel 2 content
            //get the Middle panel content
            if($this->loggedin){
                
                
                    $this->panelContent_2='<div class="home-img"><img src="images/uc.jpg" /></div><br><br><br>'; 
                
                
                
            }
            else{        
                $this->panelContent_2='<div class="home-img"><img src="images/uc.jpg" /></div><br><br><br>';
            }
        }//end METHOD - //set the panel 2 content  
        
       
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        //public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}
        
        

        
}//end class
        