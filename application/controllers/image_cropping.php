<?php
include 'magazine.php';
/*处理上传图像并剪切*/
class Image_cropping extends Magazine {
	private $web=array();
	function __construct(){
		parent::MY_Controller();
		$this->load->helper('api');
		$this->load->helper('thumb');
		$this->load->library('session');
		$this->_auth_check_web();
		$username=$this->session->userdata('nickname');
		//网站地址
		$this->web['sitehttp']= $this->config->item('web_host').'/';
		//上传路径
		$this->web['img_up_dir']=$this->config->item('upload_img_dir').'/'.$this->session->userdata('user_id');;
		//截图类型（限jpg、gif、png）
		$this->web['img_up_format']='jpg';
		//截图质量（限jpg、70-100，100为最好质量）
		$this->web['img_up_quality']=80;
		//源图命名（应用于论坛等程序时可以用会员名编码命名）
		$this->web['socure_img_name']=time().mt_rand(0,10000);
		//截图命名
		$this->web['cut_image_name']=$this->web['socure_img_name'].'_180';
		$this->web['cut_image_name_80']=$this->web['socure_img_name'].'_80';
		$this->web['cut_image_name_50']=$this->web['socure_img_name'].'_50';
		//上传最大尺寸（KB）
		$this->web['max_file_size']=2000;
		//允许上传的格式 |分割
		$this->web['permit_upload_format']='jpg|gif|png';
		if(!file_exists($this->web['img_up_dir'])) mkdir($this->web['img_up_dir']);
	}
	public function index(){
		$this->smarty->view('image_cropping/index.tpl');
	}
	/*加载上传界面*/
	public function show_up_ui(){
		$this->smarty->view('image_cropping/start.tpl');
	}
	/*加载裁剪界面*/
	public function show_cut_ui(){
		$this->smarty->view('image_cropping/cut.tpl');
	}
	/*上传本地图片*/
	private function _upload_local_file(){
  if(is_array($_FILES['purl1']) && $_FILES['purl1']['size']){
    if(!file_exists($this->web['img_up_dir']) && !@mkdir($this->web['img_up_dir'])){
      exit('图片无法上传，上传目录'.$this->web['img_up_dir'].'不存在！');
    }else{
      @chmod($this->web['img_up_dir'],0777);
      $inis = ini_get('upload_max_filesize');
      $uploadmax=$inis;
      if($_FILES['purl1']['size']>$this->web['max_file_size']*1024){
        exit('图片上传不成功！上传的文件请小于'.$this->web['max_file_size'].'KB！');
      }else{
        if(!preg_match('/\.('.$this->web['permit_upload_format'].')$/i',$_FILES['purl1']['name'],$matches)){
          exit('图片上传不成功！请选择一个有效的文件：允许的格式有（jpg|gif|png）！');
        }else{
          $file_format=strtolower($matches[1]);
          if(@move_uploaded_file($_FILES['purl1']['tmp_name'],$this->web['img_up_dir'].'/'.$this->web['socure_img_name'].'.'.$file_format)){
            $image_path='/'.$this->session->userdata('user_id').'/'.$this->web['socure_img_name'].'.'.$file_format;
            $this->_fsetcookie($this->config->item('upload_img_host').$image_path);
			echo '<script>location.href="/image_cropping/show_cut_ui"</script>';
	      }else{
            exit('图片上传不成功！');
	      }
		}
	  }
	}
  }else{
    exit('图片不存在！请选择正确的路径！');
  }

}
	/*上传网络图片*/
	private function _upload_network_file(){
		$filename=$_POST['purl2'];
		  //if($filename=='' || !preg_match('/^https?:\/\/.+\.(jpg|gif|png)$/i',$filename,$matches)){
		if($filename=='' || !preg_match('/^https?:\/\/.+/i',$filename)){
			exit('图片URL输入不合法！网址以http[s]://开头！');
		  }
		  if(!$im=@file_get_contents($filename)){
			exit('无法获取此图片！请确定图片URL正确。');
		  }
		  if(strlen($im)>$this->web['max_file_size']*1024){
			exit('图片上传不成功！链接的文件请小于'.$this->web['max_file_size'].'KB！');
		  }
		  //$t=strtolower($matches[1]);
		  $format=$this->web['img_up_format'];
		  $this->_write_network_img($this->web['img_up_dir'].'/'.$this->web['socure_img_name'].'.'.$format,$im);
		  //$this->_fsetcookie($this->web['img_up_dir'].'/'.$this->web['socure_img_name'].'.'.$format);
		  $this->_fsetcookie($this->config->item('upload_img_host').'/'.$this->session->userdata('user_id').'/'.$this->web['socure_img_name'].'.'.$format);
		  echo '图像上传成功';
		  echo '<script>location.href="/image_cropping/show_cut_ui"</script>';
	}
	/*网络图片写入本地*/
	private function _write_network_img($file,$text){
		if(!file_exists($file)){
			if(!@touch($file)){
			  exit('操作失败！原因分析：文件'.$file.'不存在或不可创建或读写，可能是当前运行环境权限不足');
			}
		}
	  $arr_dir=@explode('/',$file);
	  $dir_num=count($arr_dir);
	  if($dir_num>0){
		for($i=0;$i<$dir_num;$i++){
		  $the_dir=str_pad('',3*($dir_num-$i-1),'../').$arr_dir[$i];
		  @chmod($the_dir,0755);
		}
	  }
	  @chmod($file,0755);
	  if(is_writable($file) && ($fp=@fopen($file,'rb+'))){
		$this->_lock_file($fp);
		@ftruncate($fp,0);
		if(strlen($text)>0 && !@fwrite($fp,$text)){
		  exit('操作失败！原因分析：文件'.$file.'不存在或不可创建或读写，可能是权限不足！');
		}
		@flock($fp,LOCK_UN);
		fclose($fp);
	  }else{
		exit('操作失败！原因分析：文件'.$file.'不存在或不可读写');
	  }
	}
	//锁定文件
	private function _lock_file($fp){
		  if($fp){
			if(!flock($fp,LOCK_EX)){
			  sleep(1);
			  $this->_lock_file($fp);
			}
		  }
	}
	/*路径存入COOKIE*/
	private function _fsetcookie($img_path){
		echo '<script>document.cookie="letoupath="+encodeURIComponent(\''.$img_path.'\')+"; path=/;";</script>';
	}

