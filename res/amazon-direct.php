<?php
$aiomatic_simulated = false;
if(!class_exists('AiomaticObj'))
{
	#[AllowDynamicProperties]
	class AiomaticObj
	{
		public $link_url = '';
		public $link_keyword = '';
		public $link_status = '';
		public $link_desc = '';
	}
}
if(!class_exists('AiomaticProductObj'))
{
	#[AllowDynamicProperties]
	class AiomaticProductObj
	{
		public $product_author = '';
		public $product_brand = '';
		public $product_isbn = '';
		public $product_upc = '';
		public $offer_title = '';
		public $offer_desc = '';
		public $offer_url = '';
		public $source_link = '';
		public $offer_price = '';
		public $product_price = '';
		public $product_list_price = '';
		public $offer_img = '';
		public $product_img = '';
		public $price_numeric = '';
		public $price_currency = '';
		public $review_link = '';
		public $product_asin = '';
		public $cart_url = '';
		public $list_price_numeric = '';
		public $product_imgs = '';
		public $product_imgs_html = '';
		public $price_with_discount_fixed = '';
		//new
		public $item_score = '';
		public $edition = '';
		public $language = '';
		public $pages_count = '';
		public $publication_date = '';
		public $contributors = '';
		public $manufacturer = '';
		public $binding = '';
		public $product_group = '';
		public $rating = '';
		public $eans = '';
		public $part_no = '';
		public $model = '';
		public $warranty = '';
		public $color = '';
		public $is_adult = '';
		public $dimensions = '';
		public $date = '';
		public $size = '';
		public $unit_count = '';

		public function getContributors()
		{
			return $this->contributors;
		}
		public function getItemPartNumber()
		{
			return $this->part_no;
		}
		public function getModel()
		{
			return $this->model;
		}
		public function getWarranty()
		{
			return $this->warranty;
		}
		public function getColor()
		{
			return $this->color;
		}
		public function getIsAdultProduct()
		{
			return $this->is_adult;
		}
		public function getItemDimensions()
		{
			return $this->dimensions;
		}
		public function getReleaseDate()
		{
			return $this->date;
		}
		public function getSize()
		{
			return $this->size;
		}
		public function getUnitCount()
		{
			return $this->unit_count;
		}
		public function getBinding()
		{
			return $this->binding;
		}
		public function getProductGroup()
		{
			return $this->product_group;
		}
		public function getContentRating()
		{
			return $this->rating;
		}
		public function getEANs()
		{
			return $this->eans;
		}
		public function getISBNs()
		{
			return $this->product_isbn;
		}
		public function getManufacturer()
		{
			return $this->manufacturer;
		}
		public function getEdition()
		{
			return $this->edition;
		}
		public function getLanguages()
		{
			return $this->language;
		}
		public function getPagesCount()
		{
			return $this->pages_count;
		}
		public function getPublicationDate()
		{
			return $this->publication_date;
		}
		public function getBrand()
		{
			return $this->product_brand;
		}
		public function getAuthor()
		{
			return $this->product_author;
		}
		public function getPrice()
		{
            return $this->price_numeric . $this->price_currency;
		}
		public function getPricePlain()
		{
            return $this->price_numeric;
		}
		public function getCurrency()
		{
			return $this->price_currency;
		}
		public function getISBN()
		{
			return $this->product_isbn;
		}
		public function getASIN()
		{
			return $this->product_asin;
		}
		public function getDetailPageURL()
		{
			return $this->offer_url;
		}
		public function getImage()
		{
			return $this->product_img;
		}
		public function getImages()
		{
			return $this->product_imgs;
		}
		public function getItemInfo()
		{
			return $this->offer_desc;
		}
		public function getScore()
		{
			return $this->item_score;
		}
		public function getBrowseNodeInfo()
		{
			return null;
		}
		public function getTitle()
		{
			return $this->offer_title;
		}
	}
}

