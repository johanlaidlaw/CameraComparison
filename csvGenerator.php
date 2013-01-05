<?php

class csvGenerator {
	
	private $fileHandler;
	public function __construct($file){
		try{
			$this->fileHandler = fopen($file, 'w');	
		}catch(Exception $e){
			print_r($e->getTraceAsString);
		}
	}
	public function __destruct(){
		fclose($this->fileHandler);
	}
	
	public function generate($allCameras){
		foreach($allCameras[0] as $heading => $data){
			fwrite($this->fileHandler, "\n".$heading."\n");
			foreach($data as $name => $value){
				fwrite($this->fileHandler, $name);
				foreach($allCameras as $camera){
					fwrite($this->fileHandler, ',"'.$camera[$heading][$name].'"');
				}
				fwrite($this->fileHandler, "\n");
			}
		}
	}
}