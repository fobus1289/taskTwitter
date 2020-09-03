<?php

namespace crutch;

class JwtAuth
{
   
    private const  Type   = "JWT";
    public  const  SHA256 = "SHA256";
    public  const  SHA512 = "SHA512";
       
    private function valid($token,$secret,$expValid = true)
    {
        
        if(! ($data = $this->parseToken($token))) {
            validation_error('400', ['message' => 'Invalid Argument']);
        }

        $header = @\json_decode(@\base64_decode($data[0]),true);
        $payload = @\json_decode(@\base64_decode($data[1]),true);

        $hash = @\hash_hmac($header['alg'],$data[0].$data[1], $secret);

        if (! @\hash_equals($hash, $data[2])) {
            validation_error('500', ['message' => 'Invalid Signature']);
        }
 
        if($expValid && $payload['exp'] <= time()) {  
            validation_error('401', ['message' => 'Token Expired']);
        }

        return [
            'header' => $header,
            'payload' => $payload
        ];      
    }

    /**
     * @param string $token
     * @param string $secret
     * @return array
     */
    public function decode($token = null,$secret = null,$expVlid = true) 
    {   
        AuthMan::$data = $this->valid($token ?? jwt_config('token'), $secret ?? jwt_config('secret'),$expVlid);
        return AuthMan::$data;
    }

    private function parseToken($token) 
    {

        $token = @\explode('.', $token);

        if(@\count($token) !== 3) {
           return false; 
        }

        return $token;
    }

    public function refresh($token = null,$secret = null)
    {

        $token  = $token ?? jwt_config('token');
        $secret = $secret ?? jwt_config('secret');
        $sin = $this->valid($token, $secret, false);
        
        $exp = $sin['payload']['refresh_expired'];

        if($exp > time() + day_unix(3)) {
            validation_error('400', ['message' => 'token refresh time has passed']);
        }
        
        $credentials = \app\models\User::credentials();
        $primary = $credentials['primary'];
        $id = $sin['payload'][$primary];
        $user = \app\models\User::findOne([$primary => $id]);
        
        if($user == null) {
            validation_error('404', ['message' => 'User not found']);
        }
        
        return $this->encode($user->fields());
    }

    /**
     * @param array $payload
     * @param string $secret
     * @param string $alg
     * @return string
     */
    public function encode($payload,$secret = null,$alg = self::SHA256)
    {

        $header = [
            'alg' => $alg,
            'typ' => self::Type
        ];

        $header = @\json_encode($header);

        $payload['exp'] = \time() + 60 * jwt_config('token_expired');

        $payload['refresh_expired'] = \time() + jwt_config('refresh_expired');
        
        $payload = @\json_encode($payload);
        
        return $this->genearteHash($header,$payload,$secret ?? jwt_config('secret'),$alg);
    }
    
    private function genearteHash($header, $payload, $secret , $alg)
    {

        $h = @\base64_encode($header);
        $p=  @\base64_encode($payload);
        $signature = @\hash_hmac($alg,$h.$p,$secret);

        return "$h.$p.$signature";
    }

}
