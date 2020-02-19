<?php
/**
 * Class: User
 * 
 * The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
     * User registration
     * User Login
     * User Logout
     * Persisting user session data by keeping the$_SESSION array up to date
 *
 * 
 */
class User extends Model {
    //put your code here
    
    //class properties
    private $session;
    private $db;
    private $userID;
    private $email;
    private $userTypeID;
    private $postArray;

    //constructor
    function __construct($session,$database) 
    {   
        parent::__construct($session->getLoggedinState());
        $this->db=$database;
        $this->session=$session;
        //get properties from the session object
        $this->userID=$session->getUserID();
        $this->email=$session->getEmail();
        $this->userTypeID=$session->getUserTypeID();
        $this->postArray=array();
    }
    //end METHOD - Constructor

    public function login($userID, $password) {
        //This login function checks both the student and lecturer tables for valid login credentials

        //encrypt the password
        $password = hash('ripemd160', $password); //Skip encryption for the moment until I can add users via the site
        
        //set up the SQL query strings
        $SQL1="SELECT userID,email FROM user WHERE userID='$userID' AND password='$password' AND usertypeid=1"; //admins are usertype1. For the meantime, admin=lecturer, user=student
        $SQL2="SELECT userID,email FROM user WHERE userID='$userID' AND password='$password' AND usertypeid=2";//users are usertype 2. Hopefully these statements will differentiate user type

        //execute the queries to get the 2 resultsets
        $rs1=$this->db->query($SQL1); //query th table
        $rs2=$this->db->query($SQL2); //query the student table

        //use the resultsets to determine if login is valid and which type of user has logged on. 
        if(($rs1->num_rows===1)OR($rs2->num_rows===1)){

            if(($rs1->num_rows===1)AND($rs2->num_rows===0)){ //lecturer has logged on
                $row=$rs1->fetch_assoc(); //get the users record from the query result             
                $this->session->setUserID($userID);
                $this->session->setEmail($row['email']);
                $this->session->setUserTypeID('ADMIN'); 
                $this->session->setLoggedinState(TRUE);

                $this->userID=$userID;
                $this->email=$row['email'];
                $this->userTypeID='ADMIN';


                $this->loggedin=TRUE;
                return TRUE;
            }
            elseif (($rs2->num_rows===1)AND($rs1->num_rows===0)){ //student has logged on
                $row=$rs2->fetch_assoc(); //get the users record from the query result             
                $this->session->setUserID($userID);
                $this->session->setEmail($row['email']);
                $this->session->setUserTypeID('GENERAL'); 
                $this->session->setLoggedinState(TRUE);

                $this->userID=$userID;
                $this->email=$row['email'];
                $this->userTypeID='GENERAL';

                $this->loggedin=TRUE;
                return TRUE;
            }
            else {  //something has gone wrong - there should not be duplicate entries in the two tables - student and lecturer
                $this->session->setLoggedinState(FALSE);
                $this->loggedin=FALSE;
                return FALSE;
            }    
        }
        else{ //invalid login credentials entered 
            $this->session->setLoggedinState(FALSE);
            $this->loggedin=FALSE;
            return FALSE;
        }

        //close the resultsets
        $rs1->close();
        $rs2->close();
    }
    //end METHOD - User login

    public function logout(){
        //
        $this->session->logout();
    }
    //end METHOD - User login

    public function register($postArray){
        //get the values entered in the registration form
        $userID=$this->db->real_escape_string($postArray['userID']);
        $email=$this->db->real_escape_string($postArray['email']);
        $password=$this->db->real_escape_string($postArray['password']);
        //$password=$this->db->real_escape_string($postArray['lectPass1']);
        //encrypt the password
        $password = hash('ripemd160', $password);
        //construct the INSERT SQL
        $sql="INSERT INTO user (userID,email,password) VALUES ('$userID','$email','$password')";
        
        //$sql="INSERT INTO lecturer (LectID,FirstName,LastName,PassWord) VALUES ('".$postArray['lectID']."','".$postArray['lectFirstName']."','".$postArray['lectLastName']."','".$postArray['lectPass1']."')";
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //end METHOD - Register User 

    //setters
    public function setLoginAttempts($num){$this->session->setLoginAttempts($num);}  
    
    //getters
    public function getLoggedInState(){return $this->session->getLoggedinState();}//end METHOD - getLoggedInState        
    public function getUserID(){return $this->userID;}
    public function getEmail(){return $this->email;}
    public function getUserTypeID(){return $this->userTypeID;}
    public function getLoginAttempts(){return $this->session->getLoginAttempts();}    
}
