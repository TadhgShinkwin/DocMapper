<?php


class userEdit extends Model{
    private $pageTitle;
    private $pageHeading;
    private $postArray;  
    private $panelHead_1;
    private $panelContent_1;
    private $db;
    
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
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading= "Manage User" ; //$pageHead;
        }
        
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3>Edit User</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Please Log In</h3>'; 
            }       
        }
        public function setPanelContent_1(){//set the panel 1 content
            
            
            $UID = $this->postArray['selectedUserID'];
            if($this->loggedin){  //display the calculator form
                
                if($this->postArray['btn']){
                    switch ($this->postArray['btn']) {
                        case ('Delete'):
                            $sql='DELETE FROM user WHERE userID = "'.$UID.'"';
                            $sql2='DELETE FROM maps WHERE userid="'.$UID.'"';
                            
                             if (mysqli_multi_query($this->db, $sql2)){
                            $this->panelContent_1.='The user maps have been deleted<br><br><br><br>';}
                            else{
                                $this->panelContent_1.='We have encountered a proble, please try again later<br><br><br><br>';
                            }
                            
                            if (mysqli_multi_query($this->db, $sql)){
                            $this->panelContent_1='This user has been deleted<br>';}
                            else{
                                $this->panelContent_1='We have encountered a proble, please try again later<br><br><br><br>';
                            }
                           
                            break;
                        case ('Toggle Admin'):
                            if($this->getUserType($UID)==3){
                                $this->panelContent_1='This user account has been suspended. Please unsuspend the account before assigning Admin status<br><br><br><br>';
                            }
                            else if($this->getUserType($UID)==2){
                                $sql='UPDATE user SET usertypeid=1 WHERE userID = "'.$UID.'"';
                                if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                                $this->panelContent_1='This user acccount has now been changed to Admin<br><br><br><br>';
                                }
                                else{
                                    $this->panelContent_1='An error occurred, please try again later<br><br><br><br>';
                                }
                            }
                            else if($this->getUserType($UID)==1){
                                $sql='UPDATE user SET usertypeid=2 WHERE userID = "'.$UID.'"';
                                if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                                $this->panelContent_1='This Admin acccount has now been changed to User<br><br><br><br>';
                                }
                                else{
                                    $this->panelContent_1='An error occurred, please try again later<br><br><br><br>';
                                }
                            }
                            
                            
                            
                            break;
                        case ('Toggle Suspend'):
                            if($this->getUserType($UID)!=3){
                            $sql='UPDATE user SET usertypeid=3 WHERE userID = "'.$UID.'"';
                            if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                                $this->panelContent_1='This user acccount has now been suspended<br><br><br><br>';
                            }
                            else{
                                $this->panelContent_1='An error occurred, please try again later<br><br><br><br>';
                            }
                            }
                            else{
                            $sql='UPDATE user SET usertypeid=2 WHERE userID = "'.$UID.'"';
                            if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                                $this->panelContent_1='The suspension has been lifted from this user acccount<br><br><br><br>';
                            }
                            else{
                                $this->panelContent_1='An error occurred, please try again later<br>';
                            }
                            }
                            
                            break;
                        case ('Change Password'):
                            $this->panelContent_1 = '<form method="post" action="index.php?pageID=userEdit">
                                                    <div class="form-group">
                                                    <label for="Pass1">Enter New Password</label><input required type="password" class="form-control" id="Pass1" name="Pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                                    <label for="Pass2">Re-enter Password</label><input required type="password" class="form-control" id="Pass2" name="Pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">
                                                    <input type="hidden" name="selectedUserID" value="'.$UID.'">
                                                    </div>
                                                    <button type="submit" class="btn btn-secondary" style="float:left; margin-right:3px;" name="btn" value="NewPass">Change</button>
                                                    </form>&nbsp&nbsp';
                            break;
                        case('NewPass'):
                            if(($this->postArray['Pass1'])===($this->postArray['Pass2'])){
                                $password=hash('ripemd160',$this->postArray['Pass1']);
                                $sql='UPDATE user SET password="'.$password.'" WHERE userID = "'.$UID.'"';
                                if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                                    $this->panelContent_1='This password has now been changed<br>';
                                }
                                else{
                                    $this->panelContent_1='An error occurred, please try again later<br><br><br>';
                                }
                            }
                            else{
                                $this->panelContent_1='The passwords <b>Do Not</b> match, please try again';
                                $this->panelContent_1.= '<form method="post" action="index.php?pageID=userEdit">
                                                    <div class="form-group">
                                                    <label for="Pass1">Enter New Password</label><input required type="password" class="form-control" id="Pass1" name="Pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                                    <label for="Pass2">Re-enter Password</label><input required type="password" class="form-control" id="Pass2" name="Pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">
                                                    <input type="hidden" name="selectedUserID" value="'.$UID.'">
                                                    </div>
                                                    <button type="submit" class="btn btn-default" style="float:left; margin-right:3px;" name="btn" value="NewPass">Change</button>
                                                    </form>&nbsp&nbsp';
                            }

                        default:
                            break;
                    }
                }
                else{
                    $this->panelContent_1='Something went wrong. Please return and try again';
                    
                }
                if($this->getUserType($_SESSION['userid'])==1){
                    $this->panelContent_1.='<a href = "'.$_SERVER['PHP_SELF'].'?pageID=usermgmt"><button style="float:center;" class="btn btn-secondary">Return</button></a>';
                    }
                else{
                    $this->panelContent_1.='<a href = "'.$_SERVER['PHP_SELF'].'?pageID=profile"><button style="float:center;" class="btn btn-secondary">Return</button></a>';
                }
                }
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='Please log in to view users. ';                          
                } 
        }
        
        
        private function getUserType($UID){
            $UT='';
            $sql='SELECT usertypeid FROM user WHERE userID = "'.$UID.'"';
            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
                 while ($row = $rs->fetch_assoc()){
                      foreach($row as $key=>$value){
                          $UT=$value;
                      }
                 }
            }
            return $UT;
        }
       
        
        
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
}

