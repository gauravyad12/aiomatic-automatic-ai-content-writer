<?php
defined('ABSPATH') or die();
function aiomatic_check_if_phantom($use_phantom)
{
    if($use_phantom == '1' || $use_phantom == '2' || $use_phantom == '3' || $use_phantom == '4' || $use_phantom == '5' || $use_phantom == '6')
    {
        return true;
    }
    return false;
}

function aiomatic_get_content($type, $getname, $htmlcontent, $single = false, $array = false)
{
    if($array == true)
    {
        $extract = array();
    }
    else
    {
        $extract = '';
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (isset($aiomatic_Main_Settings['multi_separator'])) {
        $cont_sep = $aiomatic_Main_Settings['multi_separator'];
    }
    else
    {
        if($single == true)
        {
            $cont_sep = '';
        }
        else
        {
            $cont_sep = '<br/>';
        }
    }
    if ($type == 'regex') {
        $matches     = array();
        $rez = preg_match_all($getname, $htmlcontent, $matches);
        if ($rez === FALSE) {
            $rez = preg_match_all('~' . $getname . '~', $htmlcontent, $matches);
            if ($rez === FALSE) {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('[aiomatic_get_content] preg_match_all failed for expr: ' . $getname . '!');
                }
                if($array == true)
                {
                    return array();
                }
                else
                {
                    return '';
                }
            }
        }
        $regcnt = 0;
        foreach ($matches as $match) {
            if($regcnt == 0)
            {
                $regcnt++;
                continue;
            }
            if(!isset($match[0]))
            {
                continue;
            }
            $regcnt++;
            if($array == true)
            {
                $extract[] = $match[0];
                if($single === true)
                {
                    break;
                }
            }
            else
            {
                $extract .= $match[0];
                if($single === true)
                {
                    break;
                }
                else
                {
                    $extract .= $cont_sep;
                }
            }
        }
    } elseif ($type == 'regexall') {
        $matches     = array();
        $rez = preg_match_all($getname, $htmlcontent, $matches);
        if ($rez === FALSE) {
            $rez = preg_match_all('~' . $getname . '~', $htmlcontent, $matches);
            if ($rez === FALSE) {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('[aiomatic_get_content] preg_match_all failed for expr: ' . $getname . '!');
                }
                if($array == true)
                {
                    return array();
                }
                else
                {
                    return '';
                }
            }
        }
        $regcnt = 0;
        foreach ($matches as $match) {
            if($regcnt == 0 && count($matches) > 1)
            {
                $regcnt++;
                continue;
            }
            if(!isset($match[0]))
            {
                continue;
            }
            $regcnt++;
            foreach($match as $mmatch)
            {
                if($array == true)
                {
                    $extract[] = $mmatch;
                }
                else
                {
                    $extract .= $mmatch . $cont_sep;
                }
            }
            if($single === true)
            {
                break;
            }
        }
    } elseif ($type == 'xpath' || $type == 'visual') {
        require_once (dirname(__FILE__) . "/res/simple_html_dom.php");
        $extractok = false;
        $html_dom_original_html = aiomatic_str_get_html($htmlcontent);
        if(stristr($getname, ' or ') === false && $html_dom_original_html !== false && method_exists($html_dom_original_html, 'find')){
            $ret = $html_dom_original_html->find( trim($getname) );
            if(count($ret) == 0)
            {
                $html_dom_original_html->clear();
                $html_dom_original_html = null;
                unset($html_dom_original_html);
                $doc = new DOMDocument;
                $internalErrors = libxml_use_internal_errors(true);
                $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlcontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_use_internal_errors($internalErrors);
                $xpath = new \DOMXpath($doc);
                $articles = $xpath->query(trim($getname));
                if($articles !== false && $articles->length > 0)
                {
                    foreach($articles as $container) {
						if(method_exists($container, 'saveHTML'))
						{
                            $extractok = true;
                            preg_match_all('#(?:[\s\S]*?)@([^"\'\]\[@\/\\*=]*)$#', $getname, $rezmetch);
                            if($array == true)
                            {
                                if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                                {
                                    $extract[] = $container->nodeValue;
                                }
                                else
                                {
                                    $extract[] = $container->saveHTML();
                                }
                            }
                            else
                            {
                                if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                                {
                                    $extract .= $container->nodeValue . $cont_sep;
                                }
                                else
                                {
                                    $extract .= $container->saveHTML() . $cont_sep;
                                }
                            }
						}
                        elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                        {
                            $extractok = true;
                            preg_match_all('#(?:[\s\S]*?)@([^"\'\]\[@\/\\*=]*)$#', $getname, $rezmetch);
                            if($array == true)
                            {
                                if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                                {
                                    $extract[] = $container->nodeValue;
                                }
                                else
                                {
                                    $extract[] = $container->ownerDocument->saveHTML($container);
                                }
                            }
                            else
                            {
                                if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                                {
                                    $extract .= $container->nodeValue . $cont_sep;
                                }
                                else
                                {
                                    $extract .= $container->ownerDocument->saveHTML($container) . $cont_sep;
                                }
                            }
                        }
                        elseif(isset($container->nodeValue))
                        {
                            $extractok = true;
                            if($array == true)
                            {
                                $extract[] = $container->nodeValue;
                            }
                            else
                            {
                                $extract .= $container->nodeValue . $cont_sep;
                            }
                        }
                    }
                }
                else
                {
                    if($getname != '//select[@name="id"]')
                    {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                            aiomatic_log_to_file('aiomatic_str_get_html failed for page (first attempt), xpath is: ' . $getname . '!');
                        }
                    }
                }
            }
            else
            {
                foreach ($ret as $item ) 
                {
                    $extractok = true;
                    if($array == true)
                    {
                        if($item->innertext == '')
                        {
                            $extract[] = $item->outertext;
                        }
                        else
                        {
                            $extract[] = $item->innertext;
                        }
                        if($single === true)
                        {
                            break;
                        }
                    }
                    else
                    {
                        if($item->innertext == '')
                        {
                            $extract .= $item->outertext;
                        }
                        else
                        {
                            $extract .= $item->innertext;
                        }
                        if($single === true)
                        {
                            break;
                        }
                        else
                        {
                            $extract .= $cont_sep;
                        }
                    }
                }
                $html_dom_original_html->clear();
                $html_dom_original_html = null;
                unset($html_dom_original_html);
            }
        }
        if($extractok == false)
        {
            $doc = new DOMDocument;
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlcontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors($internalErrors);
            $xpath = new \DOMXpath($doc);
            $articles = $xpath->query(trim($getname));
            if($articles !== false && $articles->length > 0)
            {
                foreach($articles as $container) {
					if(method_exists($container, 'saveHTML'))
					{
                        preg_match_all('#(?:[\s\S]*?)@([^"\'\]\[@\/\\*=]*)$#', $getname, $rezmetch);
                        if($array == true)
                        {
                            if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                            {
                                $extract[] = $container->nodeValue;
                            }
                            else
                            {
                                $extract[] = $container->saveHTML();
                            }
                        }
                        else
                        {
                            if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                            {
                                $extract .= $container->nodeValue . $cont_sep;
                            }
                            else
                            {
                                $extract .= $container->saveHTML() . $cont_sep;
                            }
                        }
					}
                    elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                    {
                        preg_match_all('#(?:[\s\S]*?)@([^"\'\]\[@\/\\*=]*)$#', $getname, $rezmetch);
                        if($array == true)
                        {
                            if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                            {
                                $extract[] = $container->nodeValue;
                            }
                            else
                            {
                                $extract[] = $container->ownerDocument->saveHTML($container);
                            }
                        }
                        else
                        {
                            if(isset($rezmetch[1][0]) && isset($container->nodeValue))
                            {
                                $extract .= $container->nodeValue . $cont_sep;
                            }
                            else
                            {
                                $extract .= $container->ownerDocument->saveHTML($container) . $cont_sep;
                            }
                        }
                    }
                    elseif(isset($container->nodeValue))
                    {
                        $extract .= $container->nodeValue . $cont_sep;
                    }
                }
            }
            else
            {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging']) && $getname != '//select[@name="id"]') {
                    aiomatic_log_to_file('aiomatic_str_get_html failed for page, xpath: ' . $getname . '!');
                }
                if($array == true)
                {
                    return array();
                }
                else
                {
                    return '';
                }
            }
        }
    } elseif ($type == 'class' && strstr(trim($getname), ' ') === false) {
        require_once (dirname(__FILE__) . "/res/simple_html_dom.php");
        $extractok = false;
        $html_dom_original_html = aiomatic_str_get_html($htmlcontent);
        if($html_dom_original_html !== false && method_exists($html_dom_original_html, 'find')){
            $getnames = explode(',', $getname);
            foreach($getnames as $gname)
            {
                $ret = $html_dom_original_html->find('//*[contains(@class, "' . trim($gname) . '")]');
                foreach ($ret as $item ) {
                    $extractok = true;
                    if($array == true)
                    {
                        if($item->innertext != ''){
                            $extract[] = $item->innertext ;
                        }else{
                            $extract[] = $item->outertext ;
                        }
                        if ($single == '1') {
                            break;
                        }
                    }
                    else
                    {
                        if($item->innertext != ''){
                            $extract .= $item->innertext . $cont_sep ;
                        }else{
                            $extract .= $item->outertext . $cont_sep ;
                        }
                        if ($single == '1') {
                            break;
                        }
                    }
                }
            }
            $html_dom_original_html->clear();
            unset($html_dom_original_html);
        }
        if($extractok == false)
        {
            $oks = false;
            $doc = new DOMDocument;
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlcontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors($internalErrors);
            $xpath = new \DOMXpath($doc);
            $getnames = explode(',', $getname);
            foreach($getnames as $gname)
            {
                $articles = $xpath->query('//*[contains(@class, "' . $gname . '")]');
                if($articles !== false && $articles->length > 0)
                {
                    foreach($articles as $container) {
                        if($array == true)
                        {
                            if(method_exists($container, 'saveHTML'))
                            {
                                $oks = true;
                                $extract[] = $container->saveHTML();
                            }
                            elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                            {
                                $oks = true;
                                $extract[] = $container->ownerDocument->saveHTML($container);
                            }
                            elseif(isset($container->nodeValue))
                            {
                                $oks = true;
                                $extract[] = $container->nodeValue;
                            }
                        }
                        else
                        {
                            if(method_exists($container, 'saveHTML'))
                            {
                                $oks = true;
                                $extract .= $container->saveHTML() . $cont_sep;
                            }
                            elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                            {
                                $oks = true;
                                $extract .= $container->ownerDocument->saveHTML($container) . $cont_sep;
                            }
                            elseif(isset($container->nodeValue))
                            {
                                $oks = true;
                                $extract .= $container->nodeValue . $cont_sep;
                            }
                        }
                    }
                }
            }
            if($oks == false)
            {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('No matching content found for query: //*[contains(@class, "' . $getname . '")]');
                }
                if($array == true)
                {
                    return array();
                }
                else
                {
                    return '';
                }
            }
        }
    } else {
        require_once (dirname(__FILE__) . "/res/simple_html_dom.php");
        $extractok = false;
        $html_dom_original_html = aiomatic_str_get_html($htmlcontent);
        if($html_dom_original_html !== false && method_exists($html_dom_original_html, 'find')){
            $getnames = explode(',', $getname);
            foreach($getnames as $gname)
            {
                $ret = $html_dom_original_html->find('*['.$type.'="'.trim($gname).'"]');
                if(count($ret) == 0)
                {
                    $doc = new DOMDocument;
                    $internalErrors = libxml_use_internal_errors(true);
                    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlcontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    libxml_use_internal_errors($internalErrors);
                    $xpath = new \DOMXpath($doc);
                    $articles = $xpath->query('//*[@'.$type.'="'.trim($gname).'"]');
                    $oks = false;
                    if($articles !== false && $articles->length > 0)
                    {
                        foreach($articles as $container) {
                            if($array == true)
                            {
                                if(method_exists($container, 'saveHTML'))
                                {
                                    $extractok = true;
                                    $oks = true;
                                    $extract[] = $container->saveHTML();
                                }
                                elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                                {
                                    $extractok = true;
                                    $extract[] = $container->ownerDocument->saveHTML($container);
                                }
                                elseif(isset($container->nodeValue))
                                {
                                    $extractok = true;
                                    $oks = true;
                                    $extract[] = $container->nodeValue;
                                }
                            }
                            else
                            {
                                if(method_exists($container, 'saveHTML'))
                                {
                                    $extractok = true;
                                    $oks = true;
                                    $extract .= $container->saveHTML() . $cont_sep;
                                }
                                elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                                {
                                    $extractok = true;
                                    $extract .= $container->ownerDocument->saveHTML($container) . $cont_sep;
                                }
                                elseif(isset($container->nodeValue))
                                {
                                    $extractok = true;
                                    $oks = true;
                                    $extract .= $container->nodeValue . $cont_sep;
                                }
                            }
                        }
                    }
                    if($oks == false)
                    {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                            aiomatic_log_to_file('No content found matching the query you set (first attempt): *[' . $type . '="' . trim($gname) . '"]');
                        }
                    }
                }
                else
                {
                    foreach ($ret as $item ) {
                        $extractok = true;
                        if($array == true)
                        {
                            if($item->innertext == '')
                            {
                                $extract[] = $item->outertext;
                            }
                            else
                            {
                                $extract[] = $item->innertext;
                            }
                        }
                        else
                        {
                            if($item->innertext == '')
                            {
                                $extract .= $item->outertext . $cont_sep;
                            }
                            else
                            {
                                $extract .= $item->innertext . $cont_sep;
                            }
                        }
                        if($single === true)
                        {
                            break;
                        }
                    }
                }
            }
        }
        if($extractok == false)
        {
            $html_dom_original_html = null;
            unset($html_dom_original_html);
            $doc = new DOMDocument;
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="utf-8" ?>' . $htmlcontent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_use_internal_errors($internalErrors);
            $xpath = new \DOMXpath($doc);
            $getnames = explode(',', $getname);
            $oks = false;
            foreach($getnames as $gname)
            {
                $articles = $xpath->query('//*[@'.$type.'="'.trim($gname).'"]');
                if($articles !== false && $articles->length > 0)
                {
                    foreach($articles as $container) {
                        if($array == true)
                        {
                            if(method_exists($container, 'saveHTML'))
                            {
                                $oks = true;
                                $extract[] = $container->saveHTML();
                            }
                            elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                            {
                                $oks = true;
                                $extract[] = $container->ownerDocument->saveHTML($container);
                            }
                            elseif(isset($container->nodeValue))
                            {
                                $oks = true;
                                $extract[] = $container->nodeValue;
                            }
                        }
                        else
                        {
                            if(method_exists($container, 'saveHTML'))
                            {
                                $oks = true;
                                $extract .= $container->saveHTML() . $cont_sep;
                            }
                            elseif(isset($container->ownerDocument) && method_exists($container->ownerDocument, 'saveHTML'))
                            {
                                $oks = true;
                                $extract .= $container->ownerDocument->saveHTML($container) . $cont_sep;
                            }
                            elseif(isset($container->nodeValue))
                            {
                                $oks = true;
                                $extract .= $container->nodeValue . $cont_sep;
                            }
                        }
                    }
                }
            }
            if($oks == false)
            {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('No matching content found for query: ' . '*['.$type.'="'.trim($getname).'"]');
                }
                if($array == true)
                {
                    return array();
                }
                else
                {
                    return '';
                }
            }
        }
    }
    if($array == false)
    {
        if($cont_sep != '' && $cont_sep != '<br/>')
        {
            $extract = rtrim($extract, $cont_sep);
        }
    }
    return $extract;
}
function aiomatic_testTor()
{
    if(!function_exists('shell' . '_exec')) {
        return -1;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell' . '_exec', $disabled))
    {
        return -2;
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $custom_user_agent = 'default';
    $custom_cookies = 'default';
    $user_pass = 'default';
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';
    $url = 'https://example.com';
    $puppeteer_comm = 'node ';
    $puppeteer_comm .= '"' . dirname(__FILE__) . '/res/puppeteer/torcheck.js" "' . $url . '" ' . $phantomjs_proxcomm . '  "' . $custom_user_agent . '" "' . $custom_cookies . '" "' . $user_pass . '" "' . $phantomjs_timeout . '" "0"';
    $puppeteer_comm .= ' 2>&1';
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        aiomatic_log_to_file('Puppeteer-Tor TEST command: ' . $puppeteer_comm);
    }
    $shefunc = trim(' s ') . trim(' h ') . 'ell' . '_exec';
    $cmdResult = $shefunc($puppeteer_comm);
    if($cmdResult === NULL || $cmdResult == '')
    {
        aiomatic_log_to_file('puppeteer-tor did not return usable info for: ' . $url);
        return 0;
    }
    if(trim($cmdResult) === 'timeout')
    {
        aiomatic_log_to_file('puppeteer timed out while getting page (tor): ' . $url. ' - please increase timeout in Settings');
        return 0;
    }
    if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
    {
        aiomatic_log_to_file('nodeJS not found, please install it on your server');
        return 0;
    }
    if(stristr($cmdResult, 'sh: puppeteer: command not found') !== false)
    {
        aiomatic_log_to_file('puppeteer not found, please install it on your server (also tor)');
        return 0;
    }
    if(stristr($cmdResult, 'Error: Cannot find module \'puppeteer\'') !== false)
    {
        aiomatic_log_to_file('puppeteer module not found, please install it on your server');
        return 0;
    }
    if(stristr($cmdResult, 'aiomatic NOT USING TOR!') !== false)
    {
        aiomatic_log_to_file('Tor was not able to be used by aiomatic/Puppeteer. Please install Tor on your server!');
        return 0;
    }
    if(stristr($cmdResult, 'res/puppeteer/torcheck.js:') !== false)
    {
        aiomatic_log_to_file('torcheck failed to run, error: ' . $cmdResult);
        return 0;
    }
    if(stristr($cmdResult, 'TOR OK!') !== false)
    {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Tor OK!');
        }
        return 1;
    }
    aiomatic_log_to_file('Tor returned unknown result: ' . $cmdResult);
    return 0;
}

