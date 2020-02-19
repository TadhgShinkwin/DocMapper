<?php
/**
 * Class: Navigation
 * This class is used to generate navigation menu items in an an array for the view.
 * 
 * It uses the logged in status and currently selected pageID to determine which items 
 * are included in the menu for that specific page.
 *
 * 
 * 
 */

class Navigation extends Model{
	//class properties
        private $pageID;   //currently selected page
        private $menuNav;  //array of menu items    
        private $user;
	
	//constructor
	function __construct($user,$pageID) {   
            parent::__construct($user->getLoggedInState());
            $this->user=$user;
            $this->pageID=$pageID;
            $this->setmenuNav();

	}  //end METHOD constructor
      
        //setter methods
        public function setmenuNav(){//set the menu items depending on the users selected page ID
            
            //empty string for menu items
            $this->menuNav='';
            
            
                        
                        
            if($this->loggedin){  //if user is logged in   

                
                if ($this->user->getUserTypeID()==='ADMIN'){
                    switch ($this->pageID) {
                    case "home":
                        
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=usermgmt">User Management</a></li>';                      
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "usermgmt":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';                      
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;                    
                    case "logout":  //DUMMY CASE - this case is not actually needed!!
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                        break;
                    default:
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=usermgmt">User Management</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                
                }//end switch
                }
                else{  //STUDENT menu items
                    switch ($this->pageID) {
                    case "home":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';  
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                                                      
                    case "documents"://docs
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    case "docupload"://docs
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    
                    case "keyextract"://docs
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                    
                    case "maps"://maps
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';  
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                                      
                    case "logout":  //DUMMY CASE - this case is not actually needed!!
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';  
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        break;
                    default:
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=documents">Documents</a></li>';  
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=maps">Maps</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=profile">Profile</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a></li>';
                        break;
                
                }//end switch
                }
                

            }
            else{ //user is NOT logged in
                
                  switch ($this->pageID) {
                    case "home":
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                        break;
                    case "register":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                        break;         
                    case "login":
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a></li>';
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                        break;  
                    default:
                        //$this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a></li>';
                        $this->menuNav.='<li><a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a></li>';
                        break;
            }
        }   
        } //end METHOD - set the menu items depending on the users selected page ID
        
        //getter methods
        public function getMenuNav(){return $this->menuNav;}    //end METHOD - get the navigation menu string   
  
}//end class
        