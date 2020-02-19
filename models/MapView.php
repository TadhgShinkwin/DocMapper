<?php
/**
 * Class: UnderConstruction
 * This is a template/empty class that provides 'under construction' content.
 * 
 * It handles bot logged in and not logged in use cases. 
 *
 * 
 * 
 */

class Mapview extends Model{
	
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $panelHead_2;
        private $panelContent_2;
        private $db;
        private $get;
        
        
 
	
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
            $this->get=$_GET;
            
            //set the FIRST panel content
            $this->setPanelHead_1();
            $this->setPanelContent_1();
            
            

            //set the DECOND panel content
            $this->setPanelHead_2();
            $this->setPanelContent_2();
        

	}
      
        //setter methods
        public function setPageTitle($pageTitle){ //set the page title    
                $this->pageTitle=$pageTitle;
        }  //end METHOD -   set the page title       

        public function setPageHeading($pageHead){ //set the page heading  
                $this->pageHeading='MAP';
        }  //end METHOD -   set the page heading
        
        //Panel 1
        public function setPanelHead_1(){//set the panel 1 heading
            if($this->loggedin){
                $this->panelHead_1='Toolbar';   
            }
            else{        
                $this->panelHead_1='Toolbar'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
             if(@$this->get['mapid']){          
                $mapid=$this->get['mapid'];
             }
             else{
                 $mapid=$this->postArray['mapid'];
             }
            
            if($this->checkEmpty($mapid)){
                $this->panelContent_1='<p style="text-decoration:underline; text-align:center; font-style:italic;">This map is empty</p><br>';
            }
            else{
                  
            $two=$this->setNums($mapid)[2];
            $three=$this->setNums($mapid)[3];
            $four=$this->setNums($mapid)[4];
            $five=$this->setNums($mapid)[5];
            $one=$this->setNums($mapid)[1];
             if (@$this->get['oneNum']){
                $temp=$one;
                
                switch($this->get['oneNum']){
                    case (2):
                        $one=$two;
                        $two=$temp;
                        break;
                    case (3):
                        $one=$three;
                        $three=$temp;
                        break;
                    case (4):
                        $one=$four;
                        $four=$temp;
                        break;
                    case (5):
                        $one=$five;
                        $five=$temp;
                        break;
                    default:
                        $one=$one;
                        $two=$two;
                }
            }
            else{
               $one=$this->setNums($mapid)[1];
        }
            
            if (@$this->get['docNum']){
                $comparative = $this->get['docNum'];
            }
            else{
            $comparative=$two;
            }
            }
            if($this->loggedin){  //display the calculator form
                
                if($this->checkEmpty($mapid)){
                    $this->panelContent_1.= '<form style="display:inline-block; float:center;" action="index.php?pageID=mapupdate" method="POST"><input type="hidden" name="mapid" value="'.$mapid.'"/><input style="float:center;" type="submit" value="Update Map"/></form>';
                }
                else{
                    $this->panelContent_1 = '';
                    $this->panelContent_1.= '<div style="float:center; text-align:center;" class="">';
                    $this->panelContent_1.= $this->showMapDocs($mapid,$one,$two,$three,$four,$five);
                    $this->panelContent_1.= '<div class=""><form   action="index.php?pageID=mapupdate" method="POST"><input type="hidden" name="mapid" value="'.$mapid.'"/><input  type="submit" value="Update Docs"/></form></div>';
                    $this->panelContent_1.= '</div>';
                    $this->panelContent_1.= '<br>';
                    $this->panelContent_1.= '<div class="row">';
                
                    
                    
                if(!$this->noMatch($this->getDocID($one, $mapid),$this->getDocID($comparative, $mapid))){
//                      
                    $this->panelContent_1.= '<div class="keylist-head"><hr>Common Keywords Between <b>'.$this->docName($this->getDocID($one, $mapid), $_SESSION['userid']).'</b> and <b>'.$this->docName($this->getDocID($comparative, $mapid), $_SESSION['userid']).'</b></div>';
                    $this->panelContent_1.='<ul class="list group list-group-flush keylist">';
                    $this->panelContent_1.= $this->showMatchedKeys($this->getDocID($one, $mapid),$this->getDocID($comparative, $mapid));
                    $this->panelContent_1.='</ul>';
                }
                else{
                    $this->panelContent_1.= '<div class="keylist-head" ><hr>There are no common keywords between <b>'.$this->docName($this->getDocID($one, $mapid), $_SESSION['userid']).'</b> and <b>'.$this->docName($this->getDocID($comparative, $mapid), $_SESSION['userid']).'</b></div>';
                }
   
                    $this->panelContent_1.= '</div>';
            } }  
                else{ //if user is not logged in they see some info about bootstrap                
                    $this->panelContent_1='';                          
                } 
        }//end METHOD - //set the panel 1 content        

        //Panel 2
        public function setPanelHead_2(){ //set the panel 2 heading
            if($this->loggedin){
                if($this->postArray['mapid']){
                    $this->panelHead_2='<h3 style="text-align:center; text-decoration:underline; margin:2px;"><b>'.$this->mapName($this->postArray['mapid'], $_SESSION['userid']).'</b></h3><br><br>';
                }
                else{
                    $this->panelHead_2='<h1 style="text-align:center;">'.$this->mapName($this->get['mapid'], $_SESSION['userid']).'</h1>';
                }
            }
            else{        
                $this->panelHead_2='Map'; 
            }
        }//end METHOD - //set the panel 2 heading     
        
        public function setPanelContent_2(){//set the panel 2 content
            
            if($this->loggedin){

            if(@$this->get['mapid']){          
                $mapid=$this->get['mapid'];
             }
             else{
                 $mapid=$this->postArray['mapid'];
             }
            if($this->checkEmpty($mapid)){
                $this->panelContent_2='<h3>There are no Documents in this map, please select \'Update Map\'</h3>';
            }
                
            else{    
            $two=$this->setNums($mapid)[2];
            $three=$this->setNums($mapid)[3];
            $four=$this->setNums($mapid)[4];
            $five=$this->setNums($mapid)[5];
            $one=$this->setNums($mapid)[1];
             if (@$this->get['oneNum']){
                $temp=$one;
                switch($this->get['oneNum']){
                    case (2):
                        $one=$two;
                        $two=$temp;
                        break;
                    case (3):
                        $one=$three;
                        $three=$temp;
                        break;
                    case (4):
                        $one=$four;
                        $four=$temp;
                        break;
                    case (5):
                        $one=$five;
                        $five=$temp;
                        break;
                    default:
                        $one=$one;
                        $two=$two;
                }
            }
            else{
               $one=$this->setNums($mapid)[1];
        }
        

            $twocolour='#000000';//#ff000000
            $threecolour='#000000';
            $fourcolour='#000000';
            $fivecolour='#000000';

        
            $map='<div style="padding-bottom:-600px;"class="map-container"><svg
                       xmlns:dc="http://purl.org/dc/elements/1.1/"
                       xmlns:cc="http://creativecommons.org/ns#"
                       xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                       xmlns:svg="http://www.w3.org/2000/svg"
                       xmlns="http://www.w3.org/2000/svg"
                       xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                       xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                       width="210mm"
                       height="297mm"
                       viewBox="0 0 210 297"
                       version="1.1"
                       id="svg8"
                       inkscape:version="0.92.3 (2405546, 2018-03-11)"
                       sodipodi:docname="simple1-3map.svg">
                      <defs
                         id="defs2" />
                      <sodipodi:namedview
                         id="base"
                         pagecolor="#ffffff"
                         bordercolor="#666666"
                         borderopacity="1.0"
                         inkscape:pageopacity="0.0"
                         inkscape:pageshadow="2"
                         inkscape:zoom="0.98994949"
                         inkscape:cx="152.50539"
                         inkscape:cy="937.18263"
                         inkscape:document-units="mm"
                         inkscape:current-layer="layer1"
                         showgrid="false"
                         inkscape:measure-start="95.9645,645.487"
                         inkscape:measure-end="495.533,553.756"
                         inkscape:window-width="1920"
                         inkscape:window-height="1001"
                         inkscape:window-x="-9"
                         inkscape:window-y="-9"
                         inkscape:window-maximized="1" />
                      <metadata
                         id="metadata5">
                        <rdf:RDF>
                          <cc:Work
                             rdf:about="">
                            <dc:format>image/svg+xml</dc:format>
                            <dc:type
                               rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                            <dc:title />
                          </cc:Work>
                        </rdf:RDF>
                      </metadata>
                      <g
                         inkscape:label="Layer 1"
                         inkscape:groupmode="layer"
                         id="layer1">
                        <g
                           id="g134"
                           transform="matrix(0.31718307,0,0,0.30721977,34.017405,64.24737)">
                          <g
                             id="g73">
                            <path
                               id="path61"
                               d="m 42.5,22 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path63"
                               d="m 17.5,16 h 10 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 h -10 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path65"
                               d="m 42.5,30 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path67"
                               d="m 42.5,38 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path69"
                               d="m 42.5,46 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path71"
                               d="M 38.914,0 H 6.5 v 60 h 47 V 14.586 Z M 39.5,3.414 50.086,14 H 39.5 Z M 8.5,58 V 2 h 29 v 14 h 14 v 42 z"
                               inkscape:connector-curvature="0" />
                          </g>
                          <g
                             id="g75" />
                          <g
                             id="g77" />
                          <g
                             id="g79" />
                          <g
                             id="g81" />
                          <g
                             id="g83" />
                          <g
                             id="g85" />
                          <g
                             id="g87" />
                          <g
                             id="g89" />
                          <g
                             id="g91" />
                          <g
                             id="g93" />
                          <g
                             id="g95" />
                          <g
                             id="g97" />
                          <g
                             id="g99" />
                          <g
                             id="g101" />
                          <g
                             id="g103" />
                        </g>
                        <g class="';
                           $map.=$this->docCheck1($two, $mapid);
                           $map.='" id="g134-1"
                           transform="matrix(0.31718307,0,0,0.30721977,170.79499,0.08087305)">
                          <g
                             id="g73-7">
                            <path
                               id="path61-7"
                               d="m 42.5,22 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path63-6"
                               d="m 17.5,16 h 10 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 h -10 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path65-4"
                               d="m 42.5,30 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path67-4"
                               d="m 42.5,38 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path69-0"
                               d="m 42.5,46 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path71-0"
                               d="M 38.914,0 H 6.5 v 60 h 47 V 14.586 Z M 39.5,3.414 50.086,14 H 39.5 Z M 8.5,58 V 2 h 29 v 14 h 14 v 42 z"
                               inkscape:connector-curvature="0" />
                          </g>
                          <g
                             id="g75-4" />
                          <g
                             id="g77-8" />
                          <g
                             id="g79-8" />
                          <g
                             id="g81-5" />
                          <g
                             id="g83-9" />
                          <g
                             id="g85-3" />
                          <g
                             id="g87-4" />
                          <g
                             id="g89-7" />
                          <g
                             id="g91-4" />
                          <g
                             id="g93-2" />
                          <g
                             id="g95-4" />
                          <g
                             id="g97-5" />
                          <g
                             id="g99-8" />
                          <g
                             id="g101-5" />
                          <g
                             id="g103-1" />
                        </g>
                        <g class="';
                           $map.=$this->docCheck1($five, $mapid);
                           $map.='" id="g134-3"
                           transform="matrix(0.31718307,0,0,0.30721977,170.68554,117.10291)">
                          <g
                             id="g73-67">
                            <path
                               id="path61-70"
                               d="m 42.5,22 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path63-59"
                               d="m 17.5,16 h 10 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 h -10 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path65-7"
                               d="m 42.5,30 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path67-42"
                               d="m 42.5,38 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path69-3"
                               d="m 42.5,46 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path71-07"
                               d="M 38.914,0 H 6.5 v 60 h 47 V 14.586 Z M 39.5,3.414 50.086,14 H 39.5 Z M 8.5,58 V 2 h 29 v 14 h 14 v 42 z"
                               inkscape:connector-curvature="0" />
                          </g>
                          <g
                             id="g75-9" />
                          <g
                             id="g77-4" />
                          <g
                             id="g79-0" />
                          <g
                             id="g81-2" />
                          <g
                             id="g83-3" />
                          <g
                             id="g85-0" />
                          <g
                             id="g87-8" />
                          <g
                             id="g89-6" />
                          <g
                             id="g91-16" />
                          <g
                             id="g93-0" />
                          <g
                             id="g95-0" />
                          <g
                             id="g97-9" />
                          <g
                             id="g99-89" />
                          <g
                             id="g101-1" />
                          <g
                             id="g103-8" />
                        </g>
                        <g  class="';
                           $map.=$this->docCheck1($three, $mapid);
                           $map.='" id="g134-1-5"
                           transform="matrix(0.31718307,0,0,0.30721977,170.79499,39.024023)">
                          <g
                             id="g73-7-9">
                            <path
                               id="path61-7-0"
                               d="m 42.5,22 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path63-6-7"
                               d="m 17.5,16 h 10 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 h -10 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path65-4-8"
                               d="m 42.5,30 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path67-4-5"
                               d="m 42.5,38 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path69-0-6"
                               d="m 42.5,46 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path71-0-0"
                               d="M 38.914,0 H 6.5 v 60 h 47 V 14.586 Z M 39.5,3.414 50.086,14 H 39.5 Z M 8.5,58 V 2 h 29 v 14 h 14 v 42 z"
                               inkscape:connector-curvature="0" />
                          </g>
                          <g
                             id="g75-4-5" />
                          <g
                             id="g77-8-1" />
                          <g
                             id="g79-8-9" />
                          <g
                             id="g81-5-7" />
                          <g
                             id="g83-9-2" />
                          <g
                             id="g85-3-4" />
                          <g
                             id="g87-4-7" />
                          <g
                             id="g89-7-5" />
                          <g
                             id="g91-4-8" />
                          <g
                             id="g93-2-4" />
                          <g
                             id="g95-4-8" />
                          <g
                             id="g97-5-5" />
                          <g
                             id="g99-8-2" />
                          <g
                             id="g101-5-0" />
                          <g
                             id="g103-1-3" />
                        </g>
                        <g  class="';
                           $map.=$this->docCheck1($four, $mapid);      
                           $map.='" id="g134-1-4"
                           transform="matrix(0.31718307,0,0,0.30721977,170.68553,78.159746)">
                          <g
                             id="g73-7-6">
                            <path
                               id="path61-7-3"
                               d="m 42.5,22 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path63-6-5"
                               d="m 17.5,16 h 10 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 h -10 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path65-4-2"
                               d="m 42.5,30 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path67-4-8"
                               d="m 42.5,38 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path69-0-65"
                               d="m 42.5,46 h -25 c -0.552,0 -1,0.447 -1,1 0,0.553 0.448,1 1,1 h 25 c 0.552,0 1,-0.447 1,-1 0,-0.553 -0.448,-1 -1,-1 z"
                               inkscape:connector-curvature="0" />
                            <path
                               id="path71-0-2"
                               d="M 38.914,0 H 6.5 v 60 h 47 V 14.586 Z M 39.5,3.414 50.086,14 H 39.5 Z M 8.5,58 V 2 h 29 v 14 h 14 v 42 z"
                               inkscape:connector-curvature="0" />
                          </g>
                          <g
                             id="g75-4-2" />
                          <g
                             id="g77-8-8" />
                          <g
                             id="g79-8-3" />
                          <g
                             id="g81-5-2" />
                          <g
                             id="g83-9-1" />
                          <g
                             id="g85-3-46" />
                          <g
                             id="g87-4-2" />
                          <g
                             id="g89-7-0" />
                          <g
                             id="g91-4-9" />
                          <g
                             id="g93-2-7" />
                          <g
                             id="g95-4-84" />
                          <g
                             id="g97-5-8" />
                          <g
                             id="g99-8-25" />
                          <g
                             id="g101-5-7" />
                          <g
                             id="g103-1-8" />
                        </g>
                        <path id="path1" class="';
                           $map.=$this->docCheck($two, $one, $mapid);
                           $map.='" style="fill:none;fill-rule:evenodd;stroke:';
                           $map.=$twocolour;    #000000
                           $map.=';stroke-width:0.31216165px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                           d="M 50.986699,69.967159 172.85668,12.79427"
                           id="path7899"
                           inkscape:connector-curvature="0"
                           inkscape:connector-type="polyline"
                           inkscape:connection-start="#g134"
                           inkscape:connection-end="#g134-1" />
                        <path id="path2" class="';
                           $map.=$this->docCheck($three,$one, $mapid);
                           $map.='" style="fill:none;fill-rule:evenodd;stroke:';
                           $map.=$threecolour;    #000000
                           $map.=';stroke-width:0.31216165px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                           d="M 50.986699,72.089397 172.85668,49.615183"
                           id="path7903"
                           inkscape:connector-curvature="0"
                           inkscape:connector-type="polyline"
                           inkscape:connection-start="#g134"
                           inkscape:connection-end="#g134-1-5" />
                        <path id="path3" class="';
                           $map.=$this->docCheck($four,$one, $mapid);
                           $map.='" style="fill:none;fill-rule:evenodd;stroke:';
                           $map.=$fourcolour;    #000000
                           $map.=';stroke-width:0.31216165px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                           d="M 50.986699,74.222736 172.74722,86.617566"
                           id="path7907"
                           inkscape:connector-curvature="0"
                           inkscape:connector-type="polyline"
                           inkscape:connection-start="#g134"
                           inkscape:connection-end="#g134-1-4" />
                        <path id="path4" class="';
                           $map.=$this->docCheck($five,$one, $mapid);
                           $map.='" style="fill:none;fill-rule:evenodd;stroke:';
                           $map.=$fivecolour;    #000000
                           $map.=';stroke-width:0.31216165px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                           d="M 50.986699,76.346674 172.74723,123.43679"
                           id="path7911"
                           inkscape:connector-curvature="0"
                           inkscape:connector-type="polyline"
                           inkscape:connection-start="#g134"
                           inkscape:connection-end="#g134-3" />
                        <ellipse id="ellipse1" class="';
                           $map.=$this->docCheck($two,$one, $mapid);
                           $map.='" style="fill:';
                           $map.=$twocolour;//#000000
                           $map.=';fill-opacity:0.8745098;stroke:#1e364e;stroke-width:0.31216165;stroke-opacity:0.89349042"
                           id="path7917"
                           cx="113.05593"
                           cy="40.627407"
                           rx="3.5964065"
                           ry="3.4834368"/>
                        <ellipse id="ellipse2" class="';
                           $map.=$this->docCheck($three,$one, $mapid);
                           $map.='" style="fill:';
                           $map.=$threecolour;//#000000
                           $map.=';fill-opacity:0.8745098;stroke:#1e364e;stroke-width:0.31216165;stroke-opacity:0.89349042"
                           id="path7917-3"
                           cx="113.05593"
                           cy="60.694717"
                           rx="3.5964065"
                           ry="3.4834368" />"/>
                         
                          <ellipse id="ellipse3" class="';
                           $map.=$this->docCheck($four,$one, $mapid);
                           $map.='" style="fill:';
                           $map.=$fourcolour;//#000000
                           $map.=';fill-opacity:0.8745098;stroke:#1e364e;stroke-width:0.31216165;stroke-opacity:0.89349042"
                           id="path7917-2"
                           cx="113.05593"
                           cy="80.486359"
                           rx="3.5964065"
                           ry="3.4834368" />
                        
                           <ellipse id="ellipse4" class="';
                           $map.=$this->docCheck($five,$one, $mapid);
                           $map.='" style="fill:';
                           $map.=$fivecolour;//#000000
                           $map.=';fill-opacity:0.8745098;stroke:#1e364e;stroke-width:0.31216165;stroke-opacity:0.89349042"
                           id="path7917-6"
                           cx="113.05593"
                           cy="100.36792"
                           rx="3.5964065"
                           ry="3.4834368" /></a>
                        <flowRoot
                           xml:space="preserve"
                           id="flowRoot7960"
                           style="font-style:normal;font-weight:normal;font-size:40px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#0000ff;fill-opacity:1;stroke:none"
                           transform="scale(0.26458333)"><flowRegion
                             id="flowRegion7962"
                             style="fill:#0000ff"><rect
                               id="rect7964"
                               width="160.61426"
                               height="207.08127"
                               x="-405.07117"
                               y="107.31638"
                               style="fill:#0000ff" /></flowRegion><flowPara
                             id="flowPara7966" /></flowRoot>    <flowRoot
                           xml:space="preserve"
                           id="flowRoot8797"
                           style="font-style:normal;font-weight:normal;font-size:16px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none"
                           transform="scale(0.26458333)"><flowRegion
                             id="flowRegion8799"
                             style="font-size:16px"><rect
                               id="rect8801"
                               width="225.26402"
                               height="134.35028"
                               x="81.822357"
                               y="375.00681"
                               style="font-size:16px" /></flowRegion><flowPara
                             id="flowPara8803"></flowPara></flowRoot>    <flowRoot
                           xml:space="preserve"
                           id="flowRoot8827"
                           style="font-style:normal;font-weight:normal;font-size:40px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none"
                           transform="scale(0.26458333)"><flowRegion
                             id="flowRegion8829"><rect
                               id="rect8831"
                               width="186.87822"
                               height="207.08127"
                               x="-430.32498"
                               y="-21.983149" /></flowRegion><flowPara
                             id="flowPara8833"></flowPara></flowRoot>    <flowRoot
                           xml:space="preserve"
                           id="flowRoot8835"
                           style="font-style:normal;font-weight:normal;font-size:40px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none"
                           transform="scale(0.26458333)"><flowRegion
                             id="flowRegion8837"><rect
                               id="rect8839"
                               width="144.4518"
                               height="252.53815"
                               x="-548.51282"
                               y="212.37224" /></flowRegion><flowPara
                             id="flowPara8841"></flowPara></flowRoot>    <flowRoot
                           xml:space="preserve"
                           id="flowRoot8859"
                           style="font-style:normal;font-weight:normal;font-size:40px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none"
                           transform="scale(0.26458333)"><flowRegion
                             id="flowRegion8861"><rect
                               id="rect8863"
                               width="155.56349"
                               height="60.104076"
                               x="104.04572"
                               y="320.96365" /></flowRegion><flowPara
                             id="flowPara8865"></flowPara></flowRoot>    <text
                           xml:space="preserve"
                           style="font-style:normal;font-weight:normal;font-size:10.58333302px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none;stroke-width:0.26458332"
                           x="28.33057"
                           y="87.594322"
                           id="text8869"><tspan
                             sodipodi:role="line"
                             id="tspan8867"
                             x="28.33057"
                             y="97.249817"
                             style="stroke-width:0.26458332" /></text>
                        <flowRoot
                           xml:space="preserve"
                           id="flowRoot8871"
                           style="font-style:normal;font-weight:normal;font-size:40px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#000000;fill-opacity:1;stroke:none"><flowRegion
                             id="flowRegion8873"><rect
                               id="rect8875"
                               width="128.79445"
                               height="65.154839"
                               x="124.24876"
                               y="318.94333" /></flowRegion><flowPara
                             id="flowPara8877"></flowPara></flowRoot>';
                            $map.=$this->labelMapDocOne($mapid,$one,35,88);
                            $map.=$this->labelMapDocs($mapid,$one,$two,173,23);//'<text x="167" y="23" font-family="Verdana" font-size="5" fill="black">Document 2</text>';
                            $map.=$this->labelMapDocs($mapid,$one,$three, 173, 62.7);//'<text x="167" y="62.7" font-family="Verdana" font-size="5" fill="black">Document 3</text>';
                            $map.=$this->labelMapDocs($mapid,$one,$four, 173, 102);//'<text x="167" y="102" font-family="Verdana" font-size="5" fill="black">Document 4</text>';
                            $map.=$this->labelMapDocs($mapid,$one,$five, 173, 140.8);//'<text x="167" y="140.8" font-family="Verdana" font-size="5" fill="black">Document 5</text>';
               $map.='</g></svg></div>';
              
                
               if($this->docCheck1($one, $mapid)=='visible'){ 
                
                $this->panelContent_2=$map;
                         }
               
               else{
                   $this->panelContent_2='Please upload documents to map';
               }

            }}  
            else{        
                $this->panelContent_2=''; 
            }//end IF
        }
        
        private function showMapDocs($mapid, $one, $two, $three, $four, $five){
        
        $sql1='SELECT doc'.$one.' FROM maps WHERE mapid="'.$mapid.'"';
        $sql2='SELECT doc'.$two.' FROM maps WHERE mapid="'.$mapid.'"';
        $sql3='SELECT doc'.$three.' FROM maps WHERE mapid="'.$mapid.'"';
        $sql4='SELECT doc'.$four.' FROM maps WHERE mapid="'.$mapid.'"';
        $sql5='SELECT doc'.$five.' FROM maps WHERE mapid="'.$mapid.'"';
        $returnString='<div class="docs-map" ><p style="font-style:italic; font-size:20px; text-align:center; text-decoration: underline;">Documents in Map</p><ul style="float:center;  padding-right:0px; padding-left:0px;">';
                if((@$rs=$this->db->query($sql1))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            foreach($row as $key=>$value){
                                    if($value!=null){
                                   $returnString.='<li class="list-group-item" style="text-align: center; ">Examined Document: <b>';
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        //$returnString.='<form action="index.php?pageID=mapview&oneNum=1&mapid='.$mapid.'" method="POST"><input type="hidden" value ="'.$value.'"><input type="submit" value="Examine" ></form>';
                                }
                                
                                $returnString.= '</b></li>'; 
                               }
                            }
                    
                      
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                if((@$rs=$this->db->query($sql2))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { foreach($row as $key=>$value){
                                    if($value!=null){
                                   $returnString.='<li class="list-group-item" style="text-align: center; ">';
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        $returnString.='<form action="index.php?pageID=mapview&oneNum=2&mapid='.$mapid.'" method="POST"><input type="hidden" value ="'.$value.'"><input type="submit" value="Examine" ></form>';
            
                                }
                                
                                $returnString.= '</li>'; 
                               }
                                
                            }
                    
                      
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                if((@$rs=$this->db->query($sql3))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            
                                
                               foreach($row as $key=>$value){
                                    if($value!=null){
                                   $returnString.='<li class="list-group-item" style="text-align: center; ">';
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        $returnString.='<form action="index.php?pageID=mapview&oneNum=3&mapid='.$mapid.'" method="POST"><input type="hidden" value ="'.$value.'"><input type="submit" value="Examine" ></form>';
            
                                }
                                
                                $returnString.= '</li>'; 
                               }
                            }
                    
                      
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                if((@$rs=$this->db->query($sql4))&&($rs->num_rows===1)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            
                                
                               foreach($row as $key=>$value){
                                   if($value!=null){
                                   $returnString.='<li class="list-group-item" style="text-align: center; ">';
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        $returnString.='<form action="index.php?pageID=mapview&oneNum=4&mapid='.$mapid.'" method="POST"><input type="hidden" value ="'.$value.'"><input type="submit" value="Examine" ></form>';
            
                                }
                                
                                $returnString.= '</li>'; 
                               } 
                            }
                    
                      
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                if((@$rs=$this->db->query($sql5))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            foreach($row as $key=>$value){
                                    if($value!=null){
                                   $returnString.='<li class="list-group-item" style="text-align: center; ">';
                                        $docname = $value;
                                       
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
                                        $returnString.='<form action="index.php?pageID=mapview&oneNum=5&mapid='.$mapid.'" method="POST"><input type="hidden" value ="'.$value.'"><input type="submit" value="Examine" ></form>';
            
                                }
                                
                                $returnString.= '</li>'; 
                               }
                            }
                    
                      
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                $returnString.= '</ul></div>'; 
                //free result set memory
                //$rs->free();
                return $returnString;
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
    
     private function labelMapDocs($mapid,$oneNum, $docnum,$x,$y){
        
        $sql='SELECT doc'.$docnum.' FROM maps WHERE mapid="'.$mapid.'" ';
        $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            //$returnString.='<text x="34" y="88" font-family="Verdana" font-size="5" fill="black">';
                            
                        
                            $returnString.='<a href="index.php?pageID=mapview&docNum='.$docnum.'&oneNum='.$oneNum.'&mapid='.$mapid.'">';
                            $returnString.='<text style"text-align:center;" x="'.$x.'" y="'.$y.'" font-family="Verdana" font-size="3" fill="black"';//  onclick="alert(';
                                
                               foreach($row as $key=>$value){
                                        //$docname = $value;
                                        $returnString.='">';//\'Doc ID: '.$value.'\')">';
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
            
                                }
                                
                                $returnString.= '</text>'; 
                                
                            }
                   
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                //free result set memory
                //$rs->free();
                return $returnString;
}
private function labelMapDocOne($mapid, $docnum,$x,$y){
        
        $sql='SELECT doc'.$docnum.' FROM maps WHERE mapid="'.$mapid.'" ';
        $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){ 
                    
                    while ($row = $rs->fetch_assoc()) { 
                            //$returnString.='<text x="34" y="88" font-family="Verdana" font-size="5" fill="black">';
                            
                        
                            
                            $returnString.='<text class="maplabel" style"text-align:center;" x="'.$x.'" y="'.$y.'" font-family="Verdana" font-size="3" fill="black"';//  onclick="alert(';
                                
                               foreach($row as $key=>$value){
                                        //$docname = $value;
                                        $returnString.='">';//\'Doc ID: '.$value.'\')">';
                                        $rando = $this->docName($value, $_SESSION['userid']);
                                        $returnString.=$rando;//change docName function to get map name. at the moment it just prints mapid
            
                                }
                                
                                $returnString.= '</text>'; 
                                
                            }
                   
                    
                    
                }  
                else{  //resultset is empty or something else went wrong with the query

                        $returnString.= '<br>No records available to view - please try again<br>';

                }
                //free result set memory
                //$rs->free();
                return $returnString;
}


private function docCheck1($docnum,$mapid){
    $return='invisible';
    $sql='SELECT doc'.$docnum.' FROM maps WHERE mapid="'.$mapid.'"';
    if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
        while ($row = $rs->fetch_assoc()){
            foreach($row as $key=>$value){
            if($value!=null){
                $return='visible';
            }
            
        }
        }
        
    }
    return $return;
}
private function docCheck($docnum,$one,$mapid){
    
    $return='invisible';

   
    $sql='SELECT doc'.$docnum.' FROM maps WHERE mapid="'.$mapid.'"';
    if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
        while ($row = $rs->fetch_assoc()){           
            foreach($row as $key=>$value){
            if(($value!=null)||($this->noMatch($one, $docnum))){
                $return='visible';
            }
            }
        }
        }
        
    
    return $return;
}
private function setNums($mapid) {
    $sql= mysqli_query($this->db,'SELECT*FROM maps WHERE mapid ="'.$mapid.'"');
    $returnstring='';
    $numArray= array(0,1,2,3,4,5);
    if ($result = mysqli_fetch_array($sql)){
    
    if($result['doc1']!=NULL){
        $numArray = array(0,1,2,3,4,5);
    }   
     
    else if (($result['doc1'] === NULL)&&($result['doc2']!=NULL)) {
        $numArray= array(0,2,1,3,4,5);
        }
    else if (($result['doc2'] === NULL)&&($result['doc3']!=NULL)) {
        $numArray= array(0,3,1,4,2,5);
        }
    else if (($result['doc3'] === NULL)&&($result['doc4']!=NULL)) {
        $numArray= array(0,4,1,5,2,3);
        }
     else if (($result['doc4'] === NULL)&&($result['doc5']!=NULL)) {
        $numArray= array(0,5,1,4,2,3);
        }
    else{
        $returnstring= "Messed up here";
        }
        return $numArray;
}
    else{
        return;
    }
}
private function showMatchedKeys($docid1, $docid2) {
    $resultString='';
    $j=1;
     
    $sql1=mysqli_query($this->db,'SELECT kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10 FROM documents WHERE docid = '.$docid1.'');
    $sql2=mysqli_query($this->db,'SELECT kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10 FROM documents WHERE docid = '.$docid2.'');
    
    $doc1Array = mysqli_fetch_array($sql1);
    $doc2Array = mysqli_fetch_array($sql2);
    $resArray = array();
    
    while ($j<11){
     $i=1;  
    while  ($i<11){
    
    if ($doc1Array['kw'.$i.'']==$doc2Array['kw'.$j.'']){
        $resArray['kw'.$i.'']=$doc1Array['kw'.$i.''];
        $i++;
    }
    else{
        $i++;
    }
    }
    $j++;
    }
    
    
    foreach($resArray as $key=>$value){
      
        $resultString.='<li class="list-group-item">'.$value.'</li>';;
     
    }

    
    return $resultString;
 
}
private function getDocID($num,$mapid){
    $sql = 'SELECT doc'.$num.' FROM maps WHERE mapid = '.$mapid.'';
    $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
                    while ($row = $rs->fetch_assoc()){
                        foreach($row as $key=>$value){
                            $returnString.=$value;
                        }
                    }
                }
                return $returnString;
}
 
    private function checkEmpty($mapid){
        $sql=mysqli_query($this->db,'SELECT doc1,doc2,doc3,doc4,doc5 FROM maps WHERE mapid='.$mapid.'');
        $result = mysqli_fetch_array($sql);
        $returnString='';
        if(($result['doc1'] === NULL)&&($result['doc1'] === NULL)&&($result['doc1'] === NULL)&&($result['doc1'] === NULL)&&($result['doc1'] === NULL)){
            return TRUE;
        }
        
        else{
            return FALSE;
        }    
    }
    
    private function noMatch($docid1, $docid2) {
    $j=1;
     
    $sql1=mysqli_query($this->db,'SELECT kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10 FROM documents WHERE docid = '.$docid1.'');
    $sql2=mysqli_query($this->db,'SELECT kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10 FROM documents WHERE docid = '.$docid2.'');
    
    $doc1Array = mysqli_fetch_array($sql1);
    $doc2Array = mysqli_fetch_array($sql2);
    $resArray = array();
    
    while ($j<11){
     $i=1;  
    while  ($i<11){
    
    if ($doc1Array['kw'.$i.'']==$doc2Array['kw'.$j.'']){
        $resArray['kw'.$i.'']=$doc1Array['kw'.$i.''];
        $i++;
    }
    else{
        $i++;
    }
    }
    $j++;
    }
    if(empty($resArray)){
        return TRUE;
    }
    else{
        return FALSE;
    } 
}
private function mapName($id, $UID){
    $sql='SELECT mapname FROM maps WHERE mapid='.$id.'';
    $returnString='';
                if((@$rs=$this->db->query($sql))&&($rs->num_rows)){
                    while ($row = $rs->fetch_assoc()){
                        foreach($row as $key=>$value){
                            $returnString.=$value;
                        }
                    }
                }
                return $returnString;
}
    

        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getPanelContent_2(){return $this->panelContent_2;}


        
}//end class
        