<?php

class Profile extends Model{
    
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
                $this->pageTitle=$pageTitle;
        } 
    
    public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading='Your Profile';
        }
    
    public function setPanelHead_1(){
        if($this->loggedin){
            $this->panelHead_1='<br><br>User Details';
        }
        else
            $this->panelHead_1='';
    }
    
    public function setPanelContent_1(){
        if($this->loggedin){
            $UID=$_SESSION['userid'];
            $general='General User';
            $admin='Administrator';
            $sql='SELECT userID, email, usertypeid FROM user WHERE userID="'.$UID.'"';
            
            $this->panelContent_1='<table class="table table-bordered table-mine" style="width:100%;">';
            $this->panelContent_1.='<tr><th>User ID</th><th>Email</th><th>User Type</th></tr>';
            
            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
                while ($row = $rs->fetch_assoc()){
                    $this->panelContent_1.='<tr>';
                    foreach($row as $key=>$value){
                                   if ($value==2){
                                   $value=$general;
                                   }
                                   else if($value==1){
                                       $value=$admin;
                                   }
                                   
                                   $this->panelContent_1.= "<td>$value</td>";
                                }
                                $this->panelContent_1.= '</tr>';
                }
            }
            else{
                $this->panelContent_1='';
            }
            
            
            
            $this->panelContent_1.='</table>';
            $this->panelContent_1.= '<form style="float:center;" action="'.$_SERVER["PHP_SELF"].'?pageID=userEdit" method="post">';
            $this->panelContent_1.='<input type="submit" type="button" class="btn btn-secondary" value="Change Password" name="btn" >';
            $this->panelContent_1.= '<input type="hidden" value="'.$UID.'" name="selectedUserID">';
            $this->panelContent_1.= '</form>';
        }
        else
            $this->panelContent_1='Please log in to view your user information';
    }
    
    public function getPageTitle(){return $this->pageTitle;}
    public function getPageHeading(){return $this->pageHeading;}
    public function getMenuNav(){return $this->menuNav;}
    public function getPanelHead_1(){return $this->panelHead_1;}
    public function getPanelContent_1(){return $this->panelContent_1;}
}