<?php 
@include_once (APPPATH.'libraries/hashids/Hashids.php'); 
use Hashids\Hashids;   
class AccountModel extends CI_Model{
	function __construct()
    {
		parent::__construct();
    }
	function get_gen_hash($param,$type)
	{
		if($type=="encode")
		{
			$hashids = new Hashids('',8, 'abwxyefghi3456jklmnopqEFGHILM@#NOPrstuz12789ABCDQRSTUVWXYZ');
			return $hashids->encode($param); 
		}
		else
		{
			$hashids = new Hashids('',8, 'abwxyefghi3456jklmnopqEFGHILM@#NOPrstuz12789ABCDQRSTUVWXYZ');
			return $hashids->decode($param); 
		}
	}
	function decrypt($encrypted) {
		$salt='!kQm*fdq3231e1Kbm%9';
		$password='83udn038x9ue90x3umx38x';
		// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
		$key = hash('SHA256', $salt . $password, true);
		// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
		$iv = base64_decode(substr($encrypted, 0, 22) . '==');
		// Remove $iv from $encrypted.
		$encrypted = substr($encrypted, 22);
		// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
		// Retrieve $hash which is the last 32 characters of $decrypted.
		$hash = substr($decrypted, -32);
		// Remove the last 32 characters from $decrypted.
		$decrypted = substr($decrypted, 0, -32);
		// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
		if (md5($decrypted) != $hash) return false;
		// Yay!
		return $decrypted;
	}

	function encrypt($decrypted) 
	{ 
		$salt='!kQm*fdq3231e1Kbm%9';
		// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
		$password="83udn038x9ue90x3umx38x";
		$key = hash('SHA256', $salt . $password, true);
		// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
		srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
		// We're done!
		return $iv_base64 . $encrypted;
	}
	function saveCookieLogin($userInfo)
	{
		$accountId=$this->encrypt($userInfo['accountId']);
		$cookieData=['u'=>$accountId];
		$cookie_name = "in";
		$cookie_value = json_encode($cookieData);
		setcookie($cookie_name, $cookie_value, time() + (315360000), "/");
		$this->session->user=$userInfo;
	}
	function checkLogin()
	{  
		if($this->uri->segment(1)=="logout")
		return true;
		
		$sessCheck=isset($this->session->user)?true:false;
		
		if(!$sessCheck)
		{
			$loginCookie=isset($_COOKIE['in'])?json_decode($_COOKIE['in'],true):[];
			
			if(count($loginCookie)>0)
			{
				if(array_key_exists('u',$loginCookie))
				{
					$userHashId=$loginCookie['u'];
					
					$accountIdDec=$this->decrypt($userHashId);
					
					if(!$accountIdDec)
					return false;
				
					$userInfo=$this->DbLayer->getData('accounts',$select=null,$where=['accountId'=>$accountIdDec],$resultType="row_array");
					
					$this->session->user=$userInfo;
					
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	function logout()
	{  
		$sessCheck=isset($this->session->user)?true:false;
		
		if($sessCheck)
		{
			$loginCookie=isset($_COOKIE['in'])?json_decode($_COOKIE['in'],true):[];
			
			if(count($loginCookie)>0)
			{
				if(array_key_exists('u',$loginCookie))
				{
					$userHashId=$loginCookie['u'];
					
					$accountIdDec=$this->decrypt($userHashId);
					
					if(!$accountIdDec)
					return 23;
				
					setcookie("in","", time() - (315360000), "/");
					session_destroy();
					unset($_SESSION['user']);
					
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 2;
		}
	}
}