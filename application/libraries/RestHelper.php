<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RestHelper
{
    var $notification_msg = array(
        '0' => 'Success',
        '1' => 'Incomplete Parameter',
    );

    public function __construct()
    {
        $this->CI = &get_instance();
    }
    function getResponseApi($resp_msg_code, $resp_status, $lang, $user, $sys_date, $key, $val)
    {
        # Array Key
        $arrKey = [];
        array_push($arrKey, 'code');
        array_push($arrKey, 'status');
        array_push($arrKey, 'user_app');
        foreach ($key as $key) {
            array_push($arrKey, $key);
        }
        array_push($arrKey, 'sys_date');
        array_push($arrKey, 'message');

        # Convert Mobile Phone
        if ($user[0] == '0' || $user[1] == '8') {
            $this->CI->load->library('common_lib');
            $user = $this->CI->common_lib->replace_mobile_phone($user);
        }

        # Array Value
        $arrVal = [];
        array_push($arrVal, $resp_msg_code);
        array_push($arrVal, $resp_status);
        array_push($arrVal, $user);
        foreach ($val as $val) {
            array_push($arrVal, $val);
        }
        array_push($arrVal, $sys_date);
        array_push($arrVal, $this->notification_msg[$resp_msg_code]);

        $message = array_combine($arrKey, $arrVal);

        return $message;
    }
}
