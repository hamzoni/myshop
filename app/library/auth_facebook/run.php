<?php
//Include FB config file && User class
require_once 'assets/facebook.php';
class cf_fbA {
	public $appId;
	public $appSecret;
	public $redirectURL;
	public $fbPermissions;
	public function __construct() {
		$this->appId = '1766792506971778'; 
		$this->appSecret = '55080333f76f4ab25eea1ac3bc981b62';
		$this->redirectURL = "http://".$_SERVER['SERVER_NAME'].BASE_URL."fb_login/"; 
		$this->fbPermissions = 'email';  
	}
}
class init {
	public $set_url;
	public $fb_user;
	public $facebook;
	function __construct($user) {
		$config = new cf_fbA;
		$this->facebook = new Facebook(['appId'  => $config->appId,'secret' => $config->appSecret]);
		$this->fb_user = $this->facebook->getUser();
		if(!$this->fb_user){
			$this->fb_user = NULL;
			$this->set_url = [
				"label" => "Log in",
				"href"  => $this->facebook->getLoginUrl([
					'redirect_uri'=>$config->redirectURL,
					'scope'=>$config->fbPermissions
				])
			];
		} else {
			$user_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');
			$user_data = array(
				'oauth_provider'=> 'facebook',
				'oauth_uid' 	=> $user_profile['id'],
				'first_name' 	=> $user_profile['first_name'],
				'last_name' 	=> $user_profile['last_name'],
				'email' 		=> $user_profile['email'],
				'gender' 		=> $user_profile['gender'],
				'locale' 		=> $user_profile['locale'],
				'picture' 		=> $user_profile['picture']['data']['url'],
				'link' 			=> $user_profile['link']
			);
			$fb_user_data = $user->check_user_exist($user_data);
			if ($fb_user_data) {
				$user->update_user_data($user_data);
			} else {
				$user->insert_user_data($user_data);
			}
			$_SESSION['fb_user_data'] = $user_data;
			$this->set_url = [
				"label" => "Log out",
				"href"  => BASE_URL."client/home/fb_logout"
			];
		}
	}
}

?>
