<?php

/**
 * Class: UserController
 * This is the controller for the USER user type
 *
 * 
 * 
 */
class UserController extends Controller {

    //properties
    private $postArray;     //a copy of the content of the $_POST superglobal array
    private $getArray;      //a copy of the content of the $_GET superglobal array
    private $viewData;          //an array containing page content generated using models
    private $controllerObjects;          //an array containing models used by the controller
    private $user; //session object
    private $db;
    private $pageTitle;

    //methods

    function __construct($user,$db) { //constructor   
        parent::__construct($user->getLoggedinState());
        $this->user=$user;
        //initialise all the class properties
        $this->postArray = array();
        $this->getArray = array();
        $this->viewData=array();
        $this->controllerObjects=array();
        $this->user=$user;
        $this->db=$db;
        $this->pageTitle='DocMapper';
    }

//end METHOD - constructor

    public function run() {  // run the controller
        $this->getUserInputs();
        $this->updateView();
    }

//end METHOD - run the controller

    public function getUserInputs() { // get user input
        //
        //This method is the main interface between the user and the controller.
        //
        //Get the $_GET array values
        $this->getArray = filter_input_array(INPUT_GET) ; //used for PAGE navigation
        
        //Get the $_POST array values
        $this->postArray = filter_input_array(INPUT_POST);  //used for form data entry and buttons
        
    }

//end METHOD - get user input

