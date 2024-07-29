<?php
defined("ABSPATH") or die();
class Aiomatic_Statistics
{
    private $wpdb = null;
    private $db_check = false;
    private $table_logs = null;
    private $table_logmeta = null;
    private $apiRef = null;

    public function __construct()
    {
        add_action('ihc_action_after_subscription_activated', array($this, 'reset_usage_after_activation'), 999, 4);
        add_action('ihc_action_after_subscription_renew_activated', array($this, 'reset_usage_after_renewal'), 999, 4);

        $aiomatic_Main_Settings = get_option("aiomatic_Main_Settings", false);
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_logs = $wpdb->prefix . "aiomatic_logs";
        $this->table_logmeta = $wpdb->prefix . "aiomatic_logmeta";
        add_shortcode("aiomatic-user-remaining-credits-bar", [
            $this,
            "shortcode_current",
        ]);
        if (
            isset($aiomatic_Main_Settings["aiomatic_enabled"]) &&
            $aiomatic_Main_Settings["aiomatic_enabled"] === "on"
        ) {
            if (
                isset($aiomatic_Main_Settings["enable_tracking"]) &&
                trim($aiomatic_Main_Settings["enable_tracking"]) == "on"
            ) {
                add_filter("aiomatic_stats_query", [$this, "query"], 10, 1);
                add_filter(
                    "aiomatic_ai_reply",
                    function ($reply, $query) {
                        global $aiomatic_stats;
                        $aiomatic_stats->addCasually($query, $reply, []);
                        return $reply;
                    },
                    10,
                    2
                );
                add_filter(
                    "aiomatic_ai_reply_text",
                    function ($query, $text) {
                        global $aiomatic_stats;
                        $aiomatic_stats->addCasually($query, $text, []);
                        return $text;
                    },
                    10,
                    2
                );
                aiomatic_get_session_id();
                add_filter(
                    "aiomatic_ai_allowed",
                    [$this, "check_limits"],
                    1,
                    2
                );
                add_filter(
                    "aiomatic_tts_allowed",
                    [$this, "check_limits_tts"],
                    1,
                    2
                );
            }
        }
    }
    public function reset_usage_after_activation($uid, $lid, $firstTime, $args) 
    {
        $this->deleteUsageEntries('all', false, $uid, null, null);
    }
    public function reset_usage_after_renewal($uid, $lid, $args) 
    {
        $this->deleteUsageEntries('all', false, $uid, null, null);
    }
    function check_limits($allowed, $aiomatic_Limit_Settings)
    {
        global $aiomatic_stats;
        if (empty($aiomatic_stats)) {
            return $allowed;
        }
        $userId = null;
        if (
            isset($aiomatic_Limit_Settings["enable_limits"]) &&
            trim($aiomatic_Limit_Settings["enable_limits"]) == "on"
        ) {
            $userId = $this->getUserId();
            $target = $userId ? "users" : "guests";
            $skipme = false;
            if ($target === "users") {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users"]) &&
                    $aiomatic_Limit_Settings["ignored_users"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users"];
                } else {
                    $ignoredUsers = "admin";
                }
                $isAdministrator = current_user_can("manage_options");
                if ($isAdministrator && $ignoredUsers == "admin") {
                    $skipme = true;
                }
                $isEditor = current_user_can("edit_posts");
                if ($isEditor && $ignoredUsers == "editor") {
                    $skipme = true;
                }
            }
            if ($skipme == false) {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users"]) &&
                    $aiomatic_Limit_Settings["ignored_users"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users"];
                } else {
                    $ignoredUsers = "admin";
                }
                if (
                    isset($aiomatic_Limit_Settings["limit_message_logged"]) &&
                    $aiomatic_Limit_Settings["limit_message_logged"] != ""
                ) {
                    $limit_message_logged =
                        $aiomatic_Limit_Settings["limit_message_logged"];
                } else {
                    $limit_message_logged = esc_html__(
                        "You have reached the usage limit.",
                        "aiomatic-automatic-ai-content-writer"
                    );
                }
                if (
                    isset(
                        $aiomatic_Limit_Settings["limit_message_not_logged"]
                    ) &&
                    $aiomatic_Limit_Settings["limit_message_not_logged"] != ""
                ) {
                    $limit_message_not_logged =
                        $aiomatic_Limit_Settings["limit_message_not_logged"];
                } else {
                    $limit_message_not_logged = esc_html__(
                        "You have reached the usage limit.",
                        "aiomatic-automatic-ai-content-writer"
                    );
                }
                if ($target === "users") {
                    if (
                        isset($aiomatic_Limit_Settings["user_credits"]) &&
                        $aiomatic_Limit_Settings["user_credits"] == "0"
                    ) {
                        return $limit_message_logged;
                    } elseif (
                        !isset($aiomatic_Limit_Settings["user_credits"]) ||
                        $aiomatic_Limit_Settings["user_credits"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["user_time_frame"]) &&
                        $aiomatic_Limit_Settings["user_time_frame"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["user_time_frame"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_user"]) &&
                        $aiomatic_Limit_Settings["is_absolute_user"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                } else {
                    if (
                        isset($aiomatic_Limit_Settings["guest_credits"]) &&
                        $aiomatic_Limit_Settings["guest_credits"] == "0"
                    ) {
                        return $limit_message_not_logged;
                    } elseif (
                        !isset($aiomatic_Limit_Settings["guest_credits"]) ||
                        $aiomatic_Limit_Settings["guest_credits"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["guest_time_frame"]) &&
                        $aiomatic_Limit_Settings["guest_time_frame"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["guest_time_frame"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_guest"]) &&
                        $aiomatic_Limit_Settings["is_absolute_guest"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                }
                if ($skipme == false) {
                    $stats = $this->query($timeFrame, $isAbsolute);
                    if ($stats["overLimit"]) {
                        if ($target === "users") {
                            return $limit_message_logged;
                        } else {
                            return $limit_message_not_logged;
                        }
                    }
                }
            }
        }
        

        $aiomatic_Limit_Rules = get_option("aiomatic_Limit_Rules", false);
        if (is_array($aiomatic_Limit_Rules)) {
            if (
                isset($aiomatic_Limit_Settings["limit_message_rule"]) &&
                $aiomatic_Limit_Settings["limit_message_rule"] != ""
            ) {
                $limit_message_rule =
                    $aiomatic_Limit_Settings["limit_message_rule"];
            } else {
                $limit_message_rule = esc_html__(
                    "You have reached the usage limit.",
                    "aiomatic-automatic-ai-content-writer"
                );
            }
            $userRoles = aiomatic_my_get_current_user_roles();
            $userSubs = aiomatic_my_get_current_user_subscriptions();
            if(count($userSubs) > 1)
            {
                $is_limited = array();
                $no_limit_found = false;
                foreach($userSubs as $usub)
                {
                    foreach ($aiomatic_Limit_Rules as $cont => $bundle[]) {
                        $matching = false;
                        $bundle_values = array_values($bundle);
                        $myValues = $bundle_values[$cont];
                        $array_my_values = array_values($myValues);
                        for ($iji = 0; $iji < count($array_my_values); ++$iji) {
                            if (is_string($array_my_values[$iji])) {
                                $array_my_values[$iji] = stripslashes(
                                    $array_my_values[$iji]
                                );
                            }
                        }
                        $user_credits = $array_my_values[0];
                        $user_credit_type = $array_my_values[1];
                        $user_time_frame = $array_my_values[2];
                        $absolute = $array_my_values[3];
                        $role = $array_my_values[4];
                        $active = $array_my_values[5];
                        $ums_sub = $array_my_values[6];
                        $message = $array_my_values[7];
                        $rule_description = $array_my_values[8];
                        $user_list = $array_my_values[9];
                        if ($active !== "1") {
                            continue;
                        }
                        if (
                            empty($user_time_frame) ||
                            empty($user_credit_type) ||
                            empty($user_credits)
                        ) {
                            continue;
                        }
                        if (
                            $user_credit_type == 'pdf' || $user_credit_type == 'pdfchar'
                        ) {
                            continue;
                        }
                        $isAbsolute = false;
                        if ($absolute == "1") {
                            $isAbsolute = true;
                        }
                        if ($role == "any" || in_array($role, $userRoles)) {
                            $matching = true;
                        }
                        if(!empty($user_list) && !empty($userId))
                        {
                            $user_list_arr = explode(',', trim($user_list));
                            foreach($user_list_arr as $uli)
                            {
                                if($userId == $uli)
                                {
                                    $matching = true;
                                    break;
                                }
                            }
                        }
                        if ($ums_sub == "any" || $ums_sub == $usub){
                            $matching = true;
                        } elseif ($ums_sub == "nosub" && empty($userSubs)) {
                            $matching = true;
                        } else {
                            if ($ums_sub !== "none") {
                                $matching = false;
                            }
                        }
                        if ($matching === true) {
                            $stats = $this->query(
                                $user_time_frame,
                                $isAbsolute,
                                $user_credits,
                                $user_credit_type
                            );
                            if ($stats["overLimit"]) 
                            {
                                if (!empty($message)) {
                                    $is_limited[] = $message;
                                } else {
                                    $is_limited[] = $limit_message_rule;
                                }
                            }
                            else
                            {
                                $no_limit_found = true;
                            }
                        }
                    }
                }
                if($no_limit_found == false && count($is_limited) > 0)
                {
                    return $is_limited[0];
                }
            }
            else
            {
                foreach ($aiomatic_Limit_Rules as $cont => $bundle[]) {
                    $matching = false;
                    $bundle_values = array_values($bundle);
                    $myValues = $bundle_values[$cont];
                    $array_my_values = array_values($myValues);
                    for ($iji = 0; $iji < count($array_my_values); ++$iji) {
                        if (is_string($array_my_values[$iji])) {
                            $array_my_values[$iji] = stripslashes(
                                $array_my_values[$iji]
                            );
                        }
                    }
                    $user_credits = $array_my_values[0];
                    $user_credit_type = $array_my_values[1];
                    $user_time_frame = $array_my_values[2];
                    $absolute = $array_my_values[3];
                    $role = $array_my_values[4];
                    $active = $array_my_values[5];
                    $ums_sub = $array_my_values[6];
                    $message = $array_my_values[7];
                    $rule_description = $array_my_values[8];
                    $user_list = $array_my_values[9];
                    if ($active !== "1") {
                        continue;
                    }
                    if (
                        empty($user_time_frame) ||
                        empty($user_credit_type) ||
                        empty($user_credits)
                    ) {
                        continue;
                    }
                    if (
                        $user_credit_type == 'pdf' || $user_credit_type == 'pdfchar'
                    ) {
                        continue;
                    }
                    $isAbsolute = false;
                    if ($absolute == "1") {
                        $isAbsolute = true;
                    }
                    if ($role == "any" || in_array($role, $userRoles)) {
                        $matching = true;
                    }
                    if(!empty($user_list) && !empty($userId))
                    {
                        $user_list_arr = explode(',', trim($user_list));
                        foreach($user_list_arr as $uli)
                        {
                            if($userId == $uli)
                            {
                                $matching = true;
                                break;
                            }
                        }
                    }
                    if ($ums_sub == "any" || in_array($ums_sub, $userSubs)) {
                        $matching = true;
                    } elseif ($ums_sub == "nosub" && empty($userSubs)) {
                        $matching = true;
                    } else {
                        if ($ums_sub !== "none") {
                            $matching = false;
                        }
                    }
                    if ($matching === true) {
                        $stats = $this->query(
                            $user_time_frame,
                            $isAbsolute,
                            $user_credits,
                            $user_credit_type
                        );
                        if ($stats["overLimit"]) {
                            if (!empty($message)) {
                                return $message;
                            } else {
                                return $limit_message_rule;
                            }
                        }
                    }
                }
            }
        }
        return $allowed;
    }

    function check_limits_tts($allowed, $aiomatic_Limit_Settings)
    {
        global $aiomatic_stats;
        if (empty($aiomatic_stats)) {
            return $allowed;
        }
        if (
            isset($aiomatic_Limit_Settings["enable_limits_text"]) &&
            trim($aiomatic_Limit_Settings["enable_limits_text"]) == "on"
        ) {
            $userId = $this->getUserId();
            $target = $userId ? "users" : "guests";
            $skipme = false;
            if ($target === "users") {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users_text"]) &&
                    $aiomatic_Limit_Settings["ignored_users_text"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users_text"];
                } else {
                    $ignoredUsers = "admin";
                }
                $isAdministrator = current_user_can("manage_options");
                if ($isAdministrator && $ignoredUsers == "admin") {
                    $skipme = true;
                }
                $isEditor = current_user_can("edit_posts");
                if ($isEditor && $ignoredUsers == "editor") {
                    $skipme = true;
                }
            }
            if ($skipme == false) {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users_text"]) &&
                    $aiomatic_Limit_Settings["ignored_users_text"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users_text"];
                } else {
                    $ignoredUsers = "admin";
                }
                $limit_message_logged = esc_html__(
                    "You have reached the usage limit.",
                    "aiomatic-automatic-ai-content-writer"
                );
                $limit_message_not_logged = esc_html__(
                    "You have reached the usage limit.",
                    "aiomatic-automatic-ai-content-writer"
                );
                if ($target === "users") {
                    if (
                        isset($aiomatic_Limit_Settings["user_credits_text"]) &&
                        $aiomatic_Limit_Settings["user_credits_text"] == "0"
                    ) {
                        return $limit_message_logged;
                    } elseif (
                        !isset($aiomatic_Limit_Settings["user_credits_text"]) ||
                        $aiomatic_Limit_Settings["user_credits_text"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["user_time_frame_text"]) &&
                        $aiomatic_Limit_Settings["user_time_frame_text"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["user_time_frame_text"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_user_text"]) &&
                        $aiomatic_Limit_Settings["is_absolute_user_text"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                } else {
                    if (
                        isset($aiomatic_Limit_Settings["guest_credits_text"]) &&
                        $aiomatic_Limit_Settings["guest_credits_text"] == "0"
                    ) {
                        return $limit_message_not_logged;
                    } elseif (
                        !isset($aiomatic_Limit_Settings["guest_credits_text"]) ||
                        $aiomatic_Limit_Settings["guest_credits_text"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["guest_time_frame_text"]) &&
                        $aiomatic_Limit_Settings["guest_time_frame_text"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["guest_time_frame_text"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_guest_text"]) &&
                        $aiomatic_Limit_Settings["is_absolute_guest_text"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                }
                if ($skipme == false) {
                    $stats = $this->query_tts($timeFrame, $isAbsolute);
                    if ($stats["overLimit"]) {
                        if ($target === "users") {
                            return $limit_message_logged;
                        } else {
                            return $limit_message_not_logged;
                        }
                    }
                }
            }
        }
        return $allowed;
    }

    public function get_pdf_limits()
    {
        $pdfpage = array();
        $pdfchar = array();
        global $aiomatic_stats;
        if (empty($aiomatic_stats)) {
            return array($pdfpage, $pdfchar);
        }
        $userId = $this->getUserId();
        $aiomatic_Limit_Rules = get_option("aiomatic_Limit_Rules", false);
        if (is_array($aiomatic_Limit_Rules)) 
        {
            $userRoles = aiomatic_my_get_current_user_roles();
            $userSubs = aiomatic_my_get_current_user_subscriptions();
            
            if(count($userSubs) > 1)
            {
                foreach($userSubs as $usub)
                {
                    foreach ($aiomatic_Limit_Rules as $cont => $bundle[]) {
                        $matching = false;
                        $bundle_values = array_values($bundle);
                        $myValues = $bundle_values[$cont];
                        $array_my_values = array_values($myValues);
                        for ($iji = 0; $iji < count($array_my_values); ++$iji) {
                            if (is_string($array_my_values[$iji])) {
                                $array_my_values[$iji] = stripslashes(
                                    $array_my_values[$iji]
                                );
                            }
                        }
                        $user_credits = $array_my_values[0];
                        $user_credit_type = $array_my_values[1];
                        $user_time_frame = $array_my_values[2];
                        $absolute = $array_my_values[3];
                        $role = $array_my_values[4];
                        $active = $array_my_values[5];
                        $ums_sub = $array_my_values[6];
                        $message = $array_my_values[7];
                        $rule_description = $array_my_values[8];
                        $user_list = $array_my_values[9];
                        if ($active !== "1") {
                            continue;
                        }
                        if (
                            empty($user_time_frame) ||
                            empty($user_credit_type) ||
                            empty($user_credits)
                        ) {
                            continue;
                        }
                        if (
                            $user_credit_type != 'pdf' && $user_credit_type != 'pdfchar'
                        ) {
                            continue;
                        }
                        if ($role == "any" || in_array($role, $userRoles)) {
                            $matching = true;
                        }
                        if(!empty($user_list) && !empty($userId))
                        {
                            $user_list_arr = explode(',', trim($user_list));
                            foreach($user_list_arr as $uli)
                            {
                                if($userId == $uli)
                                {
                                    $matching = true;
                                    break;
                                }
                            }
                        }
                        if ($ums_sub == "any" || $ums_sub == $usub){
                            $matching = true;
                        } elseif ($ums_sub == "nosub" && empty($userSubs)) {
                            $matching = true;
                        } else {
                            if ($ums_sub !== "none") {
                                $matching = false;
                            }
                        }
                        if ($matching === true) {
                            if ($user_credit_type == 'pdf')
                            {
                                $pdfpage[] = $user_credits;
                            }
                            elseif ($user_credit_type == 'pdfchar')
                            {
                                $pdfchar[] = $user_credits;
                            }
                        }
                    }
                }
            }
            else
            {
                foreach ($aiomatic_Limit_Rules as $cont => $bundle[]) {
                    $matching = false;
                    $bundle_values = array_values($bundle);
                    $myValues = $bundle_values[$cont];
                    $array_my_values = array_values($myValues);
                    for ($iji = 0; $iji < count($array_my_values); ++$iji) {
                        if (is_string($array_my_values[$iji])) {
                            $array_my_values[$iji] = stripslashes(
                                $array_my_values[$iji]
                            );
                        }
                    }
                    $user_credits = $array_my_values[0];
                    $user_credit_type = $array_my_values[1];
                    $user_time_frame = $array_my_values[2];
                    $absolute = $array_my_values[3];
                    $role = $array_my_values[4];
                    $active = $array_my_values[5];
                    $ums_sub = $array_my_values[6];
                    $message = $array_my_values[7];
                    $rule_description = $array_my_values[8];
                    $user_list = $array_my_values[9];
                    if ($active !== "1") {
                        continue;
                    }
                    if (
                        empty($user_time_frame) ||
                        empty($user_credit_type) ||
                        empty($user_credits)
                    ) {
                        continue;
                    }
                    if (
                        $user_credit_type != 'pdf' && $user_credit_type != 'pdfchar'
                    ) {
                        continue;
                    }
                    if ($role == "any" || in_array($role, $userRoles)) {
                        $matching = true;
                    }
                    if(!empty($user_list) && !empty($userId))
                    {
                        $user_list_arr = explode(',', trim($user_list));
                        foreach($user_list_arr as $uli)
                        {
                            if($userId == $uli)
                            {
                                $matching = true;
                                break;
                            }
                        }
                    }
                    if ($ums_sub == "any" || in_array($ums_sub, $userSubs)) {
                        $matching = true;
                    } elseif ($ums_sub == "nosub" && empty($userSubs)) {
                        $matching = true;
                    } else {
                        if ($ums_sub !== "none") {
                            $matching = false;
                        }
                    }
                    if ($matching === true) {
                        if ($user_credit_type == 'pdf')
                        {
                            $pdfpage[] = $user_credits;
                        }
                        elseif ($user_credit_type == 'pdfchar')
                        {
                            $pdfchar[] = $user_credits;
                        }
                    }
                }
            }
        }
        $aiomatic_Limit_Settings = get_option("aiomatic_Limit_Settings", false);
        if (
            isset($aiomatic_Limit_Settings["enable_limits"]) &&
            trim($aiomatic_Limit_Settings["enable_limits"]) == "on"
        ) {
            $userId = $this->getUserId();
            $target = $userId ? "users" : "guests";
            $skipme = false;
            if ($target === "users") {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users"]) &&
                    $aiomatic_Limit_Settings["ignored_users"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users"];
                } else {
                    $ignoredUsers = "admin";
                }
                $isAdministrator = current_user_can("manage_options");
                if ($isAdministrator && $ignoredUsers == "admin") {
                    $skipme = true;
                }
                $isEditor = current_user_can("edit_posts");
                if ($isEditor && $ignoredUsers == "editor") {
                    $skipme = true;
                }
            }
            if ($skipme == false) {
                if ($target === "users") {
                    if (
                        isset($aiomatic_Limit_Settings["guest_credit_type"]) &&
                        trim($aiomatic_Limit_Settings["guest_credit_type"]) == "pdf" && 
                        isset($aiomatic_Limit_Settings["guest_credits"]) &&
                        $aiomatic_Limit_Settings["guest_credits"] != ""
                    ) {
                        $pdfpage[] = $aiomatic_Limit_Settings["guest_credits"];
                    }
                    elseif (
                        isset($aiomatic_Limit_Settings["guest_credit_type"]) &&
                        trim($aiomatic_Limit_Settings["guest_credit_type"]) == "pdfchar" && 
                        isset($aiomatic_Limit_Settings["guest_credits"]) &&
                        $aiomatic_Limit_Settings["guest_credits"] != ""
                    ) {
                        $pdfchar[] = $aiomatic_Limit_Settings["guest_credits"];
                    }
                } else {
                    if (
                        isset($aiomatic_Limit_Settings["user_credit_type"]) &&
                        trim($aiomatic_Limit_Settings["user_credit_type"]) == "pdf" && 
                        isset($aiomatic_Limit_Settings["user_credits"]) &&
                        $aiomatic_Limit_Settings["user_credits"] != ""
                    ) {
                        $pdfpage[] = $aiomatic_Limit_Settings["user_credits"];
                    }
                    elseif (
                        isset($aiomatic_Limit_Settings["user_credit_type"]) &&
                        trim($aiomatic_Limit_Settings["user_credit_type"]) == "pdfchar" && 
                        isset($aiomatic_Limit_Settings["user_credits"]) &&
                        $aiomatic_Limit_Settings["user_credits"] != ""
                    ) {
                        $pdfchar[] = $aiomatic_Limit_Settings["user_credits"];
                    }
                }
            }
        }
        return array($pdfpage, $pdfchar);
    }

    public function get_limits($aiomatic_Limit_Settings)
    {
        $limits = "";
        $userId = null;
        global $aiomatic_stats;
        if (empty($aiomatic_stats)) {
            return esc_html__(
                "Limits not available",
                "aiomatic-automatic-ai-content-writer"
            );
        }
        if (
            isset($aiomatic_Limit_Settings["enable_limits"]) &&
            trim($aiomatic_Limit_Settings["enable_limits"]) == "on"
        ) {
            $userId = $this->getUserId();
            $target = $userId ? "users" : "guests";
            $skipme = false;
            if ($target === "users") {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users"]) &&
                    $aiomatic_Limit_Settings["ignored_users"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users"];
                } else {
                    $ignoredUsers = "admin";
                }
                $isAdministrator = current_user_can("manage_options");
                if ($isAdministrator && $ignoredUsers == "admin") {
                    $skipme = true;
                }
                $isEditor = current_user_can("edit_posts");
                if ($isEditor && $ignoredUsers == "editor") {
                    $skipme = true;
                }
            }
            if ($skipme == false) {
                if (
                    isset($aiomatic_Limit_Settings["ignored_users"]) &&
                    $aiomatic_Limit_Settings["ignored_users"] != ""
                ) {
                    $ignoredUsers = $aiomatic_Limit_Settings["ignored_users"];
                } else {
                    $ignoredUsers = "admin";
                }
                if ($target === "users") {
                    if (
                        isset($aiomatic_Limit_Settings["user_credits"]) &&
                        $aiomatic_Limit_Settings["user_credits"] == "0"
                    ) {
                    } elseif (
                        !isset($aiomatic_Limit_Settings["user_credits"]) ||
                        $aiomatic_Limit_Settings["user_credits"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["user_time_frame"]) &&
                        $aiomatic_Limit_Settings["user_time_frame"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["user_time_frame"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_user"]) &&
                        $aiomatic_Limit_Settings["is_absolute_user"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                } else {
                    if (
                        !isset($aiomatic_Limit_Settings["guest_credits"]) ||
                        $aiomatic_Limit_Settings["guest_credits"] == ""
                    ) {
                        $skipme = true;
                    }
                    if (
                        isset($aiomatic_Limit_Settings["guest_time_frame"]) &&
                        $aiomatic_Limit_Settings["guest_time_frame"] != ""
                    ) {
                        $timeFrame =
                            $aiomatic_Limit_Settings["guest_time_frame"];
                    } else {
                        $timeFrame = "day";
                    }
                    if (
                        isset($aiomatic_Limit_Settings["is_absolute_guest"]) &&
                        $aiomatic_Limit_Settings["is_absolute_guest"] == "on"
                    ) {
                        $isAbsolute = true;
                    } else {
                        $isAbsolute = false;
                    }
                }
                if ($skipme == false) {
                    $stats = $this->query($timeFrame, $isAbsolute);
                    if ($stats["queriesLimit"] != "0") {
                        $limits .=
                            $stats["queries"] .
                            ' ' .
                            esc_html__(
                                "used",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["queriesLimit"] .
                            " " .
                            esc_html__(
                                "queries",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $timeFrame .
                            "<br>";
                    } elseif ($stats["unitsLimit"] != "0") {
                        $limits .=
                            $stats["units"] .
                            ' ' .
                            esc_html__(
                                "used",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["unitsLimit"] .
                            " " .
                            esc_html__(
                                "tokens",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $timeFrame .
                            "<br>";
                    } elseif ($stats["priceLimit"] != "0") {
                        $limits .=
                            $stats["price"] .
                            ' ' .
                            esc_html__(
                                "used",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["priceLimit"] .
                            " " .
                            esc_html__(
                                "USD",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $timeFrame .
                            "<br>";
                    }
                }
            }
        }

        $aiomatic_Limit_Rules = get_option("aiomatic_Limit_Rules", false);
        if (is_array($aiomatic_Limit_Rules)) {
            $userRoles = aiomatic_my_get_current_user_roles();
            $userSubs = aiomatic_my_get_current_user_subscriptions();
            foreach ($aiomatic_Limit_Rules as $cont => $bundle[]) {
                $matching = false;
                $bundle_values = array_values($bundle);
                $myValues = $bundle_values[$cont];
                $array_my_values = array_values($myValues);
                for ($iji = 0; $iji < count($array_my_values); ++$iji) {
                    if (is_string($array_my_values[$iji])) {
                        $array_my_values[$iji] = stripslashes(
                            $array_my_values[$iji]
                        );
                    }
                }
                $user_credits = $array_my_values[0];
                $user_credit_type = $array_my_values[1];
                $user_time_frame = $array_my_values[2];
                $absolute = $array_my_values[3];
                $role = $array_my_values[4];
                $active = $array_my_values[5];
                $ums_sub = $array_my_values[6];
                $message = $array_my_values[7];
                $rule_description = $array_my_values[8];
                $user_list = $array_my_values[9];
                if ($active !== "1") {
                    continue;
                }
                if (
                    empty($user_time_frame) ||
                    empty($user_credit_type) ||
                    empty($user_credits)
                ) {
                    continue;
                }
                if (
                    $user_credit_type == 'pdf' || $user_credit_type == 'pdfchar'
                ) {
                    continue;
                }
                $isAbsolute = false;
                if ($absolute == "1") {
                    $isAbsolute = true;
                }
                if ($role == "any" || in_array($role, $userRoles)) {
                    $matching = true;
                }
                if(!empty($user_list) && !empty($userId))
                {
                    $user_list_arr = explode(',', trim($user_list));
                    foreach($user_list_arr as $uli)
                    {
                        if($userId == $uli)
                        {
                            $matching = true;
                            break;
                        }
                    }
                }
                if ($ums_sub == "any" || in_array($ums_sub, $userSubs)) {
                    $matching = true;
                } elseif ($ums_sub == "nosub" && empty($userSubs)) {
                    $matching = true;
                } else {
                    if ($ums_sub !== "none") {
                        $matching = false;
                    }
                }
                if ($matching === true) 
                {
                    $stats = $this->query(
                        $user_time_frame,
                        $isAbsolute,
                        $user_credits,
                        $user_credit_type
                    );
                    if ($stats["queriesLimit"] != "0") {
                        $limits .=
                            $stats["queries"] .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["queriesLimit"] .
                            " " .
                            esc_html__(
                                "queries",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $user_time_frame .
                            "<br>";
                    } elseif ($stats["unitsLimit"] != "0") {
                        $limits .=
                            $stats["units"] .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["unitsLimit"] .
                            " " .
                            esc_html__(
                                "tokens",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $user_time_frame .
                            "<br>";
                    } elseif ($stats["priceLimit"] != "0") {
                        $limits .=
                            $stats["price"] .
                            esc_html__(" used from a maximum of ", "aiomatic-automatic-ai-content-writer") .
                            $stats["priceLimit"] .
                            " " .
                            esc_html__(
                                "USD",
                                "aiomatic-automatic-ai-content-writer"
                            ) .
                            "/" .
                            $user_time_frame .
                            "<br>";
                    }
                }
            }
        }
        if (empty($limits)) {
            return esc_html__(
                "No limit",
                "aiomatic-automatic-ai-content-writer"
            );
        } else {
            return $limits;
        }
    }

    function calculatePrice(
        $model,
        $response_units,
        $prompt_units = 0,
        $option = null
    ) {
        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        // Price as of 1st November 2023: https://openai.com/api/pricing/
        $openai_pricing = [
            // Base models:
            [
                "model" => "text-embedding-ada-002",
                "prompt_price" => 0.0001,
                "completion_price" => 0.0001,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "text-embedding-3-large",
                "prompt_price" => 0.00013,
                "completion_price" => 0.00013,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "text-embedding-3-small",
                "prompt_price" => 0.00002,
                "completion_price" => 0.00002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "chatgpt",
                "prompt_price" => 0.0010,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "chatgpt-16k",
                "prompt_price" => 0.003,
                "completion_price" => 0.004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4",
                "prompt_price" => 0.03,
                "completion_price" => 0.06,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4-turbo",
                "prompt_price" => 0.01,
                "completion_price" => 0.03,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4o",
                "prompt_price" => 0.005,
                "completion_price" => 0.015,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4-32k",
                "prompt_price" => 0.06,
                "completion_price" => 0.12,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "davinci",
                "prompt_price" => 0.002,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt-instruct",
                "prompt_price" => 0.0015,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "curie",
                "prompt_price" => 0.002,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "babbage",
                "prompt_price" => 0.0004,
                "completion_price" => 0.0004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "ada",
                "prompt_price" => 0.0004,
                "completion_price" => 0.0004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            // Image models:
            [
                "model" => "dalle2",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.02],
                    ["option" => "512x512", "price" => 0.018],
                    ["option" => "256x256", "price" => 0.016],
                ],
            ],
            [
                "model" => "dalle3",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.04],
                    ["option" => "1024x1792", "price" => 0.08],
                    ["option" => "1792x1024", "price" => 0.08]
                ],
            ],
            [
                "model" => "dalle3hd",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.08],
                    ["option" => "1024x1792", "price" => 0.12],
                    ["option" => "1792x1024", "price" => 0.12]
                ],
            ],
            [
                "model" => "stable-diffusion",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.02],
                    ["option" => "512x512", "price" => 0.018],
                ],
            ],
            // Fine-tuned models:
            [
                "model" => "fn-davinci",
                "prompt_price" => 0.012,
                "completion_price" => 0.012,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-curie",
                "prompt_price" => 0.012,
                "completion_price" => 0.012,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-babbage",
                "prompt_price" => 0.0016,
                "completion_price" => 0.0016,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-ada",
                "prompt_price" => 0.0016,
                "completion_price" => 0.0016,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-turbo",
                "prompt_price" => 0.003,
                "completion_price" => 0.006,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-gpt4",
                "prompt_price" => 0.09,
                "completion_price" => 0.18,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
        ];
        //https://www.goapi.ai/midjourney-api
        $midjourney_pricing = [[
            "model" => "fast",
            "type" => "image",
            "unit" => 1,
            "options" => [
                ["option" => "1024x1024", "price" => 0.045],
                ["option" => "512x512", "price" => 0.045],
                ["option" => "256x256", "price" => 0.045],
                ["option" => "1792x1024", "price" => 0.045],
                ["option" => "1024x1792", "price" => 0.045],
            ],
            [
            "model" => "turbo",
            "type" => "image",
            "unit" => 1,
            "options" => [
                ["option" => "1024x1024", "price" => 0.1],
                ["option" => "512x512", "price" => 0.1],
                ["option" => "256x256", "price" => 0.1],
                ["option" => "1792x1024", "price" => 0.1],
                ["option" => "1024x1792", "price" => 0.1],
            ]],
            [
            "model" => "mixed",
            "type" => "image",
            "unit" => 1,
            "options" => [
                ["option" => "1024x1024", "price" => 0.015],
                ["option" => "512x512", "price" => 0.015],
                ["option" => "256x256", "price" => 0.015],
                ["option" => "1792x1024", "price" => 0.015],
                ["option" => "1024x1792", "price" => 0.015],
            ]]
            ]
        ];
        //https://azure.microsoft.com/en-us/pricing/details/cognitive-services/openai-service/
        $azure_pricing = [
            // Base models:
            [
                "model" => "embeddings",
                "prompt_price" => 0.0001,
                "completion_price" => 0.0001,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "chatgpt",
                "prompt_price" => 0.0005,
                "completion_price" => 0.0015,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt-instruct",
                "prompt_price" => 0.0015,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "chatgpt-16k",
                "prompt_price" => 0.003,
                "completion_price" => 0.004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4",
                "prompt_price" => 0.03,
                "completion_price" => 0.06,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "gpt4-32k",
                "prompt_price" => 0.06,
                "completion_price" => 0.12,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "davinci",
                "prompt_price" => 0.02,
                "completion_price" => 0.02,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "curie",
                "prompt_price" => 0.002,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "babbage",
                "prompt_price" => 0.0005,
                "completion_price" => 0.0005,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "ada",
                "prompt_price" => 0.0004,
                "completion_price" => 0.0004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            // Image models:
            [
                "model" => "dall-e",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.02],
                    ["option" => "512x512", "price" => 0.02],
                    ["option" => "256x256", "price" => 0.02],
                ],
            ],
            // Image models:
            [
                "model" => "dalle3",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.04],
                    ["option" => "1024x1792", "price" => 0.08],
                    ["option" => "1792x1024", "price" => 0.08],
                ],
            ],
            [
                "model" => "dalle3hd",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.08],
                    ["option" => "1024x1792", "price" => 0.12],
                    ["option" => "1792x1024", "price" => 0.12]
                ],
            ],
            [
                "model" => "stable-diffusion",
                "type" => "image",
                "unit" => 1,
                "options" => [
                    ["option" => "1024x1024", "price" => 0.02],
                    ["option" => "512x512", "price" => 0.018],
                ],
            ],
            // Fine-tuned models:
            [
                "model" => "fn-davinci",
                "prompt_price" => 0.02,
                "completion_price" => 0.02,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-curie",
                "prompt_price" => 0.002,
                "completion_price" => 0.002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-babbage",
                "prompt_price" => 0.0005,
                "completion_price" => 0.0005,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "fn-ada",
                "prompt_price" => 0.0004,
                "completion_price" => 0.0004,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
        ];
        //https://www-files.anthropic.com/production/images/model_pricing_nov2023.pdf
        $claude_pricing = [
            // Base models:
            [
                "model" => "claude-instant-1",
                "prompt_price" => 0.00163,
                "completion_price" => 0.00551,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],[
                "model" => "claude-instant-1.2",
                "prompt_price" => 0.00163,
                "completion_price" => 0.00551,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-2.0",
                "prompt_price" => 0.008,
                "completion_price" => 0.024,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-2.1",
                "prompt_price" => 0.008,
                "completion_price" => 0.024,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-3-opus-20240229",
                "prompt_price" => 0.015,
                "completion_price" => 0.075,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-3-sonnet-20240229",
                "prompt_price" => 0.003,
                "completion_price" => 0.015,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-3-haiku-20240307",
                "prompt_price" => 0.00025,
                "completion_price" => 0.00125,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "claude-3-5-sonnet-20240620",
                "prompt_price" => 0.003,
                "completion_price" => 0.015,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ]
        ];
        $google_pricing = [
            // Base models:
            [
                "model" => "gemini-pro",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],[
                "model" => "gemini-1.5-pro-latest",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],[
                "model" => "gemini-1.5-flash-latest",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],[
                "model" => "gemini-1.0-pro",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],[
                "model" => "chat-bison-001",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "text-bison-001",
                "prompt_price" => 0,
                "completion_price" => 0,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ]
        ];
        //https://docs.perplexity.ai/docs/pricing
        $perplexity_pricing = [
            // Base models:
            [
                "model" => "llama-3-sonar-small-32k-chat",
                "prompt_price" => 0.0002,
                "completion_price" => 0.0002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "llama-3-sonar-small-32k-online",
                "prompt_price" => 0.0002,
                "completion_price" => 0.0002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "llama-3-sonar-large-32k-chat",
                "prompt_price" => 0.0006,
                "completion_price" => 0.0006,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "llama-3-sonar-large-32k-online",
                "prompt_price" => 0.0006,
                "completion_price" => 0.0006,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "llama-3-8b-instruct",
                "prompt_price" => 0.0002,
                "completion_price" => 0.0002,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "llama-3-70b-instruct",
                "prompt_price" => 0.001,
                "completion_price" => 0.001,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ],
            [
                "model" => "mixtral-8x7b-instruct",
                "prompt_price" => 0.0006,
                "completion_price" => 0.0006,
                "type" => "token",
                "unit" => 1 / 1000,
                "options" => [],
            ]
        ];
        if (aiomatic_check_if_midjourney($model))
        {
            foreach ($midjourney_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        elseif (aiomatic_is_claude_model($model))
        {
            foreach ($claude_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        elseif (aiomatic_is_google_model($model))
        {
            foreach ($google_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        elseif (aiomatic_is_huggingface_model($model) || $model == 'huggingface')
        {
            $response_price = 0;
            $prompt_price = 0;
            return $response_price + $prompt_price;
        }
        elseif (aiomatic_is_ollama_model($model) || $model == 'ollama')
        {
            $response_price = 0;
            $prompt_price = 0;
            return $response_price + $prompt_price;
        }
        elseif (aiomatic_is_openrouter_model($model))
        {
            $response_price = 0;
            $prompt_price = 0;
            return $response_price + $prompt_price;
        }
        elseif (aiomatic_is_perplexity_model($model))
        {
            foreach ($perplexity_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        elseif (aiomatic_check_if_azure($aiomatic_Main_Settings))
        {
            foreach ($azure_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        else
        {
            foreach ($openai_pricing as $price) {
                if ($price["model"] == $model) {
                    if ($price["type"] == "image") {
                        if (!$option) {
                            aiomatic_log_to_file("Image models require an option.");
                            return 0;
                        } else {
                            foreach ($price["options"] as $imageType) {
                                if ($imageType["option"] == $option) {
                                    $response_price =
                                        $imageType["price"] * $response_units;
                                    return $response_price;
                                }
                            }
                        }
                    } else {
                        $response_price =
                            $price["completion_price"] *
                            $price["unit"] *
                            $response_units;
                        $prompt_price =
                            $price["prompt_price"] * $price["unit"] * $prompt_units;
                        return $response_price + $prompt_price;
                    }
                }
            }
        }
        aiomatic_log_to_file("Invalid model (" . $model . ").");
        return 0;
    }
    function getVisionPrice($model)
    {
        if($model == 'gpt-4-vision-preview')
        {
            return 0.00085;
        }
        return 0;
    }
    function getPrice($query, $answer)
    {
        $prompt_units = 0;
        $response_units = 0;
        $model = $query->model;
        $modelBase = null;
        $option = "";
        if ($query->mode == "text") {
            if (preg_match("/^([a-zA-Z]{0,32}):/", $model, $matches)) {
                if($matches[1] != 'ft')
                {
                    $modelBase = "fn-" . $matches[1];
                }
                else
                {
                    if(aiomatic_starts_with($model, 'ft:davinci-002'))
                    {
                        $modelBase = "fn-davinci";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:babbage-002'))
                    {
                        $modelBase = "fn-babbage";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:gpt-3.5-turbo'))
                    {
                        $modelBase = "fn-turbo";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:gpt-4'))
                    {
                        $modelBase = "fn-gpt4";
                    }
                    else
                    {
                        aiomatic_log_to_file("Cannot find the base model for trained model $model.");
                        return null;
                    }
                }
            } elseif (
                preg_match("/^(?:text|code)-(\w+)-\d+/", $model, $matches)
            ) {
                $modelBase = $matches[1];
            } elseif (aiomatic_is_chatgpt_model($model)) {
                if (stristr($model, "turbo") !== false) {
                    if (stristr($model, "turbo-16k") !== false) 
                    {
                        $modelBase = "chatgpt-16k";
                    }
                    else
                    {
                        $modelBase = "chatgpt";
                    }
                } else {
                    if (stristr($model, "32k") !== false) {
                        $modelBase = "gpt4-32k";
                    } else {
                        $modelBase = "gpt4";
                    }
                }
            }
            elseif (aiomatic_is_claude_model($model)) 
            {
                $modelBase = $model;
            }
            elseif (aiomatic_is_chatgpt_turbo_model($model)) 
            {
                $modelBase = 'gpt4-turbo';
            }
            elseif (aiomatic_is_chatgpt_o_model($model)) 
            {
                $modelBase = 'gpt4o';
            }
            elseif (aiomatic_is_perplexity_model($model)) 
            {
                $modelBase = $model;
            }
            elseif (aiomatic_is_huggingface_model($model)) 
            {
                $modelBase = 'huggingface';
            }
            elseif (aiomatic_is_ollama_model($model)) 
            {
                $modelBase = 'ollama';
            }
            else
            {
                $modelBase = 'gpt-instruct';
            }
            if (empty($modelBase)) {
                aiomatic_log_to_file("Cannot find the base model for $model.");
                return null;
            }
            if (isset($query->prompt) && is_string($query->prompt)) {
                $prompt_units = count(aiomatic_encode($query->prompt));
            }
            if (is_string($answer)) {
                $response_units = count(aiomatic_encode($answer));
            } else {
                if (isset($answer->usage->total_tokens)) {
                    $response_units = $answer->usage->total_tokens;
                } else {
                    if (isset($answer['content'][0]['text']['value'])) {
                        $response_units = count(
                            aiomatic_encode($answer['content'][0]['text']['value'])
                        );
                    }
                    else
                    {
                        aiomatic_log_to_file(
                            "Error, textual answer does not have total_tokens: " .
                                print_r($answer, true)
                        );
                        return false;
                    }
                }
            }
        } elseif ($query->mode == "image") {
            $modelBase = $query->model;
            $response_units = 1;
            if (isset($query->image_size)) {
                $option = $query->image_size;
            }
        } elseif ($query->mode == "stable") {
            $modelBase = "stable-diffusion";
            $response_units = 1;
            if (isset($query->image_size)) {
                $option = $query->image_size;
            }
        } elseif ($query->mode == "edit") {
            if (preg_match("/^([a-zA-Z]{0,32}):/", $model, $matches)) {
                if($matches[1] != 'ft')
                {
                    $modelBase = "fn-" . $matches[1];
                }
                else
                {
                    if(aiomatic_starts_with($model, 'ft:davinci-002'))
                    {
                        $modelBase = "fn-davinci";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:babbage-002'))
                    {
                        $modelBase = "fn-babbage";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:gpt-3.5-turbo'))
                    {
                        $modelBase = "fn-turbo";
                    }
                    elseif(aiomatic_starts_with($model, 'ft:gpt-4'))
                    {
                        $modelBase = "fn-gpt4";
                    }
                    else
                    {
                        aiomatic_log_to_file("Cannot find the base model for trained model $model.");
                        return null;
                    }
                }
            } elseif (
                preg_match("/^(?:text|code)-(\w+)-edit-\d+/", $model, $matches)
            ) {
                $modelBase = $matches[1];
            }
            if (empty($modelBase)) {
                aiomatic_log_to_file("Cannot find the base model for $model.");
                return null;
            }
            if (isset($query->prompt) && is_string($query->prompt)) {
                $prompt_units = count(aiomatic_encode($query->prompt));
            }
            if (is_string($answer)) {
                $response_units = count(aiomatic_encode($answer));
            } else {
                if (isset($answer->usage->total_tokens)) {
                    $response_units = $answer->usage->total_tokens;
                } else {
                    if (isset($answer['content'][0]['text']['value'])) {
                        $response_units = count(
                            aiomatic_encode($answer['content'][0]['text']['value'])
                        );
                    }
                    else
                    {
                        aiomatic_log_to_file(
                            "Error, textual answer does not have total_tokens: " .
                                print_r($answer, true)
                        );
                        return false;
                    }
                }
            }
        } elseif ($query->mode == "embeddings") {
            $modelBase = $query->model;
            $response_units = 1;
            if (isset($query->prompt) && is_string($query->prompt)) {
                $prompt_units = count(aiomatic_encode($query->prompt));
            }
            if (is_string($answer)) {
                $response_units = count(aiomatic_encode($answer));
            } else {
                if (isset($answer["usage"]["total_tokens"])) {
                    $response_units = $answer["usage"]["total_tokens"];
                } elseif (isset($answer->usage->total_tokens)) {
                    $response_units = $answer->usage->total_tokens;
                } elseif (isset($answer[0]->usage->total_tokens)) {
                    $response_units = $answer[0]->usage->total_tokens;
                } else {
                    aiomatic_log_to_file(
                        "Error, embedding answer does not have total_tokens: " .
                            print_r($answer, true)
                    );
                    return false;
                }
            }
        } else {
            aiomatic_log_to_file("Unknown query: " . print_r($query, true));
        }
        return $this->calculatePrice(
            $modelBase,
            $response_units,
            $prompt_units,
            $option
        );
    }
    function addCasually($query, $answer, $overrides)
    {
        $type = null;
        $units = 0;
        if ($query->mode == "text" || $query->mode == "edit") {
            $type = "tokens";
            if (is_string($answer)) {
                $units =
                    count(aiomatic_encode($answer)) +
                    count(aiomatic_encode($query->prompt));
            } else {
                if (aiomatic_is_aiomaticapi_key($query->apiKey)) {
                    if (isset($answer->content)) {
                        $response_units = count(
                            aiomatic_encode($answer->content)
                        );
                        $prompt_units = count(aiomatic_encode($query->prompt));
                        $units = $prompt_units + $response_units;
                    } else {
                        aiomatic_log_to_file(
                            "Error, AiomaticAPI text answer does not have defined layout: " .
                                print_r($answer, true)
                        );
                        return false;
                    }
                } else {
                    if (isset($answer->usage->total_tokens)) {
                        $units = $answer->usage->total_tokens;
                    } else {
                        if (isset($answer['content'][0]['text']['value'])) 
                        {
                            $response_units = count(
                                aiomatic_encode($answer['content'][0]['text']['value'])
                            );
                            $prompt_units = count(aiomatic_encode($query->prompt));
                            $units = $prompt_units + $response_units;
                        }
                        else
                        {
                            aiomatic_log_to_file(
                                "Error, text answer does not have total_tokens: " .
                                    print_r($answer, true)
                            );
                            return false;
                        }
                    }
                }
            }
        } elseif ($query->mode == "image") {
            $type = "images";
            $units = 1;
        } elseif ($query->mode == "video") {
            $type = "videos";
            $units = 1;
        } elseif ($query->mode == "stable") {
            $type = "images";
            $units = 1;
        } elseif ($query->mode == "text-to-speech") {
            $type = "characters";
            $units = strlen($answer);
        } elseif ($query->mode == "embeddings") {
            $type = "tokens";
            if (isset($answer["usage"]["total_tokens"])) {
                $units = $answer["usage"]["total_tokens"];
            } else {
                $units = count(aiomatic_encode($query->prompt));
            }
        }
        $stats = [
            "env" => $query->env,
            "session" => $query->session,
            "mode" => $query->mode,
            "model" => $query->model,
            "assistant_id" => $query->assistant_id,
            "apiRef" => $query->apiKey,
            "units" => $units,
            "type" => $type,
        ];
        $stats = array_merge($stats, $overrides);
        if (empty($stats["price"])) {
            if ($query->mode == "text-to-speech") 
            {
                if($query->model == 'elevenlabs')
                {
                    $stats["price"] = 0;
                }
                elseif($query->model == 'google')
                {
                    $stats["price"] = 0.000004 * $units;
                }
                elseif($query->model == 'd-id')
                {
                    $stats["price"] = 0;
                }
                elseif($query->model == 'openai-tts-1')
                {
                    $stats["price"] = 0.000015 * $units;
                }
                elseif($query->model == 'openai-tts-1-hd')
                {
                    $stats["price"] = 0.00003 * $units;
                }
                else
                {
                    $stats["price"] = 0;
                }
            }
            else
            {
                if (aiomatic_is_aiomaticapi_key($query->apiKey)) 
                {
                    $stats["price"] = 0;
                } 
                elseif($stats['type'] == 'videos')
                {
                    $stats["price"] = 0;
                }
                else 
                {
                    $stats["price"] = $this->getPrice($query, $answer);
                }
            }
        }
        return $this->add($stats);
    }
    function getUserId($data = null)
    {
        if (isset($data) && isset($data["userId"])) {
            return (int) $data["userId"];
        }
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if ($current_user->ID > 0) {
                return $current_user->ID;
            }
        }
        return null;
    }

    function buildTagsForDb($tags)
    {
        if (is_array($tags)) {
            $tags = implode("|", $tags);
        }
        if (!empty($tags)) {
            $tags .= "|";
        } else {
            $tags = null;
        }
        return $tags;
    }

    function getUserIpAddress($data = null)
    {
        if (isset($data) && isset($data["ip"])) {
            $data["ip"] = (string) $data["ip"];
        } else {
            if (isset($_SERVER["REMOTE_ADDR"])) {
                $data["ip"] = $_SERVER["REMOTE_ADDR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $data["ip"] = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $data["ip"] = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
        }
        return $data["ip"];
    }

    function query(
        $timeFrame = null,
        $isAbsolute = null,
        $credits = null,
        $credit_type = null,
        $userId = null,
        $ipAddress = null,
        $apiRef = null
    ) {
        if ($apiRef === null) {
            $apiRef = $this->apiRef;
        }
        $target = "guests";
        if ($userId === null && $ipAddress === null) {
            $userId = $this->getUserId();
            if ($userId) {
                $target = "users";
            } else {
                $ipAddress = $this->getUserIpAddress();
                if ($ipAddress === null) {
                    aiomatic_log_to_file(
                        "There should be an userId or an ipAddress."
                    );
                    return null;
                }
            }
        }
        $aiomatic_Limit_Settings = get_option("aiomatic_Limit_Settings", false);
        if ($target == "guests") {
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credits"]) &&
                    $aiomatic_Limit_Settings["guest_credits"] != ""
                ) {
                    $hasLimits = true;
                } else {
                    $hasLimits = false;
                }
            } else {
                $hasLimits = true;
            }
            if ($timeFrame === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_time_frame"]) &&
                    $aiomatic_Limit_Settings["guest_time_frame"] != ""
                ) {
                    $timeFrame = $aiomatic_Limit_Settings["guest_time_frame"];
                } else {
                    $timeFrame = "day";
                }
            }
            if ($isAbsolute === null) {
                if (
                    isset($aiomatic_Limit_Settings["is_absolute_guest"]) &&
                    $aiomatic_Limit_Settings["is_absolute_guest"] == "on"
                ) {
                    $isAbsolute = true;
                } else {
                    $isAbsolute = false;
                }
            }
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credits"]) &&
                    $aiomatic_Limit_Settings["guest_credits"] != ""
                ) {
                    $credits = $aiomatic_Limit_Settings["guest_credits"];
                } else {
                    $credits = "";
                }
            }
            if ($credit_type === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credit_type"]) &&
                    $aiomatic_Limit_Settings["guest_credit_type"] != ""
                ) {
                    $credit_type =
                        $aiomatic_Limit_Settings["guest_credit_type"];
                } else {
                    $credit_type = "queries";
                }
            }
        } else {
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credits"]) &&
                    $aiomatic_Limit_Settings["user_credits"] != ""
                ) {
                    $hasLimits = true;
                } else {
                    $hasLimits = false;
                }
            } else {
                $hasLimits = true;
            }
            if ($timeFrame === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_time_frame"]) &&
                    $aiomatic_Limit_Settings["user_time_frame"] != ""
                ) {
                    $timeFrame = $aiomatic_Limit_Settings["user_time_frame"];
                } else {
                    $timeFrame = "day";
                }
            }
            if ($isAbsolute === null) {
                if (
                    isset($aiomatic_Limit_Settings["is_absolute_user"]) &&
                    $aiomatic_Limit_Settings["is_absolute_user"] == "on"
                ) {
                    $isAbsolute = true;
                } else {
                    $isAbsolute = false;
                }
            }
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credits"]) &&
                    $aiomatic_Limit_Settings["user_credits"] != ""
                ) {
                    $credits = $aiomatic_Limit_Settings["user_credits"];
                } else {
                    $credits = "";
                }
            }
            if ($credit_type === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credit_type"]) &&
                    $aiomatic_Limit_Settings["user_credit_type"] != ""
                ) {
                    $credit_type = $aiomatic_Limit_Settings["user_credit_type"];
                } else {
                    $credit_type = "queries";
                }
            }
        }
        if (
            $timeFrame !== "day" &&
            $timeFrame !== "week" &&
            $timeFrame !== "month" &&
            $timeFrame !== "year"
        ) {
            aiomatic_log_to_file(
                "TimeFrame should be day, week, month, or year."
            );
            return null;
        }
        if (
            $credit_type == 'pdf' || $credit_type == 'pdfchar'
        ) {
            return null;
        }

        $this->check_db();
        $prefix = esc_sql($this->wpdb->prefix);
        $sql = "SELECT COUNT(*) AS queries, SUM(units) AS units, SUM(price) AS price FROM {$prefix}aiomatic_logs WHERE ";

        if ($target === "users") {
            $sql .= "userId = " . esc_sql($userId) . "";
        } else {
            $sql .= "ip = '" . esc_sql($ipAddress) . "'";
        }

        if ($apiRef) {
            $sql .= " AND apiRef = '" . esc_sql($apiRef) . "'";
        }

        if ($timeFrame === "day") {
            if ($isAbsolute) {
                $sql .= " AND DAY(time) = DAY(CURRENT_DATE())";
            } else {
                $sql .= " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
            }
        } elseif ($timeFrame === "week") {
            if ($isAbsolute) {
                $sql .= " AND WEEK(time) = WEEK(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK)";
            }
        } elseif ($timeFrame === "month") {
            if ($isAbsolute) {
                $sql .= " AND MONTH(time) = MONTH(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)";
            }
        } elseif ($timeFrame === "year") {
            if ($isAbsolute) {
                $sql .= " AND YEAR(time) = YEAR(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR)";
            }
        }

        $results = $this->wpdb->get_results($sql);
        if (count($results) === 0) {
            return null;
        }
        $result = $results[0];
        $stats = [];
        $stats["userId"] = $userId;
        $stats["ipAddress"] = $ipAddress;
        $stats["queries"] = intVal($result->queries);
        $stats["units"] = intVal($result->units);
        $stats["price"] = round(floatVal($result->price), 2);

        $stats["queriesLimit"] = intVal(
            $hasLimits && $credit_type === "queries" ? $credits : 0
        );
        $stats["unitsLimit"] = intVal(
            $hasLimits && $credit_type === "units" ? $credits : 0
        );
        $stats["priceLimit"] = floatVal(
            $hasLimits && $credit_type === "price" ? $credits : 0
        );

        $credits = apply_filters("aiomatic_stats_credits", $credits, $userId);
        $stats["overLimit"] = false;
        if ($hasLimits) {
            if ($credit_type === "queries") {
                $stats["overLimit"] = $stats["queries"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["queriesLimit"] > 0
                        ? round(
                            ($stats["queries"] / $stats["queriesLimit"]) * 100,
                            2
                        )
                        : 0;
            } elseif ($credit_type === "units") {
                $stats["overLimit"] = $stats["units"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["unitsLimit"] > 0
                        ? round(
                            ($stats["units"] / $stats["unitsLimit"]) * 100,
                            2
                        )
                        : 0;
            } elseif ($credit_type === "price") {
                $stats["overLimit"] = $stats["price"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["priceLimit"] > 0
                        ? round(
                            ($stats["price"] / $stats["priceLimit"]) * 100,
                            2
                        )
                        : 0;
            }
        }
        return $stats;
    }

    function query_tts(
        $timeFrame = null,
        $isAbsolute = null,
        $credits = null,
        $credit_type = null,
        $userId = null,
        $ipAddress = null,
        $apiRef = null
    ) {
        if ($apiRef === null) {
            $apiRef = $this->apiRef;
        }
        $target = "guests";
        if ($userId === null && $ipAddress === null) {
            $userId = $this->getUserId();
            if ($userId) {
                $target = "users";
            } else {
                $ipAddress = $this->getUserIpAddress();
                if ($ipAddress === null) {
                    aiomatic_log_to_file(
                        "There should be an userId or an ipAddress."
                    );
                    return null;
                }
            }
        }
        $aiomatic_Limit_Settings = get_option("aiomatic_Limit_Settings", false);
        if ($target == "guests") {
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credits_text"]) &&
                    $aiomatic_Limit_Settings["guest_credits_text"] != ""
                ) {
                    $hasLimits = true;
                } else {
                    $hasLimits = false;
                }
            } else {
                $hasLimits = true;
            }
            if ($timeFrame === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_time_frame_text"]) &&
                    $aiomatic_Limit_Settings["guest_time_frame_text"] != ""
                ) {
                    $timeFrame = $aiomatic_Limit_Settings["guest_time_frame_text"];
                } else {
                    $timeFrame = "day";
                }
            }
            if ($isAbsolute === null) {
                if (
                    isset($aiomatic_Limit_Settings["is_absolute_guest_text"]) &&
                    $aiomatic_Limit_Settings["is_absolute_guest_text"] == "on"
                ) {
                    $isAbsolute = true;
                } else {
                    $isAbsolute = false;
                }
            }
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credits_text"]) &&
                    $aiomatic_Limit_Settings["guest_credits_text"] != ""
                ) {
                    $credits = $aiomatic_Limit_Settings["guest_credits_text"];
                } else {
                    $credits = "";
                }
            }
            if ($credit_type === null) {
                if (
                    isset($aiomatic_Limit_Settings["guest_credit_type_text"]) &&
                    $aiomatic_Limit_Settings["guest_credit_type_text"] != ""
                ) {
                    $credit_type =
                        $aiomatic_Limit_Settings["guest_credit_type_text"];
                } else {
                    $credit_type = "characters";
                }
            }
        } else {
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credits_text"]) &&
                    $aiomatic_Limit_Settings["user_credits_text"] != ""
                ) {
                    $hasLimits = true;
                } else {
                    $hasLimits = false;
                }
            } else {
                $hasLimits = true;
            }
            if ($timeFrame === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_time_frame_text"]) &&
                    $aiomatic_Limit_Settings["user_time_frame_text"] != ""
                ) {
                    $timeFrame = $aiomatic_Limit_Settings["user_time_frame_text"];
                } else {
                    $timeFrame = "day";
                }
            }
            if ($isAbsolute === null) {
                if (
                    isset($aiomatic_Limit_Settings["is_absolute_user_text"]) &&
                    $aiomatic_Limit_Settings["is_absolute_user_text"] == "on"
                ) {
                    $isAbsolute = true;
                } else {
                    $isAbsolute = false;
                }
            }
            if ($credits === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credits_text"]) &&
                    $aiomatic_Limit_Settings["user_credits_text"] != ""
                ) {
                    $credits = $aiomatic_Limit_Settings["user_credits_text"];
                } else {
                    $credits = "";
                }
            }
            if ($credit_type === null) {
                if (
                    isset($aiomatic_Limit_Settings["user_credit_type_text"]) &&
                    $aiomatic_Limit_Settings["user_credit_type_text"] != ""
                ) {
                    $credit_type = $aiomatic_Limit_Settings["user_credit_type_text"];
                } else {
                    $credit_type = "characters";
                }
            }
        }
        if (
            $timeFrame !== "day" &&
            $timeFrame !== "week" &&
            $timeFrame !== "month" &&
            $timeFrame !== "year"
        ) {
            aiomatic_log_to_file(
                "TimeFrame should be day, week, month, or year."
            );
            return null;
        }

        $this->check_db();
        $prefix = esc_sql($this->wpdb->prefix);
        $sql = "SELECT COUNT(*) AS queries, SUM(units) AS units, SUM(price) AS price FROM {$prefix}aiomatic_logs WHERE ";

        if ($target === "users") {
            $sql .= "userId = " . esc_sql($userId) . "";
        } else {
            $sql .= "ip = '" . esc_sql($ipAddress) . "'";
        }

        if ($apiRef) {
            $sql .= " AND apiRef = '" . esc_sql($apiRef) . "'";
        }
        $sql .= " AND mode = 'text-to-speech'";
        if ($timeFrame === "day") {
            if ($isAbsolute) {
                $sql .= " AND DAY(time) = DAY(CURRENT_DATE())";
            } else {
                $sql .= " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
            }
        } elseif ($timeFrame === "week") {
            if ($isAbsolute) {
                $sql .= " AND WEEK(time) = WEEK(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK)";
            }
        } elseif ($timeFrame === "month") {
            if ($isAbsolute) {
                $sql .= " AND MONTH(time) = MONTH(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)";
            }
        } elseif ($timeFrame === "year") {
            if ($isAbsolute) {
                $sql .= " AND YEAR(time) = YEAR(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR)";
            }
        }

        $results = $this->wpdb->get_results($sql);
        if (count($results) === 0) {
            return null;
        }
        $result = $results[0];
        $stats = [];
        $stats["userId"] = $userId;
        $stats["ipAddress"] = $ipAddress;
        $stats["queries"] = intVal($result->queries);
        $stats["units"] = intVal($result->units);
        $stats["price"] = round(floatVal($result->price), 2);

        $stats["queriesLimit"] = intVal(
            $hasLimits && $credit_type === "queries" ? $credits : 0
        );
        $stats["unitsLimit"] = intVal(
            $hasLimits && $credit_type === "characters" ? $credits : 0
        );
        $stats["priceLimit"] = floatVal(
            $hasLimits && $credit_type === "price" ? $credits : 0
        );

        $credits = apply_filters("aiomatic_stats_credits", $credits, $userId);
        $stats["overLimit"] = false;
        if ($hasLimits) {
            if ($credit_type === "queries") {
                $stats["overLimit"] = $stats["queries"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["queriesLimit"] > 0
                        ? round(
                            ($stats["queries"] / $stats["queriesLimit"]) * 100,
                            2
                        )
                        : 0;
            } elseif ($credit_type === "characters") {
                $stats["overLimit"] = $stats["units"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["unitsLimit"] > 0
                        ? round(
                            ($stats["units"] / $stats["unitsLimit"]) * 100,
                            2
                        )
                        : 0;
            } elseif ($credit_type === "price") {
                $stats["overLimit"] = $stats["price"] >= $credits;
                $stats["usagePercentage"] =
                    $stats["priceLimit"] > 0
                        ? round(
                            ($stats["price"] / $stats["priceLimit"]) * 100,
                            2
                        )
                        : 0;
            }
        }
        return $stats;
    }

    public function deleteUsageEntries(
        $timeFrame = null,
        $isAbsolute = null,
        $userId = null,
        $ipAddress = null,
        $apiRef = null
    ) {
        if ($apiRef === null) {
            $apiRef = $this->apiRef;
        }
        $target = "guests";
        if ($userId) {
            $target = "users";
        }
        if ($userId === null && $ipAddress === null) {
            $userId = $this->getUserId();
            if ($userId) {
                $target = "users";
            } else {
                $ipAddress = $this->getUserIpAddress();
                if ($ipAddress === null) {
                    aiomatic_log_to_file(
                        "There should be an userId or an ipAddress."
                    );
                    return null;
                }
            }
        }
        if (
            $timeFrame !== "day" &&
            $timeFrame !== "week" &&
            $timeFrame !== "month" &&
            $timeFrame !== "year" &&
            $timeFrame !== "all"
        ) {
            aiomatic_log_to_file(
                "TimeFrame should be day, week, month, year or all."
            );
            return null;
        }
        $this->check_db();
        $prefix = esc_sql($this->wpdb->prefix);
        $sql = "DELETE FROM {$prefix}aiomatic_logs WHERE ";
        if ($target === "users") {
            $sql .= "userId = " . esc_sql($userId) . "";
        } else {
            $sql .= "ip = '" . esc_sql($ipAddress) . "'";
        }
        if ($apiRef) {
            $sql .= " AND apiRef = '" . esc_sql($apiRef) . "'";
        }
        if ($timeFrame === "day") {
            if ($isAbsolute) {
                $sql .= " AND DAY(time) = DAY(CURRENT_DATE())";
            } else {
                $sql .= " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)";
            }
        } elseif ($timeFrame === "week") {
            if ($isAbsolute) {
                $sql .= " AND WEEK(time) = WEEK(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 WEEK)";
            }
        } elseif ($timeFrame === "month") {
            if ($isAbsolute) {
                $sql .= " AND MONTH(time) = MONTH(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)";
            }
        } elseif ($timeFrame === "year") {
            if ($isAbsolute) {
                $sql .= " AND YEAR(time) = YEAR(CURRENT_DATE())";
            } else {
                $sql .=
                    " AND time >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR)";
            }
        }
        $result = $this->wpdb->query($sql);
        if ($result === false) {
            aiomatic_log_to_file("Error deleting usage entries.");
            return false;
        }
        return true;
    }

    function shortcode_current($atts)
    {
        $aiomatic_Limit_Settings = get_option('aiomatic_Limit_Settings', false);
        if (
            isset($aiomatic_Limit_Settings["enable_limits"]) &&
            trim($aiomatic_Limit_Settings["enable_limits"]) == "on"
        ) 
        {
          $display = isset($atts["display"]) ? $atts["display"] : "usage";
          $stats = $this->query();
          if ($display === "usage") {
              $name = md5(get_bloginfo());
              wp_register_style(
                  $name . "-stats-style",
                  plugins_url("../styles/stats-chatgpt.css", __FILE__),
                  false,
                  AIOMATIC_MAJOR_VERSION
              );
              wp_enqueue_style($name . "-stats-style");
              $percent = isset($stats["usagePercentage"])
                  ? $stats["usagePercentage"]
                  : 0;
              $cssPercent = $percent > 100 ? 100 : $percent;
              $output =
                  '<div class="aiomatic-statistics aiomatic-statistics-usage">';
              $output .= '<div class="aiomatic-statistics-bar-container">';
              $output .=
                  '<div class="aiomatic-statistics-bar" style="width: ' .
                  $cssPercent .
                  '%;"></div>';
              $output .= "</div>";
              $output .=
                  '<div class="aiomatic-statistics-bar-text">' .
                  $percent .
                  "%</div>";
              $output .= "</div>";
              return $output;
          } elseif ($display === "details") {
              if ($stats === null) {
                  return "No stats available.";
              }
              $output =
                  '<div class="aiomatic-statistics aiomatic-statistics-debug">';
              if (!empty($stats["ipAddress"])) {
                  $output .= "IP Address: {$stats["ipAddress"]}<br>";
              }
              $output .=
                  "Queries: {$stats["queries"]}" .
                  (!empty($stats["queriesLimit"])
                      ? " / {$stats["queriesLimit"]}"
                      : "") .
                  "<br>";
              $output .=
                  "Tokens (Units): {$stats["units"]}" .
                  (!empty($stats["unitsLimit"])
                      ? " / {$stats["unitsLimit"]}"
                      : "") .
                  "<br>";
              $output .=
                  "Dollars (Price): {$stats["price"]}" .
                  (!empty($stats["priceLimit"])
                      ? " / {$stats["priceLimit"]}"
                      : "") .
                  "<br>";
              if (isset($stats["usagePercentage"])) {
                  $output .= "Usage: {$stats["usagePercentage"]}%" . "<br>";
                  $output .=
                      "Status: " . ($stats["overLimit"] ? "OVER LIMIT" : "OK");
              }
              $output .= "</div>";
              return $output;
          }
        }
    }

    function validate_data($data)
    {
        // env: Could be "textwriter", "chatbot", "imagesbot", or anything else
        $data["time"] = date("Y-m-d H:i:s");
        $data["userId"] = $this->getUserId($data);
        $data["session"] = isset($data["session"])
            ? (string) $data["session"]
            : null;
        $data["ip"] = $this->getUserIpAddress($data);
        $data["model"] = isset($data["model"]) ? (string) $data["model"] : null;
        $data["assistant_id"] = isset($data["assistant_id"]) ? (string) $data["assistant_id"] : null;
        $data["mode"] = isset($data["mode"]) ? (string) $data["mode"] : null;
        $data["units"] = isset($data["units"]) ? intval($data["units"]) : 0;
        $data["type"] = isset($data["type"]) ? (string) $data["type"] : null;
        $data["price"] = isset($data["price"]) ? floatval($data["price"]) : 0;
        $data["env"] = isset($data["env"]) ? (string) $data["env"] : null;
        $data["apiRef"] = isset($data["apiRef"])
            ? (string) $data["apiRef"]
            : null;
        $data["tags"] = $this->buildTagsForDb(
            isset($data["tags"]) ? $data["tags"] : null
        );
        return $data;
    }

    function add($data)
    {
        $this->check_db();
        $data = $this->validate_data($data);
        $dbrez = $this->wpdb->insert($this->table_logs, $data);
        if ($dbrez === false) {
            aiomatic_log_to_file(
                "Failed to save statistics data: " . $this->wpdb->last_error
            );
        }
    }

    function check_db()
    {
        if ($this->db_check) {
            return true;
        }
        $this->db_check = !(
            strtolower(
                $this->wpdb->get_var("SHOW TABLES LIKE '$this->table_logs'")
            ) != strtolower($this->table_logs)
        );
        if (!$this->db_check) {
            $this->create_db();
            $this->db_check = !(
                strtolower(
                    $this->wpdb->get_var("SHOW TABLES LIKE '$this->table_logs'")
                ) != strtolower($this->table_logs)
            );
        }
        if (!$this->wpdb->get_var("SHOW COLUMNS FROM `{$this->table_logs}` LIKE 'assistant_id'")) {
            $this->wpdb->query("ALTER TABLE `{$this->table_logs}` ADD `assistant_id` VARCHAR(256) NULL");
        }
        $this->db_check =
            $this->db_check &&
            $this->wpdb->get_var(
                "SHOW COLUMNS FROM $this->table_logs LIKE 'apiRef'"
            );
        if (!$this->db_check) {
            $this->wpdb->query(
                "ALTER TABLE $this->table_logs ADD COLUMN apiRef VARCHAR(128) NULL"
            );
            $this->wpdb->query(
                "UPDATE $this->table_logs SET apiRef = '$this->apiRef'"
            );
            $this->db_check = true;
        }

        return $this->db_check;
    }

    function create_db()
    {
        $charset_collate = $this->wpdb->get_charset_collate();

        $sqlLogs = "CREATE TABLE $this->table_logs (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        userId BIGINT(20) NULL,
        ip VARCHAR(64) NULL,
        session VARCHAR(64) NULL,
        model VARCHAR(256) NULL,
        assistant_id VARCHAR(256) NULL,
        mode VARCHAR(128) NULL,
        units INT(11) NOT NULL DEFAULT 0,
        type VARCHAR(64) NULL,
        price FLOAT NOT NULL DEFAULT 0,
        env VARCHAR(64) NULL,
        tags VARCHAR(128) NULL,
        apiRef VARCHAR(128) NULL,
        time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

        $sqlLogMeta = "CREATE TABLE $this->table_logmeta (
        meta_id BIGINT(20) NOT NULL AUTO_INCREMENT,
        log_id BIGINT(20) NOT NULL,
        meta_key varchar(255) NULL,
        meta_value longtext NULL,
        PRIMARY KEY  (meta_id)
      ) $charset_collate;";

        require_once ABSPATH . "wp-admin/includes/upgrade.php";
        dbDelta($sqlLogs);
        dbDelta($sqlLogMeta);
    }

    function remove_db()
    {
        $sql = "DROP TABLE IF EXISTS $this->table_logs, $this->table_logmeta;";
        $this->wpdb->query($sql);
    }
    function clear_db()
    {
        $sql = "TRUNCATE TABLE $this->table_logs;";
        $this->wpdb->query($sql);
        $sql = "TRUNCATE TABLE $this->table_logmeta;";
        $this->wpdb->query($sql);
    }
    public function logs_query(
        $logs = [],
        $offset = 0,
        $limit = null,
        $filters = null,
        $sort = null
    ) {
        $offset = !empty($offset) ? intval($offset) : 0;
        $limit = !empty($limit) ? intval($limit) : 100;
        $filters = !empty($filters) ? $filters : [];
        $sort = !empty($sort) ? $sort : ["accessor" => "time", "by" => "desc"];
        $query = "SELECT * FROM $this->table_logs";
        $where = [];
        if (isset($filters["apiRef"])) {
            $where[] = "apiRef = '" . esc_sql($filters["apiRef"]) . "'";
        }
        if (isset($filters["userId"])) {
            $where[] = "userId = '" . intval($filters["userId"]) . "'";
        }
        if (isset($filters["ip"])) {
            $where[] = "ip = '" . esc_sql($filters["ip"]) . "'";
        }
        if (isset($filters["session"])) {
            $where[] = "session = '" . esc_sql($filters["session"]) . "'";
        }
        if (isset($filters["model"])) {
            $where[] = "model = '" . esc_sql($filters["model"]) . "'";
        }
        if (isset($filters["assistant_id"])) {
            $where[] = "assistant_id = '" . esc_sql($filters["assistant_id"]) . "'";
        }
        if (isset($filters["mode"])) {
            $where[] = "mode = '" . esc_sql($filters["mode"]) . "'";
        }
        if (isset($filters["type"])) {
            $where[] = "type = '" . esc_sql($filters["type"]) . "'";
        }
        if (isset($filters["env"])) {
            $where[] = "env = '" . esc_sql($filters["env"]) . "'";
        }
        if (isset($filters["tags"])) {
            $where[] = "tags LIKE '%" . esc_sql($filters["tags"]) . "%'";
        }
        if (isset($filters["from"])) {
            $where[] = "time >= '" . esc_sql($filters["from"]) . "'";
        }
        if (isset($filters["to"])) {
            $where[] = "time <= '" . esc_sql($filters["to"]) . "'";
        }
        if (count($where) > 0) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $logs["total"] = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM ($query) AS t"
        );

        if(isset($sort["accessor"]) && isset($sort["by"]))
        {
            $query .=
            " ORDER BY " .
            esc_sql($sort["accessor"]) .
            " " .
            esc_sql($sort["by"]);
        }
        else
        {
            $query .=
            " ORDER BY time desc";
        }
        if ($limit > 0) {
            $query .= " LIMIT $offset, $limit";
        }
        $logs["rows"] = $this->wpdb->get_results($query, ARRAY_A);
        return $logs;
    }
}
?>
