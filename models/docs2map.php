<?php

class docs2map extends Model{
    
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $db;
        private $SESSION;
    
    function __construct($user,$postArray,$pageTitle,$pageHead,$database){
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
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading='Update Documents';
        }  //end METHOD -   set the page heading
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3>Update Documents</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Please Log In</h3>'; 
            }       
        }
    
        public function setPanelContent_1(){
            $mapid=$this->postArray['mapid'];
            if($this->loggedin){
                $this->panelContent_1='';
                
                if((($this->postArray['doc5'])!=($this->postArray['doc4']))&&(($this->postArray['doc5'])!=($this->postArray['doc3']))&&(($this->postArray['doc5'])!=($this->postArray['doc2']))&&(($this->postArray['doc5'])!=($this->postArray['doc1']))){
                    $five=$this->postArray['doc5'];
                }
                else{
                    $five=NULL;
                }
                if((($this->postArray['doc4'])!=($this->postArray['doc3']))&&(($this->postArray['doc4'])!=($this->postArray['doc2']))&&(($this->postArray['doc4'])!=($this->postArray['doc1']))){
                    $four=$this->postArray['doc4'];
                }
                else{
                    $four=NULL;
                }
                if((($this->postArray['doc3'])!=($this->postArray['doc2']))&&(($this->postArray['doc3'])!=($this->postArray['doc1']))){
                    $three=$this->postArray['doc3'];                   
                }
                else{
                    $three=NULL;
                }
                if((($this->postArray['doc2'])!=($this->postArray['doc1']))){
                    $two=$this->postArray['doc2'];
                }
                else{
                    $two=NULL;
                }
                
                $one=$this->postArray['doc1'];
                
                $sql='UPDATE maps SET ';
                $sql.='doc1='.$one.',';
                $sql.='doc2='.$two.',';
                $sql.='doc3='.$three.',';
                $sql.='doc4='.$four.',';
                $sql.='doc5='.$five.'';
                $sql.=' WHERE mapid = '.$mapid.'';
                
                
                
                if(($this->db->multi_query($sql)===TRUE)&&($this->db->affected_rows===1)){
                    $this->panelContent_1.='<h3>Your map: <b>\''.$this->mapName($mapid).'\'</b> has been successfully updated!</h3></br>';
                    $this->panelContent_1.='<form action="'.$_SERVER['PHP_SELF'].'?pageID=mapview" method="POST"><input type="hidden" name="mapid" value="'.$mapid.'"/><input type="submit" value="Return to Map"/>';
                }
                else{
                    $this->panelContent_1.='<p>This action cannot be taken at the moment, please make sure you have not chosen a document more than once for this map<p>';
                    $this->panelContent_1.='<form action="'.$_SERVER['PHP_SELF'].'?pageID=mapview" method="POST"><input type="hidden" name="mapid" value="'.$mapid.'"/><input type="submit" value="Return to Map"/>';
                }
                
                
                
            }
            else{        
                $this->panelContent_1='<h3>Please Log In</h3>'; 
            } 
        }
    
    
    private function mapName($mapid){
        $sql='SELECT mapname FROM maps WHERE mapid='.$mapid.'';
        $res = mysqli_query($this->db,$sql);
        while($row = $res->fetch_assoc()) {
           $DN= $row['mapname'];
            //$DN = $row;
        }
        return $DN;
    }
    
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
}

