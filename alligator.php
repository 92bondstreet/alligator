<?php

/**
 * Alligator
 *
 * regator.com non-official PHP API. PHP plugin for regator.com
 * Search best blogs posts from keywords & get url, title and description
 * http://regator.com/ does not sponsor this API.
 *
 * Copyright (c) 2013 - 92 Bond Street, Yassine Azzout
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Alligator
 * @version 1.0
 * @copyright 2013 - 92 Bond Street, Yassine Azzout
 * @author Yassine Azzout
 * @link http://www.92bondstreet.com Alligator
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

// SwissCode plugin
// Download on https://github.com/92bondstreet/swisscode
require_once('swisscode.php');	

define("REGATOR_URL",'http://regator.com/search/');	
define("RESULTS_PER_PAGE",20);	
 
 //Report all PHP errors
error_reporting(E_ALL);
set_time_limit(0);



class Regator { 
	public $url = "";
	public $title = "";
	public $description = "";
}


class Alligator{
		
	// file dump to log
	private  $enable_log;
	private  $log_file_name = "alligator.log";
	private  $log_file;
	
	
	/**
	 * Constructor, used to input the data
	 *
	 * @param bool $log
	 */
	public function __construct($log=false){
					
		$this->enable_log = $log;
		if($this->enable_log)
			$this->log_file = fopen($this->log_file_name, "w");
		else
			$this->log_file = null;
			
	}
	
	/**
	 * Destructor, free datas
	 *
	 */
	public function __destruct(){
	
		// and now we're done; close it
		if(isset($this->log_file))
			fclose($this->log_file);
	}
	
	/**
	 * Write to log file
	 *
	 * @param $value string to write 
	 *
	 */
	function dump_to_log($value){
		fwrite($this->log_file, $value."\n");
	}

	/**
	 * Get best blogs posts about keyword
	 *
	 * @param 	$keyword 			to search
	 * @param 	$postresults		number of results to return 	
	 *
	 * @return array|null
	 */
	
	
	function search_allblogs($keyword, $postresults=50){
		

		$results = array();

		// Step 0. Get page number according to number results
		$nb_pages = ceil($postresults / RESULTS_PER_PAGE);
		
	
		// Step 1. parse pages: 20 results per pages
		for($start=1;$start<=$nb_pages;$start++){
			
			$regator_url = REGATOR_URL.urlencode($keyword)."/page".$start;
			$regator_results = $this->parse_regator_url($regator_url);
			$results = array_merge($results,$regator_results);
		}
		
		return array_slice($results,0,$postresults);		// get only number of results defined by user
	}

	function parse_regator_url($url){
	
		$results = array();

		//Step 0. Parse search url
		$html = MacG_connect_to($url);
		$html = str_get_html($html);
		
		$blognews = $html->find('.postWrapper');		
		foreach($blognews as $news){
		
			$regator = new Regator;
			$url = $news->find('a',0)->href;
			$regator->url = $url;
			$title = $news->find('a',0)->plaintext;
			$regator->title = $title;
			$description = $news->find('p',0)->plaintext;
			$regator->description = $description;
								
			$results[] = $regator;
		}
			
		unset($html);
		
		return $results;
	}
}

?>