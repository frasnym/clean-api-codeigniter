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
    function getResponseApi($error_number, $lang, $user, $sys_date, $key, $val)
    {
        # Array Key
        $arrKey = [];
        array_push($arrKey, 'errNumber');
        array_push($arrKey, 'userApp');
        foreach ($key as $key) {
            array_push($arrKey, $key);
        }
        array_push($arrKey, 'respTime');
        array_push($arrKey, 'respMessage');

        # Convert Mobile Phone
        if ($user[0] == '0' || $user[1] == '8') {
            $this->CI->load->library('common_lib');
            $user = $this->CI->common_lib->replace_mobile_phone($user);
        }

        # Array Value
        $arrVal = [];
        array_push($arrVal, $error_number);
        array_push($arrVal, $user);
        foreach ($val as $val) {
            array_push($arrVal, $val);
        }
        array_push($arrVal, $sys_date);
        array_push($arrVal, $this->notification_msg[$error_number]);

        $message = array_combine($arrKey, $arrVal);

        return $message;
    }
}