	private function _exec_check(){
		if(extension_loaded('gd')){
			if(!function_exists('gd_info')){
				exit('重要提示：你的gd版本很低，图片处理功能可能受到约束！');
			}
		  }else{
			exit('重要提示：你尚未加载gd库，不能使用图片处理功能！');
		  }
		$uploaded_path=$_COOKIE['letoupath'];//上传图片的路径
		$convert_source=$this->_convert_img_format($uploaded_path);//转换格式后的资源
		$cimg_m=$this->web['img_up_dir'].'/letou.'.$this->web['img_up_format']; //原图
		$cimg_s=$this->web['img_up_dir'].'/'.$this->web['cut_image_name'].'.'.$this->web['img_up_format']; //缩略图180x180
		if($this->_run_img_resize($convert_source,$cimg_m,0,0,$_POST['noww'],$_POST['nowh'],false,false,$this->web['img_up_quality']) && 
		$this->_run_img_resize($cimg_m,$cimg_s,$_POST['px'],$_POST['py'],$_POST['pw'],$_POST['ph'],$_POST['pw'],$_POST['ph'],$this->web['img_up_quality'])){
			$return_path = $this->web['img_up_dir'].'/'.$this->web['cut_image_name'].'.'.$this->web['img_up_format']; //缩略图80x80
			$img_80=$this->web['img_up_dir'].'/'.$this->web['cut_image_name_80'].'.'.$this->web['img_up_format']; //缩略图80x80
			$img_50=$this->web['img_up_dir'].'/'.$this->web['cut_image_name_50'].'.'.$this->web['img_up_format']; //缩略图50x50
			image_thumb($return_path, $img_80, 80, 80, false);
			image_thumb($return_path, $img_50, 50, 50, false);
			$this->_exec_dropping_img($uploaded_path, $convert_source, $cimg_m, $cimg_s);
		}else{
		      exit('截图失败！');
		}
	}

