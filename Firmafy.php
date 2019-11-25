<?php
class firmafy{
    private $_data;
    private $_target;
    private $_user;
    private $_password;
    private $_mkey;
    private $_token;
    function __construct()
    {
        $this -> _target = 'https://app.firmafy.com/ApplicationProgrammingInterface.php';
        $this -> _user = 'USUARIO app.firmafy.com';
        $this -> _password = 'CLAVE app.firmafy.com';
        $this -> _mkey   = 'client.mkey';
        $this -> _token  = $this -> auth();
    }
    public function setData($data)
    {
        $this -> _data = $data;
        return $this;
    }

    private function auth()
    {
        if ($this -> _token == '') {
            if (file_exists($this -> _mkey) && $this -> checkTimeKey()) {
                return file_get_contents($this -> _mkey);
            } else {
                return $this -> getToken();
            }
        }
    }

    private function getToken()
    {
        $this -> _data = array(
            'action' => 'login',
            'usuario' => $this -> _user,
            'password' => $this -> _password
        );
        $token = $this -> send();
        $token = json_decode($token);
        if (!$token -> error) {
            
            file_put_contents($this -> _mkey, $token -> data);
            return $token -> data;
        }
    }

    private function checkTimeKey()
    {
        $now  = time();
        if (is_file($this -> _mkey)) {
            if ($now - filemtime($this -> _mkey) >= 60 * 60 * 1 ) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function send()
    {
        $target_url = $this -> _target;
        $post = $this -> _data;
        $post['token'] = $this -> _token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

}
?>
