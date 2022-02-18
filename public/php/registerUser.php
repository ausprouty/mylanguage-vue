<?php
function registerUser($p){
    $out = array();
    $out['debug'] = 'Register User' ."\n";
    //are you authorized to register someone
    if (isset($p['authorizer'])){
        $sql = "SELECT  * FROM users WHERE uid = :uid LIMIT 1";
        $data = array(
            'uid' =>  $p['authorizer']
        );
        $check = sqlReturnObjectOne($sql, $data);
        if ($check->scope == 'team' OR $check->scope == 'global'){
            // is this email in use
            $sql = "SELECT uid FROM users WHERE email = :email LIMIT 1";
            $data = array(
                'email' => $p['email'] 
            );
            $content = sqlReturnObjectOne($sql, $data);
            if (!$content){
                $hash = password_hash($p['password'], PASSWORD_DEFAULT);
                $sql = "INSERT INTO users ( team, firstname, lastname, email, password, date_started) VALUES
                    ( :team, :firstname, :lastname, :email, :password, :date_started)";
                $data = array(
                    'team' => $check->team,
                    'firstname' =>  $p['firstname'], 
                    'lastname' => $p['lastname'], 
                    'email' =>$p['email'], 
                    'password' => $hash , 
                    'date_started' => time()
                );
                sqlSafe($sql, $data);
                $out['content'] = 'registered';
                $out['error'] = false;
            }
            else{
                $out['message'] = "Username already in use";
                $out['error'] = true;
            }
        }
        else{
            $out['message'] = "Not Authorized to add Editors";
            $out['error'] = true;

        }
    }
    else{
        $out['message'] = "Not Registered";
        $out['error'] = true;
    }
    return $out;
}