	/*处理剪切图片*/
	private function _exec_dropping_img($uploaded_path, $convert_source, $cimg_m, $cimg_s){
			$session_id = $this->session->userdata("session_id");
			$data = json_encode(array('avatar' => $this->web['socure_img_name']));
			$this->_auth_check_web();
			$request = request($this->config->item('api_host') . "/user/me?session_id=$session_id", $data, 'PUT',false);
			if ($request['httpcode'] == '202'){
				$msg = "修改成功";
			}
			else {
				$msg = "修改失败";
			}
			$tips =  "<script>document.domain = 'in1001.com';parent.$.fn.colorbox.close();parent.showTipsbox('设置头像成功', 'access', 'reload');</script>";
			echo $tips;
	}
	//处理缩略图
	private function _run_img_resize($img,$resize_img_name,$dx,$dy,$resize_width,$resize_height,$w,$h,$quality){
		  $img_info=@getimagesize($img);
		  $width=$img_info[0];
		  $height=$img_info[1];
		  $w=$w==false?$width:$w;
		  $h=$h==false?$height:$h;
		  switch($img_info[2]){
		    case 1:
		    $img=@imagecreatefromgif($img);
		    break;
		    case 2:
		    $img=@imagecreatefromjpeg($img);
		    break;
		    case 3:
		    $img=@imagecreatefrompng($img);
		    break;
		  }
		  if(!$img) return false;
		  if(function_exists("imagecopyresampled")){
		    $resize_img=@imagecreatetruecolor($resize_width,$resize_height);
		    $white=@imagecolorallocate($resize_img,255,255,255);
		    @imagefilledrectangle($resize_img,0,0,$resize_width,$resize_height,$white);// 填充背景色
		    @imagecopyresampled($resize_img,$img,0,0,$dx,$dy,$resize_width,$resize_height,$w,$h);
		  }else{
		    $resize_img=@imagecreate($resize_width,$resize_height);
		    $white=@imagecolorallocate($resize_img,255,255,255);
		    @imagefilledrectangle($resize_img,0,0,$resize_width,$resize_height,$white);// 填充背景色
		    @imagecopyresized($resize_img,$img,0,0,$dx,$dy,$resize_width,$resize_height,$w,$h);
		  }
		  //if(file_exists($resize_img_name)) unlink($resize_img_name);
		  switch($img_info[2]){
		    case 1:
		    @imagegif($resize_img,$resize_img_name);
		    break;
		    case 2:
		    @imagejpeg($resize_img,$resize_img_name,$quality); //100质量最好，默认75
		    break;
		    case 3:
		    @imagepng($resize_img,$resize_img_name);
		    break;
		  }
		  @imagedestroy($resize_img);
		  return true;
		}

	/*转换图片格式*/
	private function _convert_img_format($uploaded_path){
		$uploaded_format=strtolower(ltrim(strrchr($uploaded_path,'.'),'.'));//获取上传图片的后缀名
	  if($uploaded_format!=$this->web['img_up_format']){
		if($uploaded_format=='gif'){
		  $img_source=imagecreatefromgif($uploaded_path);
		}elseif($uploaded_format=='png'){
		  $img_source=imagecreatefrompng($uploaded_path);
		}elseif($uploaded_format=='jpg'){
		  $img_source=imagecreatefromjpeg($uploaded_path);
		}
		if($this->web['img_up_format']=='jpg') $f='jpeg';
		elseif($this->web['img_up_format']=='png') $f='png';
		else $f='gif';	
		$uploaded_path=preg_replace("/\.".preg_quote($uploaded_format)."$/","",$uploaded_path).".".$uploaded_format;
		$function='image'.$f;
		if(@$function($img_source,$uploaded_path)){
			imagedestroy($img_source);
		}
	  }
	  return $uploaded_path;
	}

	/*选择上传程序 本地 or 网络地址*/
	private function _switch_upload_programs(){
		switch($this->input->post('ptype')){
			case 1;	$this->_upload_local_file();break;
			case 2;	$this->_upload_network_file();break;
			default :$this->_upload_local_file();break;
		}

	}
	public function exec_dropping(){
		$this->_exec_check();
	}

	public function exec_crop(){
		$this->_switch_upload_programs();
	}
}
