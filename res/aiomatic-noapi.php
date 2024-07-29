<?php
class aiomatic_no_amazon_api {
	private $ch = "";
	private $region = "";
	public $is_next_page_available = false;
	public $next_request_qid = null;
	public $update_agent_required = false;
	public $slugs = array ();
	function __construct(&$ch, $region) {
		$this->ch = $ch;
		$this->region = $region;
	}
	public function getItemByAsin($asin_code, $slug = '', $affiliateID = '') {
		sleep(rand(3,5));
		$asin_code = trim ( $asin_code );
		$item_url = "https://www.amazon.{$this->region}/dp/$asin_code";
		$url_gcache = trim ( $slug ) == '' ? $item_url : "https://www.amazon.{$this->region}/$slug/dp/$asin_code";
		curl_setopt ( $this->ch, CURLOPT_URL, "$url_gcache" );
		curl_setopt ( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $this->ch, CURLOPT_CUSTOMREQUEST, "GET" );
		$headers = array ();
		$headers [] = "Authority: www.amazon.{$this->region}";
		$headers [] = "Upgrade-Insecure-Requests: 1";
		$headers [] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
		$headers [] = "Sec-Fetch-Site: none";
		$headers [] = "Sec-Fetch-Mode: navigate";
		$headers [] = "Sec-Fetch-User: ?1";
		$headers [] = "Sec-Fetch-Dest: document";
		$headers [] = "Accept-Language: en-US,en;q=0.9,ar;q=0.8";
		curl_setopt ( $this->ch, CURLOPT_HTTPHEADER, $headers );
		$exec = curl_exec ( $this->ch );
		if (! stristr ( $exec, $asin_code )) {
			$gzdec = @gzdecode ( $exec );
			if (stristr ( $gzdec, $asin_code ))
				$exec = $gzdec;
		}
		$x = curl_error ( $this->ch );
		$cuinfo = curl_getinfo ( $this->ch );
		if (trim ( $exec ) == '' || trim ( $x ) != '') {
			throw new Exception ( 'No valid reply returned from Amazon with a possible cURL err ' . $x );
		}
		if (stristr ( $exec, '/captcha/' ) || $cuinfo ['http_code'] == 503) 
		{
			$url_gcache = "http://webcache.googleusercontent.com/search?q=cache:$url_gcache";
			curl_setopt ( $this->ch, CURLOPT_URL, trim ( $url_gcache ) );
			$exec_gcache = curl_exec ( $this->ch );
			if (stristr ( $exec_gcache, $asin_code ) && ! stristr ( $exec_gcache, ' 404 ' ) && ! stristr($exec_gcache, 'unusual traffic from your computer') ) {
				$exec = $exec_gcache;
				$cuinfo ['http_code'] = 200;
			}
		}
		if (stristr ( $exec, '/captcha/' ) || $cuinfo ['http_code'] == 503) {
			require_once (dirname(__FILE__) . "/GoogleTranslateProxy.php"); 
			try 
			{
				$GoogleTranslateProxy = new AIGoogleTranslateProxy($this->ch);
				$exec = $GoogleTranslateProxy->fetch($item_url);
				$cuinfo ['http_code'] = 200;
			} 
			catch (Exception $e) 
			{
				aiomatic_log_to_file('Google Proxy failed: ' . $e->getMessage());
			}
		}
		if (stristr ( $exec, '/captcha/' ) || $cuinfo ['http_code'] == 503) {
			throw new Exception ( 'Captcha required by Amazon...' );
		}
		if (!stristr ( $exec, $asin_code )) 
		{
			throw new Exception ( 'No valid reply returned from Amazon can not find the item asin' );
		}
		$exec = str_replace ( 'iso-8859-1', 'utf-8', $exec );
		$doc = new DOMDocument ();
		$internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTML ( $exec, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		libxml_use_internal_errors($internalErrors);
		$xpath = new DOMXpath ( $doc );
		$elements = $xpath->query ( '//*[@id="productTitle"]' );
		$item_title = '';
		if ($elements->length > 0) {
			$title_element = $elements->item ( 0 );
			$item_title = trim ( $title_element->nodeValue );
		}
		if(trim($item_title) == '' ){
			preg_match( '{<meta property="og:title" content="(.*?)"}' , $exec , $title_matches   );
			$item_title = isset( $title_matches[1]) ? $title_matches[1] : '' ;
		}
		$ret ['link_title'] = $item_title;
		$item_description = '';
		preg_match_all ( '{<div id="productDescription.*?<p>(.*?)</p>[^<]}s', $exec, $description_matches );
		$description_matches = $description_matches [1];
		if (isset ( $description_matches [0] )) 
		{
			$item_description = $description_matches [0];
			$item_description = str_replace ( '</p><p>', '<br>', $item_description );
			$item_description = str_replace ( array (
					'<p>',
					'</p>' 
			), '', $item_description );
		}
		if (trim ( $item_description ) == '' && stristr ( $exec, 'id="aplus"' )) 
		{
			unset ( $elements );
			$elements = $xpath->query ( '//*[@id="aplus"]' );
			if ($elements->length > 0) {
				$item_description = $doc->saveHTML ( $elements->item ( 0 ) );
				$item_description = preg_replace ( array (
						'{<style.*?style>}s',
						'{<a.*?/a>}s',
						'{<script.*?/script>}s' 
				), '', $item_description );
				$item_description = strip_tags ( $item_description, '<p><br><img><h3>' );
			}
		}
		if (stristr ( $exec, 'bookDesc_iframe_wrapper' )) 
		{
			preg_match_all ( '{<noscript>\s*(<div>.*?)</noscript}s', $exec, $book_desc_matches );
			if (count ( $book_desc_matches [1] ) == 1 && isset ( $book_desc_matches [1] [0] )) {
				$item_description = $book_desc_matches [1] [0] . '<br>' . $item_description;
			}
		}
		if (stristr ( $exec, 'detailBulletsWrapper_feature_div' )) {
			$detailelements = $xpath->query ( '//*[@id="detailBullets_feature_div"]/ul/li' );
			$detailBulletsWrapper_feature_div = '';
			if ($detailelements->length > 0) {
				foreach ( $detailelements as $element ) {
					$detailBulletsWrapper_feature_div .= (  str_replace("\n" , '' ,($element->nodeValue)) ) . '<br>';
				}
			}
			if ( trim($detailBulletsWrapper_feature_div) != ''  ) {
				$item_description =  $item_description . '<br>' . $detailBulletsWrapper_feature_div;
			}
		}
		$ret ['item_description'] = $item_description;
		unset ( $elements );
		$elements = $xpath->query ( '//*[@id="feature-bullets"]/ul/li/span[@class="a-list-item"]' );
		$item_features = array ();
		if ($elements->length > 0) {
			foreach ( $elements as $element ) {
				$item_features [] = trim ( ($element->nodeValue) );
			}
			unset ( $item_features [0] );
		}
		$ret ['item_features'] = $item_features;
		preg_match_all ( '{colorImages\': \{.*?large":".*?".*?script>}s', $exec, $imgs_matches );
		$possible_img_part = '';
		if (isset ( $imgs_matches [0] [0] )) {
			$possible_img_part = $imgs_matches [0] [0];
		}
		if (trim ( $possible_img_part ) != '') {
			preg_match_all ( '{large":"(.*?)"}s', $possible_img_part, $imgs_matches );
		} else {
			preg_match_all ( '{large":"(.*?)"}s', $exec, $imgs_matches );
		}
		$item_images = array_unique ( $imgs_matches [1] );
		
		if (count ( $item_images ) == 0) {
			if (stristr ( $exec, 'imageGalleryData' )) {
				preg_match ( '{imageGalleryData(.*?)dimensions}s', $exec, $poassible_book_imgs );
			} elseif (stristr ( $exec, 'ebooksImageBlockContainer' )) {
				preg_match ( '{<div id="ebooksImageBlockContainer(.*?)div>\s</div>}s', $exec, $poassible_book_imgs );
			} elseif (stristr ( $exec, 'mainImageContainer' )) {
				preg_match ( '{<div id="mainImageContainer(.*?)div>}s', $exec, $poassible_book_imgs );
			} elseif (stristr ( $exec, 'main-image-container' )) {
				preg_match ( '{<div id="main-image-container(.*?)div>}s', $exec, $poassible_book_imgs );
			}
			
			if (isset ( $poassible_book_imgs[0] )) {
				$poassible_book_imgs = $poassible_book_imgs[0];
			} else {
				$poassible_book_imgs = '';
			}
			if (trim ( $poassible_book_imgs ) != '') {
				preg_match_all ( '{https://.*?\.jpg}s', $poassible_book_imgs, $possible_book_img_srcs );
				$possible_book_img_srcs = $possible_book_img_srcs [0];
				if (count ( $possible_book_img_srcs ) > 0) {
					$final_img = end ( $possible_book_img_srcs );
					$final_img = preg_replace ( '{,.*?\.}', '.', $final_img );
					$item_images = array (
							$final_img 
					);
				}
			}
		}
		if(count($item_images) == 0 && strpos($exec, 'data-zoom-hires')){
			preg_match_all('{data-zoom-hires="(.*?)"}', $exec, $mobile_imgs_matches);
			$item_images = $mobile_imgs_matches[1];
		}
		
		$ret ['item_images'] = $item_images;
		unset ( $elements );
		if (stristr ( $exec, 'id="priceblock_dealprice' ) || stristr ( $exec, 'id=priceblock_dealprice' )) 
		{
			$elements = $xpath->query ( '//*[@id="priceblock_dealprice"]' );
		} 
		elseif (stristr ( $exec, 'id="priceblock_ourprice' ) || stristr ( $exec, 'id=priceblock_ourprice' )) 
		{
			$elements = $xpath->query ( '//*[@id="priceblock_ourprice"]' );
		} 
		elseif (stristr ( $exec, 'id="priceblock_saleprice' ) || stristr ( $exec, 'id=priceblock_saleprice' )) 
		{
			$elements = $xpath->query ( '//*[@id="priceblock_saleprice"]' );
		} 
		elseif (stristr ( $exec, 'id="price_inside_buybox' ) || stristr ( $exec, 'id=price_inside_buybox' )) 
		{
			$elements = $xpath->query ( '//*[@id="price_inside_buybox"]' );
		}
		elseif (stristr ( $exec, 'id="newBuyBoxPrice' ) || stristr ( $exec, 'id=newBuyBoxPrice' )) {
			
			$elements = $xpath->query ( '//*[@id="newBuyBoxPrice"]' );
		}
		
		$item_price = '';
		if (isset ( $elements ) && $elements->length > 0) {
			$item_price = trim ( $elements->item ( 0 )->nodeValue );
			$item_price = preg_replace ( '{ -.*}', '', $item_price );
		} 
		elseif (stristr ( $exec, ' offer-price ' )) 
		{
			
			preg_match_all ( '{ offer-price .*?>(.*?)</span>}s', $exec, $possible_price_matches );
			$possible_price_matches = $possible_price_matches [1];
			if (isset ( $possible_price_matches [0] ) && trim ( $possible_price_matches [0] ) != '')
				$item_price = $possible_price_matches [0];
		} 
		elseif (stristr ( $exec, '<span class="a-size-small a-color-price">' )) 
		{
			preg_match_all ( '{<span class="a-size-small a-color-price">(.*?)</span>}s', $exec, $possible_price_matches );
			$possible_price_matches = $possible_price_matches [1];
			if (isset ( $possible_price_matches [0] ) && trim ( $possible_price_matches [0] ) != '')
				$item_price = trim ( $possible_price_matches [0] );
		}
		elseif( stristr($exec, '<span class="a-size-large a-color-price">'))
		{
			preg_match_all ( '{<span class="a-size-large a-color-price">(.*?)</span>}s', $exec, $possible_price_matches );
			$possible_price_matches = $possible_price_matches [1];
			
			if (isset ( $possible_price_matches [0] ) && trim ( $possible_price_matches [0] ) != '')
				$item_price = trim ( $possible_price_matches [0] );

		}
		elseif(stristr($exec, '<span class="a-price a-text-price a-size-medium" data-a-size="b" data-a-color="price"><span class="a-offscreen">')){

			preg_match_all ( '{<span class="a-price a-text-price a-size-medium" data-a-size="b" data-a-color="price"><span class="a-offscreen">(.*?)</span>}s', $exec, $possible_price_matches );
			$possible_price_matches = $possible_price_matches [1];
			
			if (isset ( $possible_price_matches [0] ) && trim ( $possible_price_matches [0] ) != '')
				$item_price = trim ( $possible_price_matches [0] );
			
		}
		elseif(stristr($exec,'data-a-color="price"><span class="a-offscreen">')){

			preg_match_all ( '{data-a-color="price"><span class="a-offscreen">(.*?)</span>}s', $exec, $possible_price_matches );
			$possible_price_matches = $possible_price_matches [1];
			
			if (isset ( $possible_price_matches [0] ) && trim ( $possible_price_matches [0] ) != '')
				$item_price = trim ( $possible_price_matches [0] );
			

		}
		elseif(stristr($exec, 'id="twister-plus-price-data-price"')){
			preg_match ( '#<input type="hidden" id="twister-plus-price-data-price" value="([^"]*?)"#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $item_price = $possible_price_matches_pre;
		}
		elseif(stristr($exec, '"priceAmount":')){
			preg_match ( '#"priceAmount":([^,]*?),#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $item_price = $possible_price_matches_pre;
		}
		elseif(stristr($exec, '<input type="hidden" name="priceValue"')){
			preg_match ( '#<input type="hidden" name="priceValue" value="([^"]*?)" id="priceValue"#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $item_price = $possible_price_matches_pre;
		}
		unset ( $elements );
		$elements = $xpath->query ( "//*[contains(@class, 'priceBlockStrikePriceString')]" );
		$item_pre_price = $item_price;
		if ($elements->length > 0) 
		{
			$item_pre_price = trim ( $elements->item ( 0 )->nodeValue );
			$item_pre_price = preg_replace ( '{ -.*}', '', $item_pre_price );
		}
		elseif(stristr($exec, 'data-a-strike="true" data-a-color="secondary">')){

			preg_match ( '{data-a-strike="true" data-a-color="secondary"><span class="a-offscreen">(.*?)</span>}s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $item_pre_price = $possible_price_matches_pre;
		}
		$ret ['item_pre_price'] = $item_pre_price;
		if(empty($item_price) && !empty($item_pre_price))
		{
			$item_price = $item_pre_price;
		}
		$item_price = str_replace ( '$ ', '$', $item_price );
		$item_price = str_replace('()', '', $item_price);
		$item_price = strip_tags($item_price);
		$currency = '$';
		if(stristr($exec, '"currencySymbol":"')){

			preg_match ( '#"currencySymbol":"([^"]*?)"#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $currency = $possible_price_matches_pre;
		}
		elseif(stristr($exec, '<input type="hidden" name="priceSymbol"')){

			preg_match ( '#<input type="hidden" name="priceSymbol" value="([^"]*?)" id="priceSymbol"#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $currency = $possible_price_matches_pre;
		}
		elseif(stristr($exec, '<input type="hidden" id="twister-plus-price-data-price-unit"')){

			preg_match ( '#<input type="hidden" id="twister-plus-price-data-price-unit" value="([^"]*?)"#s', $exec, $possible_price_matches_pre );
			$possible_price_matches_pre = $possible_price_matches_pre [1];
			if(trim($possible_price_matches_pre) != '') $currency = $possible_price_matches_pre;
		}
		$ret ['item_price'] = $item_price;
		$ret ['price_currency'] = $currency;
		$ret ['item_link'] = 'https://amazon.' . $this->region . '/dp/' . $asin_code;
		$ret ['item_reviews'] = 'https://www.amazon.' . $this->region . '/product-reviews/' . $asin_code . '?atag=' . $affiliateID;
		unset ( $elements );
		$elements = $xpath->query ( '//*[@id="featurebullets_feature_div"]' );
		$item_features_html = '';
		if ($elements->length > 0) {
			$item_features_elem = $elements->item ( 0 );
			$item_features_html = trim ( $item_features_elem->nodeValue );
		}
		$ret ['item_features_html'] = $item_features_html;
		unset ( $elements );
		$elements = $xpath->query ( '//*[@data-hook="review-collapsed"]' );
		$item_reviews_text = array ();
		if ($elements->length > 0) {
			foreach ( $elements as $element ) {
				$revme = $element->nodeValue;
				$revme = str_replace('The media could not be loaded.', '', $revme);
				$revme = trim($revme);
				$item_reviews_text[] = trim ( ($revme) );
			}
		}
		$ret ['item_reviews_text'] = $item_reviews_text;
		return $ret;
	}
	public function getItemByKeyword($keyword, $ItemPage, $product_type, $additionalParam = array(), $min = '', $max = '') {
		$this->is_next_page_available = false;
		$keyword_encoded = urlencode ( trim ( $keyword ) );
		$search_url = "https://www.amazon.{$this->region}/s?k=$keyword_encoded&ref=nb_sb_noss";
		if ($ItemPage != 1) 
		{
			$search_url .= "&page=$ItemPage";
		}
		$x = 'error';
		$url = $search_url;
		curl_setopt ( $this->ch, CURLOPT_HTTPGET, 1 );
		curl_setopt ( $this->ch, CURLOPT_URL, trim ( $url ) );
		curl_setopt ( $this->ch, CURLOPT_HTTPHEADER, 'accept-encoding: utf-8' );
		curl_setopt ( $this->ch, CURLOPT_ENCODING, "" );
		$exec = curl_exec ( $this->ch );
		$x = curl_error ( $this->ch );
		if (trim ( $exec ) == '' || trim ( $x ) != '') {
			throw new Exception ( 'No valid reply returned from Amazon with a possible cURL err ' . $x );
		}
		if (! stristr ( $exec, 'data-asin' )) {
			return array ();
		}
		preg_match_all ( '{data-asin="(.*?)"}', $exec, $productMatchs );
		$asins = $productMatchs [1];
		if (stristr ( $exec, 'proceedWarning' )) {
			return array ();
		}
		$possible_next_page = $ItemPage + 1;
		if (stristr ( $exec, 'page=' . $possible_next_page . '&' ))
			$this->is_next_page_available = true;
		return ($asins);
	}
	public function getASINs($moreUrl) {
		sleep ( rand ( 4, 6 ) );
		$x = 'error';
		$url = $moreUrl;
		$headers = array ();
		$headers [] = "Authority: www.amazon.{$this->region}";
		$headers [] = "Upgrade-Insecure-Requests: 1";
		$headers [] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
		$headers [] = "Sec-Fetch-Site: none";
		$headers [] = "Sec-Fetch-Mode: navigate";
		$headers [] = "Sec-Fetch-Dest: document";
		$headers [] = "Accept-Language: en-US,en;q=0.9";
		curl_setopt ( $this->ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $this->ch, CURLOPT_HTTPGET, 1 );
		curl_setopt ( $this->ch, CURLOPT_URL, trim ( $url ) );
		$exec = curl_exec ( $this->ch );
		$x = curl_error ( $this->ch );
		$cuinfo = curl_getinfo ( $this->ch );
		if (trim ( $exec ) == '') {
			throw new Exception ( 'Empty reply from Amazon with possible curl error ' . $x );
		}
		if (! stristr ( $exec, 'amazon' )) {
			$gzdec = @gzdecode ( $exec );
			if (stristr ( $gzdec, 'amazon' ))
				$exec = $gzdec;
		}
		if (stristr ( $exec, '/captcha/' ) || $cuinfo ['http_code'] == 503) {
			return array();
		}
		if (! stristr ( $exec, 'data-asin' )) {
			return array ();
		}
		if (stristr ( $exec, 'proceedWarning' )) {
			return array ();
		}
		$doc = new DOMDocument ();
		$internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTML ( $exec, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		libxml_use_internal_errors($internalErrors);
		$xpath = new DOMXpath ( $doc );
		$elements = $xpath->query ( '//*[@data-index]' );
		$all_valid_items_html = '';
		foreach ( $elements as $single_asin_element ) 
		{
			$item_html = $doc->saveHtml ( $single_asin_element );
			if (! stristr ( $item_html, 'a-row a-spacing-micro' ) && stristr ( $item_html, 'a-price-whole' )) {
				$all_valid_items_html .= $item_html;
			}
		}
		preg_match_all ( '{data-asin="(.*?)"}', $all_valid_items_html, $productMatchs );
		$asins = array_values ( array_filter ( $productMatchs [1] ) );
		preg_match ( '{amp;qid\=(\d*?)&}', $exec, $qid_matches );
		if (isset ( $qid_matches [1] ) && is_numeric ( $qid_matches [1] )) {
			$this->next_request_qid = $qid_matches [1];
		}
		$slugs = array ();
		foreach ( $asins as $product_asin ) {
			preg_match ( '{/([^/]*?)/dp/' . $product_asin . '}', $all_valid_items_html, $slug_match );
            if(isset($slug_match[1]))
            {
                $slugs[] = $slug_match[1];
            }
		}
		$this->slugs = $slugs;
		return ($asins);
	}
}
?>