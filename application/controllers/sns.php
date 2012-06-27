<?php
/**
 * 第三方操作
 * @author zshen
 *
 */
class Sns extends MY_Controller {

	protected $apiHost = null;
	
	public function __construct () {
		parent::__construct();
		$this->load->model('sns_model');
		$this->load->helper('url');
		$this->load->helper('api');
		$this->load->library('session');
		$this->apiHost = $this->config->item('api_hosts');
	}
	/**
	 * 接口说明：第三方登陆与绑定第三方账号的跳转接口,跳转到相关授权页,临时存储A[snsid,apptype,opt和session_id至session],客户端在实现时用类似webview打开并提供回调方法接收相关返回值
	请求方式：get
	参数说明：
		snsid:平台id{sina/qq}
		apptype:应用类型{web/android/ios}
		op:操作类型,现有为第三方登陆和绑定操作,分别为1和2
		session_id:当进行绑定操作时，需要传递该参数	
	返回结果:
		授权成功返回callback页面
	 *
	 */
	public function redirect() {
		$snsid = (string)$this->input->get('snsid');
		$apptype = strtolower((string)$this->input->get('apptype'));
		if (!in_array($apptype, Sns_Model::getAppTypes())) {
			return  show_error('参数错误',500);
		}
 		$opArray = array(1,2); //请求操作,op＝1为登陆,op=2为绑定
		$op = (int)$this->input->get('op');
		if(!in_array($op,$opArray)) {
			return  show_error('参数错误',500);
		}
		$sessionid = (string)$this->input->get('session_id');
		if($op==2 && !$sessionid) {
			return  show_error('参数错误',500);
		}
		$params = array('snsid'=>$snsid,'apptype'=>$apptype,'op'=>$op,'refer'=>$this->input->server('HTTP_REFERER'));
		if($sessionid && $op==2) {
			$params['session_id'] = $sessionid;
		}
		$state = base64_encode(json_encode($params));
		$result = request($this->apiHost.'/sns/oauthzieurl',array('snsid'=>$snsid,'state'=>$state));
		if($result['httpcode']==200) {
			redirect($result['data'][$snsid],'Location',302);
		}
		else {
			return  show_error('参数错误',500);
		}
	}
	/**
	 * 接口说明：授权回调页,验证授权有效性,从session拿到接口1中临时数据A,调用接口5,获取返回值,根据op实现用户操作,
		1).当op为1时，即登陆操作
			如果已绑定1001账号，获取session_id,清除临时数据A，根据apptype传回session_id(客户端提供相关js回调方法)
			如果未绑定1001账号，向临时数据A中追加{snsid,oauthstring},显示创建账号页面，并显示用已有账号绑定链接
		2).当op为2时，为绑定操作
        请求方式：get
        参数说明：
        返回结果:
		看接口说明
	 *
	 */
	public function callback() {
		$query = $_SERVER['QUERY_STRING'];
		$state = @json_decode(base64_decode(urldecode((string)$this->input->get('state'))),true);
		if(!$state || !$query) {
			return  show_error('参数错误',500);
		}
		$params = array();
		$params['snsid'] = $state['snsid'];
		$params['query'] = urldecode($query);
		$sessionid = null;
		$apptype = $state['apptype'];
		if(isset($state['session_id']) && $state['op']==2) {
			$sessionid = $params['session_id'] = $state['session_id'];
		}
		$result = request($this->apiHost.'/sns/callback',$params);
		if($result['httpcode'] != 200) {
			
			return  show_error('参数错误',500);
		}
		$data = $result['data'];
		if($state['op']==2) { //绑定
			if($data) {
				return  show_error('绑定成功',200,'恭喜');
			}
			else {
				return  show_error('绑定失败',500);
			}
		}
		else { //登陆
			if(is_array($data) && isset($data['session_id']) && $data['session_id']) {
				return  show_error('登陆成功 session_id:'.$data['session_id'],200,'恭喜');
			}
			elseif (isset($data['unbind']) && $data['unbind']) {
				//＠todo 输入账号页面
				$renderData = array(
						'snsid'=>$data['snsid'],
						'apptype'=>$apptype,
						'status'=>Sns_Model::encodeAuthString($data['oauthstring'])
						);
				$this->smarty->view('sns/register.tpl',$renderData);
			}
		}
	}
	/**
	 * 接口说明：为接口3中的两个实际页面,用户输入用户名和密码登陆成功后用获取到的sessionid以及临时数据A调用接口8,获取返回信息，清除临时数据A,根据apptype传回sessionid(客户端提供相关js回调方法)
	请求方式：get|提交时post	
	参数说明：
		new:区分是创建新账号绑定还是用已有账号绑定
	返回结果：	
		看接口说明
	 *
	 */
	public function bind() {
		$new = (int)$this->input->get_post('new');
		$snsid = (string)$this->input->get_post('snsid');
		$apptype = (string)$this->input->get_post('apptype');
		$status = (string)$this->input->get_post('status');
		if(!$snsid || !$apptype || !$status) {
			return  show_error('参数错误',500);
		}
		$method = strtoupper($this->input->server('REQUEST_METHOD'));
		if($new) { //创建账号绑定
			if($method == 'POST') {
				$username = $this->input->post('username');
				$passwd = $this->input->post('passwd');
				$confirmPasswd = $this->input->post('confirm_passwd');
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$status,
						'username'=>$username
					);
				if(!$username || !$passwd || !$confirmPasswd || $passwd!=$confirmPasswd) {
					$renderData['errormessage']='提交数据错误';
					return $this->smarty->view('sns/register.tpl',$renderData);
				}
				$params = array(
						'username'=>$username,
						'passwd'=>$passwd
						);
				$result = request($this->apiHost.'/auth/signup',$params,'POST');
				//@TODO 获取第三方账号信息更新user info
				if($result['httpcode']==200 && $result['data']['status']=='USER_EXISTS') {
					$renderData['errormessage']='用户名已存在';
					return $this->smarty->view('sns/register.tpl',$renderData);
				}
				elseif($result['httpcode']!=200 || $result['data']['status']!='OK') {
					$renderData['errormessage']='注册失败';
					return $this->smarty->view('sns/register.tpl',$renderData);
				}
				$sessionid = $result['data']['session_id'];
				$bindParams = array(
						'session_id'=>$sessionid,
						'snsid'=>$snsid,
						'authstring'=>Sns_Model::decodeAuthString($status)
						);
				$result = request($this->apiHost.'/sns/bind',$bindParams,'GET');
				if($result['httpcode']!=200) {
					return  show_error('绑定失败',500);
				}
				else {
					//return  show_error('注册并绑定成功 session_id:'.$sessionid,200,'恭喜');
					$this->__finish($apptype, $status, $sessionid);
				}
			}
			else {
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status')
						);
				return $this->smarty->view('sns/register.tpl',$renderData);
			}
		}
		else { //输入已有账号绑定
			if($method == 'POST') {
				$username = $this->input->post('username');
				$passwd = $this->input->post('passwd');
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status'),
						'username'=>$username
						);
				if(!$username || !$passwd) {
					$renderData['errormessage']='请输入正确用户名和密码';
					$this->smarty->view('sns/login.tpl',$renderData);
				}
				
				$getkey = request($this->apiHost."/auth/getkey");
				if ($getkey['httpcode'] != '200'){
					$renderData['errormessage']='登陆失败';
					$this->smarty->view('sns/login.tpl',$renderData);
				}
				$getkey_data = $getkey['data']['key'];
				$passwd1 = md5(md5($passwd).$getkey_data);
				$params = array(
						'username'=>$username,
						'passwd'=>$passwd1
				);
				$result = request($this->apiHost.'/auth/signin',$params);//登陆
				if($result['httpcode']!=200 || $result['data']['status']!='OK') {
					$renderData['errormessage']='登陆失败';
					return $this->smarty->view('sns/login.tpl',$renderData);
				}
				$sessionid = $result['data']['session_id'];
				$bindParams = array(
						'session_id'=>$sessionid,
						'snsid'=>$snsid,
						'authstring'=>Sns_Model::decodeAuthString($status)
				);
				$result = request($this->apiHost.'/sns/bind',$bindParams,'GET');//登陆后获取sessionid绑定账号
				if($result['httpcode']!=200) {
					return  show_error('绑定失败',500);
				}
				else {
					//return  show_error('登陆并绑定成功 session_id:'.$sessionid,200,'恭喜');
					$this->__finish($apptype, $status, $sessionid);
				}
			}
			else {
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status')
				);
				return $this->smarty->view('sns/login.tpl',$renderData);
			}
		}
	}
	
	private function __finish($apptype,$status,$sessionid) {
		switch ($apptype) {
			case 'web':
				$status = Sns_Model::decodeAuthString($status);
				$status = json_decode(base64_decode($status),true);
				if(isset($status['state'])) {
					$status['state'] = @json_decode(base64_decode($status['state']),true);
				}
				$this->session->set_userdata('session_id',$sessionid);
				$u = '/index.php';
				if(isset($status['state']['refer']) && isset($status['state']['refer'])) {
					$u = $status['state']['refer'];
				}
				redirect($u);
				break;
			case 'android':
				break;
			case 'ios':
				break;
			default:
				exit(0);
		}
	}
}

