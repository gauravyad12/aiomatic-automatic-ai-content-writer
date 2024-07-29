<?php
defined('ABSPATH') or die();
function aiomatic_spin_text($title, $content, $alt = false)
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . ' ' . $titleSeparator . ' ' . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        require_once(dirname(__FILE__) . "/res/aiomatic-text-spinner.php");
        $phpTextSpinner = new PhpTextSpinner();
        if ($alt === FALSE) {
            $spinContent = $phpTextSpinner->spinContent($text);
        } else {
            $spinContent = $phpTextSpinner->spinContentAlt($text);
        }
        $translated = $phpTextSpinner->runTextSpinner($spinContent);
    }
    catch (Exception $e) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}


function aiomatic_best_spin_text($title, $content)
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "The Best Spinner" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $newhtml             = $title . ' ' . $titleSeparator . ' ' . $content;
    $url              = 'http://thebestspinner.com/api.php';
    $data             = array();
    $data['action']   = 'authenticate';
    $data['format']   = 'php';
    $data['username'] = $aiomatic_Main_Settings['best_user'];
    $data['password'] = $aiomatic_Main_Settings['best_password'];
    $ch               = curl_init();
    if ($ch === FALSE) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Failed to init curl!');
        }
        return FALSE;
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
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    $fdata = "";
    foreach ($data as $key => $val) {
        $fdata .= "$key=" . urlencode($val) . "&";
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $html = curl_exec($ch);
    curl_close($ch);
    if ($html === FALSE) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('"The Best Spinner" failed to exec curl.');
        }
        return FALSE;
    }
    $output = unserialize($html);
    if ($output['success'] == 'true') {
        $session                = $output['session'];
        $data                   = array();
        $data['session']        = $session;
        $data['format']         = 'php';
        $data['protectedterms'] = '';
        $data['action']         = 'replaceEveryonesFavorites';
        $data['maxsyns']        = '100';
        $data['quality']        = '1';
        $ch = curl_init();
        if ($ch === FALSE) {
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                aiomatic_log_to_file('Failed to init curl');
            }
            return FALSE;
        }
        $newhtml = html_entity_decode($newhtml);
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
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        $spinned = '';
        if(str_word_count($newhtml) > 4000)
        {
            while($newhtml != '')
            {
                $first30k = substr($newhtml, 0, 30000);
                $first30k = rtrim($first30k, '(*');
                $first30k = ltrim($first30k, ')*');
                $newhtml = substr($newhtml, 30000);
                $data['text']           = $first30k;
                $fdata = "";
                foreach ($data as $key => $val) {
                    $fdata .= "$key=" . urlencode($val) . "&";
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                $output = curl_exec($ch);
                if ($output === FALSE) {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
                    }
                    return FALSE;
                }
                $output = unserialize($output);
                if ($output['success'] == 'true') {
                    $spinned .= ' ' . $output['output'];
                } else {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('"The Best Spinner" failed to spin article.');
                    }
                    return FALSE;
                }
            }
        }
        else
        {
            $data['text'] = $newhtml;
            $fdata = "";
            foreach ($data as $key => $val) {
                $fdata .= "$key=" . urlencode($val) . "&";
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
            $output = curl_exec($ch);
            if ($output === FALSE) {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
                }
                return FALSE;
            }
            $output = unserialize($output);
            if ($output['success'] == 'true') {
                $spinned = $output['output'];
            } else {
                if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                    aiomatic_log_to_file('"The Best Spinner" failed to spin article: ' . print_r($output, true));
                }
                return FALSE;
            }
        }
        curl_close($ch);
        $result = explode($titleSeparator, $spinned);
        if (count($result) < 2) {
            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                aiomatic_log_to_file('"The Best Spinner" failed to spin article - titleseparator not found.' . print_r($output, true));
            }
            return FALSE;
        }
        $spintax = new AIomatic_Spintax();
        $result[0] = $spintax->Parse($result[0]);
        $result[1] = $spintax->Parse($result[1]);
        return $result;

    } else {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('"The Best Spinner" authentification failed. ' . $html);
        }
        return FALSE;
    }
}
class AIomatic_Spintax {
    static $countBlocks = 0;
    static $blocks = [];
    public static function Parse($text, $count = [])
    {
        if (strpos($text, '#block#') !== false) {
            $text = stripslashes(preg_replace_callback('|#block#(.*?)#/block#|si', ['Aiomatic_Spintax', 'replaceBlock'], $text));
            $newBlocks = self::$blocks;
            shuffle($newBlocks);
            $count_from = $count_to = 0;
            if (!empty($count)) {
                $count_from = (int) $count[0] > 0 ? (int) $count[0] : 1;
                $count_to = ((int) $count[1] == 0 || (int) $count[1] > count($newBlocks)) ? count($newBlocks) : (int) $count[1];
            }
            $cntBlocks = rand($count_from, $count_to);
            $cntBlocks = ($cntBlocks == 0 || $cntBlocks > count($newBlocks)) ? count($newBlocks) : $cntBlocks;
            for ($i = 0; $i < $cntBlocks; $i++) {
                $p = implode("</p><p>", $newBlocks[$i]);
                $p = str_replace('<br />', '', $p);
                $p = '<p>' . $p . '</p>';
                $text = str_replace('{#block' . ($i + 1) . '#}', $p, $text);
            }
            $text = stripslashes(preg_replace('|{#block.*?#}|si', '', $text));
            self::$countBlocks = 0;
            self::$blocks = array();
        }
        $text = str_replace('</p><br />', '</p>', $text);
        $final = preg_replace('#(<br \/>\n*)+$#', '', self::process($text));
        return $final;
    }
    public static function replaceBlock($text)
    {
        if (!empty($text[1])) {
            preg_match_all('|#p#(.*?)#/p#|si', $text[1], $matches);
            if (!empty($matches[1])) {
                $p = $matches[1];
                shuffle($p);
                foreach ($p AS $key => $val) {
                    if (empty($val)) continue;
                    $test = explode('#s#', $val);
                    $index = array_rand($test, 1);
                    $test = $test[$index];
                    $test = explode("\n", $test);
                    shuffle($test);
                    $text = implode("</p><p>", $test);
                    $text = '<p>'. $text . '</p>';
                    self::$blocks[self::$countBlocks][] = $text;
                }
            } else {
                self::$blocks[self::$countBlocks][] = trim($text[1]);
            }
        }
        self::$countBlocks++;
        return '{#block' . self::$countBlocks . '#}';
    }
    public static function process($text)
    {
        $pattern = '/\{(((?>[^\{\}]+)|(?R))*)\}/x';
        return preg_replace_callback($pattern, ['Aiomatic_Spintax', 'replace'], $text);
    }
    public static function replace($text)
    {
        $text = self::process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}
function aiomatic_replaceExcludes($text, &$htmlfounds, &$pre_tags_matches, &$pre_tags_matches_s, &$conseqMatchs)
{
    preg_match_all ( '{<script.*?script>}s', $text, $script_matchs );
    $script_matchs = $script_matchs [0];
    preg_match_all ( '{<pre.*?/pre>}s', $text, $pre_matchs );
    $pre_matchs = $pre_matchs [0];
    preg_match_all ( '{<code.*?/code>}s', $text, $code_matchs );
    $code_matchs = $code_matchs [0];
    preg_match_all ( "/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER );
    $htmlfounds = array_filter ( array_unique ( $matches [0] ) );
    $htmlfounds = array_merge ( $script_matchs, $pre_matchs, $code_matchs, $htmlfounds );
    $htmlfounds [] = '&quot;';
    $imgFoundsSeparated = array ();
    $new_imgFoundsSeparated = array ();
    $altSeparator = '';
    $colonSeparator = '';
    foreach ( $htmlfounds as $key => $currentFound ) 
    {
        if (stristr ( $currentFound, '<img' ) && stristr ( $currentFound, 'alt' ) && ! stristr ( $currentFound, 'alt=""' )) 
        {
            $altSeparator = '';
            $colonSeparator = '';
            if (stristr ( $currentFound, 'alt="' )) {
                $altSeparator = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr ( $currentFound, 'alt = "' )) {
                $altSeparator = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr ( $currentFound, 'alt ="' )) {
                $altSeparator = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr ( $currentFound, 'alt= "' )) {
                $altSeparator = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr ( $currentFound, 'alt=\'' )) {
                $altSeparator = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr ( $currentFound, 'alt = \'' )) {
                $altSeparator = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr ( $currentFound, 'alt= \'' )) {
                $altSeparator = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr ( $currentFound, 'alt =\'' )) {
                $altSeparator = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim ( $altSeparator ) != '') 
            {
                $currentFoundParts = explode ( $altSeparator, $currentFound );
                $preAlt = $currentFoundParts [1];
                $preAltParts = explode ( $colonSeparator, $preAlt );
                $altText = $preAltParts [0];
                if (trim ( $altText ) != '') 
                {
                    unset ( $preAltParts [0] );
                    $past_alt_text = implode ( $colonSeparator, $preAltParts );
                    $imgFoundsSeparated [] = $currentFoundParts [0] . $altSeparator;
                    $imgFoundsSeparated [] = $colonSeparator . $past_alt_text;
                    $htmlfounds [$key] = '';
                }
            }
        }
    }
    $title_separator = str_replace ( 'alt', 'title', $altSeparator );
    if($title_separator == '')
    {
        $title_separator = 'title';
    }
    if($colonSeparator != '')
    {
        foreach ( $imgFoundsSeparated as $img_part ) 
        {
            if (stristr ( $img_part, ' title' )) 
            {
                $img_part_parts = explode ( $title_separator, $img_part );
                $pre_title_part = $img_part_parts [0] . $title_separator;
                $post_title_parts = explode ( $colonSeparator, $img_part_parts [1] );
                $found_title = $post_title_parts [0];
                unset ( $post_title_parts [0] );
                $past_title_text = implode ( $colonSeparator, $post_title_parts );
                $post_title_part = $colonSeparator . $past_title_text;
                $new_imgFoundsSeparated [] = $pre_title_part;
                $new_imgFoundsSeparated [] = $post_title_part;
            } else {
                $new_imgFoundsSeparated [] = $img_part;
            }
        }
    }
    if (count ( $new_imgFoundsSeparated ) != 0) {
        $htmlfounds = array_merge ( $htmlfounds, $new_imgFoundsSeparated );
    }
    preg_match_all ( "/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER );
    $newhtmlfounds = $matches2 [0];
    preg_match_all ( "/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER );
    $shortcodesfounds = $matches3 [0];
    $htmlfounds = array_merge ( $htmlfounds, $newhtmlfounds, $shortcodesfounds );
    $in = 0;
    $cleanHtmlFounds = array ();
    foreach ( $htmlfounds as $htmlfound ) {
        
        if ($htmlfound == '[19459000]') {
        } elseif (trim ( $htmlfound ) == '') {
        } else {
            $cleanHtmlFounds [] = $htmlfound;
        }
    }
    $htmlfounds = array_filter ( $cleanHtmlFounds );
    $start = 19459001;
    foreach ( $htmlfounds as $htmlfound ) {
        $text = str_replace ( $htmlfound, '[' . $start . ']', $text );
        $start ++;
    }
    $text = str_replace ( '.{', '. {', $text );
    preg_match_all ( '!(?:\[1945\d*\][\s]*){2,}!s', $text, $conseqMatchs );
    $startConseq = 19659001;
    foreach ( $conseqMatchs [0] as $conseqMatch ) {
        $text = preg_replace ( '{' . preg_quote ( trim ( $conseqMatch ) ) . '}', '[' . $startConseq . ']', $text, 1 );
        $startConseq ++;
    }
    preg_match_all ( '{\[.*?\]}', $text, $pre_tags_matches );
    $pre_tags_matches = ($pre_tags_matches [0]);
    preg_match_all ( '{\s*\[.*?\]\s*}u', $text, $pre_tags_matches_s );
    $pre_tags_matches_s = ($pre_tags_matches_s [0]);
    $text = str_replace ( '[', "\n\n[", $text );
    $text = str_replace ( ']', "]\n\n", $text );
	return $text;	
}
function aiomatic_countExcludes($translated)
{
    preg_match_all ( '{\[.*?\]}', $translated, $bracket_matchs );
    $bracket_matchs = $bracket_matchs[0];
    return count($bracket_matchs);
}
function aiomatic_restoreExcludes($translated, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs){
    $translated = preg_replace ( '{]\s*?1945}', '][1945', $translated );
    $translated = preg_replace ( '{ 19459(\d*?)]}', ' [19459$1]', $translated );
    $translated = str_replace ( '[ [1945', '[1945', $translated );
    $translated = str_replace ( '], ', ']', $translated );
    preg_match_all ( '{\[.*?\]}', $translated, $bracket_matchs );
    $bracket_matchs = $bracket_matchs [0];
    foreach ( $bracket_matchs as $single_bracket ) 
    {
        if (stristr ( $single_bracket, '1' ) && stristr ( $single_bracket, '9' )) {
            $single_bracket_clean = str_replace ( array (
                    ',',
                    ' ' 
            ), '', $single_bracket );
            $translated = str_replace ( $single_bracket, $single_bracket_clean, $translated );
        }
    }
    preg_match_all ( '{\[\d*?\]}', $translated, $post_tags_matches );
    $post_tags_matches = ($post_tags_matches [0]);
    if (count ( $pre_tags_matches ) == count ( $post_tags_matches )) 
    {
        if ($pre_tags_matches !== $post_tags_matches) 
        {
            $i = 0;
            foreach ( $post_tags_matches as $post_tags_match ) {
                $translated = preg_replace ( '{' . preg_quote ( trim ( $post_tags_match ) ) . '}', '[' . $i . ']', $translated, 1 );
                $i ++;
            }
            $i = 0;
            foreach ( $pre_tags_matches as $pre_tags_match ) {
                $translated = str_replace ( '[' . $i . ']', $pre_tags_match, $translated );
                $i ++;
            }
        }
    }
    $translated = str_replace ( "\n\n[", '[', $translated );
    $translated = str_replace ( "]\n\n", ']', $translated );
    $i = 0;
    foreach ( $pre_tags_matches_s as $pre_tags_match ) 
    {
        $pre_tags_match_h = htmlentities ( $pre_tags_match );
        if (stristr ( $pre_tags_match_h, '&nbsp;' )) {
            $pre_tags_match = str_replace ( '&nbsp;', ' ', $pre_tags_match_h );
        }
        $translated = preg_replace ( '{' . preg_quote ( trim ( $pre_tags_match ) ) . '}', "[$i]", $translated, 1 );
        $i ++;
    }
    $translated = preg_replace ( '{\s*\[}u', '[', $translated );
    $translated = preg_replace ( '{\]\s*}u', ']', $translated );
    $i = 0;
    foreach ( $pre_tags_matches_s as $pre_tags_match ) 
    {
        $pre_tags_match_h = htmlentities ( $pre_tags_match );
        if (stristr ( $pre_tags_match_h, '&nbsp;' )) {
            $pre_tags_match = str_replace ( '&nbsp;', ' ', $pre_tags_match_h );
        }
        $translated = preg_replace ( '{' . preg_quote ( "[$i]" ) . '}', $pre_tags_match, $translated, 1 );
        $i ++;
    }
    $startConseq = 19659001;
    foreach ( $conseqMatchs [0] as $conseqMatch ) {
        $translated = str_replace ( '[' . $startConseq . ']', $conseqMatch, $translated );
        $startConseq ++;
    }
    preg_match_all ( '!\[.*?\]!', $translated, $brackets );
    $brackets = $brackets [0];
    $brackets = array_unique ( $brackets );
    foreach ( $brackets as $bracket ) {
        if (stristr ( $bracket, '19' )) 
        {
            $corrrect_bracket = str_replace ( ' ', '', $bracket );
            $corrrect_bracket = str_replace ( '.', '', $corrrect_bracket );
            $corrrect_bracket = str_replace ( ',', '', $corrrect_bracket );
            $translated = str_replace ( $bracket, $corrrect_bracket, $translated );
        }
    }
    $start = 19459001;
    foreach ( $htmlfounds as $htmlfound ) {
        $translated = str_replace ( '[' . $start . ']', $htmlfound, $translated );
        $start ++;
    }
    return $translated;
}
function aiomatic_replaceAIExecludes($article, &$htmlfounds, $opt = false, $dymmy_char = '-')
{
    $htmlurls = array();$article = preg_replace('{data-image-description="(?:[^\"]*?)"}i', '', $article);
	if($opt === true){
		preg_match_all( "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*?)<\/a>/s" ,$article,$matches,PREG_PATTERN_ORDER);
		$htmlurls=$matches[0];
	}
	$urls_txt = array();
	if($opt === true){
		preg_match_all('/https?:\/\/[^<\s]+/', $article,$matches_urls_txt);
		$urls_txt = $matches_urls_txt[0];
	}
	preg_match_all("/<[^<>]+>/is",$article,$matches,PREG_PATTERN_ORDER);
	$htmlfounds=$matches[0];
	preg_match_all('{\[nospin\].*?\[/nospin\]}s', $article,$matches_ns);
	$nospin = $matches_ns[0];
	//$pattern="\[.*?\]";
	//preg_match_all("/".$pattern."/s",$article,$matches2,PREG_PATTERN_ORDER);
	//$shortcodes=$matches2[0];
    $shortcodes=array();
	preg_match_all("/<script.*?<\/script>/is",$article,$matches3,PREG_PATTERN_ORDER);
	$js=$matches3[0];
	preg_match_all('/\d{2,}/s', $article,$matches_nums);
	$nospin_nums = $matches_nums[0];
	sort($nospin_nums);
	$nospin_nums = array_reverse($nospin_nums);
	$capped = array();
	if($opt === true){
		preg_match_all("{\b[A-Z][a-z']+\b[,]?}", $article,$matches_cap);
		$capped = $matches_cap[0];
		sort($capped);
		$capped=array_reverse($capped);
	}
	$curly_quote = array();
	if($opt === true){
		preg_match_all('{???.*????}', $article, $matches_curly_txt);
		$curly_quote = $matches_curly_txt[0];
		preg_match_all('{???.*????}', $article, $matches_curly_txt_s);
		$single_curly_quote = $matches_curly_txt_s[0];
		preg_match_all('{&quot;.*?&quot;}', $article, $matches_curly_txt_s_and);
		$single_curly_quote_and = $matches_curly_txt_s_and[0];
		preg_match_all('{&#8220;.*?&#8221}', $article, $matches_curly_txt_s_and_num);
		$single_curly_quote_and_num = $matches_curly_txt_s_and_num[0];
		$curly_quote_regular = array();
		preg_match_all('{".*?"}', $article, $matches_curly_txt_regular);
        $curly_quote_regular = $matches_curly_txt_regular[0];
		$curly_quote = array_merge($curly_quote , $single_curly_quote ,$single_curly_quote_and,$single_curly_quote_and_num,$curly_quote_regular);
	}
	$htmlfounds = array_merge($nospin, $shortcodes, $js, $htmlurls, $htmlfounds, $curly_quote, $urls_txt, $nospin_nums, $capped);
	$htmlfounds = array_filter(array_unique($htmlfounds));
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article = str_replace($htmlfound, '(' . $dymmy_char . $i . $dymmy_char . ')', $article);	
		$i++;
	}
    $article = str_replace(':(' . $dymmy_char, ': (' . $dymmy_char, $article);
	return $article;
}
function aiomatic_restoreAIExecludes($article, $htmlfounds, $dymmy_char = 'x'){
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace( '(' . $dymmy_char . $i . $dymmy_char . ')', $htmlfound, $article);
		$i++;
	}
	$article = str_replace(array('[nospin]','[/nospin]'), '', $article);
	return $article;
}
function aiomatic_fix_spinned_content($final_content, $spinner)
{
    if ($spinner == 'wordai') {
        $final_content = str_replace('-LRB-', '(', $final_content);
        $final_content1 = preg_replace("/{\*\|.*?}/", '*', $final_content);
        if($final_content1 !== null)
        {
            $final_content = $final_content1;
        }
    }
    elseif ($spinner == 'spinnerchief') {
        $final_content = preg_replace('#\[[\s\\\/]*([\d]*?)[\s\\\/]*\[#', '[$1]', $final_content);
        $final_content = preg_replace('#\][\s\\\/]*([\d]*?)[\s\\\/]*\]#', '[$1]', $final_content);
        $final_content = preg_replace('#\[[\s\\\/]*([\d]*?)[\s\\\/]*\]#', '[$1]', $final_content);
    }
    elseif ($spinner == 'spinrewriter' || $spinner == 'translate') {
        $final_content = str_replace('& #', '&#', $final_content);
        $final_content = preg_replace('#&\s([a-zA-Z]+?);#', '', $final_content);
    }
    return $final_content;
}
function aiomatic_spin_and_translate($post_title, $final_content, $methodtouse = '1', $skip_spin = '0', $skip_translate = '0')
{
    $translation = false;
    $pre_tags_matches = array();
    $pre_tags_matches_s = array();
    $conseqMatchs = array();
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if($skip_spin != '1')
    {
        if($methodtouse == '1' || $methodtouse == '3')
        {
            if (isset($aiomatic_Main_Settings['spin_text']) && $aiomatic_Main_Settings['spin_text'] !== 'disabled') {
                
                $htmlfounds = array();
                $final_content = aiomatic_replaceExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                if ($aiomatic_Main_Settings['spin_text'] == 'builtin') {
                    $translation = aiomatic_builtin_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'wikisynonyms') {
                    $translation = aiomatic_spin_text($post_title, $final_content, false);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'freethesaurus') {
                    $translation = aiomatic_spin_text($post_title, $final_content, true);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'best') {
                    $translation = aiomatic_best_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'wordai') {
                    $translation = aiomatic_wordai_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'spinrewriter') {
                    $translation = aiomatic_spinrewriter_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'spinnerchief') {
                    $translation = aiomatic_spinnerchief_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'chimprewriter') {
                    $translation = aiomatic_chimprewriter_spin_text($post_title, $final_content);
                } elseif ($aiomatic_Main_Settings['spin_text'] == 'contentprofessor') {
                    $translation = aiomatic_contentprofessor_spin_text($post_title, $final_content);
                }
                if ($translation !== FALSE) {
                    if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                        if (!isset($aiomatic_Main_Settings['no_title']) || $aiomatic_Main_Settings['no_title'] != 'on') {
                            $final_content = $translation[1];
                        }
                        $post_title    = $translation[0];
                        
                        $final_content = aiomatic_fix_spinned_content($final_content, $aiomatic_Main_Settings['spin_text']);
                        $final_content = aiomatic_restoreExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                        
                    } else {
                        $final_content = aiomatic_restoreExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                            aiomatic_log_to_file('Text Spinning failed - malformed data ' . $aiomatic_Main_Settings['spin_text']);
                        }
                    }
                } else {
                    $final_content = aiomatic_restoreExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('Text Spinning Failed - returned false ' . $aiomatic_Main_Settings['spin_text']);
                    }
                }
            }
        }
    }
    if($skip_translate != '1')
    {
        if($methodtouse == '2' || $methodtouse == '3')
        {
            if (isset($aiomatic_Main_Settings['translate']) && $aiomatic_Main_Settings['translate'] != 'disabled') {
                if(isset($aiomatic_Main_Settings['translate_source']) && $aiomatic_Main_Settings['translate_source'] != 'disabled')
                {
                    $tr = $aiomatic_Main_Settings['translate_source'];
                }
                else
                {
                    $tr = 'auto';
                }
                $htmlfounds = array();
                $final_content = aiomatic_replaceExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                $translation = aiomatic_translate($post_title, $final_content, $tr, $aiomatic_Main_Settings['translate']);
                if (is_array($translation) && isset($translation[1]))
                {
                    $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
                    $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
                    $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
                    if(isset($aiomatic_Main_Settings['second_translate']) && $aiomatic_Main_Settings['second_translate'] != 'disabled')
                    {
                        $translation = aiomatic_translate($translation[0], $translation[1], $aiomatic_Main_Settings['translate'], $aiomatic_Main_Settings['second_translate']);
                        if (is_array($translation) && isset($translation[1]))
                        {
                            $translation[1] = aiomatic_restoreExcludes($translation[1], $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                        }
                        else
                        {
                            $final_content = aiomatic_restoreExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                            $translation = false;
                            if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                                aiomatic_log_to_file('Failed to translate text the second time, from ' . $aiomatic_Main_Settings['translate'] . ' to ' . $aiomatic_Main_Settings['second_translate']);
                            }
                        }
                    }
                    else
                    {
                        $translation[1] = aiomatic_restoreExcludes($translation[1], $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                    }
                }
                else
                {
                    $final_content = aiomatic_restoreExcludes($final_content, $htmlfounds, $pre_tags_matches, $pre_tags_matches_s, $conseqMatchs);
                }
                if ($translation !== FALSE) {
                    if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                        $post_title    = $translation[0];
                        $final_content = $translation[1];
                        $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                        if(stristr($final_content, '<head>') !== false)
                        {
                            $d = new DOMDocument;
                            $mock = new DOMDocument;
                            $internalErrors = libxml_use_internal_errors(true);
                            $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                            libxml_use_internal_errors($internalErrors);
                            $body = $d->getElementsByTagName('body')->item(0);
                            foreach ($body->childNodes as $child)
                            {
                                $mock->appendChild($mock->importNode($child, true));
                            }
                            $new_post_content_temp = $mock->saveHTML();
                            if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                            {
                                $new_post_content_temp = str_replace('<?xml encoding="utf-8" ?>', '', $new_post_content_temp);
                                $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                            }
                        }
                        $final_content = htmlspecialchars_decode($final_content);
                        $final_content = str_replace('</ ', '</', $final_content);
                        $final_content = str_replace(' />', '/>', $final_content);
                        $final_content = str_replace('< br/>', '<br/>', $final_content);
                        $final_content = str_replace('< / ', '</', $final_content);
                        $final_content = str_replace(' / >', '/>', $final_content);
                        $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                        $post_title = preg_replace('{&\s*#\s*(\d+)\s*;}', '&#$1;', $post_title);
                        $post_title = htmlspecialchars_decode($post_title);
                        $post_title = str_replace('</ ', '</', $post_title);
                        $post_title = str_replace(' />', '/>', $post_title);
                        $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
                    } else {
                        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                            aiomatic_log_to_file('Translation failed - malformed data!');
                        }
                    }
                } else {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('Translation Failed - returned false!');
                    }
                }
            }
        }
    }
    return array(
        $post_title,
        $final_content
    );
}
function aiomatic_translate_stability($post_title)
{
    $tr = 'auto';
    $translation = aiomatic_translate($post_title, 'test', $tr, 'en');
    if ($translation !== FALSE) 
    {
        if (is_array($translation) && isset($translation[0]) && isset($translation[1])) 
        {
            $post_title = $translation[0];
            $post_title = preg_replace('{&\s*#\s*(\d+)\s*;}', '&#$1;', $post_title);
            $post_title = htmlspecialchars_decode($post_title);
            $post_title = str_replace('</ ', '</', $post_title);
            $post_title = str_replace(' />', '/>', $post_title);
            $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
        }
    }
    return $post_title;
}
function aiomatic_translate($title, $content, $from, $to)
{
    $ch                     = FALSE;
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    try {
        if($from == 'disabled')
        {
            if(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
            {
                $from = 'auto-';
            }
            else
            {
                $from = 'auto';
            }
        }
        if($from != 'en' && $from != 'EN-' && $from != 'en!' && $from == $to)
        {
            if(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
            {
                $from = 'en-';
            }
            else
            {
                $from = 'en';
            }
        }
        elseif(($from == 'en' || $from == 'EN-' || $from == 'en!') && $from == $to)
        {
            return false;
        }
        if(strstr($to, '!') !== false)
        {
            if (!isset($aiomatic_Main_Settings['bing_auth']) || trim($aiomatic_Main_Settings['bing_auth']) == '')
            {
                throw new Exception('You must enter a Microsoft Translator API key from plugin settings, to use this feature!');
            }
            require_once (dirname(__FILE__) . "/res/aiomatic-translator-microsoft.php");
            $options    = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );
            $ch = curl_init();
            if ($ch === FALSE) {
                aiomatic_log_to_file ('Failed to init curl in Microsoft Translator');
				return false;
            }
            if (isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') {
				$prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
                $randomness = array_rand($prx);
                $options[CURLOPT_PROXY] = trim($prx[$randomness]);
                if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
                {
                    $prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
                    if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                    {
                        $options[CURLOPT_PROXYUSERPWD] = trim($prx_auth[$randomness]);
                    }
                }
            }
            curl_setopt_array($ch, $options);
			$MicrosoftTranslator = new MicrosoftTranslator ( $ch );	
			try 
            {
                if (!isset($aiomatic_Main_Settings['bing_region']) || trim($aiomatic_Main_Settings['bing_region']) == '')
                {
                    $mt_region = 'global';
                }
                else
                {
                    $mt_region = trim($aiomatic_Main_Settings['bing_region']);
                }
                if($from == 'auto' || $from == 'auto-' || $from == 'disabled')
                {
                    $from = 'no';
                }
				$accessToken = $MicrosoftTranslator->getToken ( trim($aiomatic_Main_Settings['bing_auth']) , $mt_region  );
                $from = trim($from, '!');
                $to = trim($to, '!');
				$translated = $MicrosoftTranslator->translateWrap ( $content, $from, $to );
                $translated_title = $MicrosoftTranslator->translateWrap ( $title, $from, $to );
                curl_close($ch);
			} 
            catch ( Exception $e ) 
            {
                curl_close($ch);
				aiomatic_log_to_file ('Microsoft Translation error: ' . $e->getMessage());
				return false;
			}
        }
        elseif(strstr($to, '-') !== false && $to != 'zh-CN' && $to != 'zh-TW')
        {
            if (!isset($aiomatic_Main_Settings['deepl_auth']) || trim($aiomatic_Main_Settings['deepl_auth']) == '')
            {
                throw new Exception('You must enter a DeepL API key from plugin settings, to use this feature!');
            }
            $to = rtrim($to, '-');
            $from = rtrim($from, '-');
            if(strlen($content) > 13000)
            {
                $translated = '';
                while($content != '')
                {
                    $first30k = substr($content, 0, 13000);
                    $content = substr($content, 13000);
                    if (isset($aiomatic_Main_Settings['deppl_free']) && trim($aiomatic_Main_Settings['deppl_free']) == 'on')
                    {
                        $ch = curl_init('https://api-free.deepl.com/v2/translate');
                    }
                    else
                    {
                        $ch = curl_init('https://api.deepl.com/v2/translate');
                    }
                    if($ch !== false)
                    {
                        $data           = array();
                        $data['text']   = $first30k;
                        if($from != 'auto')
                        {
                            $data['source_lang']   = $from;
                        }
                        $data['tag_handling']  = 'xml';
                        $data['non_splitting_tags']  = 'div';
                        $data['preserve_formatting']  = '1';
                        $data['target_lang']   = $to;
                        $data['auth_key']   = trim($aiomatic_Main_Settings['deepl_auth']);
                        $fdata = "";
                        foreach ($data as $key => $val) {
                            $fdata .= "$key=" . urlencode(trim($val)) . "&";
                        }
                        $headers = [
                            'Content-Type: application/x-www-form-urlencoded',
                            'Content-Length: ' . strlen($fdata)
                        ];
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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
                        $translated_temp = curl_exec($ch);
                        if($translated_temp === false)
                        {
                            throw new Exception('Failed to post to DeepL: ' . curl_error($ch));
                        }
                        curl_close($ch);
                    }
                    $trans_json = json_decode($translated_temp, true);
                    if($trans_json === null)
                    {
                        throw new Exception('Incorrect multipart response from DeepL: ' . $translated_temp);
                    }
                    if(!isset($trans_json['translations'][0]['text']))
                    {
                        throw new Exception('Unrecognized multipart response from DeepL: ' . $translated_temp);
                    }
                    $translated .= ' ' . $trans_json['translations'][0]['text'];
                }
            }
            else
            {
                if (isset($aiomatic_Main_Settings['deppl_free']) && trim($aiomatic_Main_Settings['deppl_free']) == 'on')
                {
                    $ch = curl_init('https://api-free.deepl.com/v2/translate');
                }
                else
                {
                    $ch = curl_init('https://api.deepl.com/v2/translate');
                }
                if($ch !== false)
                {
                    $data           = array();
                    $data['text']   = $content;
                    if($from != 'auto')
                    {
                        $data['source_lang']   = $from;
                    }
                    $data['tag_handling']  = 'xml';
                    $data['non_splitting_tags']  = 'div';
                    $data['preserve_formatting']  = '1';
                    $data['target_lang']   = $to;
                    $data['auth_key']   = trim($aiomatic_Main_Settings['deepl_auth']);
                    $fdata = "";
                    foreach ($data as $key => $val) {
                        $fdata .= "$key=" . urlencode(trim($val)) . "&";
                    }
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $headers = [
                        'Content-Type: application/x-www-form-urlencoded',
                        'Content-Length: ' . strlen($fdata)
                    ];
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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
                    $translated = curl_exec($ch);
                    if($translated === false)
                    {
                        throw new Exception('Failed to post to DeepL: ' . curl_error($ch));
                    }
                    curl_close($ch);
                }
                $trans_json = json_decode($translated, true);
                if($trans_json === null)
                {
                    throw new Exception('Incorrect text response from DeepL: ' . $translated);
                }
                if(!isset($trans_json['translations'][0]['text']))
                {
                    throw new Exception('Unrecognized text response from DeepL: ' . 'https://api.deepl.com/v2/translate?text=' . urlencode($content) . '&source_lang=' . $from . '&target_lang=' . $to . '&auth_key=' . trim($aiomatic_Main_Settings['deepl_auth']) . '&tag_handling=xml&preserve_formatting=1' . ' --- ' . $translated);
                }
                $translated = $trans_json['translations'][0]['text'];
            }
            $translated = str_replace('<strong>', ' <strong>', $translated);
            $translated = str_replace('</strong>', '</strong> ', $translated);
            if($from != 'auto')
            {
                $from_from = '&source_lang=' . $from;
            }
            else
            {
                $from_from = '';
            }
            if (isset($aiomatic_Main_Settings['deppl_free']) && trim($aiomatic_Main_Settings['deppl_free']) == 'on')
            {
                $translated_title = aiomatic_get_web_page('https://api-free.deepl.com/v2/translate?text=' . urlencode($title) . $from_from . '&target_lang=' . $to . '&auth_key=' . trim($aiomatic_Main_Settings['deepl_auth']) . '&tag_handling=xml&preserve_formatting=1');
            }
            else
            {
                $translated_title = aiomatic_get_web_page('https://api.deepl.com/v2/translate?text=' . urlencode($title) . $from_from . '&target_lang=' . $to . '&auth_key=' . trim($aiomatic_Main_Settings['deepl_auth']) . '&tag_handling=xml&preserve_formatting=1');
            }
            $trans_json = json_decode($translated_title, true);
            if($trans_json === null)
            {
                throw new Exception('Incorrect title response from DeepL: ' . $translated_title);
            }
            if(!isset($trans_json['translations'][0]['text']))
            {
                throw new Exception('Unrecognized title response from DeepL: ' . $translated_title);
            }
            $translated_title = $trans_json['translations'][0]['text'];
        }
        else
        {
            if (isset($aiomatic_Main_Settings['google_trans_auth']) && trim($aiomatic_Main_Settings['google_trans_auth']) != '')
            {
                require_once(dirname(__FILE__) . "/res/translator-api.php");
                $ch = curl_init();
                if ($ch === FALSE) {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('Failed to init cURL in translator!');
                    }
                    return false;
                }
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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
                $GoogleTranslatorAPI = new GoogleTranslatorAPI($ch, $aiomatic_Main_Settings['google_trans_auth']);
                $translated = '';
                $translated_title = '';
                if($content != '')
                {
                    if(strlen($content) > 13000)
                    {
                        while($content != '')
                        {
                            $first30k = substr($content, 0, 13000);
                            $content = substr($content, 13000);
                            $translated_temp       = $GoogleTranslatorAPI->translateText($first30k, $from, $to);
                            $translated .= ' ' . $translated_temp;
                        }
                    }
                    else
                    {
                        $translated       = $GoogleTranslatorAPI->translateText($content, $from, $to);
                    }
                }
                if($title != '')
                {
                    $translated_title = $GoogleTranslatorAPI->translateText($title, $from, $to);
                }
                curl_close($ch);
            }
            else
            {
                require_once(dirname(__FILE__) . "/res/aiomatic-translator.php");
                $ch = curl_init();
                if ($ch === FALSE) {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('Failed to init cURL in translator!');
                    }
                    return false;
                }
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
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
                curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
				if (isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled') {
					$prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
					$randomness = array_rand($prx);
					curl_setopt( $ch, CURLOPT_PROXY, trim($prx[$randomness]));
					if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
					{
						$prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
						if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
						{
							curl_setopt( $ch, CURLOPT_PROXYUSERPWD, trim($prx_auth[$randomness]) );
						}
					}
				}
				$GoogleTranslator = new GoogleTranslator($ch);
                if(strlen($content) > 13000)
                {
                    $translated = '';
                    while($content != '')
                    {
                        $first30k = substr($content, 0, 13000);
                        $content = substr($content, 13000);
                        $translated_temp       = $GoogleTranslator->translateText($first30k, $from, $to);
                        if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                            throw new Exception('Page content already in ' . $to);
                        }
                        if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                            throw new Exception('Unexpected error while translating page!');
                        }
                        if(substr_compare($translated_temp, '</pre>', -strlen('</pre>')) === 0){$translated_temp = substr_replace($translated_temp ,"", -6);}if(substr( $translated_temp, 0, 5 ) === "<pre>"){$translated_temp = substr($translated_temp, 5);}
                        $translated .= ' ' . $translated_temp;
                    }
                }
                else
                {
                    $translated       = $GoogleTranslator->translateText($content, $from, $to);
                    if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                        throw new Exception('Page content already in ' . $to);
                    }
                    if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                        throw new Exception('Unexpected error while translating page!');
                    }
                }
                $translated_title = $GoogleTranslator->translateText($title, $from, $to);
                if (strpos($translated_title, '<h2>The page you have attempted to translate is already in ') !== false) {
                    throw new Exception('Page title already in ' . $to);
                }
                if (strpos($translated_title, 'Error 400 (Bad Request)!!1') !== false) {
                    throw new Exception('Unexpected error while translating page title!');
                }
                curl_close($ch);
            }
        }
    }
    catch (Exception $e) {
        curl_close($ch);
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Exception thrown in GoogleTranslator ' . $e);
        }
        return false;
    }
    if(substr_compare($translated_title, '</pre>', -strlen('</pre>')) === 0){$title = substr_replace($translated_title ,"", -6);}else{$title = $translated_title;}if(substr( $title, 0, 5 ) === "<pre>"){$title = substr($title, 5);}
    if(substr_compare($translated, '</pre>', -strlen('</pre>')) === 0){$text = substr_replace($translated ,"", -6);}else{$text = $translated;}if(substr( $text, 0, 5 ) === "<pre>"){$text = substr($text, 5);}
    $text  = preg_replace('/' . preg_quote('html lang=') . '.*?' . preg_quote('>') . '/', '', $text);
    $text  = preg_replace('/' . preg_quote('!DOCTYPE') . '.*?' . preg_quote('<') . '/', '', $text);
    $text  = preg_replace('#https:\/\/translate\.google\.com\/translate\?hl=en&amp;prev=_t&amp;sl=en&amp;tl=pl&amp;u=([^><"\'\s\n]*)#i', urldecode('$1'), $text);
    return array(
        $title,
        $text
    );
}
function aiomatic_wordai_spin_text($title, $content)
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "Wordai" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = 'Readable';
    $html             = $title . ' ' . $titleSeparator . ' ' . $content;
    $email = $aiomatic_Main_Settings['best_user'];
    $pass = $aiomatic_Main_Settings['best_password'];
    $html = urlencode($html);
    $ch = curl_init('https://wai.wordai.com/api/rewrite');
    if($ch === false)
    {
        aiomatic_log_to_file('Failed to init curl in wordai spinning.');
        return FALSE;
    }
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, "input=$html&uniqueness=2&rewrite_num=1&return_rewrites=true&email=$email&key=$pass");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
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
    $result = curl_exec($ch);
    if ($result === FALSE) {
        aiomatic_log_to_file('"Wordai" failed to exec curl after auth: ' . curl_error($ch));
        curl_close ($ch);
        return FALSE;
    }
    curl_close ($ch);
    $result = json_decode($result);
    if(!isset($result->rewrites))
    {
        aiomatic_log_to_file('"Wordai" unrecognized response: ' . print_r($result, true));
        return FALSE;
    }
    $result = explode($titleSeparator, $result->rewrites[0]);
    if (count($result) < 2) {
        $result[1] = $result[0];
        $result[0] = $title;
    }
    return $result;
}
function aiomatic_chimprewriter_spin_text($title, $content)
{
    $titleSeparator = '[19459000]';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "ChimpRewriter" user email and password.');
        return FALSE;
    }
    $usr = $aiomatic_Main_Settings['best_user'];
    $pss = $aiomatic_Main_Settings['best_password'];
    $html = stripslashes($title). ' ' . $titleSeparator . ' ' . stripslashes($content);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
	curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$curlurl="https://api.chimprewriter.com/ChimpRewrite";
	$curlpost="email=" . trim($usr) . "&apikey=" . trim($pss) . "&quality=4&text=" . urlencode($html) . "&aid=none&tagprotect=[|]&phrasequality=3&posmatch=3";
	curl_setopt($ch, CURLOPT_URL, $curlurl);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlpost);
	$exec = curl_exec($ch);
    curl_close ($ch);
    if ($exec === FALSE) {
        aiomatic_log_to_file('"ChimpRewriter" failed to exec curl after auth.');
        return FALSE;
    }
	if(stristr($exec, '{'))
    {
		$json = json_decode($exec);
		if($json !== null && isset($json->status))
        {	
			if(isset($json->output) && trim($json->status) == 'success')
            {
				$result = explode($titleSeparator, $json->output);
                if (count($result) < 2) {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('"ChimpRewriter" failed to spin article - titleseparator not found.');
                    }
                    return FALSE;
                }
                $spintax = new AIomatic_Spintax();
                $result[0] = $spintax->Parse(trim($result[0]));
                $result[1] = $spintax->Parse(trim($result[1]));
                return $result;
			}
            else
            {
				aiomatic_log_to_file('Invalid "ChimpRewriter" json response (output missing): ' . $exec);
                return FALSE;
			}
		}
        else
        {
			aiomatic_log_to_file('Invalid "ChimpRewriter" json response: ' . $exec);
            return FALSE;
		}
	}
    else
    {
		aiomatic_log_to_file('Invalid "ChimpRewriter" response: ' . $exec);
        return FALSE;
	}
    return FALSE;
}
function aiomatic_spinnerchief_spin_text($title, $content)
{
    $titleSeparator = '[19459000]';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "SpinnerChief" user email and password.');
        return FALSE;
    }
    $pss = $aiomatic_Main_Settings['best_password'];
    $html = stripslashes($title). ' ' . $titleSeparator . ' ' . stripslashes($content);
    if(str_word_count($html) > 5000)
    {
        $result = '';
        while($html != '')
        {
            $first30k = substr($html, 0, 20000);
            $first30k = rtrim($first30k, '(*');
            $first30k = ltrim($first30k, ')*');
            $html = substr($html, 20000);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $curlpost =  $first30k;
            $curlpost1 = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $curlpost);
            if($curlpost1 !== null)
            {
                $curlpost = $curlpost1;
            }
            $post_me = 'dev_key=api2409357d02fa474d8&api_key=' . $pss . '&text=' . urlencode($curlpost);
            $url = "https://www.spinnerchief.com/api/paraphraser";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_me); 
            $result_temp = curl_exec($ch);
            if ($result_temp === FALSE) {
                $cer = 'Curl error: ' . curl_error($ch);
                aiomatic_log_to_file('"SpinnerChief" failed to exec curl after auth. ' . $cer);
                curl_close ($ch);
                return FALSE;
            }
            else
            {
                $json_res = json_decode($result_temp);
                if($json_res !== null && isset($json_res->text))
                {
                    $result .= $json_res->text;
                }
                else
                {
                    $result .= $result_temp;
                }
            }
            curl_close ($ch);
        }
    }
    else
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $curlpost = $html;
        //to fix issue with unicode characters where the API times out
        $curlpost1 = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $curlpost);
        if($curlpost1 !== null)
        {
            $curlpost = $curlpost1;
        }
        $url = "https://www.spinnerchief.com/api/paraphraser";
        $post_me = 'dev_key=api2409357d02fa474d8&api_key=' . $pss . '&text=' . urlencode($curlpost);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_me); 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            $cer = 'Curl error: ' . curl_error($ch);
            aiomatic_log_to_file('"SpinnerChief" failed to exec curl after auth. ' . $cer);
            curl_close ($ch);
            return FALSE;
        }
        $json_res = json_decode($result);
        if($json_res !== null && isset($json_res->text))
        {
            $result = $json_res->text;
        }
        curl_close ($ch);
    }
    $result = preg_replace('#\](\d+\])#', '[$1', $result);
    $result = explode($titleSeparator, $result);
    if (count($result) < 2) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('"SpinnerChief" failed to spin article - titleseparator not found: ' . print_r($result, true));
        }
        return FALSE;
    }
    $spintax = new AIomatic_Spintax();
    $result[0] = $spintax->Parse(trim($result[0]));
    $result[1] = $spintax->Parse(trim($result[1]));
    return $result;
}

