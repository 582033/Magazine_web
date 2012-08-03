<?php
/**
 * 第三方操作
 * @author zshen
 *
 */
require_once APPPATH . "/controllers/magazine.php";
class Sns extends Magazine {

	protected $apiHost = null;
	
	public function __construct () {
		parent::__construct();
		$this->load->model('sns_model');
		$this->load->helper('url');
		$this->load->helper('api');
		$this->load->library('session');
		$this->apiHost = $this->config->item('api_host');
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
	public function redirect() { // {{{
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
	} // }}}
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
	public function callback() { // {{{
		//sina返回错误码，qq直接关闭
		if($this->input->get('error_code') == '21330') {
			redirect('/');
		}
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
		$result = request($this->apiHost.'/sns/callback',$params,'GET');
		if($result['httpcode'] != 200) {
			return  show_error('参数错误',500);
		}
		$data = $result['data'];
		if($state['op']==2) { //绑定
			if($data) {
				$u = isset($state['refer']) && $state['refer'] ? $state['refer']:'/user/me/set_share';
				redirect($u);
				//return  show_error('绑定成功',200,'恭喜');
			}
			else {
				return  show_error('绑定失败',500);
			}
		}
		else { //登陆
			if(is_array($data) && isset($data['session_id']) && $data['session_id']) {
				$this->__finish($apptype, Sns_Model::encodeAuthString($data['oauthstring']), $data);
			}
			elseif (isset($data['unbind']) && $data['unbind']) {
				//＠todo 输入账号页面
				$renderData = array(
						'snsid'=>$data['snsid'],
						'apptype'=>$apptype,
						'status'=>Sns_Model::encodeAuthString($data['oauthstring']),
						'snsnickname'=>isset($data['nickname'])?$data['nickname']:'',
						'avatar'=>isset($data['avatar']) && $data['avatar']?$data['avatar']:'http://img.in1001.com/avatar/0/default.jpg!50'
						);
				$this->_show_signup($renderData);
			}
		}
	} //}}}
	/**
	 * 接口说明：为接口3中的两个实际页面,用户输入用户名和密码登陆成功后用获取到的sessionid以及临时数据A调用接口8,获取返回信息，清除临时数据A,根据apptype传回sessionid(客户端提供相关js回调方法)
	请求方式：get|提交时post	
	参数说明：
		new:区分是创建新账号绑定还是用已有账号绑定
	返回结果：	
		看接口说明
	 *
	 */
	public function bind() { // {{{
		$new = (int)$this->input->get_post('new');
		$snsid = (string)$this->input->get_post('snsid');
		$apptype = (string)$this->input->get_post('apptype');
		$status = (string)$this->input->get_post('status');
		$snsnickname = (string)$this->input->get_post('snsnickname');
		$avatar = (string)$this->input->get_post('avatar');
		if(!$snsid || !$apptype || !$status) {
			return  show_error('参数错误',500);
		}
		$method = strtoupper($this->input->server('REQUEST_METHOD'));
		if($new) { // {{{ 创建账号绑定
			if($method == 'POST') {
				$username = $this->input->post('username');
				$passwd = $this->input->post('passwd');
				$confirmPasswd = $this->input->post('confirm_passwd');
				$nickname = $this->input->post('nickname');
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$status,
						'username'=>$username,
						'snsnickname'=>$snsnickname,
						'avatar'=>$avatar
					);
				if(!$username || !$passwd || !$confirmPasswd || $passwd!=$confirmPasswd) {
					$renderData['errormessage']='提交数据错误';
					return $this->_show_signup($renderData);
				}
				$params = array(
						'username'=>$username,
						'passwd'=>$passwd,
						'nickname'=>$nickname
						);
				$result = request($this->apiHost.'/auth/signup',$params,'POST');
				//@TODO 获取第三方账号信息更新user info
				if($result['httpcode']==200 && $result['data']['status']=='USER_EXISTS') {
					$renderData['errormessage']='此邮箱已经注册过，请更换其他邮箱';
					return $this->_show_signup($renderData);
				}
				elseif($result['httpcode']!=200 || $result['data']['status']!='OK') {
					$renderData['errormessage']='注册失败';
					return $this->_show_signup($renderData);
				}
				$sessionData = $result['data'];
				$bindParams = array(
						'session_id'=>$sessionData['session_id'],
						'snsid'=>$snsid,
						'authstring'=>Sns_Model::decodeAuthString($status),
						'do'=>'FETCH'
						);
				set_time_limit(100);//获取图片
				$result = request($this->apiHost.'/sns/bind',$bindParams,'GET',true,array(),null);
				if($result['httpcode']!=200) {
					return  show_error('绑定失败',500);
				}
				else {
					//return  show_error('注册并绑定成功 session_id:'.$sessionid,200,'恭喜');
					$this->__finish($apptype, $status, $sessionData);
				}
			}
			else {
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status'),
						'snsnickname'=>$snsnickname,
						'avatar'=>$avatar
						);
				return $this->_show_signup($renderData);
			}
		} // }}}
		else { // {{{ 输入已有账号绑定
			if($method == 'POST') {
				$username = $this->input->post('username');
				$passwd = $this->input->post('passwd');
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status'),
						'username'=>$username,
						'snsnickname'=>$snsnickname,
						'avatar'=>$avatar
						);
				if(!$username || !$passwd) {
					$renderData['errormessage']='请输入正确用户名和密码';
					$this->_show_bind($renderData);
				}

				$this->load->model('login_model');
				$result = $this->login_model->login($username, $passwd);
				if (is_string($result)) {
					$renderData['errormessage'] = "登陆失败: $return";
					$this->_show_bind($renderData);
					return;
				}

				$sessionData = $result['data'];
				$bindParams = array(
						'session_id'=>$sessionData['session_id'],
						'snsid'=>$snsid,
						'authstring'=>Sns_Model::decodeAuthString($status)
				);
				$result = request($this->apiHost.'/sns/bind',$bindParams,'GET');//登陆后获取sessionid绑定账号
				if($result['httpcode']!=200) {
					return  show_error('绑定失败',500);
				}
				else {
					//return  show_error('登陆并绑定成功 session_id:'.$sessionid,200,'恭喜');
					$this->__finish($apptype, $status, $sessionData);
				}
			}
			else {
				$renderData = array(
						'snsid'=>$snsid,
						'apptype'=>$apptype,
						'status'=>$this->input->get_post('status'),
						'snsnickname'=>$snsnickname,
						'avatar'=>$avatar
				);
				return $this->_show_bind($renderData);
			}
		} // }}}
	} // }}}
	
	private function __finish($apptype, $status, $signdata) { // {{{
		/*
		 * $signdata - same with output of signin/signup api
		 */
		$this->load->model('login_model');
		switch ($apptype) {
			case 'web':
				$status = Sns_Model::decodeAuthString($status);
				$status = json_decode(base64_decode($status),true);
				if(isset($status['state'])) {
					$status['state'] = @json_decode(base64_decode($status['state']),true);
				}
				$this->login_model->set_signin_cookie($signdata);
				$u = '/';
				if(isset($status['state']['refer']) && $status['state']['refer']) {
					$filters = array('sns/callback','sns/bind','signin','signup');
					$u = $status['state']['refer'];
					foreach ($filters AS $v) {
						if (false !== strpos($status['state']['refer'],$v)) {
							$u = '/';break;
						}
					}
				}
				redirect($u);
				break;
			case 'android':
				break;
			case 'ios':
				echo '你在IOS登陆了!FK!你的sessionid是:'.$signdata['session_id'],"<br>\n";
				print_r($signdata);
				die;
				break;
			default:
				exit(0);
		}
	} // }}}
	function _show_signup($data) {
		$pageid = 'sns-signup';
		$commondata = $this->_get_common_data($pageid);
		$data = array_merge($data, $commondata);
		$this->smarty->view('sns/register.tpl', $data);
	}
	function _show_bind($data) {
		$pageid = 'sns-bind';
		$commondata = $this->_get_common_data($pageid);
		$data = array_merge($data, $commondata);
		$this->smarty->view('sns/login.tpl', $data);
	}
}

