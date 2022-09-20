<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fbapi extends CI_Controller {
	
	public function __construct() { 
        parent::__construct();
		/* Initialize FB library*/
		require(APPPATH."third_party/fb-graph/src/Facebook/autoload.php");
		$this->fb = new Facebook\Facebook(array(
			'app_id' => '480856050366232',
			'app_secret' => '05c6b2cc96b12181a0752ebcef8734ab',
			'default_graph_version' => 'v15.0',
		));
		$this->helper = $this->fb->getRedirectLoginHelper();
		/* Initialize FB library*/
		/* Load database model to insert / update tables*/
		$this->load->model('fb_model','fbModel', TRUE);
		/* Load database model to insert / update tables*/
    }
	
	/*Facebook callback after login successfully*/
	public function fbcallback()
	{		
		 $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		 $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		 $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		 $this->output->set_header('Pragma: no-cache');
		 
		 try {
		  $accessToken = $this->helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		   redirect('fbapi/errorpage', 'location');
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		   redirect('fbapi/errorpage', 'location');
		  exit;
		}
		
		if (!isset($accessToken)) {
		  redirect('fbapi/errorpage', 'location');
		  exit;
		}
		
		$res 	= 	$this->fb->get('/me?fields=name,email,id',$accessToken->getValue());
		$fbUser	=	$res->getDecodedBody();
		$fbPagesG = $this->fb->get('/'.$fbUser['id'].'/accounts', $accessToken->getValue())->getGraphEdge()->asArray();
		
		$insertData["socialUniqueId"]=$fbUser['id'];
		$insertData["fullName"]=$fbUser['name'];
		$insertData["emailId"]=$fbUser['email'];
		$insertData["loginTime"]=date('Y-m-d H:i:s');
		$insertData["pageCount"]=count($fbPagesG);
		$this->fbModel->insertRow($this->config->item('MEMBERS_TABLE'),$insertData);
		
		$sessionData=array('fbUserId'=>$fbUser['id'],'fbUserName'=>$fbUser['name'],'fbAccessToken'=>$accessToken->getValue(),"fbUser" => $fbUser,'fbPages'=>$fbPages);
		$this->session->set_userdata($sessionData);
		redirect('fbapi/welcome','location');	
	}
	/*Facebook callback after login successfully*/
	
	/* Default index page*/
	public function index()
	{		
		 $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		 $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		 $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		 $this->output->set_header('Pragma: no-cache');
		 
		 $helper = $this->fb->getRedirectLoginHelper();
		 $permissions = array('email','pages_show_list','public_profile');//,
		 $data["loginUrl"] = $this->helper->getLoginUrl(base_url('fbapi/fbcallback'), $permissions);
		 
		 $this->load->view('fbapi/index',$data);
	}
	/* Default index page*/
	
	/* Error page*/
	public function errorpage()
	{		
		 $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		 $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		 $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		 $this->output->set_header('Pragma: no-cache');
		 
		 try {
		 	 
			 $this->load->view('fbapi/404',$data);
		 }catch(Facebook\Exceptions\FacebookSDKException $e) {
		 	redirect('fbapi', 'location');
		 }
	}
	/* Error page*/
	
	/* Once FB login successfully it will redirect to this welcome page*/
	public function welcome()
	{		
		 $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		 $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		 $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		 $this->output->set_header('Pragma: no-cache');
		 
		 try {
		 	 $data["logoutUrl"] = base_url('fbapi/logout');
			 $data["fbUserId"] = $fbUserId = $this->session->userdata('fbUserId');
			 $data["fbUserName"] = $this->session->userdata('fbUserName');
			 $data["fbAccessToken"] = $this->session->userdata('fbAccessToken');
			 $data["fbUser"] = $this->session->userdata('fbUser');
			 $data["fbpages"] = $this->fb->get('/'.$fbUserId.'/accounts', $this->session->userdata('fbAccessToken'))->getGraphEdge()->asArray();
			 $this->load->view('fbapi/welcome',$data);
		 }catch(Facebook\Exceptions\FacebookSDKException $e) {
		 	redirect('fbapi', 'location');
		 }
	}
	/* Once FB login successfully it will redirect to this welcome page*/
	
	/* Logout*/
	public function logout()
	{		
		 $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		 $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		 $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		 $this->output->set_header('Pragma: no-cache');
		 $this->load->driver('cache');
		 $sessionData=array('fbUserId'=>"",'fbUserName'=>"",'fbAccessToken'=>"","fbUser" => "");
		 $this->session->unset_userdata($sessionData);
		 $this->session->sess_destroy();
		 $this->cache->clean();
		 redirect('fbapi', 'location');
	}
	/* Logout*/
	
	/* Facebook page api to get all information ajax call*/
	public function getfbpageinfo($pageId)
	{	
		header('Content-Type: application/json');
		$getpageInfo = $this->fb->get('/'.$pageId.'?access_token='.$this->session->userdata('fbAccessToken').'&fields=fan_count,name,founded,hours,overall_star_rating,rating_count,followers_count');
		$getpageInfo	=	$getpageInfo->getDecodedBody();
		if(isset($getpageInfo["id"]))
		{
			$insertData["fbUserId"] = $this->session->userdata('fbUserId');
			$insertData["pageUId"] = $getpageInfo["id"];
			$insertData["pageName"] = $getpageInfo["name"];
			$insertData["reviewCount"] = isset($getpageInfo["rating_count"])?$getpageInfo["rating_count"]:0;
			$this->fbModel->insertPageRow($this->config->item('MEMBER_PAGES_TABLE'),$insertData);
		
			$response["pageName"] = $getpageInfo["name"];
			$response["followersCount"] = isset($getpageInfo["followers_count"])?$getpageInfo["followers_count"]:0;
			$response["fanCount"] = isset($getpageInfo["fan_count"])?$getpageInfo["fan_count"]:0;
			$response["ratingCount"] = isset($getpageInfo["rating_count"])?$getpageInfo["rating_count"]:0;
			$response["statusCode"]=200;
			$response["status"]="success";
		}else{
			$response["statusCode"]=404;
			$response["status"]="error";
			$response["message"]="No Data Found";
		}
		
		$json_response=json_encode($response);
		echo $json_response;
	}
	/* Facebook page api to get all information ajax call*/
}