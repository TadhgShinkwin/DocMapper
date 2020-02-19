<?php

class MapUpdate extends Model{
    private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $db;
        private $SESSION;
        private $get;
        
        
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
            $this->get=$_GET;
            
            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();
            
        }
        
        
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading='Update Map';
        }  //end METHOD -   set the page heading
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3 style="padding-top:10px;">Update Documents</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Please Log In</h3>'; 
            }       
        }
        
        public function setPanelContent_1(){
            $mapid = $this->postArray['mapid'];
            $UID = $_SESSION['userid'];
            if($this->loggedin){
                
                if(@$this->get['docNum']){
                    
                    $this->panelContent_1.=$this->get['docNum'];
                    $this->panelContent_1.='<form action="index.php?pageID=mapview" method="POST"><input type="hidden" name="mapid" id="mapid" value="'.$this->get['mapid'].'"/><input type="submit" value="Back to Map"/>';
                }
                
                
                else{
                $this->panelContent_1.='<h3>Please select Documents for your Map</h3><br>';
                
                $this->panelContent_1.='<div class="update-container">';
                $this->panelContent_1.='<form  action="index.php?pageID=docs2map" method="POST">';
                $this->panelContent_1.='<label>Document 1: &nbsp</label><select name = "doc1">';
                $this->panelContent_1.='<option value="NULL">None</option>';
                $this->panelContent_1.=$this->setDropDown($UID);
                $this->panelContent_1.='</select><br><br>';
                
                $this->panelContent_1.='<label>Document 2: &nbsp</label><select name = "doc2">';
                $this->panelContent_1.='<option value="NULL">None</option>';
                $this->panelContent_1.=$this->setDropDown($UID);
                $this->panelContent_1.='</select><br><br>';
                
                $this->panelContent_1.='<label>Document 3: &nbsp</label><select name = "doc3">';
                $this->panelContent_1.='<option value="NULL">None</option>';
                $this->panelContent_1.=$this->setDropDown($UID);
                $this->panelContent_1.='</select><br><br>';
                
                $this->panelContent_1.='<label>Document 4: &nbsp</label><select name = "doc4">';
                $this->panelContent_1.='<option value="NULL">None</option>';
                $this->panelContent_1.=$this->setDropDown($UID);
                $this->panelContent_1.='</select><br><br>';
                
                $this->panelContent_1.='<label>Document 5: &nbsp</label><select name = "doc5">';
                $this->panelContent_1.='<option value="NULL">None</option>';
                $this->panelContent_1.=$this->setDropDown($UID);
                $this->panelContent_1.='</select><br><br>';
                
                $this->panelContent_1.='<input type="hidden" name="mapid" value="'.$mapid.'"/>';
                $this->panelContent_1.='<input class="btn-mine" id="updateSub1"  type="submit" value="Submit"/>';
                $this->panelContent_1.='</form>';
                
                $this->panelContent_1.='<form  action="index.php?pageID=mapview" method="POST"><input type="hidden" name="mapid" id="mapid" value="'.$mapid.'"/><input class="btn-mine" id="updateSub2" type="submit" value="Cancel"/>';
                $this->panelContent_1.='</div>';
                $this->panelContent_1.='<br><br>';
                
                }
               
            }
            else{
                $this->panelContent_1='<h1>Please log in to view this page</h1>';
            }
        }
        
        
        
        private function setDropDown($UID){
            $sql='SELECT docid FROM documents WHERE userID = "'.$UID.'" ORDER BY docid ASC';
            $resultString='';
            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                    
                    while ($row = $rs->fetch_assoc()){
                        foreach($row as $key=>$value){
                            $docname=$this->docName($value, $UID);
                            $resultString.='<option value="'.$value.'">'.$docname.'</option>';
                                    //<option value = "1">one</option>
                        }  
                    }
            }
            else{  //resultset is empty or something else went wrong with the query

                        $resultString.= '<br>No records available to view - please try again<br>';

                }
                return $resultString;
        }
        
        
        public function docName($value, $UID){
        $DN = '';
        $sql3='SELECT documents.docname FROM documents WHERE userid="'.$UID.'" AND documents.docid="'.$value.'" ORDER BY documents.docid ASC';
        $res = mysqli_query($this->db,$sql3);
        while($row = $res->fetch_assoc()) {
           $DN= $row['docname'];
            
        }
        return $DN;
    }
        
        
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        
        
}

