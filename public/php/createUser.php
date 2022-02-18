<?php
function createUser($p){
    $out= [];
    $hash = password_hash($p['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (firstname, lastname, email, password, date_started) VALUES
        ( :firstname, :lastname, :email, :password, :date_started)";
    $data = array(
        'firstname' =>  $p['firstname'],
        'lastname' => $p['lastname'],
        'email' =>  $p['email'],
        'password' => $hash ,
        'date_started' => time()
    );
    sqlSafe($sql, $data);
    return $out;
}
