<?php
/** 
 *
 * 
 * 
 */

class Documents extends Model{
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
                $this->panelHead_1='<h3>Documents List</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Documents List</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){
                    //$UID = $_SESSION['userid']; Not necessary
                    $this->panelContent_1 = '<ul>';
                    $this->panelContent_1.=$this->dbViewQuery($_SESSION['userid']);
                    
                }
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='Please log in to view your documents. ';;                          
                
                }//end IF     
        }

        
    private function dbViewQuery($UID){
        
        $sql='SELECT documents.docid FROM documents WHERE documents.userid="'.$UID.'" ORDER BY documents.docid ASC';
        $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                    
                    while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                            $returnString.='<li class="list-group-item doclist" style="text-align: left; ">';//--start new list element
                               foreach($row as $key=>$value){
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $UID);
                                        $returnString.=$rando;
                                        $returnString.= "<button class=\"btn-mine\" style=\"float: right;\"><a style=\"color:black\" href =\"http://www.google.com/search?q=";                                       
                                        $returnString.= $this->kwSearchTerms($docname);
                                        $returnString.="\" target=\"_blank\" style=\"float: right;\">Related Search</a></button>";
                                        $returnString.="<form method=\"post\" action='index.php?pageID=deletedoc' style=\"float: right;\"><input type='hidden' name='docid' id='docid' value='".$value."'></input><input class=\"btn-mine\"type=\"submit\" value=\"Delete\" onclick=\"return confirm('Are you sure you wish to delete this document?')\"></input></form><button id=\"456\"style=\"float:right;\" class=\"show-keys btn-mine\" onclick=\"hideFunction(".$value.")\">Show Keywords</button>";
                                        $returnString.='<div class="keytable">';
                                        $returnString.='<br>';
                                        $returnString.='<table class="table table-bordered" id="'.$value.'" style="display:none;"><tr><th><b>Keywords: </b></th>';
                                        $returnString.=$this->showKeys($docname);
                                        $returnString.='</tr></table>';
                                        $returnString.='</div>';
                                        
                                        
                                }
                                
                                $returnString.= '</li>'; 
                                
                            }
                    $returnString.= '<li class="list-group-item" style="text-align:center; " ><a href="'.$_SERVER['PHP_SELF'].'?pageID=docupload">+ Add New Document</a></li>';
                    $returnString.= '</ul>';   
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br><h3>No records available to view - please try again</h3>';

                }
                //free result set memory
                //$rs->free();
                return $returnString;
                
}

    public function kwSearchTerms($docID){
        $i=1;
        $sql2='SELECT documents.kw1, documents.kw2, documents.kw3, documents.kw4, documents.kw5, documents.kw6, documents.kw7, documents.kw8, documents.kw9, documents.kw10 FROM documents WHERE documents.docid ="'.$docID.'"';
        $searchTerms='';
        if((@$rs2=$this->db->query($sql2))&&($rs2->num_rows)){
            $row = $rs2->fetch_assoc();
                while ($i<11){
                    if($row['kw'.$i.'']!=NULL){              
                    $searchTerms.=$row['kw'.$i.''];
                    $searchTerms.='+';
                    $i++;
                    }
                    else{
                        $i++;
                    }
                
            }
        }
        else{  //resultset is empty or something else went wrong with the query

                        $searchTerms.= '<br>No records available to view - please try again<br>';

                }
                $rs2->free();
                return $searchTerms;
    }
    public function docName($value, $UID){
        $DN = '';
        $sql3='SELECT documents.docname FROM documents WHERE userid="'.$UID.'" AND documents.docid="'.$value.'" ORDER BY documents.docid ASC';
        $res = mysqli_query($this->db,$sql3);
        while($row = $res->fetch_assoc()) {
           $DN= $row['docname'];
            //$DN = $row;
        }
        return $DN;
    }

    private function showKeys($docID) {
        $i=1;
        $sql2='SELECT documents.kw1, documents.kw2, documents.kw3, documents.kw4, documents.kw5, documents.kw6, documents.kw7, documents.kw8, documents.kw9, documents.kw10 FROM documents WHERE documents.docid ="'.$docID.'"';
        $searchTerms='';
        if((@$rs2=$this->db->query($sql2))&&($rs2->num_rows)){
            $row = $rs2->fetch_assoc();
                while ($i<11){
                    if($row['kw'.$i.'']!=NULL){              
                        $searchTerms.='<td style="width:10%;">';
                        $searchTerms.=$row['kw'.$i.''];
                        $searchTerms.='</td>';
                    
                    $i++;
                    }
                    else{
                        $i++;
                    }
                
            }
        }
        else{  //resultset is empty or something else went wrong with the query

                        $searchTerms.= '<br>No records available to view - please try again<br>';

                }
                $rs2->free();
                return $searchTerms;
    }    
        
        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}


        
}//


        