function aiomatic_amazon_get_post($keyword, $affiliateID, $region, $low_price, $high_price, $order, $max, $page, $posted_items) 
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
	if(!function_exists('is_plugin_active'))
	{
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	$amaz_ext_active = false;
	if (is_plugin_active('aiomatic-extension-amazon-api/aiomatic-extension-amazon-api.php')) 
	{
		$amaz_ext_active = true;
	}
	if(!isset($aiomatic_Main_Settings['amazon_app_id']) || trim($aiomatic_Main_Settings['amazon_app_id']) == '' || !isset($aiomatic_Main_Settings['amazon_app_secret']) || trim($aiomatic_Main_Settings['amazon_app_secret']) == '' || $amaz_ext_active == false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled')
		{
			$prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
			$randomness = array_rand($prx);
			curl_setopt($ch, CURLOPT_PROXY , trim($prx[$randomness]));
			if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
			{
				$prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
				if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
				{
					curl_setopt($ch, CURLOPT_PROXYUSERPWD , trim($prx_auth[$randomness]));
				}
			}
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		if (isset($aiomatic_Main_Settings['max_timeout']) && $aiomatic_Main_Settings['max_timeout'] != '')
		{
			$ztime = intval($aiomatic_Main_Settings['max_timeout']);
		}
		else
		{
			$ztime = 300;
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, $ztime);
		curl_setopt($ch, CURLOPT_REFERER, "https://www.amazon." . $region . "/");
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'amazcookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'amazcookie.txt');	
		$keyword = trim($keyword);
		if (trim($keyword) != '') 
		{
			$res = aiomatic_amazon_fetch_links($keyword, $region, $affiliateID, $ch, $low_price, $high_price, $order, $max, $page, $posted_items);
			if($res === false)
			{
				return array('status' => 'nothing');
			}
			$res_count = count($res);
			for($i = 0; $i < $res_count; $i ++) 
			{
				$t_row = $res[$i];
				$t_link_url = $t_row->link_url;
				$possible_full_link = $t_link_url;
				if (! stristr($t_link_url, 'http')) 
				{
					$possible_full_link = 'https://amazon.' . $region . '/dp/' . $t_link_url;
				} 
				else 
				{
					$link_parts = explode('/dp/', $t_link_url);
					$asin = $link_parts [1];
				}			
				if (! stristr($t_link_url, 'http')) 
				{
					$asin = $t_link_url;
					require_once (dirname(__FILE__) . '/aiomatic-noapi.php');
					$obj = new aiomatic_no_amazon_api($ch, $region);
					try 
					{
						aiomatic_simulate_location($region);
						curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
						$item = $obj->getItemByAsin($asin, $t_row->link_desc, $affiliateID);
					} 
					catch(Exception $e) 
					{
						aiomatic_log_to_file('Amazon reading error:' . $e->getMessage ());
						return false;
					}
					if (isset($item ['link_title'])) 
					{
						$desc = '';
						if(isset($item ['item_description']))
						{
							$desc = $item ['item_description'];
						}
						if (count($item ['item_features']) > 0) 
						{
							$desc .= '<br>' . implode('<br>', $item ['item_features']);
						}
						$title = $item ['link_title'];
						if (isset($item ['product_author']) && $item ['product_author'] != '') {
							$title .= '**' . $item ['product_author'];
						} else {
							$title .= '** ';
						}
						if (isset($item ['product_brand']) && $item ['product_brand'] != '') {
							$title .= '**' . $item ['product_brand'];
						} else {
							$title .= '** ';
						}
						if (isset($item ['product_isbn']) && $item ['product_isbn'] != '') {
							$title .= '**' . $item ['product_isbn'];
						} else {
							$title .= '** ';
						}
						if (isset($item ['product_upc']) && $item ['product_upc'] != '') {
							$title .= '**' . $item ['product_upc'];
						} else {
							$title .= '** ';
						}
						$t_link_url = $linkUrl = $item ['item_link'];
						$price = '';
						$price = $item ['item_price'] . '-' . $item ['item_pre_price'];
						$item_currency = $item ['price_currency'];
						$imgurl = '';
						$imgurl = implode(',', $item ['item_images']);
						$review = $item ['item_reviews'];
						$t_row->link_url = $linkUrl;
						$t_row->link_title = $title;
						$t_row->link_desc = $desc;
						$t_row->link_price = $price;
						$t_row->price_currency = $item_currency;
						$t_row->link_img = $imgurl;
						$t_row->item_features_html = $item ['item_features_html'];
						$t_row->item_reviews_text = $item ['item_reviews_text'];
						$t_row->link_review =(string) $review;
						$res [$i] = $t_row;
					}
					else 
					{
						unset($res [$i]);
					}
				}
			}
			$temp_rez = array();
			if (count($res) > 0) 
			{
				$res = array_values($res);
				for($i = 0; $i < count($res); $i ++) 
				{
					$temp = new AiomaticProductObj();
					if(!isset($res [$i]))
					{
						continue;
					}
					$ret = $res [$i];
					if (stristr($ret->link_price, '-')) 
					{
						$priceParts = explode('-', $ret->link_price);
						$ret->link_price = $priceParts [0];
						$salePrice = $priceParts [1];
					} else {
						$salePrice = $ret->link_price;
					}
					$offer_title = $ret->link_title;
					$temp->product_author = '';
					
					$temp->item_score = '';
					$temp->edition = '';
					$temp->language = '';
					$temp->pages_count = '';
					$temp->publication_date = '';
					$temp->product_brand = '';
					$temp->contributors = '';
					$temp->manufacturer = '';
					$temp->binding = '';
					$temp->product_group = '';
					$temp->rating = '';
					$temp->eans = '';
					$temp->product_isbn = '';
					$temp->part_no = '';
					$temp->model = '';
					$temp->warranty = '';
					$temp->color = '';
					$temp->is_adult = '';
					$temp->dimensions = '';
					$temp->date = '';
					$temp->size = '';
					$temp->unit_count = '';

					if (stristr($offer_title, '**')) 
					{
						$titleParts = explode('**', $offer_title);
						$offer_title = $titleParts [0];
						$temp->product_author = $titleParts [1];
						$temp->product_brand = $titleParts [2];
						if (isset($titleParts [3]))
							$temp->product_isbn = $titleParts [3];
						if (isset($titleParts [4])) {
							$temp->product_upc = $titleParts [4];
						} else {
							$temp->product_upc = '';
						}
					}
					$offer_desc = $ret->link_desc;
					$offer_desc = str_replace('View larger.', '', $offer_desc);
					$offer_desc = str_replace('To report an issue with this product, click here. ', '', $offer_desc);
					$offer_desc = str_replace('Show more', '', $offer_desc);
					$offer_desc = str_replace('From the Publisher', '', $offer_desc);
					$offer_desc = str_replace('See more product details', '', $offer_desc);
					$offer_desc = str_replace('To calculate the overall star rating and percentage breakdown by star, we don’t use a simple average. Instead, our system considers things like how recent a review is and if the reviewer bought the item on Amazon. It also analyzed reviews to verify trustworthiness. ', '', $offer_desc);
					$offer_url = $ret->link_url . '?tag=' . $affiliateID;
					$offer_price = trim($ret->link_price);
					$offer_img = $ret->link_img;
					$temp->offer_title = $offer_title;
					$temp->offer_desc = wp_strip_all_tags($offer_desc, true);
					$temp->offer_url = $offer_url;
					$temp->source_link = $ret->link_url;
					$temp->offer_price = $offer_price;
					$temp->product_price = $offer_price;
					$temp->product_list_price = $salePrice;
					$temp->offer_img = $offer_img;
					$temp->product_img = $offer_img;
					$temp->price_numeric = '00.00';
					$temp->price_currency = '$';
					$temp->offer_desc .= '<br>' . str_replace('About this item ', '', wp_strip_all_tags(trim($ret->item_features_html), true));
					$temp->item_reviews = $ret->item_reviews_text;
					$ret->link_review = preg_replace('{exp\=20\d\d}', 'exp=2030', $ret->link_review);
					$ret->link_review = str_replace('http://', '//', $ret->link_review);
					$temp->review_link = $ret->link_review;
					$tag = '';
					$subscription = '';
					if (stristr($offer_url, 'creativeASIN')) 
					{
						$enc_url = urldecode($offer_url);
						$enc_url = explode('?', $enc_url);
						$enc_parms = $enc_url [1];
						$enc_parms_arr = explode('&', $enc_parms);
						foreach($enc_parms_arr as $param) 
						{
							if (stristr($param, 'creativeASIN')) {
								$asin = str_replace('creativeASIN=', '', $param);
							} elseif (stristr($param, 'tag=')) {
								$tag = str_replace('tag=', '', $param);
							} elseif (stristr($param, 'SubscriptionId')) {
								$subscription = str_replace('SubscriptionId=', '', $param);
							}
						}
					} 
					else 
					{
						$tag = $affiliateID;
					}
					$temp->product_asin = $asin;
					$cart_url = "https://www.amazon.$region/gp/aws/cart/add.html?AssociateTag=$tag&ASIN.1=$asin&Quantity.1=1&SubscriptionId=$subscription";
					$temp->cart_url = $cart_url;
					if (trim($ret->link_price) != '') {
						$thousandSeparator = ',';
						if ($region == 'es' || $region == 'de' || $region == 'fr' || $region == 'it' || $region == 'com.br') {
							$thousandSeparator = '.';
						}
						$price_no_commas = str_replace($thousandSeparator, '', $offer_price);
						preg_match('{\d.*\d}is', $price_no_commas, $price_matches);
						if(isset($price_matches [0]))
						{
							$temp->price_numeric = $price_matches [0];
						}
						else
						{
							$temp->price_numeric = '';
						}
						$temp->price_currency = preg_replace('{[\d .,]*}', '', $offer_price);
						if(empty($temp->price_currency))
						{
							$temp->price_currency = '$';
						}
						$price_no_commas = str_replace($thousandSeparator, '', $salePrice);
						preg_match('{\d.*\d}is', $price_no_commas, $price_matches);
						if(isset($price_matches [0]))
						{
							$temp->list_price_numeric = $price_matches [0];
						}
						else
						{
							$temp->list_price_numeric = '';
						}
					}
					$temp->product_imgs = $temp->product_img;
					if (stristr($temp->product_img, ',')) {
						$imgs = explode(',', $temp->product_imgs);
						$temp->product_img = $temp->offer_img = $imgs [0];
					}
					$cg_am_full_img_t = '<img src="[img_src]" class="amazon_gallery" />';
					$allImages = explode(',', $temp->product_imgs);
					$allImages_html = '';
					foreach($allImages as $singleImage) {
						$singleImageHtml = $cg_am_full_img_t;
						$singleImageHtml = str_replace('[img_src]', $singleImage, $singleImageHtml);
						$allImages_html .= $singleImageHtml;
					}
					$temp->product_imgs_html = $allImages_html;
					if ($temp->product_price == $temp->product_list_price) {
						$temp->price_with_discount_fixed = $temp->product_price;
					} else {
						$temp->price_with_discount_fixed = '<del>' . $temp->product_list_price . '</del> - ' . $temp->product_price;
					}
					if (trim($temp->product_price) == '')
						$temp->product_price = $temp->price_numeric;
					if (trim($temp->product_list_price) == '')
						$temp->product_list_price = $temp->price_numeric;
					$temp_rez[] = $temp;
				}
			} else {
				aiomatic_log_to_file('Amazon no results found.');
				return false;
			}
			return $temp_rez;
		}
		aiomatic_log_to_file('No usable keywords found.');
	}
	else
	{
		$keyword = trim($keyword);
		if (trim($keyword) != '') 
		{
			$amazoncategory = 'All';
			$escaped_categories = array_map('preg_quote', AIOMATIC_AMAZON_CATEGORIES);
			$apattern = '/category:\s*(' . implode('|', $escaped_categories) . ')/';
			if (preg_match($apattern, $keyword, $matches)) 
			{
				if(isset($matches[1]))
				{
					$amazoncategory = $matches[1];
					$keyword = preg_replace($apattern, '', $keyword);
				}
			}
			$additionalParam = array();
			$browser_node = '';
			$res = aiomatic_searchItems_v5($region, trim($aiomatic_Main_Settings['amazon_app_id']), trim($aiomatic_Main_Settings['amazon_app_secret']), $affiliateID, $keyword, $amazoncategory, $additionalParam, $low_price, $high_price, $browser_node, $page, $max);
			$temp_rez = array();
			if (count($res) > 0) 
			{
				for($i = 0; $i < count($res); $i ++) 
				{
					$temp = new AiomaticProductObj();
					if(!isset($res [$i]))
					{
						continue;
					}
					$item = $res [$i];
					
					$item_info = $item->getItemInfo();
					$trade_info     = $item_info->getTradeInInfo();
					if($trade_info != null)
					{
						$price     = $trade_info->getPrice();
						if($price != null)
						{
							$price     = $price->getDisplayAmount();
						}
						else
						{
							$price     = '';
						}
					}
					else
					{
						$price     = '';
					}
					if ($price == '' && $item->getOffers() != null && $item->getOffers()->getListings() != null && $item->getOffers()->getListings()[0]->getPrice() != null && $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() != null) 
					{
						$price     = $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount();
					}
					$full_price = '';
					$lowprice = '';
					if($item->getOffers() !== null)
					{
						$offers = $item->getOffers()->getListings();
					}
					else
					{
						$offers = null;
					}
					if($offers != null)
					{
						foreach($offers as $off)
						{
							$lowprice = $off->getPrice();
							if($lowprice != null)
							{
								$lowprice = $lowprice->getDisplayAmount();
								if($price == '')
								{
									$price = $lowprice;
								}
							}
                            $xfull_price = $off->getSavingBasis();
							if($xfull_price != null)
							{
								$full_price = $xfull_price->getDisplayAmount();
							}
							break;
						}
					}
					if(empty($full_price))
					{
						$full_price = $price;
					}

					//new
					$content_info     = $item_info->getContentInfo();
					if($content_info != null)
					{
						$edition     = $content_info->getEdition();
						if ($edition !== null) 
						{
							$edition = $edition->getDisplayValue();
						} 
						else 
						{
							$edition = '';
						} 
						$language    = $content_info->getLanguages(); 
						if ($language !== null) 
						{
							$language_types = $language->getDisplayValues();
							$language = '';
							foreach ($language_types as $language_type) 
							{
								$language = $language_type->getDisplayValue();
								break;
							}
						}
						else 
						{
							$language = '';
						}
						$pages_count     = $content_info->getPagesCount();
						if ($pages_count !== null) 
						{
							$pages_count = $pages_count->getDisplayValue();
						} 
						else 
						{
							$pages_count = '';
						} 
						$publication_date     = $content_info->getPublicationDate();
						if ($publication_date !== null) 
						{
							$publication_date = $publication_date->getDisplayValue();
						} 
						else 
						{
							$publication_date = '';
						} 
					}
					else
					{
						$edition      = '';
						$language     = '';
						$pages_count     = '';
						$publication_date     = '';
					}	
					$byline_info     = $item_info->getByLineInfo();
					$contributors     = '';
					if($byline_info != null)
					{
						$zabrand     = $byline_info->getBrand();
						if($zabrand != null)
						{
							$brand     = $zabrand->getDisplayValue();
						}
						else
						{
							$brand     = '';
						}
						$xcontributors     = $byline_info->getContributors();
						if(is_array($xcontributors))
						{
							foreach($xcontributors as $cntx)
							{
								$contributors .= $cntx->getName() . ' ';
							}
						}
						$zamanufacturer     = $byline_info->getManufacturer();
						if($zamanufacturer != null)
						{
							$manufacturer     = $zamanufacturer->getDisplayValue();
						}
						else
						{
							$manufacturer     = '';
						}
					}
					else
					{
						$brand     = '';
						$manufacturer     = '';
					}
					$class_info     = $item_info->getClassifications();
					if($class_info != null)
					{
						$zabinding     = $class_info->getBinding();
						if($zabinding != null)
						{
							$binding     = $zabinding->getDisplayValue();
						}
						else
						{
							$binding     = '';
						}
						$zaproduct_group     = $class_info->getProductGroup();
						if($zaproduct_group != null)
						{
							$product_group     = $zaproduct_group->getDisplayValue();
						}
						else
						{
							$product_group     = '';
						}
					}
					else
					{
						$binding     = '';
						$product_group     = '';
					}
					$content_rating     = $item_info->getContentRating();
					if($content_rating != null)
					{
						$rating     = $content_rating->getAudienceRating();
						if ($rating !== null) 
						{
							$rating = $rating->getDisplayValue();
						} 
						else 
						{
							$rating = '';
						}
					}
					else
					{
						$rating     = '';
					}
					
					$external_ids     = $item_info->getExternalIds();
					if($external_ids != null)
					{
						$eans     = $external_ids->getEANs();
						if ($eans !== null && is_array($eans->getDisplayValues())) 
						{
							$eans = $eans->getDisplayValues()[0];
						}
						else
						{
							$eans = '';
						}
						$isbns     = $external_ids->getISBNs();
						if ($isbns !== null && is_array($isbns->getDisplayValues())) 
						{
							$isbns = $isbns->getDisplayValues()[0];
						}
						else
						{
							$isbns = '';
						}
						$product_upc     = $external_ids->getUPCs();
						if ($product_upc !== null && is_array($product_upc->getDisplayValues())) 
						{
							$product_upc = $product_upc->getDisplayValues()[0];
						}
						else
						{
							$product_upc = '';
						}
					}
					else
					{
						$eans     = '';
						$isbns     = '';
						$product_upc     = '';
					}
					$manu_info     = $item_info->getManufactureInfo();
					if($manu_info != null)
					{
						$part_no     = $manu_info->getItemPartNumber();
						if ($part_no !== null) 
						{
							$part_no     = $part_no->getDisplayValue();
						}
						else
						{
							$part_no     = '';
						}
						$model     = $manu_info->getModel();
						if ($model !== null) 
						{
							$model     = $model->getDisplayValue();
						}
						else
						{
							$model     = '';
						}
						$warranty     = $manu_info->getWarranty();
						if ($warranty !== null) 
						{
							$warranty     = $warranty->getDisplayValue();
						}
						else
						{
							$warranty     = '';
						}
					}
					else
					{
						$part_no     = '';
						$model     = '';
						$warranty     = '';
					}
					$product_info     = $item_info->getProductInfo();
					if($product_info != null)
					{
						$color     = $product_info->getColor();
						if($color !== null)
						{
							$color = $color->getDisplayValue();
						}
						$is_adult     = $product_info->getIsAdultProduct();
                        if($is_adult !== null)
                        {
                            $is_adult     = $is_adult->getDisplayValue();
                        }
                        else
                        {
                            $is_adult     = 'false';
                        }
						$dimensions     = $product_info->getItemDimensions();
						if ($dimensions !== null) 
						{
							$xheight = $dimensions->getHeight() ? $dimensions->getHeight()->getDisplayValue() . " " . $dimensions->getHeight()->getUnit() : "N/A";
							$xlength = $dimensions->getLength() ? $dimensions->getLength()->getDisplayValue() . " " . $dimensions->getLength()->getUnit() : "N/A";
							$xweight = $dimensions->getWeight() ? $dimensions->getWeight()->getDisplayValue() . " " . $dimensions->getWeight()->getUnit() : "N/A";
							$xwidth = $dimensions->getWidth() ? $dimensions->getWidth()->getDisplayValue() . " " . $dimensions->getWidth()->getUnit() : "N/A";
							$dimensions = "$xwidth x $xheight x $xlength $xweight";
							$dimensions = str_replace('N/A x N/A x N/A ', '', $dimensions);
						}
						else 
						{
							$dimensions = '';
						}

						$date     = $product_info->getReleaseDate();
						if($date !== null)
						{
							$date = $date->getDisplayValue();
						}
						else
						{
							$date = aiomatic_get_date_now();
						}
						$xs = $product_info->getSize();
						if($xs != null)
						{
							$size     = $xs->getDisplayValue();
						}
						else
						{
							$size     = '';
						}
						$unit_count     = $product_info->getUnitCount();
						if($unit_count != null)
						{
							$unit_count     = $unit_count->getDisplayValue();
						}
						else
						{
							$unit_count     = '';
						}
					}
					else
					{
						$color     = '';
						$is_adult     = '';
						$dimensions     = '';
						$date     = aiomatic_get_date_now();
						$size     = '';
						$unit_count     = '';
					}
					if ($contributors != '') 
					{
						$author = $contributors;
					}
					elseif ($manufacturer != '') 
					{
						$author = $manufacturer;
					} 
					elseif ($brand != '') 
					{
						$author = $brand;
					} 
					$score = $item->getScore();
					if($score != null)
					{
						$score     = $score->getDisplayValue();
					}
					else
					{
						$score     = '';
					}
					$temp->item_score = $score;
					$temp->edition = $edition;
					$temp->language = $language;
					$temp->pages_count = $pages_count;
					$temp->publication_date = $publication_date;
					$temp->product_brand = $brand;
					$temp->contributors = $contributors;
					$temp->manufacturer = $manufacturer;
					$temp->binding = $binding;
					$temp->product_group = $product_group;
					$temp->rating = $rating;
					$temp->eans = $eans;
					$temp->product_isbn = $isbns;
					$temp->product_upc = $product_upc;
					$temp->part_no = $part_no;
					$temp->model = $model;
					$temp->warranty = $warranty;
					$temp->color = $color;
					$temp->is_adult = $is_adult;
					$temp->dimensions = $dimensions;
					$temp->date = $date;
					$temp->size = $size;
					$temp->unit_count = $unit_count;

					$temp->product_author = $author;
					$temp->product_list_price = $full_price;
					$zatitle = $item_info->getTitle();
					if($zatitle != null)
					{
						$ztitle = $zatitle->getDisplayValue();
					}
					else
					{
						$ztitle = '';
					}
					$temp->offer_title = $ztitle;
					$features     = $item_info->getFeatures();
					$xcontent = '';
					if($features != null)
					{
						$features_display     = $features->getDisplayValues();
						if($features_display != null)
						{
							$xcontent .= '<ul>';
							foreach($features_display as $dv)
							{
								$xcontent .= '<li>' . $dv . '</li>';
							}
							$xcontent .= '</ul>';
						}
					}
					$temp->offer_desc = $xcontent;
					$temp->offer_url = $item->getDetailPageURL();
					$temp->source_link = $item->getDetailPageURL();
					$temp->offer_price = $price;
					$temp->product_price = $price;
					$offer_img = '';
					$offer_imgs = '';
					$allImages = array();
					$images = $item->getImages();
					if($images != null)
					{
						$primary = $images->getPrimary();
						if($primary != null)
						{
							$lp = $primary->getLarge();
							if($lp != null)
							{
								$offer_img = $lp->getURL();
							}
						}
						$variants = $images->getVariants();
						if($variants != null)
						{
							foreach($variants as $vari)
							{
								$vari_large = $vari->getLarge();
								if($vari_large != null)
								{
									if(empty($offer_img))
									{
										$offer_img = $vari_large->getURL();
									}
									$allImages[] = $vari_large->getURL();
									$offer_imgs .= $vari_large->getURL() . ',';
								}
							}
						}
					}
					$offer_imgs = trim($offer_imgs, ',');
					$temp->offer_img = $offer_img;
					$temp->product_img = $offer_img;
					$temp->price_numeric = $price;
					$temp->price_numeric = $price;
					$temp->list_price_numeric = '$';
					$temp->item_reviews = array();
					$temp->review_link = '';
					$tag = '';
					$subscription = '';
					$temp->product_asin = (string)$item->getASIN();
					$temp->cart_url = $item->getDetailPageURL();
					$temp->product_imgs = $offer_imgs;
					$cg_am_full_img_t = '<img src="[img_src]" class="amazon_gallery" />';
					$allImages_html = '';
					foreach($allImages as $singleImage) {
						$singleImageHtml = $cg_am_full_img_t;
						$singleImageHtml = str_replace('[img_src]', $singleImage, $singleImageHtml);
						$allImages_html .= $singleImageHtml;
					}
					$temp->product_imgs_html = $allImages_html;
					if ($temp->product_price == $temp->product_list_price) {
						$temp->price_with_discount_fixed = $temp->product_price;
					} else {
						$temp->price_with_discount_fixed = '<del>' . $temp->product_list_price . '</del> - ' . $temp->product_price;
					}
					if (trim($temp->product_price) == '')
						$temp->product_price = $temp->price_numeric;
					if (trim($temp->product_list_price) == '')
						$temp->product_list_price = $temp->price_numeric;
					$temp_rez[] = $temp;
				}
			} else {
				aiomatic_log_to_file('Amazon no results found.');
				return false;
			}
			return $temp_rez;
		}
		else
		{
			aiomatic_log_to_file('No usable keywords found!');
		}
	}
	return array();
}
function aiomatic_amazon_fetch_links($keyword, $region, $affiliateID, $ch, $low_price, $high_price, $order, $max, $page, $posted_items) {
	$scrapeURL = "https://www.amazon.{$region}/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=" . urlencode(trim($keyword));
	if($low_price != '' && is_numeric($low_price))
	{
		$scrapeURL .= '&low-price=' . $low_price / 100;
	}
	if($high_price != '' && is_numeric($high_price))
	{
		$scrapeURL .= '&high-price=' . $high_price / 100;
	}
	if($order != '' && $order != 'none')
	{
		$scrapeURL .= '&sort=' . $order;
	}
	if($page != '' && is_numeric($page) && $page > 1)
	{
		$scrapeURL .= '&page=' . $page;
	}
	require_once (dirname(__FILE__) . '/aiomatic-noapi.php');
	$obj = new aiomatic_no_amazon_api($ch, $region);	
	try 
	{
		curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
		aiomatic_simulate_location($region);
		$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
		if (preg_match('!^B0!', $keyword)) 
		{		
			$ASINs = explode('|', $keyword);
			$ASINs = array_map('trim', $ASINs);
		} 
		else 
		{
			if (isset($aiomatic_Main_Settings['enable_detailed_logging']) && $aiomatic_Main_Settings['enable_detailed_logging'] == 'on') {
				aiomatic_log_to_file('Scraping: ' . $scrapeURL);
			}
			$transval = get_transient('aiomatic-' . $scrapeURL);
			if($transval !== false)
			{
				$ASINs = $transval;
			}
			else
			{
				$ASINs = $obj->getASINs($scrapeURL);
				if(!empty($ASINs))
				{
					set_transient('aiomatic-' . $scrapeURL, $ASINs, 60 * 60 * 24 * 30 * 6);
				}
			}
			if (isset($aiomatic_Main_Settings['enable_detailed_logging']) && $aiomatic_Main_Settings['enable_detailed_logging'] == 'on') {
				aiomatic_log_to_file('Returned product count: ' . count($ASINs));
			}
		}	
		$slugs = $obj->slugs;
		$i = 0;
		$results = array();
		foreach($ASINs as $ASIN) {
			if(in_array($ASIN, $posted_items))
			{
				if (isset($aiomatic_Main_Settings['enable_detailed_logging']) && $aiomatic_Main_Settings['enable_detailed_logging'] == 'on') {
					aiomatic_log_to_file('Skipping product, already published: ' . $ASIN);
				}
				continue;
			}
			$slug = '';
			if (isset($slugs [$i]))
				$slug = $slugs [$i];
			$mobj = new AiomaticObj();
			$mobj->link_url = $ASIN;
			$mobj->link_keyword = $keyword;
			$mobj->link_status = '0';
			$mobj->link_desc = $slug;
			$results[] = $mobj;
			$i ++;
		}
		if(count($results) == 0 && count($ASINs) > 0)
		{
			return false;
		}
		$results = array_slice($results, 0, $max, true);
		return $results;
	} 
	catch(Exception $e) 
	{
		aiomatic_log_to_file('Exception during Amazon scraping: ' . $e->getMessage ());
		return array();
	}
}

function aiomatic_simulate_location($region) 
{
	if (!isset($GLOBALS['aiomatic_simulated']) || $GLOBALS['aiomatic_simulated'] == false) 
	{
		$aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
		$curlpost = '';
		if ($region == 'com') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=10001&storeContext=gateway&deviceType=web&pageType=Search&actionSource=glow";
		} elseif ($region == 'co.uk') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=E1+7EF&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'ca') {
			$curlpost = 'locationType=LOCATION_INPUT&zipCode=V5K+0A1&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow';
		} elseif ($region == 'de') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=10178&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'fr') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=75000&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'it') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=00127&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'es') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=08005&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'co.jp') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=100-0000&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'in') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=110001&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'com.br') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=20010-000&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		} elseif ($region == 'com.mx') {
			$curlpost = "locationType=LOCATION_INPUT&zipCode=44100&storeContext=generic&deviceType=web&pageType=Gateway&actionSource=glow";
		}
		if($curlpost != '')
		{
			$curlurl = "https://www.amazon.$region/gp/delivery/ajax/address-change.html";
			$ch = curl_init();
			if (isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled')
			{
				$prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
				$randomness = array_rand($prx);
				curl_setopt($ch, CURLOPT_PROXY , trim($prx[$randomness]));
				if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
				{
					$prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
					if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
					{
						curl_setopt($ch, CURLOPT_PROXYUSERPWD , trim($prx_auth[$randomness]));
					}
				}
			}
			curl_setopt ( $ch, CURLOPT_URL, $curlurl );
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curlpost );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10);
			if (isset($aiomatic_Main_Settings['max_timeout']) && $aiomatic_Main_Settings['max_timeout'] != '')
			{
				$ztime = intval($aiomatic_Main_Settings['max_timeout']);
			}
			else
			{
				$ztime = 300;
			}
			curl_setopt($ch, CURLOPT_TIMEOUT, $ztime);
			$exec = curl_exec ( $ch );
			curl_close($ch);
			$GLOBALS['aiomatic_simulated'] = true;
		}
	}
}
?>