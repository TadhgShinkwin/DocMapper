<?php
/**
 *
 *
 * 
 * 
 */

class Usermgmt extends Model{
	//class properties
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $database;

 
	
	//constructor
	function __construct($user,$postArray,$pageTitle,$pageHead, $database) 
	{   
            parent::__construct($user->getLoggedinState());
            $this->user=$user;
            $this->db=$database;

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
                $this->pageHeading= "User Management" ; //$pageHead;
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3 style="padding-top:0px;">User List</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>User List</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
            if($this->loggedin){  //display the calculator form
                    $this->panelContent_1 = '';
                    $sql='SELECT userID,email,usertypeid FROM user';
                    $this->panelContent_1.=$this->dbViewQuery($sql);
                }
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='Please log in to view users. ';;                          
                } 
        }//end METHOD - //set the panel 1 content        

        

        
    private function dbViewQuery($sql){
                $returnString='';
                $general='General User';
                $admin='Administrator';
                $suspended='ACCOUNT SUSPENDED ';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  
                    
                    //$returnString.= '<ul class="list-group" style="">';
                    $returnString.= '<table class="table table-bordered table-mine" style="width:100%;">';
                    $returnString.='<tr><th>User ID</th><th>email</th><th>User Type</th><th>Manage</th></tr>';
                    while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                            $returnString.='<tr>';
                               
                                
                               foreach($row as $key=>$value){
                                   if ($value==2){
                                   $value=$general;
                                   }
                                   else if($value==1){
                                       $value=$admin;
                                   }
                                   else if($value==3){
                                       $value=$suspended;
                                   }
                                   $returnString.= "<td>$value</td>";
                                }
                                $returnString.= '<td >';
                                $returnString.= '<form style="float:center;" action="'.$_SERVER["PHP_SELF"].'?pageID=userEdit" method="post">';
                                $returnString.= '<input type="submit" type="button" class="btn btn-secondary btn-sm" value="Delete" name="btn" onclick="return confirm(\'Are you sure you wish to delete this user?\')">&nbsp';
                                $returnString.= '<input type="submit" type="button" class="btn btn-secondary btn-sm" value="Toggle Admin" name="btn" onclick="return confirm(\'Are you sure you wish to make this user an Administrator?\')">&nbsp';
                                $returnString.= '<input type="submit" type="button" class="btn btn-secondary btn-sm" value="Toggle Suspend" name="btn" onclick="return confirm(\'Are you sure you wish to suspend this user?\')">&nbsp';
                                $returnString.= '<input type="submit" type="button" class="btn btn-secondary btn-sm" value="Change Password" name="btn" >';
                                $returnString.= '<input type="hidden" value="'.$row['userID'].'" name="selectedUserID">';
                                $returnString.= '</form>';
                                $returnString.= '</td>';                                
                                $returnString.= '</tr>'; //Not sure how to make this a clickable link yet
                            }
                    $returnString.= '</table>';   
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                //free result set memory
                //$rs->free();
                return $returnString;
}
    private function makeAdmin(){
        $sql = 'UPDATE `documentmapper`.`user` SET `usertypeid` = \'1\' WHERE (`userID` = \'U00006\')';
    }

        
        
        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}

        

        
}//end class
        