<?php
	$lang = null;
	$ismusical = null;

	if(isset($_GET["is_musical"]))
		$ismusical = $_GET["is_musical"];

	if(isset($_GET['lang']))
		$lang = $_GET['lang'];

	$hymns = [];

	$titles = [
			"All to Jesus I surrender", 
			"Amazing Grace", 
			"At calvary",
			"Blessed Assurance",
			"Have you been to Jesus for the cleansing power",
			"I hear the Savior say",
			"I'm pressing on the upward way",
			"It is well with my soul",
			"Just as I am",
			"My Father God, when on Thy vast creation",
			"O Come all Ye Faithfull",
			"Pass me not, O gentle Savior",
			"Rock of ages, cleft for me",
			"Stand up stand up for Jesus",
			"Tis' so sweet to trust in Jesus",
			"Would you be free from your burden of sin",
			"What can wash away my sin"];


	$swtitles = [
			"Yote namtolea Yesu", 
			"Katika neema ya Yesu", 
			"Kwa kalvari",
			"Ndiyo dhamana",
			"Wamwendea Yesu kwa kusafiwa",
			"Nasikia kuitwa",
			"Mbele ninaendelea",
			"Salama Moyoni",
			"Nitwae hivi nilivyo",
			"Bwana Mungu nashangaa kabisa",
			"Njoni tumuabudu",
			"Usinipite mwokozi",
			"Mwamba wenye imara",
			"Stand up stand up for Jesus",
			"Mteteeni Yesu",
			"Kumtegemea Mwokozi",
			"Sioshwi dhambi zangu"];

	class Hymn {
        public $name = "";
        public $src = "";
        private $lyrics;
        public $short_desc;
        private $hymn_code = null;
        private $composer = "";
        private $author = "";
        private $key = "";
        private $meter = "";
        private $time = "";

        public function setExtras($key, $composer, $author, $meter, $time){
	    	$this->$key 		= $key;
	        $this->$composer 	= $composer;
	        $this->$author 		= $author;
	        $this->$meter 		= $meter;
	        $this->$time 		= $time;
        }
    }

    class Ubeti {
        public $type = ""; //chorus / verse
        public $content = "";

        public function __construct($type, $content) {
			$this->type = $type;
			$this->content = $content;
        }
    }

    for ($i=0; $i < count($titles); $i++) { 
    	$lyrics = [];
    	$verse1 = new Ubeti("verse", "Have you been to Jesus for the cleansing pow’r?<br/>Are you washed in the blood of the Lamb?<br/>Are you fully trusting in His grace this hour?<br/>Are you washed in the blood of the Lamb?<br/>");
    	$chorus = new Ubeti("chorus", "Are you washed in the blood,<br/>In the soul-cleansing blood of the Lamb?<br/>Are your garments spotless? Are they white as snow?<br/>Are you washed in the blood of the Lamb?<br/>");
    	$verse2 = new Ubeti("verse", "Are you walking daily by the Savior’s side?<br/>Are you washed in the blood of the Lamb?<br/>Do you rest each moment in the Crucified?<br/>Are you washed in the blood of the Lamb?<br/>");
  
    	if($lang == "sw"){
	    	$verse1 = new Ubeti("verse", "Wamwendea Yesu kwa kusafiwa,<br/>Na kuoshwa kwa damu ya kondoo?<br/>Je, neema yake umemwagiwa? Umeoshwa kwa damu ya kondoo?<br/>");
	    	$chorus = new Ubeti("chorus", "Kuoshwa, kwa damu,<br/>Itutakasayo ya kondoo,<br/>Ziwe safi nguo nyeupe mno,<br/>Umeoshwa kwa damu ya kondoo?<br/>");
	    	$verse2 = new Ubeti("verse", "Wamwandama daima Mkombozi,<br/>Na kuoshwa kwa damu ya kondoo?<br/>Yako kwa Msulubiwa makazi,<br/>Umeoshwa kwa damu ya kondoo?<br/>");
    	}

    	array_push($lyrics, $verse1);

		$hymn = new Hymn();
		$hymn->src = getSrc($i, $titles);
		// $hymn->lyrics = $lyrics;
		$hymn->name = $titles[$i];

		if($lang == "sw"){
			$hymn->name = $swtitles[$i];
		}

		$hymn->short_desc = getShortDesc($hymn->name, $chorus->content);

		array_push($hymns, $hymn);
    }

    function getShortDesc($name, $chorus){
    	$desc = $name." ".strtolower(str_replace("<br/>", " ", $chorus));

    	if(strlen($desc) > 50)
    		return substr($desc, 0, 50)."...";
    	else
    		return $desc;
    }

    function getSrc($idx, $titles){
    	$fullsrc = $titles[$idx];
    	$lowersrc = strtolower($fullsrc);
    	$trimmedsrc = str_replace("'", "", $lowersrc);
    	$trimmedsrcfur = str_replace(" ", "_", $trimmedsrc);

    	return $trimmedsrcfur.".mp3";
    }

    if($ismusical == null || $lang == null)
    	echo json_encode($titles);
    else
    	echo json_encode($hymns);