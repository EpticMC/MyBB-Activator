<?php

/**
 * Copyright (c) 2018
 * The EpticMC Project
 */

if (!defined("IN_MYBB")) die("Direct initialization prohibited. IN_MYBB is not defined.");

function activate_info(){
    return array(
        "name"              => "EpticMC Activator",
        "description"       => "Activate MC Users",
        "website"           => "https://nulldev.org",
        "author"            => "NulLDev",
        "authorsite"        => "https://nulldev.org",
        "version"           => "1.1",
        "codename"          => "activate",
        "compatibility"     => "18*"
    );
}

function activate_activate(){ global $db, $cache; }
function activate_deactivate(){ global $db, $cache; }

function activate_run($profile){
    global $db, $cache;
    $user_ids = implode(", ", $profile);
    if (empty($user_ids)) die("No user selcted");
    $query = $db->simple_select("users", "uid, username, email, usergroup, coppauser", "uid IN ({$user_ids})");
    while ($user = $db->fetch_array($query)){
        if($user['coppauser']) $updated_user = array("coppauser" => 0);
        else $db->delete_query("awaitingactivation", "uid='{$user['uid']}'");
        if ($user['usergroup'] == 5) $updated_user['usergroup'] = 2;
        $db->update_query("users", $updated_user, "uid='{$user['uid']}'");
    }
    $cache->update_awaitingactivation();
}

//activate_run(["1", "2"]);
