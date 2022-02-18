<?php
/* This is called by a person who wants to join a team.
   They may be an existing user, from another team
   or they may have never fjoined a team
*/
include_once('findUserUid.php');
include_once('findTeamTid.php');
include_once('createUser.php');
include_once('addMemberToTeam.php');

function register($p){
    $out = array();
    $out['debug'] = 'Register' ."\n";
    $tid= findTeamTid($p);
    if (!$tid){
       $out['message'] = 'Team key is not valid';
       return;
    }
    // find or create user
    $uid= findUserUid($p);
    if (!$uid){
       $resp= createUser($p);
       $uid = findUserUid($p);
    }
    addMemberToTeam($uid, $tid);
    $out = myLogin($p);
    $out['content']['tid']= $tid;
    return $out;
}