    public function updateView() { //update the VIEW based on the users page selection
        if (isset($this->getArray['pageID'])) { //check if a page id is contained in the URL
            switch ($this->getArray['pageID']) {
                case "home":
                    //create objects to generate view content
                    $home = new Home($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']));//home1 not found??
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$home,$navigation);

                   //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    //get the content from the page content model  - put into the $data array for the view:
                    $data['pageTitle'] = $home->getPageTitle();
                    $data['pageHeading'] = $home->getPageHeading();
                    $data['panelHeadLHS'] = $home->getPanelHead_1();
                    //$data['panelHeadRHS'] = $home->getPanelHead_2();// A string containing the LHS panel heading/title
                    $data['stringRHS'] = $home->getPanelContent_2();
                    $data['stringLHS'] = $home->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_2_panel.php';  //load the view
                    break;
                case "documents":             
                    //get the model
                    $documents = new Documents($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']),strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$documents,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $documents->getPageTitle();
                    $data['pageHeading'] = $documents->getPageHeading();
                    $data['panelHeadLHS'] = $documents->getPanelHead_1(); // A string containing the LHS panel heading/title
                    //$data['panelHeadMID'] = $messages->getPanelHead_2();
                    $data['stringLHS'] = $documents->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringMID'] = $messages->getPanelContent_2();     // A string intended of the Left Hand Side of the pag
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                 case "deletedoc":             
                    //get the model
                    $deletedoc = new DeleteDoc($this->user,$this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$deletedoc,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $deletedoc->getPageTitle();
                    $data['pageHeading'] = $deletedoc->getPageHeading();
                    $data['panelHeadLHS'] = $deletedoc->getPanelHead_1(); // A string containing the LHS panel heading/title
                    //$data['panelHeadMID'] = $messages->getPanelHead_2();
                    $data['stringLHS'] = $deletedoc->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringMID'] = $messages->getPanelContent_2();     // A string intended of the Left Hand Side of the pag
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                case "deletemap":             
                    //get the model
                    $deletemap = new DeleteMap($this->user,$this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$deletemap,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $deletemap->getPageTitle();
                    $data['pageHeading'] = $deletemap->getPageHeading();
                    $data['panelHeadLHS'] = $deletemap->getPanelHead_1(); // A string containing the LHS panel heading/title
                    //$data['panelHeadMID'] = $messages->getPanelHead_2();
                    $data['stringLHS'] = $deletemap->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringMID'] = $messages->getPanelContent_2();     // A string intended of the Left Hand Side of the pag
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                 
                case "docupload":             
                    //get the model
                    $docupload = new DocUpload($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']),strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$docupload,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    $data['panelHeadLHS'] = $docupload->getPanelHead_1();
                    $data['pageTitle'] = $docupload->getPageTitle();
                    $data['pageHeading'] = $docupload->getPageHeading();
                    $data['stringLHS'] = $docupload->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                case "keyextract":             
                    //get the model
                    $keyextract = new KeyExtract($this->user, $this->pageTitle,$this->postArray,strtoupper($this->getArray['pageID']), $this->db, strtoupper($this->getArray['pageID']));
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$keyextract,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    $data['panelHeadLHS'] = $keyextract->getPanelHead_1();
                    $data['pageTitle'] = $keyextract->getPageTitle();
                    $data['pageHeading'] = $keyextract->getPageHeading();
                    $data['stringLHS'] = $keyextract->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                 case "keyinsert":             
                    //get the model
                    $keyinsert = new KeyInsert($this->user, $this->pageTitle,$this->postArray,strtoupper($this->getArray['pageID']), $this->db, strtoupper($this->getArray['pageID']));
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$keyinsert,$navigation);
                    //get the content from the model - put into the $data array for the view:
                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    $data['panelHeadLHS'] = $keyinsert->getPanelHead_1();
                    $data['pageTitle'] = $keyinsert->getPageTitle();
                    $data['pageHeading'] = $keyinsert->getPageHeading();
                    $data['stringLHS'] = $keyinsert->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
           
                case "maps":
                    //create objects to generate view content
                    $maps = new Maps($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$maps,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $maps->getPageTitle();
                    $data['pageHeading'] = $maps->getPageHeading();
                    $data['panelHeadLHS'] = $maps->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $maps->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                case "mapview":
                    //create objects to generate view content
                    $mapview = new Mapview($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$mapview,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    //get the content from the page content model  - put into the $data array for the view:
                    $data['pageTitle'] = $mapview->getPageTitle();
                    $data['pageHeading'] = $mapview->getPageHeading();
                    $data['panelHeadRHS'] = $mapview->getPanelHead_2(); // A string containing the RHS panel heading/title
                    $data['panelHeadLHS'] = $mapview->getPanelHead_1(); // A string containing the LHS panel heading/title 
                    $data['stringLHS'] = $mapview->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $data['stringRHS'] = $mapview->getPanelContent_2();     // A string intended of the Right Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/new_map_viewer.php'; //load the view
                    break;
                
                case "mapupdate":
                    //create objects to generate view content
                    $mapUpdate = new MapUpdate($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$mapUpdate,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $mapUpdate->getPageTitle();
                    $data['pageHeading'] = $mapUpdate->getPageHeading();
                    $data['panelHeadLHS'] = $mapUpdate->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $mapUpdate->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                case "docs2map":
                    //create objects to generate view content
                    $docs2map = new docs2map($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$docs2map,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $docs2map->getPageTitle();
                    $data['pageHeading'] = $docs2map->getPageHeading();
                    $data['panelHeadLHS'] = $docs2map->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $docs2map->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                case "mapcreate":
                    //create objects to generate view content
                    $mapcreate = new MapCreate($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$mapcreate,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle'] = $mapcreate->getPageTitle();
                    $data['pageHeading'] = $mapcreate->getPageHeading();
                    $data['panelHeadLHS'] = $mapcreate->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $mapcreate->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;
                
                case 'login':
                    
                    //process the login details from the login form if the button has been pressed
                    if(isset($this->postArray['btnLogin'])){  //check that the login button is pressed
                        $this->loggedin=$this->user->login($this->postArray['userID'], $this->postArray['password']);                       
                        if(!$this->loggedin){  //if login is not successful keep track of login attempts
                            $this->user->setLoginAttempts($this->user->getLoginAttempts()+1); //add 1 to current login attempts
                        }
                    }

                    //create objects to generate view content
                    $login = new Login($this->postArray,$this->pageTitle, strtoupper($this->getArray['pageID']),$this->db,$this->user);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$login,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    $data['pageTitle'] = $login->getPageTitle();
                    $data['pageHeading'] = $login->getPageHeading();
                    $data['panelHeadRHS'] = $login->getPanelHead_2(); // A string containing the RHS panel heading/title

                    $data['stringRHS'] = $login->getPanelContent_2();     // A string intended of the Right Hand Side of the page
                    $data['panelHeadLHS'] = $login->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $login->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view                  

                    break;
                
                case "logout":
                    
                    //Change the login state to false
                    $this->user->logout(FALSE);
                    $this->loggedin=FALSE;

                    //create objects to generate view content
                    $home = new Home($this->user, $this->pageTitle, 'HOME');
                    $navigation = new Navigation($this->user, 'home');
                    array_push($this->controllerObjects,$home,$navigation);

                    //get the content from the navigation model - put into the $data array for the view:
                   //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    //get the content from the page content model  - put into the $data array for the view:
                    $data['pageTitle'] = $home->getPageTitle();
                    $data['pageHeading'] = $home->getPageHeading();
                    $data['panelHeadLHS'] = $home->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringRHS'] = $home->getPanelContent_2();
                    $data['stringLHS'] = $home->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_2_panel.php'; //load the view                  

                    break;
                case "profile":
                    //create objects to generate view content
                    $profile = new Profile($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$profile,$navigation);

                    
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS                                        
                    $data['pageTitle'] = $profile->getPageTitle();
                    $data['pageHeading'] = $profile->getPageHeading();
                    $data['panelHeadLHS'] = $profile->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $profile->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;

               case "userEdit"://to be constructed. 

                    $userEdit = new userEdit($this->user, $this->postArray, $this->pageTitle, strtoupper($this->getArray['pageID']), $this->db);
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$userEdit,$navigation);
                    $data['menuNav'] = $navigation->getMenuNav();
                    $data['pageTitle'] = $userEdit->getPageTitle();
                    $data['pageHeading'] = $userEdit->getPageHeading();
                    $data['panelHeadLHS'] = $userEdit->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringLHS'] = $userEdit->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_1_panel.php'; //load the view
                    break;     
                
                default:
                    //no page selected 
                    //create objects to generate view content
                    $home = new Home($this->user, $this->pageTitle, strtoupper($this->getArray['pageID']));
                    $navigation = new Navigation($this->user, $this->getArray['pageID']);
                    array_push($this->controllerObjects,$home,$navigation);

                   //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    //get the content from the page content model  - put into the $data array for the view:
                    $data['pageTitle'] = $home->getPageTitle();
                    $data['pageHeading'] = $home->getPageHeading();
                    $data['panelHeadLHS'] = $home->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringRHS'] = $home->getPanelContent_2();
                    $data['stringLHS'] = $home->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
                    include_once 'views/view_new_2_panel.php';
                    break;
            }
        } 
        else {//no page selected and NO page ID passed in the URL 
            //no page selected - default loads HOME page
            //create objects to generate view content
            $home = new Home($this->user, $this->pageTitle, 'HOME');
            $navigation = new Navigation($this->user, 'home');
            array_push($this->controllerObjects,$home,$navigation);

           //get the content from the navigation model - put into the $data array for the view:
                    $data['menuNav'] = $navigation->getMenuNav();       // an array of menu items and associated URLS
                    //get the content from the page content model  - put into the $data array for the view:
                    $data['pageTitle'] = $home->getPageTitle();
                    $data['pageHeading'] = $home->getPageHeading();
                    $data['panelHeadLHS'] = $home->getPanelHead_1(); // A string containing the LHS panel heading/title
                    $data['stringRHS'] = $home->getPanelContent_2();
                    $data['stringLHS'] = $home->getPanelContent_1();     // A string intended of the Left Hand Side of the page
                    $this->viewData = $data;  //put the content array into a class property for diagnostic purposes
                    //update the view
            include_once 'views/view_new_2_panel.php';  //load the view
        }
    }

//end METHOD - update the VIEW based on the users page selection

    
    

    public function debug() {   //Diagnostics/debug information - dump the application variables if DEBUG mode is on
            echo '<section>';
            echo '<!-- The Debug SECTION -->';
            echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV

            echo '<h2>USER Controller Class - Debug information</h2><br>';

            echo '<div class="container">';  //INNER DIV
            //SECTION 1
            echo '<section style="background-color: #AAAAAA">';
            echo '<h3>Student Controller (CLASS) properties</h3>';
            echo '<section style="background-color: #BBBBB">';
            echo '<h4>User Logged in Status:</h4>';
            echo '<section style="background-color: #FFFFFF">';
            if ($this->loggedin) {
                echo 'User Logged In state is TRUE ($loggedin) <br>';
            } else {
                echo 'User Logged In state is FALSE ($loggedin) <br>';
            }
            echo '</section>';

            echo '<h4>$postArray Values</h4>';
            echo '<pre>';
            var_dump($this->postArray);
            echo '</pre>';
            echo '<br>';

            echo '<h4>$getArray Values</h4>';
            echo '<pre>';
            var_dump($this->getArray);
            echo '</pre>';
            echo '<br>';

            echo '<h4>$data Array Values</h4>';
            echo '<pre>';
            var_dump($this->viewData);
            echo '</pre>';
            echo '<br>';
            echo '</section>';
            echo '</section>';
            echo '<h1>ID Variable Contains:</h1>';
            var_dump($IDVar);
            
            


            //SECTION 2
            echo '<section style="background-color: #AAAAAA">';
            echo '<h3>SERVER - Super Global Arrays</h3>';

            echo '<section style="background-color: #AAAAAA">';
            echo '<h4>$_GET Arrays</h4>';
            echo '<section style="background-color: #FFFFFF">';
            echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
            foreach ($_GET as $key => $value) {
                echo '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            echo '</table>';
            echo '</section>';

            echo '<h4>$_POST Array</h4>';
            echo '<section style="background-color: #FFFFFF">';
            echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
            foreach ($_POST as $key => $value) {
                echo '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            echo '</table>';
            echo '</section>';
            echo '</section>';
            echo '</section>';

            echo '</div>';  //END INNER DIV
            echo '</div>';  //END outer DIV
            echo '</section>';
        
    }

// end METHOD - Diagnostics/debug information       
    
}

//end CLASS
