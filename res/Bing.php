<?php
class AiomaticBing 
{
	var $query;
	var $safe = false;
	var $xml;
	var $data = array();
	var $cache_path; 
	var $cache_file;
	var $link;
	function __construct($query, $safe = false) 
	{
		$this->query = urlencode($query);
		$this->safe = $safe;
		$this->cache_path = get_temp_dir() . 'BingCache/';
		$this->cache_file = preg_replace("/[^a-z0-9.]+/i", "+", $this->query) . '.json';
		global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') )
		{
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
		if ($wp_filesystem->exists($this->cache_path . $this->cache_file)) 
		{
			$cache = $wp_filesystem->get_contents($this->cache_path . $this->cache_file);
			$this->data = json_decode($cache, true);
		} 
		else 
		{
			$this->Query();
		}
	}
	function Query()
	{
	 	$agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36";
	 	$safeParam = $this->safe == true ? '&adlt=strict' : '';
	    $host = "https://www.bing.com/search?q=" . $this->query . $safeParam . "&format=rss";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $host);
	    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	    $this->xml = curl_exec($ch);
	    curl_close($ch);
	    $this->Parse();
	}
	function Parse() 
	{
		$dom = $this->XML_to_array($this->xml);
		if(isset($dom['channel']['item']))
		{
			foreach ($dom['channel']['item'] as $item) 
			{
				$this->data[] = $item;
			}
		}
		$this->link = "https://www.bing.com/search?q=" . $this->query;
		$this->Cache();
	}
	function Cache() 
	{
		$json = json_encode($this->data);
		global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') )
		{
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
		if ($wp_filesystem->is_writable($this->cache_path)) 
		{
			$wp_filesystem->put_contents($this->cache_path . $this->cache_file, $json);
		}
	}
	function XML_to_array($xml, $main_heading = '') 
	{
		$deXml = simplexml_load_string($xml);
		$deJson = json_encode($deXml);
		$xml_array = json_decode($deJson,TRUE);
		if (! empty($main_heading)) 
		{
			$returned = $xml_array[$main_heading];
			return $returned;
		} 
		else 
		{
			return $xml_array;
		}
	}
}
?>