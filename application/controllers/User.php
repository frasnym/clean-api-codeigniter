<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class User extends RestController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Hello
	 * --------------------------
	 * @param: name
	 * --------------------------
	 * @method : POST
	 * @link : User/hello
	 */
	public function hello_post()
	{
		# XSS Filtering : https://www.codeigniter.com/user_guide/libraries/security.html
		$data = $this->security->xss_clean($_POST);

		# Variable Declaration
		$lang = $this->common_lib->default_language();
		$this->common_lib->default_timezone();
		$sys_date = date("Y-m-d H:i:s");
		$user_app = "Unknown";
		$whatError = array();
		$outputKey = array();
		$outputVal = array();

		$user_input = array(
			'name' => "",
		);
		$check_input_param = 0;

		if (isset($data['name'])) $user_input["name"] = strtoupper($data['name']);

		# Variable Validation
		foreach ($user_input as $key => $value) {
			if ($value == "") {
				array_push($whatError, $key);
				$check_input_param = 1;
			}
		}

		# Variable Validation
		if ($check_input_param == 1) {
			array_push($outputKey, "error_helper");
			array_push($outputVal, $whatError);

			$resp_msg_code = '1';
			$resp_status = 200;
		} else {
			array_push($outputKey, "data");
			array_push($outputVal, "Hello " . $user_input["name"]);

			$resp_msg_code = '0';
			$resp_status = 200;
		}
		$output = $this->resthelper->getResponseApi($resp_msg_code, $resp_status, $lang, $user_app, $sys_date, $outputKey, $outputVal);
		$this->response($output, $resp_status);
	}
}