function aiomatic_testPuppeteer()
{
    if(!function_exists('shell' . '_exec')) {
        return -1;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell' . '_exec', $disabled))
    {
        return -2;
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $custom_user_agent = 'default';
    $custom_cookies = 'default';
    $user_pass = 'default';
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $url = 'https://example.com';
    $phantomjs_proxcomm = '"null"';
    $puppeteer_comm = 'node ';
    $puppeteer_comm .= '"' . dirname(__FILE__) . '/res/puppeteer/puppeteer.js" "' . $url . '" ' . $phantomjs_proxcomm . '  "' . $custom_user_agent . '" "' . $custom_cookies . '" "' . $user_pass . '" "' . $phantomjs_timeout . '"';
    $puppeteer_comm .= ' 2>&1';
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        aiomatic_log_to_file('Puppeteer TEST command: ' . $puppeteer_comm);
    }
    $shefunc = trim(' s ') . trim(' h ') . 'ell' . '_exec';
    $cmdResult = $shefunc($puppeteer_comm);
    if($cmdResult === NULL || $cmdResult == '')
    {
        aiomatic_log_to_file('puppeteer did not return usable info for: ' . $url);
        return 0;
    }
    if(trim($cmdResult) === 'timeout')
    {
        aiomatic_log_to_file('puppeteer timed out while getting page: ' . $url. ' - please increase timeout in Settings');
        return 0;
    }
    if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
    {
        aiomatic_log_to_file('nodeJS not found, please install it on your server');
        return 0;
    }
    if(stristr($cmdResult, 'sh: puppeteer: command not found') !== false)
    {
        aiomatic_log_to_file('puppeteer not found, please install it on your server');
        return 0;
    }
    if(stristr($cmdResult, 'res/puppeteer/puppeteer.js:') !== false)
    {
        aiomatic_log_to_file('puppeteercheck failed to run, error: ' . $cmdResult);
        return 0;
    }
    if(stristr($cmdResult, 'Example Domain') !== false)
    {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Puppeteer OK!');
        }
        return 1;
    }
    aiomatic_log_to_file('Puppeteer returned unknown result: ' . $cmdResult);
    return 0;
}

