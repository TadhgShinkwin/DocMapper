<?php
/**
 * Class: KeyExtract model
 *
 * 
 * 
 */

class KeyExtract extends Model{
	//class properties
        private $db;
        private $user;
        private $pageTitle;
        private $pageHeading;
        private $postArray;  
        private $panelHead_1;
        private $panelContent_1;
        private $SESSION;
        private $resultString;
        private $extracted;
        private $pageID;
 
	
        
	function __construct($user,$pageTitle,$postArray,$pageHead,$database, $pageID)
	{   
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
                $this->panelHead_1='<h3>Submit Document</h3>'; 
            }
            else{        
                $this->panelHead_1='<h3>Please Log in to Use this feature</h3>'; 
            }       
        }//end METHOD - //set the panel 1 heading
        
        public function setPanelContent_1(){//set the panel 1 content
                 
            
            
            
            $resultString;
            $extracted;
            //require_once ('KeyInsert.php');
            
            if($this->loggedin){
                
            
            
            

                    $resultString = $this->read_file_docx($_FILES['userfile']['tmp_name']);
                    $extracted = $this->extractKeyWords($resultString);
                    
                    if($this->extractKeyWords($resultString)){
                    
                    $this->panelContent_1.='<h2>Extracted Keywords</h2>';

                    $this->panelContent_1.='<form action="index.php?pageID=keyinsert" method="post"';
                    $this->panelContent_1.='<label for="docname">Document Name:&nbsp</label><input type="text" name="docname" value="" pattern=".{2,25}" title="Must be between 2 and 25 characters"required><br><br>';
                    $i=1;
                    foreach ($extracted as $value){
                        //$this->panelContent_1.="$value <br>";
                        $this->panelContent_1.=" <label>".$i."</label>";
                        $this->panelContent_1.=" <input type=\"text\" name=\"keyword".$i."\" value=".$value."  style=\"text-align:left;\" readonly><br>";
                        $i++;
                   }
                   $this->panelContent_1.='<input class="btn-mine" type="submit" value="Submit" name="btn">';
                    $this->panelContent_1.='</form><br>';}
                    else{
                        $this->panelContent_1.='<p>No keywords found. Possible blank or invalid file.</p><br><br><br><br><br><br><br><br>';
                    }

            
           
                
                }
                else{ //if user is not logged in they see some info about bootstrap                                   
                    $this->panelContent_1='<h3>Please Log in to Use this feature</h3>'; 
                   
                } 
        }//end METHOD - //set the panel 1 content        

       
        
        
        
      function extractKeyWords($string) {
      mb_internal_encoding('UTF-8');
      $stopwords = array('a','values','caused','100','100s','completed','step','steps','stepped','figure','figures','identified','belief','differences','outlined','focuses','focus','focused','plan','plans','level','levels','board','boards','ofstagestageend','time','case','business','stage','manager','change','work','cost','discovered','main','appear','key','question','mar','opinion','topic','based','argument','approach','approaches','idea','ideas','thesis','paper','users','days','occur','plan','dec','accessed','areas','associated','pageref','user','view','able','about','above','abst','amp','add','accordance','according','accordingly','across','act','actually','added','adj','affected','affecting','affects','after','afterwards','again','against','ah','all','almost','alone','along','already','also','although','always','am','among','amongst','an','and','announce','another','any','anybody','anyhow','anymore','anyone','anything','anyway','anyways','anywhere','apparently','approximately','are','aren','arent','arise','around','as','aside','ask','asking','at','auth','available','away','awfully','b','back','be','became','because','become','becomes','becoming','been','before','beforehand','begin','beginning','beginnings','begins','behind','being','believe','below','beside','besides','between','beyond','biol','both','brief','briefly','but','by','c','ca','came','can','cannot','can\'t','cause','causes','certain','certainly','co','com','come','comes','contain','folder','containing','contains','could','couldnt','d','date','did','didn\'t','different','do','does','doesn\'t','doing','done','don\'t','down','downwards','due','during','e','each','ed','edu','effect','eg','eight','eighty','either','else','elsewhere','end','ending','enough','especially','et','et-al','etc','even','ever','every','everybody','everyone','everything','everywhere','ex','except','f','far','few','ff','fifth','first','five','fix','followed','following','follows','for','former','formerly','forth','found','four','from','further','furthermore','g','gave','get','gets','getting','give','given','gives','giving','go','goes','gone','got','gotten','h','had','happens','hardly','has','hasn\'t','have','haven\'t','having','he','hed','hence','her','here','hereafter','hereby','herein','heres','hereupon','hers','herself','hes','hi','hid','him','himself','his','hither','home','how','howbeit','however','hundred','i','id','ie','if','i\'ll','im','immediate','immediately','importance','important','in','inc','indeed','index','information','instead','into','invention','inward','is','isn\'t','it','itd','it\'ll','its','itself','i\'ve','j','just','k','keep','keeps','kept','kg','km','know','known','knows','l','largely','last','lately','later','latter','latterly','least','less','lest','let','lets','like','liked','likely','line','little','\'ll','look','looking','looks','ltd','m','made','mainly','make','makes','many','may','maybe','me','mean','means','meantime','meanwhile','merely','mg','might','millionmiss','ml','more','moreover','most','mostly','mr','mrs','much','mug','must','my','myself','n','na','people','
            name','namely','nay','nd','near','nearly','necessarily','necessary','need','needs','neither','never','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','madethe','nor','normally','nos','not','noted','nothing','now','nowhere','o','obtain','obtained','obviously','of','off','often','oh','ok','okay','old','omitted','on','once','one','ones','only','onto','or','ord','other','others','otherwise','ought','our','ours','ourselves','out','outside','over','overall','owing','own','p','page','pages','part','particular','particularly','past','per','perhaps','placed','please','plus','poorly','possible','possibly','potentially','pp','predominantly','present','previously','primarily','probably','promptly','proud','provides','put','q','que','quickly','quite','qv','r','ran','rather','rd','re','readily','really','recent','recently','ref','refs','regarding','regardless','regards','related','relatively','research','respectively','resulted','resulting','results','right','run','s','said','same','saw','say','saying','says','sec','section','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sent','seven','several','shall','she','shed','she\'ll','shes','should','shouldn\'t','show','showed','shown','showns','shows','significant','significantly','similar','similarly','since','six','slightly','so','some','somebody','somehow','someone','somethan','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specifically','specified','specify','specifying','still','stop','strongly','sub','substantially','successfully','such','sufficiently','suggest','sup','sure','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','thered','therefore','therein','there\'ll','thereof','therere','theres','thereto','thereupon','there\'ve','these','they','theyd','they\'ll','theyre','they\'ve','think','this','those','thou','though','thoughh','thousand','throug','through','throughout','thru','thus','til','tip','to','together','too','took','toward','towards','tried','tries','truly','try','trying','ts','twice','two','u','un','under','unfortunately','unless','unlike','unlikely','until','unto','up','upon','ups','us','use','used','useful','usefully','usefulness','uses','using','usually','v','value','various','\'ve','very','via','viz','vol','vols','vs','w','want','want','was','wasnt','way','we','wed','welcome','we\'ll','went','were','werent','we\'ve','what','whatever','what\'ll','whats','when','whence','whenever','where','whereafter','whereas','whereby','wherein','wheres','whereupon','wherever','whether','which','while','whim','whither','who','whod','whoever','whole','who\'ll','whom','whomever','whos','whose','why','widely','willing','wish','with','within','without','wont','words','world','would','wouldnt','www','x','y','yes','yet','you','filtrationsedimentation','youd','you\'ll','your','youre','yours','yourself','yourselves','you\'ve','z','zero',
            'i','all','must','should','but','could','word','fully','each','i\'ve','a','about','very','an','and','type=text','are','as','at','be','by','com','de','en','for','from','how','have','in','is','it','la','lot','most','of','on','or','that','the','this','thing','to','was','what','when','where','who','will','with','und','the','www');
      $string = preg_replace('/[\pP]/u', '', trim(preg_replace('/\s\s+/iu', '', mb_strtolower($string))));
      $matchWords = array_filter(explode(' ',$string) , function ($item) use ($stopwords) { return !($item == '' || in_array($item, $stopwords) || mb_strlen($item) <= 2 || is_numeric($item));});
      $wordCountArr = array_count_values($matchWords);
      arsort($wordCountArr);
      return array_keys(array_slice($wordCountArr, 0, 10));
    }
      
    
    
    
      public function read_file_docx($filename){

        $striped_content = '';
        $content = '';

        if(!$filename || !file_exists($filename)) return false;

        $zip = zip_open($filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        //echo $content;
        //echo "<hr>";
        //file_put_contents('1.xml', $content);        

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
    
    
     public function KeyInsert(){
         if(isset($this->postArray['btn'])){
             
            $UID = $_SESSION['userid'];
            $docname = $this->db->real_escape_string($this->postArray['docname']);
            $keyword1 = $this->db->real_escape_string($this->postArray['keyword1']);
            $keyword2 = $this->db->real_escape_string($this->postArray['keyword2']);
            $keyword3 = $this->db->real_escape_string($this->postArray['keyword3']);
            $keyword4 = $this->db->real_escape_string($this->postArray['keyword4']);
            $keyword6 = $this->db->real_escape_string($this->postArray['keyword6']);
            $keyword7 = $this->db->real_escape_string($this->postArray['keyword7']);
            $keyword8 = $this->db->real_escape_string($this->postArray['keyword8']);
            $keyword9 = $this->db->real_escape_string($this->postArray['keyword9']);
            $keyword10 = $this->db->real_escape_string($this->postArray['keyword10']);
            
            $sql = "INSERT INTO keywords (docid,kw1,kw2,kw3,kw4,kw5,kw6,kw7,kw8,kw9,kw10) ";
            $sql.="VALUES (47,";
            $sql.="'".$keyword1."',";
            $sql.="'".$keyword2."',";
            $sql.="'".$keyword3."',";
            $sql.="'".$keyword4."',";
            $sql.="'".$keyword5."',";
            $sql.="'".$keyword6."',";
            $sql.="'".$keyword7."',";
            $sql.="'".$keyword8."',";
            $sql.="'".$keyword9."',";
            $sql.="'".$keyword10."'";
            $sql.=")";
            
            if(($this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){
                            $sql='SELECT docid,kw1,kw2,kw3,kw4 FROM modules WHERE docid=47';
                            $this->panelContent_1.='<p>New Module Added Successfully: check the db</p></br>';
                            $this->panelContent_1.=$this->dbViewQuery($sql);
         }
     }
     }
        
       

        //getter methods
        public function getPageTitle(){return $this->pageTitle;}
        public function getPageHeading(){return $this->pageHeading;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getPanelContent_1(){return $this->panelContent_1;}
        public function getUser(){return $this->user;}

        
}