function aiomatic_contentprofessor_spin_text($title, $content)
{
    $titleSeparator = '[19459000]';
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "ContentProfessor" user email and password.');
        return FALSE;
    }
    $usr = $aiomatic_Main_Settings['best_user'];
    $pss = $aiomatic_Main_Settings['best_password'];
    $article = stripslashes($title). ' ' . $titleSeparator . ' ' . stripslashes($content);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
	curl_setopt($ch, CURLOPT_USERAGENT, aiomatic_get_random_user_agent());
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ctu = 'pro';
	$url = 'http://www.contentprofessor.com/member_pro/api/get_session?format=json&login='.trim($usr).'&password='.trim($pss);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
 	$exec = curl_exec($ch);
	if(!stristr($exec, '{'))
    {
        $ctu = 'free';
        $url = 'http://www.contentprofessor.com/member_free/api/get_session?format=json&login='.trim($usr).'&password='.trim($pss);
        curl_setopt($ch, CURLOPT_URL, $url);
        $exec = curl_exec($ch);	
	}
    if(!stristr($exec, '{'))
    {
        aiomatic_log_to_file('Invalid "ContentProfessor" response: ' . $exec);
        return FALSE;
    }
	$exec = json_decode($exec);
	if(!isset($exec->result) || !isset($exec->result->data->session))
    {
        $ctu = 'free';
		$url = 'http://www.contentprofessor.com/member_free/api/get_session?format=json&login='.trim($usr).'&password='.trim($pss);
        curl_setopt($ch, CURLOPT_URL, $url);
        $exec = curl_exec($ch);
        $exec = json_decode($exec);
    }        
	if(isset($exec->result) && isset($exec->result->data->session))
    {
		$session = $exec->result->data->session;
		$url = "http://www.contentprofessor.com/member_" . $ctu . "/api/include_synonyms?format=json&session=" . $session . "&language=en&limit=5&quality=ideal&synonym_set=global&min_words_count=1&max_words_count=7";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		$curlpost = array('text'=> $article);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlpost);
		$exec = curl_exec($ch);
		if(stristr($exec, '{'))
        {
            $exec = json_decode($exec);
			if (isset($exec->result->data->text)) 
            {
				$article  = preg_replace('{<span class="word" id=".*?">(.*?)</span>}su', "$1", $exec->result->data->text);
                $article = explode($titleSeparator, $article);
                if (count($article) < 2) {
                    if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
                        aiomatic_log_to_file('"SpinRewriter" failed to spin article - titleseparator (' . ' ' . $titleSeparator . ' ' . ') not found: ' . $article);
                    }
                    return FALSE;
                }
                $spintax = new AIomatic_Spintax();
                $article[0] = $spintax->Parse(trim($article[0]));
                $article[1] = $spintax->Parse(trim($article[1]));
                return $article;	
			}
            else
            {
                aiomatic_log_to_file('Incorect "ContentProfessor" json response: ' . print_r($exec, true));
                return FALSE;
			}
		}
        else
        {
            aiomatic_log_to_file('Incorect "ContentProfessor" call response: ' . print_r($exec, true));
            return FALSE;
		}
	}
    else
    {
		aiomatic_log_to_file('Incorect "ContentProfessor" login response: ' . print_r($exec, true));
        return FALSE;
	}
}
function aiomatic_spinrewriter_spin_text($title, $content)
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    if (!isset($aiomatic_Main_Settings['best_user']) || $aiomatic_Main_Settings['best_user'] == '' || !isset($aiomatic_Main_Settings['best_password']) || $aiomatic_Main_Settings['best_password'] == '') {
        aiomatic_log_to_file('Please insert a valid "SpinRewriter" user name and password.');
        return FALSE;
    }
    $titleSeparator = '(19459000)';
    $html = $title . ' ' . $titleSeparator . ' ' . $content;
    $html = preg_replace('/\s+/', ' ', $html);
    $data = array();
    $data['email_address'] = $aiomatic_Main_Settings['best_user'];
    $data['api_key'] = $aiomatic_Main_Settings['best_password'];
    $data['action'] = "unique_variation";
    $data['auto_protected_terms'] = "true";
    $data['confidence_level'] = "high";
    $data['auto_sentences'] = "true";
    $data['auto_paragraphs'] = "false";
    $data['auto_new_paragraphs'] = "false";
    $data['auto_sentence_trees'] = "false";
    $data['use_only_synonyms'] = "true";
    $data['reorder_paragraphs'] = "false";
    $data['nested_spintax'] = "false";
    if(isset($aiomatic_Main_Settings['best_humanize']) && $aiomatic_Main_Settings['best_humanize'] == 'on')
    {
        $data['humanize_ai'] = "true";
    }
    if(str_word_count($html) >= 2500)
    {
        $result = '';
        while($html != '' && $html != ' ')
        {
            $words = explode(" ", $html);
            $first30k = join(" ", array_slice($words, 0, 2500));
            $html = join(" ", array_slice($words, 2500));
            
            $data['text'] = $first30k;	
            $api_response = aiomatic_spinrewriter_api_post($data);
            if ($api_response === FALSE) {
                aiomatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
                return FALSE;
            }
            $api_response = json_decode($api_response);
            if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
            {
                if(isset($api_response->status) && $api_response->status == 'ERROR')
                {
                    if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
                    {
                        $api_response = aiomatic_spinrewriter_api_post($data);
                        if ($api_response === FALSE) {
                            aiomatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                            return FALSE;
                        }
                        $api_response = json_decode($api_response);
                        if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                        {
                            aiomatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                            return FALSE;
                        }
                    }
                    else
                    {
                        aiomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                        return FALSE;
                    }
                }
                else
                {
                    aiomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            $spinned = $api_response->response;
            $result .= ' ' . $spinned;
            if($html != '' && $html != ' ')
            {
                sleep(7);
            }
        }
    }
    else
    {
        $data['text'] = $html;
        $api_response = aiomatic_spinrewriter_api_post($data);
        if ($api_response === FALSE) {
            aiomatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
            return FALSE;
        }
        $api_response = json_decode($api_response);
        if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
        {
            if(isset($api_response->status) && $api_response->status == 'ERROR')
            {
                if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
                {
                    $api_response = aiomatic_spinrewriter_api_post($data);
                    if ($api_response === FALSE) {
                        aiomatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                        return FALSE;
                    }
                    $api_response = json_decode($api_response);
                    if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                    {
                        aiomatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                        return FALSE;
                    }
                }
                else
                {
                    aiomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            else
            {
                aiomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                return FALSE;
            }
        }
        $result = $api_response->response;
    }
    $result = explode($titleSeparator, $result);
    if (count($result) < 2) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('"SpinRewriter" failed to spin article - titleseparator not found: ' . $api_response->response);
        }
        return FALSE;
    }
    return $result;
}
function aiomatic_spinrewriter_api_post($data){
	$data_raw = "";
    
    $GLOBALS['wp_object_cache']->delete('crspinrewriter_spin_time', 'options');
    $spin_time = get_option('crspinrewriter_spin_time', false);
    if($spin_time !== false && is_numeric($spin_time))
    {
        $c_time = time();
        $spassed = $c_time - $spin_time;
        if($spassed < 10 && $spassed >= 0)
        {
            sleep(10 - $spassed);
        }
    }
    update_option('crspinrewriter_spin_time', time());
    
	foreach ($data as $key => $value){
		$data_raw = $data_raw . $key . "=" . urlencode($value) . "&";
	}
	$ch = curl_init();
    if($ch === false)
    {
        return false;
    }
	curl_setopt($ch, CURLOPT_URL, "http://www.spinrewriter.com/action/api");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_raw);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
	$response = trim(curl_exec($ch));
	curl_close($ch);
	return $response;
}
function aiomatic_builtin_spin_text($title, $content)
{
    $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . ' ' . $titleSeparator . ' ' . $content;
    if (isset($aiomatic_Main_Settings['exclude_words']) && $aiomatic_Main_Settings['exclude_words'] != '') {
        $excw = explode(',', $aiomatic_Main_Settings['exclude_words']);
        $excw = array_map('trim', $excw);
    }
    else
    {
        $excw = array();
    }
    try {
        $file=file(dirname(__FILE__)  .'/res/synonyms.dat');
		foreach($file as $line){
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){
                    $must_cont = false;
                    foreach($excw as $exw)
                    {
                        if(strstr($word, $exw) !== false)
                        {
                            $must_cont = true;
                            break;
                        }
                    }
                    if($must_cont == true)
                    {
                        continue;
                    }
                    $word=str_replace('/','\/',$word);
					if(preg_match('/\b'. $word .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$word.'\b/u', trim($synonyms[$rand]), $text);
					}
                    $uword=ucfirst($word);
					if(preg_match('/\b'. $uword .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$uword.'\b/u', ucfirst(trim($synonyms[$rand])), $text);
					}
				}
			}
		}
        $translated = $text;
    }
    catch (Exception $e) {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    if (stristr($translated, $titleSeparator)) {
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($aiomatic_Main_Settings['enable_detailed_logging'])) {
            aiomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}
?>