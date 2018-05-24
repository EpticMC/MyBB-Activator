<?php

/**
 * Copyright (c) 2018
 * The EpticMC Project
 */

if (!defined("IN_MYBB")) die("Direct initialization prohibited. IN_MYBB is not defined.");

$plugins->add_hook("misc_start", "handle_hook");

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

function activate_activate(){   global $db, $cache; }
function activate_deactivate(){ global $db, $cache; }
function activate_run(){        global $db, $cache; }

function handle_hook(){
    global $mybb, $db, $plugins;    

    if ($mybb->input["action"] != "activateuser") return;

    if (empty($mybb->input["acode"])) die("No code provided");

    $regCode = $mybb->get_input("acode", MyBB::INPUT_STRING);

    $userIDRow = $db->simple_select("awaitingactivation", "uid", "code='" . $regCode . "'");
    $idRow = mysqli_fetch_assoc($userIDRow);
    $userID = $idRow["uid"];

    profile_activation($userID);
}

function profile_activation($user_id){
    global $db, $cache;

    //OLD: Pass $profile as array of UID's
    //$user_ids = implode(", ", $profile);

    //NEW: Pass $user_id as one UID at a time

    if (empty($user_id)) die("No user selcted");

    $query = $db->simple_select("users", "uid, username, email, usergroup, coppauser", "uid='" . $user_id . "'");

    while ($user = $db->fetch_array($query)){
        if ($user["coppauser"]) $updated_user = array("coppauser" => 0);
        else $db->delete_query("awaitingactivation", "uid='" . $user["uid"] . "'");

        if ($user["usergroup"] == 5) $updated_user["usergroup"] = 2;
        $db->update_query("users", $updated_user, "uid='" . $user["uid"] . "'");
    }

    $cache->update_awaitingactivation();
}