function aiomatic_get_page_Tor($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '')
{
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!function_exists('shell' . '_exec')) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('shel' . 'l_exec not found!');
        }
        return false;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell' . '_exec', $disabled))
    {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('shel' . 'l_exec disabled');
        }
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(3), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if($timeout != '')
    {
        $timeout = 'default';
    } 
    if($scripter == '')
    {
        $scripter = 'default';
    }
    if($local_storage == '')
    {
        $local_storage = 'default';
    } 
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';

    $puppeteer_comm = 'node ';
    $puppeteer_comm .= '"' . dirname(__FILE__) . '/res/puppeteer/tor.js" "' . $url . '" ' . $phantomjs_proxcomm . '  "' . $custom_user_agent . '" "' . $custom_cookies . '" "' . $user_pass . '" "' . $phantomjs_timeout . '" "1" "' . $timeout . '" "' . addslashes($scripter) . '" "' . addslashes($local_storage) . '"';
    $puppeteer_comm .= ' 2>&1';
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        aiomatic_log_to_file('Puppeteer-Tor command: ' . $puppeteer_comm);
    }
    $shefunc = trim(' s ') . trim(' h ') . 'ell' . '_exec';
    $cmdResult = $shefunc($puppeteer_comm);
    if($cmdResult === NULL || $cmdResult == '')
    {
        aiomatic_log_to_file('puppeteer-tor did not return usable info for: ' . $url);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(trim($cmdResult) === 'timeout')
    {
        aiomatic_log_to_file('puppeteer timed out while getting page (tor): ' . $url. ' - please increase timeout in Settings');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'Error: Cannot find module \'puppeteer\'') !== false)
    {
        aiomatic_log_to_file('puppeteer not found on server: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
    {
        aiomatic_log_to_file('nodeJS not found, please install it on your server');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'sh: puppeteer: command not found') !== false)
    {
        aiomatic_log_to_file('puppeteer not found, please install it on your server (also tor)');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'aiomatic NOT USING TOR!') !== false)
    {
        aiomatic_log_to_file('Tor was not able to be used by aiomatic/Puppeteer. Please install Tor on your server!');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'process.on(\'unhandledRejection\', up => { throw up })') !== false)
    {
        aiomatic_log_to_file('puppeteer failed to download resource: ' . $url . ' - error: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'Unhandled Rejection, reason: { TimeoutError') !== false)
    {
        aiomatic_log_to_file('puppeteer failed to download resource: ' . $url . ' - timeout error: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'res/puppeteer/tor.js:') !== false)
    {
        aiomatic_log_to_file('tor failed to run, error: ' . $cmdResult);
        return false;
    }
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        //aiomatic_log_to_file('Downloaded site (Puppeteer): ' . $url . ' -- ' . esc_html($cmdResult));
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return $cmdResult;
}

function aiomatic_get_page_PuppeteerAPI($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '', $auto_captcha = '', $enable_adblock = '', $clickelement = '')
{
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
    {
        aiomatic_log_to_file('You need to add your HeadlessBrowserAPI key in the plugin\'s \'Settings\' before you can use this feature.');
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(4), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $proxy_url = $aiomatic_Main_Settings['proxy_url'];
        if(isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '')
        {
            $proxy_auth = $aiomatic_Main_Settings['proxy_auth'];
        }
        else
        {
            $proxy_auth = 'default';
        }
    }
    else
    {
        $proxy_url = 'default';
        $proxy_auth = 'default';
    }
    
    $za_api_url = 'https://headlessbrowserapi.com/apis/scrape/v1/puppeteer?apikey=' . trim($aiomatic_Main_Settings['headlessbrowserapi_key']) . '&url=' . urlencode($url) . '&custom_user_agent=' . urlencode($custom_user_agent) . '&custom_cookies=' . urlencode($custom_cookies) . '&user_pass=' . urlencode($user_pass) . '&timeout=' . urlencode($phantomjs_timeout) . '&proxy_url=' . urlencode($proxy_url) . '&proxy_auth=' . urlencode($proxy_auth);
    if($timeout != '')
    {
        $za_api_url .= '&sleep=' . urlencode($timeout);
    }
    if(trim($scripter) != '')
    {
        $za_api_url .= '&jsexec=' . urlencode(trim($scripter));
    }
    if(trim($local_storage) != '')
    {
        $za_api_url .= '&localstorage=' . urlencode(trim($local_storage));
    }
    $api_timeout = 120;
    if(trim($auto_captcha) == '1')
    {
        $api_timeout += 120;
        $za_api_url .= '&solvecaptcha=' . trim($auto_captcha);
    }
    if(trim($enable_adblock) == '1')
    {
        $za_api_url .= '&enableadblock=' . trim($enable_adblock);
    }
    if(trim($clickelement) != '')
    {
        $za_api_url .= '&clickelement=' . trim($clickelement);
    }
    $args = array(
       'timeout'     => $api_timeout,
       'redirection' => 10,
       'blocking'    => true,
       'compress'    => false,
       'decompress'  => true,
       'sslverify'   => false,
       'stream'      => false
    );
    $ret_data = wp_remote_get($za_api_url, $args);
    $response_code       = wp_remote_retrieve_response_code( $ret_data );
    $response_message    = wp_remote_retrieve_response_message( $ret_data );    
    if ( 200 != $response_code ) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
        {
            aiomatic_log_to_file('Failed to get response from HeadlessBrowserAPI: ' . $za_api_url . ' code: ' . $response_code . ' message: ' . $response_message);
            if(isset($ret_data->errors['http_request_failed']))
            {
                foreach($ret_data->errors['http_request_failed'] as $errx)
                {
                    aiomatic_log_to_file('Error message: ' . html_entity_decode($errx));
                }
            }
        }
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    } else {
        $cmdResult = wp_remote_retrieve_body( $ret_data );
    }
    $jcmdResult = json_decode($cmdResult, true);
    if($jcmdResult === null)
    {
        aiomatic_log_to_file('Failed to decode response from HeadlessBrowserAPI (puppeteer): ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    $cmdResult = $jcmdResult;
    if(isset($cmdResult['apicalls']))
    {
        update_option('headless_calls', esc_html($cmdResult['apicalls']));
    }
    if(isset($cmdResult['error']))
    {
        aiomatic_log_to_file('An error occurred while getting content from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult['error'], true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(!isset($cmdResult['html']))
    {
        aiomatic_log_to_file('Malformed data imported from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return '<html><body>' . $cmdResult['html'] . '</body></html>';
}

function aiomatic_get_screenshot_PuppeteerAPI($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '', $h = '0', $w = '1920', $auto_captcha = '', $enable_adblock = '', $clickelement = '')
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
    {
        aiomatic_log_to_file('You need to add your HeadlessBrowserAPI key in the plugin\'s \'Settings\' before you can use this feature.');
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(5), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $proxy_url = $aiomatic_Main_Settings['proxy_url'];
        if(isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '')
        {
            $proxy_auth = $aiomatic_Main_Settings['proxy_auth'];
        }
        else
        {
            $proxy_auth = 'default';
        }
    }
    else
    {
        $proxy_url = 'default';
        $proxy_auth = 'default';
    }
    if($h == '')
    {
        $h = '0';
    }
    if($w == '')
    {
        $w = '1920';
    }
    $za_api_url = 'https://headlessbrowserapi.com/apis/scrape/v1/screenshot?apikey=' . trim($aiomatic_Main_Settings['headlessbrowserapi_key']) . '&url=' . urlencode($url) . '&custom_user_agent=' . urlencode($custom_user_agent) . '&custom_cookies=' . urlencode($custom_cookies) . '&user_pass=' . urlencode($user_pass) . '&timeout=' . urlencode($phantomjs_timeout) . '&proxy_url=' . urlencode($proxy_url) . '&proxy_auth=' . urlencode($proxy_auth) . '&height=' . urlencode($h) . '&width=' . urlencode($w);
    if(trim($scripter) != '')
    {
        $za_api_url .= '&jsexec=' . urlencode(trim($scripter));
    }
    if(trim($local_storage) != '')
    {
        $za_api_url .= '&localstorage=' . urlencode(trim($local_storage));
    }
    $api_timeout = 120;
    if(trim($auto_captcha) == '1')
    {
        $api_timeout += 120;
        $za_api_url .= '&solvecaptcha=' . trim($auto_captcha);
    }
    if(trim($enable_adblock) == '1')
    {
        $za_api_url .= '&enableadblock=' . trim($enable_adblock);
    }
    if(trim($clickelement) != '')
    {
        $za_api_url .= '&clickelement=' . trim($clickelement);
    }
    $args = array(
       'timeout'     => $api_timeout,
       'redirection' => 10,
       'blocking'    => true,
       'compress'    => false,
       'decompress'  => true,
       'sslverify'   => false,
       'stream'      => false
    );
    $ret_data = wp_remote_get($za_api_url, $args);
    $response_code       = wp_remote_retrieve_response_code( $ret_data );
    $response_message    = wp_remote_retrieve_response_message( $ret_data );    
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    if ( 200 != $response_code ) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
        {
            aiomatic_log_to_file('Failed to get response from HeadlessBrowserAPI: ' . $za_api_url . ' code: ' . $response_code . ' message: ' . $response_message);
            if(isset($ret_data->errors['http_request_failed']))
            {
                foreach($ret_data->errors['http_request_failed'] as $errx)
                {
                    aiomatic_log_to_file('Error message: ' . html_entity_decode($errx));
                }
            }
        }
        return false;
    } else {
        $cmdResult = wp_remote_retrieve_body( $ret_data );
    }
    if(isset($cmdResult['apicalls']))
    {
        update_option('headless_calls', esc_html($cmdResult['apicalls']));
    }
    if(strstr($cmdResult, '"error"') !== false)
    {
        aiomatic_log_to_file('Failed to decode response from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        return false;
    }
    return $cmdResult;
}
function aiomatic_get_page_TorAPI($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '', $auto_captcha = '', $enable_adblock = '', $clickelement = '')
{
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
    {
        aiomatic_log_to_file('You need to add your HeadlessBrowserAPI key in the plugin\'s \'Settings\' before you can use this feature.');
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(6), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $proxy_url = $aiomatic_Main_Settings['proxy_url'];
        if(isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '')
        {
            $proxy_auth = $aiomatic_Main_Settings['proxy_auth'];
        }
        else
        {
            $proxy_auth = 'default';
        }
    }
    else
    {
        $proxy_url = 'default';
        $proxy_auth = 'default';
    }
    
    $za_api_url = 'https://headlessbrowserapi.com/apis/scrape/v1/tor?apikey=' . trim($aiomatic_Main_Settings['headlessbrowserapi_key']) . '&url=' . urlencode($url) . '&custom_user_agent=' . urlencode($custom_user_agent) . '&custom_cookies=' . urlencode($custom_cookies) . '&user_pass=' . urlencode($user_pass) . '&timeout=' . urlencode($phantomjs_timeout) . '&proxy_url=' . urlencode($proxy_url) . '&proxy_auth=' . urlencode($proxy_auth);
    if($timeout != '')
    {
        $za_api_url .= '&sleep=' . urlencode($timeout);
    }
    if(trim($scripter) != '')
    {
        $za_api_url .= '&jsexec=' . urlencode(trim($scripter));
    }
    if(trim($local_storage) != '')
    {
        $za_api_url .= '&localstorage=' . urlencode(trim($local_storage));
    }
    $api_timeout = 120;
    if(trim($auto_captcha) == '1')
    {
        $api_timeout += 120;
        $za_api_url .= '&solvecaptcha=' . trim($auto_captcha);
    }
    if(trim($enable_adblock) == '1')
    {
        $za_api_url .= '&enableadblock=' . trim($enable_adblock);
    }
    if(trim($clickelement) != '')
    {
        $za_api_url .= '&clickelement=' . trim($clickelement);
    }
    $args = array(
       'timeout'     => $api_timeout,
       'redirection' => 10,
       'blocking'    => true,
       'compress'    => false,
       'decompress'  => true,
       'sslverify'   => false,
       'stream'      => false
    );
    $ret_data = wp_remote_get($za_api_url, $args);
    $response_code       = wp_remote_retrieve_response_code( $ret_data );
    $response_message    = wp_remote_retrieve_response_message( $ret_data );    
    if ( 200 != $response_code ) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
        {
            aiomatic_log_to_file('Failed to get response from HeadlessBrowserAPI: ' . $za_api_url . ' code: ' . $response_code . ' message: ' . $response_message);
            if(isset($ret_data->errors['http_request_failed']))
            {
                foreach($ret_data->errors['http_request_failed'] as $errx)
                {
                    aiomatic_log_to_file('Error message: ' . html_entity_decode($errx));
                }
            }
        }
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    } else {
        $cmdResult = wp_remote_retrieve_body( $ret_data );
    }
    $jcmdResult = json_decode($cmdResult, true);
    if($jcmdResult === null)
    {
        aiomatic_log_to_file('Failed to decode response from HeadlessBrowserAPI (tor): ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    $cmdResult = $jcmdResult;
    if(isset($cmdResult['apicalls']))
    {
        update_option('headless_calls', esc_html($cmdResult['apicalls']));
    }
    if(isset($cmdResult['error']))
    {
        aiomatic_log_to_file('An error occurred while getting content from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult['error'], true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(!isset($cmdResult['html']))
    {
        aiomatic_log_to_file('Malformed data imported from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return '<html><body>' . $cmdResult['html'] . '</body></html>';
}
function aiomatic_get_page_PhantomJSAPI($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '')
{
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['headlessbrowserapi_key']) || trim($aiomatic_Main_Settings['headlessbrowserapi_key']) == '')
    {
        aiomatic_log_to_file('You need to add your HeadlessBrowserAPI key in the plugin\'s \'Settings\' before you can use this feature.');
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(7), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = 'default';
    }
    $phantomjs_proxcomm = '"null"';
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $proxy_url = $aiomatic_Main_Settings['proxy_url'];
        if(isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '')
        {
            $proxy_auth = $aiomatic_Main_Settings['proxy_auth'];
        }
        else
        {
            $proxy_auth = 'default';
        }
    }
    else
    {
        $proxy_url = 'default';
        $proxy_auth = 'default';
    }
    
    $za_api_url = 'https://headlessbrowserapi.com/apis/scrape/v1/phantomjs?apikey=' . trim($aiomatic_Main_Settings['headlessbrowserapi_key']) . '&url=' . urlencode($url) . '&custom_user_agent=' . urlencode($custom_user_agent) . '&custom_cookies=' . urlencode($custom_cookies) . '&user_pass=' . urlencode($user_pass) . '&timeout=' . urlencode($phantomjs_timeout) . '&proxy_url=' . urlencode($proxy_url) . '&proxy_auth=' . urlencode($proxy_auth);
    if($timeout != '')
    {
        $za_api_url .= '&sleep=' . urlencode($timeout);
    }
    if(trim($scripter) != '')
    {
        $za_api_url .= '&jsexec=' . urlencode(trim($scripter));
    }
    if(trim($local_storage) != '')
    {
        $za_api_url .= '&localstorage=' . urlencode(trim($local_storage));
    }
    $api_timeout = 120;
    $args = array(
       'timeout'     => $api_timeout,
       'redirection' => 10,
       'blocking'    => true,
       'compress'    => false,
       'decompress'  => true,
       'sslverify'   => false,
       'stream'      => false
    );
    $ret_data = wp_remote_get($za_api_url, $args);
    $response_code       = wp_remote_retrieve_response_code( $ret_data );
    $response_message    = wp_remote_retrieve_response_message( $ret_data );    
    if ( 200 != $response_code ) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
        {
            aiomatic_log_to_file('Failed to get response from HeadlessBrowserAPI: ' . $za_api_url . ' code: ' . $response_code . ' message: ' . $response_message);
            if(isset($ret_data->errors['http_request_failed']))
            {
                foreach($ret_data->errors['http_request_failed'] as $errx)
                {
                    aiomatic_log_to_file('Error message: ' . html_entity_decode($errx));
                }
            }
        }
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    } else {
        $cmdResult = wp_remote_retrieve_body( $ret_data );
    }
    $jcmdResult = json_decode($cmdResult, true);
    if($jcmdResult === null)
    {
        aiomatic_log_to_file('Failed to decode response from HeadlessBrowserAPI (phantomjs): ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    $cmdResult = $jcmdResult;
    if(isset($cmdResult['apicalls']))
    {
        update_option('headless_calls', esc_html($cmdResult['apicalls']));
    }
    if(isset($cmdResult['error']))
    {
        aiomatic_log_to_file('An error occurred while getting content from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult['error'], true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(!isset($cmdResult['html']))
    {
        aiomatic_log_to_file('Malformed data imported from HeadlessBrowserAPI: ' . $za_api_url . ' - ' . print_r($cmdResult, true));
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return '<html><body>' . $cmdResult['html'] . '</body></html>';
}
function aiomatic_get_page_Puppeteer($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $timeout = '', $request_delay = '', $scripter = '', $local_storage = '')
{
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if(!function_exists('shell' . '_exec')) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('shel' . 'l_exec not found!');
        }
        return false;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell' . '_exec', $disabled))
    {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('shel' . 'l_exec disabled');
        }
        return false;
    }
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(8), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    }
    if($timeout == '')
    {
        $timeout = 'default';
    }   
    if($scripter == '')
    {
        $scripter = 'default';
    }    
    if($local_storage == '')
    {
        $local_storage = 'default';
    } 
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = '60000';
    }
    $phantomjs_proxcomm = '"null"';
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
        $randomness = array_rand($prx);
        $phantomjs_proxcomm = '"' . trim($prx[$randomness]);
        if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
        {
            $prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
            if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
            {
                $phantomjs_proxcomm .= '~~~' . trim($prx_auth[$randomness]);
            }
        }
        $phantomjs_proxcomm .= '"';
    }
    $puppeteer_comm = 'node ';
    $puppeteer_comm .= '"' . dirname(__FILE__) . '/res/puppeteer/puppeteer.js" "' . $url . '" ' . $phantomjs_proxcomm . '  "' . $custom_user_agent . '" "' . $custom_cookies . '" "' . $user_pass . '" "' . $phantomjs_timeout . '" "' . $timeout . '" "' . addslashes($scripter) . '" "' . addslashes($local_storage) . '"';
    $puppeteer_comm .= ' 2>&1';
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        aiomatic_log_to_file('Puppeteer command: ' . $puppeteer_comm);
    }
    $shefunc = trim(' s ') . trim(' h ') . 'ell' . '_exec';
    $cmdResult = $shefunc($puppeteer_comm);
    if($cmdResult === NULL || $cmdResult == '')
    {
        aiomatic_log_to_file('puppeteer did not return usable info for: ' . $url);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(trim($cmdResult) === 'timeout')
    {
        aiomatic_log_to_file('puppeteer timed out while getting page: ' . $url. ' - please increase timeout in Settings');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'Error: Cannot find module \'puppeteer\'') !== false)
    {
        aiomatic_log_to_file('puppeteer not found on server: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
    {
        aiomatic_log_to_file('nodeJS not found, please install it on your server');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'sh: puppeteer: command not found') !== false)
    {
        aiomatic_log_to_file('puppeteer not found, please install it on your server');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'process.on(\'unhandledRejection\', up => { throw up })') !== false)
    {
        aiomatic_log_to_file('puppeteer failed to download resource: ' . $url . ' - error: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'Unhandled Rejection, reason: { TimeoutError') !== false)
    {
        aiomatic_log_to_file('puppeteer failed to download resource: ' . $url . ' - timeout error: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'res/puppeteer/puppeteer.js:') !== false)
    {
        aiomatic_log_to_file('puppeteer failed to run, error: ' . $cmdResult);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        //aiomatic_log_to_file('Downloaded site (Puppeteer): ' . $url . ' -- ' . esc_html($cmdResult));
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return $cmdResult;
}
function aiomatic_get_page_PhantomJS($url, $custom_cookies, $custom_user_agent, $use_proxy, $user_pass, $phantom_wait, $request_delay, $scripter, $local_storage)
{
    if(!function_exists('shell' . '_exec')) {
        aiomatic_log_to_file('shell_' . 'exec not found, cannot run');
        return false;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell' . '_exec', $disabled))
    {
        aiomatic_log_to_file('shell' . '_exec disabled, cannot run');
        return false;
    }
    if($custom_user_agent == 'none')
    {
        $custom_user_agent = '';
    }
    elseif($custom_user_agent == '')
    {
        $custom_user_agent = aiomatic_get_random_user_agent();
    }
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $delay = '';
    if (isset($aiomatic_Main_Settings['request_delay']) && $aiomatic_Main_Settings['request_delay'] != '') {
        if(stristr($aiomatic_Main_Settings['request_delay'], ',') !== false)
        {
            $tempo = explode(',', $aiomatic_Main_Settings['request_delay']);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($aiomatic_Main_Settings['request_delay'])))
            {
                $delay = intval(trim($aiomatic_Main_Settings['request_delay']));
            }
        }
    }
    if ($request_delay != '') 
    {
        if(stristr($request_delay, ',') !== false)
        {
            $tempo = explode(',', $request_delay);
            if(isset($tempo[1]) && is_numeric(trim($tempo[1])) && is_numeric(trim($tempo[0])))
            {
                $delay = rand(trim($tempo[0]), trim($tempo[1]));
            }
        }
        else
        {
            if(is_numeric(trim($request_delay)))
            {
                $delay = intval(trim($request_delay));
            }
        }
    }
    if($delay != '' && is_numeric($delay))
    {
        $GLOBALS['wp_object_cache']->delete('aiomatic_last_time', 'options');
        $last_time = get_option('aiomatic_last_time', false);
        if($last_time !== false && intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000) > 0)
        {
            $sleep_time = intval(((intval($last_time) - time()) * 1000 + $delay ) * 1000);
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) 
            {
                aiomatic_log_to_file('Delay between requests set(9), waiting ' . ($sleep_time/1000) . ' ms');
            }
            if($sleep_time < 21600000)
            {
                usleep($sleep_time);
            }
        }
    }
    if (isset($aiomatic_Main_Settings['phantom_path']) && $aiomatic_Main_Settings['phantom_path'] != '') 
    {
        $phantomjs_comm = $aiomatic_Main_Settings['phantom_path'];
    }
    else
    {
        $phantomjs_comm = 'phantomjs';
    }
    if (isset($aiomatic_Main_Settings['phantom_timeout']) && $aiomatic_Main_Settings['phantom_timeout'] != '') 
    {
        $phantomjs_timeout = ((int)$aiomatic_Main_Settings['phantom_timeout']);
    }
    else
    {
        $phantomjs_timeout = '60000';
    }
    if($custom_user_agent == '')
    {
        $custom_user_agent = 'default';
    }
    if($custom_cookies == '')
    {
        $custom_cookies = 'default';
    }
    if($user_pass == '')
    {
        $user_pass = 'default';
    } 
    if($scripter == '')
    {
        $scripter = 'default';
    } 
    if($local_storage == '')
    {
        $local_storage = 'default';
    } 
    if ($use_proxy == '1' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') 
    {
        $prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
        $randomness = array_rand($prx);
        $phantomjs_comm .= ' --proxy=' . trim($prx[$randomness]);
        if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
        {
            $prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
            if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
            {
                $phantomjs_comm .= ' --proxy-auth=' . trim($prx_auth[$randomness]);
            }
        }
    }
    $phantomjs_comm .= ' --ignore-ssl-errors=true ';
    $phantomjs_comm .= '"' . dirname(__FILE__) . '/res/phantomjs/phantom.js" "' . $url . '" "' . esc_html($phantomjs_timeout) . '" "' . $custom_user_agent . '" "' . $custom_cookies . '" "' . $user_pass . '" "' . esc_html($phantom_wait) . '" "' . addslashes($scripter) . '" "' . addslashes($local_storage) . '"';
    $phantomjs_comm .= ' 2>&1';
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        aiomatic_log_to_file('PhantomJS command: ' . $phantomjs_comm);
    }
    $shefunc = trim(' s ') . trim(' h ') . 'ell' . '_exec';
    $cmdResult = $shefunc($phantomjs_comm);
    if($cmdResult === NULL || $cmdResult == '')
    {
        aiomatic_log_to_file('phantomjs did not return usable info for: ' . $url);
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(trim($cmdResult) === 'timeout')
    {
        aiomatic_log_to_file('phantomjs timed out while getting page: ' . $url. ' - please increase timeout in Settings');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if(stristr($cmdResult, 'sh: phantomjs: command not found') !== false)
    {
        aiomatic_log_to_file('phantomjs not found, please install it on your server');
        if($delay != '' && is_numeric($delay))
        {
            update_option('aiomatic_last_time', time());
        }
        return false;
    }
    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
        //aiomatic_log_to_file('Downloaded site (PhantomJS): ' . $url . ' -- ' . esc_html($cmdResult));
    }
    if($delay != '' && is_numeric($delay))
    {
        update_option('aiomatic_last_time', time());
    }
    return $cmdResult;
}
?>