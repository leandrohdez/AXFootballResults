<?php
	//
	//  AXFootballResults.php
	//  
	//
	//  Created by Leandro Hernandez on 20/06/2014.
	//  Copyright (c) 2014 Leandro Hernandez. All rights reserved.
	//


	include("AXFootballResults.config.php");

	class AXFootballResults{
	
		// Get your API_KEY in the "www.resultados-futbol.com" platform
		// you can get on http://www.resultados-futbol.com/api
		var $API_KEY;
		var $formatRequest 	= CONFIG::JSON_FORMAT;
		var $workingAsAPI 	= CONFIG::WORKING_AS_API;
	
	
		public function AXFootballResults($apiKey=null){
			if($apiKey){
				$this->API_KEY = $apiKey; 
				return;
			}
			$this->isCorrect();
		}
	
	
		public function isCorrect(){
			// url version api
			$result = $this->curlGetContentData($this->createApiUrlRequest());
			$this->formatReturnResult($result);
		}
	
		public function getChampionsLeague(){
			$passedParams = array("req" => "leagues", "country" => "ue");
			$result = $this->curlGetContentData($this->createApiUrlRequest($passedParams));
			$this->formatReturnResult($result["league"][0]);
		}
		
		public function getWorldCup(){
			$passedParams = array("req" => "leagues", "country" => "wo");
			$result = $this->curlGetContentData($this->createApiUrlRequest($passedParams));
			
			$worldCupData = array();
			
			if($result && isset($result["league"][0]["id"])){
				$worldCupData = $result["league"][0];
				$leagueId = $result["league"][0]["id"];
				
				$passedParams = array("req" => "matchs", "league" => $leagueId );
				$result = $this->curlGetContentData($this->createApiUrlRequest($passedParams));
				
				if($result && isset($result["match"])){
					$worldCupData["matchs"] = $result["match"];
				}
			}
			return $this->formatReturnResult($worldCupData);
		}
	
		public function getLeagues(){
			$passedParams = array("req" => "leagues", "country" => "ue");
			$result = $this->curlGetContentData($this->createApiUrlRequest($passedParams));
			die(json_encode($result["league"][0]));
			$this->formatReturnResult($result);
		}
	
	
		private function createApiUrlRequest($params=array()){
			$url = CONFIG::SERVER_URL."?key=".$this->API_KEY."&format=".$this->formatRequest;
			if($params && count($params)>0){
				$urlAditionalsParams = "";
				foreach($params as $param=>$value){
					$urlAditionalsParams .= "&".$param."=".$value;
				}
				$url .= $urlAditionalsParams;
			}
			return $url;
		}
	
		private function curlGetContentData($url=null) {
			if($url){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				//Set curl to return the data instead of printing it to the browser.
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				$data = curl_exec($ch);
				curl_close($ch);
			
				return json_decode($data,true);
			}
			return false;
		}
	
		private function formatReturnResult($data=null){
			// when the library work as api
			if($this->workingAsAPI){
				header('Content-Type: application/'.$this->formatRequest);
				if($data){
					// JSON
					if($this->formatRequest == CONFIG::JSON_FORMAT){
						$result = array("success" => true, "lenght" => count($data), "data" => $data);
						die(json_encode($result));
					}
					// XML
					if($this->formatRequest == CONFIG::XML_FORMAT){
						// TODO: implements xml format return
					}
				}
				else{
					// JSON
					if($this->formatRequest == CONFIG::JSON_FORMAT){
						$result = array("success" => false, "lenght" => 0, "data" => "Invalid request");
						die(json_encode($result));
					}
					// XML
					if($this->formatRequest == CONFIG::XML_FORMAT){
						// TODO: implements xml format return
					}
				}
			}
			
			// when the library NOT work as api
			else{
				return $data;
			}
		}
	
	}

	

	


















?>
