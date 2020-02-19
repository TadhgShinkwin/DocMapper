<?php
    
class KeyInsert extends Model{
    
    
        private $db;
        private $user;
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $SESSION;
        private $pageID;
        private $contentVar;
        
        
        
        
        function __construct($user,$pageTitle,$postArray,$pageHead,$database,$pageID){
            
            parent::__construct($user->getLoggedinState());
            
            $this->db=$database;
            
            $this->pageID=$pageID;

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
        
         public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle="Document Submitted";
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading=$pageHead;
        }  //end METHOD -   set the page heading
        
        public function setPanelHead_1(){
            if($this->loggedin){                
                $this->panelHead_1='<h3>Document Submitted</h3>'; 
            }
            else{        
                $this->panelHead_1='<h3>Please Log in to Use this feature</h3>'; 
            }       
        }
        public function setPanelContent_1(){
            $UID = $_SESSION['userid'];
            $docname = $this->db->real_escape_string($this->postArray['docname']);
            $key1=$this->db->real_escape_string($this->postArray['keyword1']);
            $key2=$this->db->real_escape_string($this->postArray['keyword2']);
            $key3=$this->db->real_escape_string($this->postArray['keyword3']);
            $key4=$this->db->real_escape_string($this->postArray['keyword4']);
            $key5=$this->db->real_escape_string($this->postArray['keyword5']);
            $key6=$this->db->real_escape_string($this->postArray['keyword6']);
            $key7=$this->db->real_escape_string($this->postArray['keyword7']);
            $key8=$this->db->real_escape_string($this->postArray['keyword8']);
            $key9=$this->db->real_escape_string($this->postArray['keyword9']);
            $key10=$this->db->real_escape_string($this->postArray['keyword10']);
            
            
                               
            $UID = $_SESSION['userid'];
            $docname = $this->db->real_escape_string($this->postArray['docname']);
            
            $sql="INSERT INTO documents (docname, userid,kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10) ";
            $sql.="VALUES (";
            $sql.="'".$docname."',";
            $sql.="'".$UID."',";
            $sql.="'".$key1."',";
            $sql.="'".$key2."',";
            $sql.="'".$key3."',";
            $sql.="'".$key4."',";
            $sql.="'".$key5."',";
            $sql.="'".$key6."',";
            $sql.="'".$key7."',";
            $sql.="'".$key8."',";
            $sql.="'".$key9."',";
            $sql.="'".$key10."'";
            $sql.=");";
            

            //execute the INSERT SQL and check that the new row is inserted OK
            if(($this->db->multi_query($sql)===TRUE)&&($this->db->affected_rows===1)){
                //$sql="SELECT * FROM user";;
                $this->panelContent_1.='<h3>Your document: <b>\''.$docname.'\'</b> has been successfully uploaded!</h3><br>';
                $this->panelContent_1.='<button class="btn-mine"> <a href = "'.$_SERVER['PHP_SELF'].'?pageID=documents">Click Here</a></button>';
                
                
              
                
            }
            else{
                $this->panelContent_1.='Unable to add new Document<br>';
                $this->panelContent_1.='<button class="btn-mine"> <a href = "'.$_SERVER['PHP_SELF'].'?pageID=documents">Click Here</a></button>';            
                        }
            
//           
        }
    
    
    ////////////Functions go below here
    public function sendTerms($kw1,$kw2,$kw3,$kw4,$kw5,$kw6,$kw7,$kw8,$kw9,$kw10){
        
        
        
        $sql.= "INSERT INTO keywords (docid, kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10)";
        $sql.="VALUES (";
        $sql.="47,";
        $sql.="'".$kw1."',";
        $sql.="'".$kw2."',";
        $sql.="'".$kw3."',";
        $sql.="'".$kw4."',";
        $sql.="'".$kw5."',";
        $sql.="'".$kw6."',";
        $sql.="'".$kw7."',";
        $sql.="'".$kw8."',";
        $sql.="'".$kw9."',";       
        $sql.="'".$kw10."'";
        $sql.=")";
        
        
        $returnString = '';
        if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
            $returnString = "<P>Database Updated!</p>";
        }
        else{
            $returnString = "<P>Database unable to Update!</p>";
        }
        return $returnString;
        
        
        
        
    }
    
    function dbTest($sql){
        
        
        
        $returnString='';
                            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                                //iterate through the resultset to create a HTML table
                                
                                $returnString.= '<table class="table table-bordered">';
                                $returnString.='<tr><th>UserID</th><th>Email</th><th>Password</th><th>userType</th></tr>';//table headings
                                while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                                        $returnString.='<tr>';//--start table row
                                           foreach($row as $key=>$value){
                                                    $returnString.= "<td>$value</td>";
                                            }
                                            //Edit button
                                            
                                            $returnString.= '</tr>';  //end table row
                                        }
                                $returnString.= '</table>';   
                            }  
                            else{  //resultset is empty or something else went wrong with the query
                            
                                    $returnString.= '<br>No records available to view - please try again<br>';
                                    
                            }
                            
                            return $returnString;
    }
    
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getUser(){return $this->user;}
    
}

?>





