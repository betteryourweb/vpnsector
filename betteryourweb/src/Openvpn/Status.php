<?php 

namespace Betteryourweb\OpenVpn;

class Status {

	public $file = null;
	public $stats = [];

	public function __construct($file = null, $show = 0){

			if($file !== null){
				$this->parseFile($file);
			}

			if($show) print_r($this->stats);
	}

	public function parseFile($file){
		if(!$file || !is_file($file)) die("Error: file doesn't exist");
	    $fileArr = [];
	    $handle = @fopen($file, "r");
	    $section = '';
	    $header = false;
	    $client_list = [];
	    $routing_tbl = [];

        while (($buffer = fgets($handle, 4096)) !== false) {
	        //echo "buffer:: $buffer\n";
	        $buffer  = trim ($buffer);

	        if($buffer != ""){
	        	// echo "$buffer\n";
	        	// Get Section
	            if(preg_match("/OpenVPN CLIENT LIST/i", $buffer)){
	                $section = "client_list";
	                if($section != $client_list) $header = true;

	            }
	            if(preg_match("/ROUTING TABLE/i", $buffer)){
	                $section = "routing_tbl";
	            }
	            if(preg_match("/GLOBAL STATS/i", $buffer)){
	                $section = "global_stats";
	            }
	            if(preg_match("/END/", $buffer)){
	                $section = "end";
	            }

	            if($section === 'client_list'){
	            	if(preg_match("/updated/i", $buffer)){
	            		$chunks = explode(',', $buffer);
	            		$client_list[$chunks[0]] = $chunks[1];
	            	}
	            	elseif(preg_match("/Common Name/i", $buffer)){
	            		$client_list['header'] = explode(',', $buffer);
	            	}
	            	elseif(preg_match("/OpenVPN CLIENT LIST/i", $buffer)){

	            	}
	            	else {
	            		$client_list['clients'][] = explode(',', $buffer);
	            	}
	            }


	            if($section === 'routing_tbl'){
					if(preg_match("/Common Name/i", $buffer)){
	            		$routing_tbl['header'] = explode(',', $buffer);
	            	}
	            	elseif(preg_match("/ROUTING TABLE/i", $buffer)){

	            	}
	            	else {
	            		$routing_tbl['routes'][] = explode(',', $buffer);
	            	}
	            }

	        }
		}

		$this->stats = ["clients" => $client_list, "routes"=>$routing_tbl];
		return $this;
	}

    public function toJson($file = null){

		if($file == null){
			if($this->file == null && count($this->stats) == 0) 
				return die("Error::  No file selected!");
			$file = $this->file;
		}

		$this->stats = (count($this->stats)==0) ? $this->toArray($this->file) : $this->stats;

		return json_encode($this->stats, JSON_PRETTY_PRINT);

    }
}