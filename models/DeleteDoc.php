<?php

class DeleteDoc extends Model{

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
                $this->pageTitle="Delete Document";
        }
        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading='Delete Document';
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='<h3>Delete Document</h3>';   
            }
            else{        
                $this->panelHead_1='<h3>Delete Document</h3>'; 
            }       
        }
         public function setPanelContent_1(){
             $sql='DELETE FROM documents WHERE docid="'.$_POST['docid'].'" LIMIT 1';
             $sql1='UPDATE maps SET doc1=NULL WHERE doc1 = "'.$_POST['docid'].'"';
             $sql2='UPDATE maps SET doc2=NULL WHERE doc2 = "'.$_POST['docid'].'"';
             $sql3='UPDATE maps SET doc3=NULL WHERE doc3 = "'.$_POST['docid'].'"';
             $sql4='UPDATE maps SET doc4=NULL WHERE doc4 = "'.$_POST['docid'].'"';
             $sql5='UPDATE maps SET doc5=NULL WHERE doc5 = "'.$_POST['docid'].'"';
             
             
             
             if(($this->db->multi_query($sql)===TRUE)&&($this->db->affected_rows===1)){
                //$sql="SELECT * FROM user";;
                $this->panelContent_1.='<h3>Your document has now been deleted</h3><br>';
                $this->panelContent_1.='<button> <a href = "'.$_SERVER['PHP_SELF'].'?pageID=documents">Click Here</a></button>';
                
                if (mysqli_multi_query($this->db, $sql1)){
                            $this->panelContent_1.='';}
                if (mysqli_multi_query($this->db, $sql2)){
                            $this->panelContent_1.='';}
                if (mysqli_multi_query($this->db, $sql3)){
                            $this->panelContent_1.='';}
                if (mysqli_multi_query($this->db, $sql4)){
                            $this->panelContent_1.='';}
                if (mysqli_multi_query($this->db, $sql5)){
                            $this->panelContent_1.='';}            
                               
            }
            else{
                $this->panelContent_1.='<h3>Unable to delete document - Please try again</h3><br>';
                
                $this->panelContent_1.='<button> <a href = "'.$_SERVER['PHP_SELF'].'?pageID=documents">Click Here</a></button>';
                            
                        }
             
             
         }


        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}

//$sql='DELETE FROM documents WHERE docid="'.$_POST['docid'].'LIMIT 1';



}
?>
