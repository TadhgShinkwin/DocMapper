<?php


class Maps extends Model{
	//class properties
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $db;
        private $SESSION;

 
	
	//constructor
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
                if($this->postArray['mapname']){
                    $UID = $_SESSION['userid'];
                    $sql='INSERT INTO maps (mapname, userid) VALUES ("'.$this->postArray['mapname'].'","'.$UID.'");';                    
                    if(($this->db->multi_query($sql)===TRUE)&&($this->db->affected_rows===1)){
                        $this->panelHead_1='<h3>New map added to Map List</h3>';
                    }
                    else{
                        $this->panelHead_1='<h3>Map could not be added</h3>';
                    }
                }
                else{
                $this->panelHead_1='<h3>Maps List</h3>';
                }
            }
            else{        
                $this->panelHead_1='<h3>Maps List</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){  //display the calculator form
                    $this->panelContent_1 = ''; 
                    $this->panelContent_1.=$this->dbViewMaps($_SESSION['userid']);
                }
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='Please log in to view your Maps. ';;                          
                } 
        }

        
   private function dbViewMaps($UID){
        $returnString='';
                        
        $sql='SELECT mapid FROM maps WHERE maps.userid="'.$UID.'" ORDER BY maps.mapid ASC';
        $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                            $returnString.='<li class="list-group-item doclist" style="text-align: left; ">';
                               foreach($row as $key=>$value){
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $UID);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        $returnString.="<form method=\"post\" action='index.php?pageID=deletemap' style=\"float: right;\"><input type='hidden' name='mapid' id='mapid' value='".$value."'></input><input class=\"btn-mine\" type=\"submit\" value=\"Delete\" onclick=\"return confirm('Are you sure you wish to delete this map?')\"></input></form>";
                                        $returnString.="<form method=\"post\" action='index.php?pageID=mapview' style=\"float: right;\"><input type='hidden' name='mapid' id='mapid' value='".$value."'></input><input class=\"btn-mine\" style=\"margin-right:3px;\" type=\"submit\" value=\"Open Map\"></input></form>&nbsp";
                                        
                                }
                                
                                $returnString.= '</li>'; 
                                
                            }
                    $returnString.= '<li class="list-group-item" style="text-align: center;" ><a href="'.$_SERVER['PHP_SELF'].'?pageID=mapcreate">+ Create New Map</a></li>';
                    $returnString.= '</ul><br><br>';   
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br><h3>No records available to view - please try again</h3>';

                }
                //free result set memory
                //$rs->free();
                return $returnString;
}

public function docName($value, $UID){
        $DN = '';
        $sql3='SELECT mapname FROM maps WHERE userid="'.$UID.'" AND mapid="'.$value.'" ORDER BY mapid ASC';
        $res = mysqli_query($this->db,$sql3);
        while($row = $res->fetch_assoc()) {
           $DN= $row['mapname'];
            //$DN = $row;
        }
        return $DN;
    }
    
    public function createMap($UID){
        
            $sql='INSERT INTO maps (mapname, userID) VALUES ('.$this->postArray['mapname'].','.$UID.')';
            mysqli_query($this->db, $sql);
     
    }

        
        
        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}

        

        
}//end class
        