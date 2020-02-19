<?php

class DeleteMap extends Model{

        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $db;
        private $SESSION;
        
        
        function __construct($user,$postArray,$pageTitle,$pageHead,$database) 
	{   
            parent::__construct($user->getLoggedinState());
            $this->user=$user;

            //set the PAGE title
            $this->setPageTitle($pageTitle);
            
            //set the PAGE heading
            $this->setPageHeading($pageHead);
            $this->db=$database;

            //get the postArray
            $this->postArray=$postArray;
            
            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();
            
            

	}
        
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle="Delete Map";
        }
        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3>Delete Map</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Delete Map</h3>'; 
            }       
        }
         public function setPanelContent_1(){
             $sql='DELETE FROM maps WHERE mapid="'.$_POST['mapid'].'" LIMIT 1';
             
             
             if(($this->db->multi_query($sql)===TRUE)&&($this->db->affected_rows===1)){
                //$sql="SELECT * FROM user";;
                $this->panelContent_1.='<h3>Your map has now been deleted</h3></br>';
                $this->panelContent_1.='<button class="btn-mine"> <a  href= "'.$_SERVER['PHP_SELF'].'?pageID=maps">Click Here</a></button><br><br>';
                
                
              
                
            }
            else{
                $this->panelContent_1.='<h3>Unable to delete document - Please try again</h3><br>';
                
                $this->panelContent_1.='<button class="btn-mine"> <a href = "'.$_SERVER['PHP_SELF'].'?pageID=maps">Click Here</a></button><br><br>';
                            
                        }
             
             
         }


        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}





}
?>