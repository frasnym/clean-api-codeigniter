<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'third_party/RestController.php';

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
	 * --------------------------
	 * @method : GET
	 * @link : User/hello
	 */
	public function hello_get()
	{
		# XSS Filtering : https://www.codeigniter.com/user_guide/libraries/security.html
		$data = $this->security->xss_clean($_POST);

		# Variable Declaration
		$FrasFunc = new FRASFUNC();
		$lang = $FrasFunc->default_language();
		$FrasFunc->default_timezone();
		$sys_date = date("Y-m-d H:i:s");
		$user_app = "Unknown";
		$whatError = array();
		$outputKey = array();
		$outputVal = array();

		$tokenData = 'Hello World!';

		# Create a token
		$token = AUTHORIZATION::generateToken($tokenData);
		# Set HTTP status code
		array_push($outputKey, "token");
		array_push($outputVal, $token);

		$resp_msg_code = '0';
		$resp_status = 200;

		$output = $this->resthelper->getResponseApi($resp_msg_code, $resp_status, $lang, $user_app, $sys_date, $outputKey, $outputVal);
		$this->response($output, $resp_status);
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
		$FrasFunc = new FRASFUNC();
		$lang = $FrasFunc->default_language();
		$FrasFunc->default_timezone();
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

	/**
	 * Jwt Auth
	 * --------------------------
	 * @param: name
	 * --------------------------
	 * @method : POST
	 * @link : User/jwt_auth
	 */
	public function jwt_auth_post()
	{
		# XSS Filtering : https://www.codeigniter.com/user_guide/libraries/security.html
		$data = $this->security->xss_clean($_POST);

		# Variable Declaration
		$FrasFunc = new FRASFUNC();
		$lang = $FrasFunc->default_language();
		$FrasFunc->default_timezone();
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
			# Create a token
			$token = AUTHORIZATION::generateToken($user_input["name"]);
			# Set HTTP status code
			array_push($outputKey, "token");
			array_push($outputVal, $token);

			$resp_msg_code = '0';
			$resp_status = 200;
		}
		$output = $this->resthelper->getResponseApi($resp_msg_code, $resp_status, $lang, $user_app, $sys_date, $outputKey, $outputVal);
		$this->response($output, $resp_status);
	}

	/**
	 * Verify Auth
	 * --------------------------
	 * @param: name
	 * --------------------------
	 * @method : POST
	 * @link : User/verify_auth
	 */
	public function verify_auth_post()
	{
		# JWT Verification
		$this->verify_request();

		# XSS Filtering : https://www.codeigniter.com/user_guide/libraries/security.html
		$data = $this->security->xss_clean($_POST);

		# Variable Declaration
		$FrasFunc = new FRASFUNC();
		$lang = $FrasFunc->default_language();
		$FrasFunc->default_timezone();
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

	private function verify_request()
	{
		# Get all the headers
		$headers = $this->input->request_headers();
		# Extract the token
		$token = "";
		if (isset($headers['Authorization'])) $token = $headers['Authorization'];
		# Use try-catch
		# JWT library throws exception if the token is not valid
		try {
			# Validate the token
			# Successfull validation will return the decoded user data else returns false
			$data = AUTHORIZATION::validateToken($token);
			if ($data === false) {
				$status = 401;
				$response = ['status' => $status, 'msg' => 'Unauthorized Access!'];
				$this->response($response, $status);
				exit();
			} else {
				return $data;
			}
		} catch (Exception $e) {
			# Token is invalid
			# Send the unathorized access message
			$status = 401;
			$response = ['status' => $status, 'msg' => 'Unauthorized Access! '];
			$this->response($response, $status);
		}
	}
}
