<?php
class AIGoogleTranslateProxy
{
	public $ch;
	function __construct(&$ch)
	{
		$this->ch = $ch;
	}
	function fetch($url)
	{
		$url = "https://translate.google.com/translate?hl=en&ie=UTF8&prev=_t&sl=ar&tl=en&u=" . urlencode($url);
		$headers = array ();
		curl_setopt ( $this->ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $this->ch, CURLOPT_CONNECTTIMEOUT, 10 );
		curl_setopt ( $this->ch, CURLOPT_TIMEOUT, 300 );
		curl_setopt ( $this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36' );
		curl_setopt ( $this->ch, CURLOPT_MAXREDIRS, 20 ); 
		curl_setopt ( $this->ch, CURLOPT_FOLLOWLOCATION, 1 );
		$cjname = 'cookie.jar';
		curl_setopt ( $this->ch, CURLOPT_COOKIEJAR, str_replace ( 'GoogleTranslateProxy.php', $cjname, __FILE__ ) );
		curl_setopt ( $this->ch, CURLOPT_COOKIEJAR, $cjname );
		curl_setopt ( $this->ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $this->ch, CURLOPT_HTTPGET, 1 );
		curl_setopt ( $this->ch, CURLOPT_REFERER, 'http://ezinearticles.com' );
		curl_setopt ( $this->ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $this->ch, CURLOPT_URL, trim($url) );
		$exec = curl_exec($this->ch);
		if(trim($exec) == '')
		{
			$er = curl_error($this->ch);
			throw new Exception('Empty response returned: ' . $er);
		}
		$exec = preg_replace('{<span class="google-src-text.*?>.*?</span>}', "", $exec);
		$exec = preg_replace('{<span class="notranslate.*?>(.*?)</span>}', "$1", $exec);
		$exec = str_replace(' style=";text-align:left;direction:ltr"', '', $exec);
		return $exec;
	}
}