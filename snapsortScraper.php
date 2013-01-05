<?php
include_once('simple_html_dom.php');

class snapsortScraper {
	
	private $snapsortPages = array();

	public function __construct($snapsortUrls){
		foreach($snapsortUrls as $url){
			$this->snapsortPages[] = file_get_html($url);
		}
	}
	
	public function run(){
		$allCameras = array();
		foreach($this->snapsortPages as $page){
			$cam1 = array();
			$cam2 = array();
			foreach($page->find("table#specs tr") as $tbody){
				if($tbody->find("td h2",0)->plaintext != null){
					$heading = $tbody->find("td h2",0)->plaintext;
					$cam1[$heading] = array();
				}
				if($tbody->find("a",0)->plaintext != null){
					$specName = ($tbody->find("th",0)->plaintext == "")? "Model" : $tbody->find("th",0)->plaintext;
					$cam1[$heading][$specName] = '"'.$tbody->find("a",0)->plaintext.'"';
					$cam2[$heading][$specName] = '"'.$tbody->find("a",1)->plaintext.'"';
				}
			}
			$allCameras[] = $cam1;
			$allCameras[] = $cam2;
		}
		$allCameras = $this->removeDuplicates($allCameras);
		return $allCameras;
	}
	
	public function removeDuplicates($allCameras){
		$uniqueCameraModels = array();
		foreach($allCameras as $index => &$camera){
			if(!in_array($camera['General']['Model'],$uniqueCameraModels))
				$uniqueCameraModels[] = $camera['General']['Model'];
			else
				unset($allCameras[$index]);
		}
		return $allCameras;
	}
	
}