
<?php
use ReallySimpleJWT\Token;
// see https://codewithawa.com/posts/password-reset-system-in-php
function retrievePassword($params){
    $out = array();
    $out['debug'] = "I was in retrievePassword\n";
    $sql = 'SELECT * FROM users WHERE email = :email';
	$data = array(
		'email' => $params['email']
	);
    $user = sqlReturnObjectOne($sql, $data);
    if ($user->email){
        $to = $user->email;
        $subject = "Reset Password";
        $txt = "Here is a link to reset your CELEBRATE password.  This link is only valid for two hours and can only be used once.";
        //create token
        $expiration = time() + (2 * 60 * 60);
        $issuer = 'celebrate.myfriends.network';

        $token = Token::create($user->uid, $params['secret'], $expiration, $issuer);
        // create link
        $link = URL .'/reset/' . $token;
        // update retrieve database
        $sql = 'INSERT INTO  reset_links  (uid, token) VALUES (:uid, :token)';
        $data = array(
            'uid' => $user->uid,
            'token' => $token
        );
        sqlSafe($sql, $data);
        $sql = 'SELECT id FROM  reset_links
            WHERE uid = :uid AND
            token = :token AND
            used IS NULL LIMIT 1';
        $data = array(
            'uid' => $user->uid,
            'token' => $token
        );
        $reset = sqlReturnObjectOne($sql, $data);
        // finish link
        $link .= '/'. $reset->id;
        $txt .=  $link;
        $headers = "From: webmaster@myfriends.network" . "\r\n" .
        "CC: bob@hereslife.com";
        mail($to,$subject,$txt,$headers);
    }
    else{
        $out['debug'] .= "No valid email\n";
    }

    return $out;
}