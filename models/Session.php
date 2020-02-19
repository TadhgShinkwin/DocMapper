<?php
/**
 * Description of Session
 * 
 * The Session Class is responsible for persistance of user data between page requests. 
 *
 * 
 */
class Session {
    //put your code here
    private $sessionID; //String : containing the PHPSESSID cookie value 
    private $loggedin; //Boolean : TRUE is logged in
    private $userID;
    private $email;
    private $userTypeID;
    private $loginAttempts;
    private $views;  //simple count of the number of page views in the current session
    private $lastViewTimestamp;  //timestamp of the most recent page view
    private $loginTimestamp;  //timestamp of successful login
    
    public function __construct(){
        //set the timestamps
        $this->lastViewTimestamp=date('d/m/Y h:i:s a', time());
        $_SESSION["lastViewTimestamp"]=$this->lastViewTimestamp;

        //get the sessionid from the cookie array
        if (isset($_COOKIE['PHPSESSID'])){
            $this->sessionID=$_COOKIE['PHPSESSID'];
            $_SESSION['sessionID']=$_COOKIE['PHPSESSID'];
        }
        else{
            $this->sessionID=null;
            $_SESSION['sessionID']=null;
        }
              
        //initialise session variables
        if (isset($_SESSION['loggedin'])){
            $this->loggedin=$_SESSION['loggedin'];
        }
        else{
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=FALSE;
          $this->loginTimestamp=null;
          $_SESSION["loginTimestamp"]=$this->loginTimestamp;
          }
          
        if(isset($_SESSION['views'])){  //keep track of the number of page views
            $_SESSION['views'] = $_SESSION['views']+ 1;
            $this->views=$_SESSION['views'];
        }
        else{
             $_SESSION['views'] = 1; 
             $this->views=$_SESSION['views'];
        }

        if (isset($_SESSION['userid'])){
            $this->userID=$_SESSION['userid'];
        }
        else{
          $_SESSION['userid'] = NULL;
          $this->userID=NULL;
          }
         
        if (isset($_SESSION['loginAttempts'])){
            $this->loginAttempts=$_SESSION['loginAttempts'];
        }
        else{
          $_SESSION['loginAttempts'] = 0;
          $this->loginAttempts=0;
          }
          
          
        if (isset($_SESSION['email'])){
            $this->email=$_SESSION['email'];
        }
        else{
          $_SESSION['email'] = NULL;
          $this->email=NULL;
          }
  

        if (isset($_SESSION['usertypeid'])){
            $this->userTypeID=$_SESSION['usertypeid'];
        }
        else{
          $_SESSION['usertypeid'] = NULL;
          $this->userTypeID=NULL;
          }

    }
    
    //setters
    public function setLoggedinState($loggedin){
        //this function can be used to set the logged in state to true or false 
        //when set to false it does not kill the session variables or the session cookie
        //it is used for both successful and failed login attempts
        //
        if($loggedin==TRUE){            
          $_SESSION['loggedin'] = TRUE;
          $this->loggedin= TRUE;  
          $this->loginTimestamp=date('d/m/Y h:i:s a', time());
          $_SESSION["loginTimestamp"]=$this->loginTimestamp;
          
        }
        else{
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=FALSE;          
          $this->setEmail(NULL);
          $this->setUserID(NULL);
          $this->setUserTypeID(NULL);     
        }    
    }
    
    public function logout(){
        //this logout function kills all session variables and expires the session cookie on the client machine
          $this->loggedin=FALSE;          
          $this->setEmail(NULL);
          $this->setUserID(NULL);
          $this->setUserTypeID(NULL);

          
          $_SESSION = array(); //destroy all of the session variables
//          if (ini_get("session.use_cookies")) {
//                $params = session_get_cookie_params();
//                setcookie(session_name(), '', time() - 42000,
//                    $params["path"], $params["domain"],
//                    $params["secure"], $params["httponly"]
//                );
//          }
          session_destroy();

    }
    public function setUserID($userID){$this->userID=$userID;$_SESSION['userid']=$userID;}
    public function setEmail($email){$this->email=$email;$_SESSION['email']=$email;}
    public function setUserTypeID($userTypeID){$this->userTypeID=$userTypeID;$_SESSION['usertypeid'] =$userTypeID;}        
    public function setLoginAttempts($num){
        $this->loginAttempts=$num;
        $_SESSION['loginAttempts']=$num;
    }  

    //getters
    public function getSessionID(){return $this->sessionID;}
    public function getLoggedinState(){return $this->loggedin;}
    public function getUserID(){return $this->userID;}
    public function getEmail(){return $this->email;}
    public function getUserTypeID(){return $this->userTypeID;}
    public function getLoginAttempts(){return $this->loginAttempts;}
    public function getLastPageViewTimestamp(){return $this->lastViewTimestamp;}
    public function getLoginTimestamp(){return $this->loginTimestamp;}
    
}
