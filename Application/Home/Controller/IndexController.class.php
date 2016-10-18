<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //获得参数 signature nonce token timestamp echostr
		$nonce     = $_GET['nonce'];
		// echo $nonce;die;
		$token     = 'myweixin';
		$timestamp = $_GET['timestamp'];
		// echo $timestamp;die;
		$echostr   = $_GET['echostr'];
		$signature = $_GET['signature'];
		//形成数组，然后按字典序排序
		$array = array();
		$array = array($nonce, $timestamp, $token);
		// var_dump($array);die;
		sort($array);
		//拼接成字符串,sha1加密 ，然后与signature进行校验
		$str = sha1( implode( $array ) );
		if( $str  == $signature && $echostr ){
			//第一次接入weixin api接口的时候
			echo  $echostr;
			exit;
		}else{
			$this->reponseMsg();
		}
    }


    // 接收事件推送并回复
	public function reponseMsg(){
		//1.获取到微信推送过来post数据（xml格式）
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		// var_dump($postArr);die;
		//2.处理消息类型，并设置回复类型和内容
		/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
</xml>*/
		$postObj = simplexml_load_string( $postArr );
		//$postObj->ToUserName = '';
		//$postObj->FromUserName = '';
		//$postObj->CreateTime = '';
		//$postObj->MsgType = '';
		//$postObj->Event = '';
		// gh_e79a177814ed
		//判断该数据包是否是订阅的事件推送
		if( strtolower( $postObj->MsgType) == 'event'){
			//如果是关注 subscribe 事件
			if( strtolower($postObj->Event == 'subscribe') ){
				//回复用户消息(纯文本格式)	
				$toUser   = $postObj->FromUserName;
				$fromUser = $postObj->ToUserName;
				$time     = time();
				$msgType  =  'text';
				$content  = '欢迎关注我们的微信公众账号'.$postObj->FromUserName.'-'.$postObj->ToUserName;
				$template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
				$info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
				echo $info;
/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>*/
			

			}
		}

		//当微信用户发送imooc，公众账号回复‘imooc is very good'
		/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>*/
		/*if(strtolower($postObj->MsgType) == 'text'){
			switch( trim($postObj->Content) ){
				case 1:
					$content = '您输入的数字是1';
				break;
				case 2:
					$content = '您输入的数字是2';
				break;
				case 3:
					$content = '您输入的数字是3';
				break;
				case 4:
					$content = "<a href='http://www.imooc.com'>慕课</a>";
				break;
				case '英文':
					$content = 'imooc is ok';
				break;

			}	
				$template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
//注意模板中的中括号 不能少 也不能多
				$fromUser = $postObj->ToUserName;
				$toUser   = $postObj->FromUserName; 
				$time     = time();
				// $content  = '18723180099';
				$msgType  = 'text';
				echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
		}
	}
*/
		//用户发送tuwen1关键字的时候，回复一个单图文
		if( strtolower($postObj->MsgType) == 'text' && trim($postObj->Content)=='tuwen2' ){
			$toUser = $postObj->FromUserName;
			$fromUser = $postObj->ToUserName;
			$arr = array(
				array(
					'title'=>'imooc',
					'description'=>"imooc is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.imooc.com',
				),
				array(
					'title'=>'hao123',
					'description'=>"hao123 is very cool",
					'picUrl'=>'https://www.baidu.com/img/bdlogo.png',
					'url'=>'http://www.hao123.com',
				),
				array(
					'title'=>'qq',
					'description'=>"qq is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.qq.com',
				),
			);
			$template = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>".count($arr)."</ArticleCount>
						<Articles>";
			foreach($arr as $k=>$v){
				$template .="<item>
							<Title><![CDATA[".$v['title']."]]></Title> 
							<Description><![CDATA[".$v['description']."]]></Description>
							<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
							<Url><![CDATA[".$v['url']."]]></Url>
							</item>";
			}
			
			$template .="</Articles>
						</xml> ";
			echo sprintf($template, $toUser, $fromUser, time(), 'news');

			//注意：进行多图文发送时，子图文个数不能超过10个
		}else{
			switch( trim($postObj->Content) ){
				case 1:
					$content = '您输入的数字是1';
				break;
				case 2:
					$content = '您输入的数字是2';
				break;
				case 3:
					$content = '您输入的数字是3';
				break;
				case 4:
					$content = "<a href='http://www.imooc.com'>慕课</a>";
				break;
				case '英文':
					$content = 'imooc is ok';
				break;
			}	
				$template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
//注意模板中的中括号 不能少 也不能多
				$fromUser = $postObj->ToUserName;
				$toUser   = $postObj->FromUserName; 
				$time     = time();
				// $content  = '18723180099';
				$msgType  = 'text';
				echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
		}//if end
	}//reponseMsg end

	// function http_curl(){
	// 	//获取imooc
	// 	//1.初始化curl
	// 	$ch = curl_init();
	// 	$url = 'http://www.baidu.com';
	// 	//2.设置curl的参数
	// 	curl_setopt($ch, CURLOPT_URL, $url);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 	//3.采集
	// 	$output = curl_exec($ch);
	// 	//4.关闭
	// 	curl_close($ch);
	// 	var_dump($output);
	// }

	/*$url 接口urlstring
	*$type 请求类型 string
	*$res 返回数据类型 string
	*$arr post 请求参数 string
	*/
	function http_curl($url,$type='get',$res='json',$arr=''){
		//获取imooc
		//1.初始化curl
		$ch = curl_init();
		
		//2.设置curl的参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($type == 'post') {
			# code...
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
		}
		//3.采集
		$output = curl_exec($ch);

		if ($res == 'json') {
			# code...
			return json_decode($output,true);
		}
		//4.关闭
		curl_close($ch);
		var_dump($output);
	}

	// function getWxAccessToken(){
	// 	//1.请求url地址
	// 	$appid = 'wxf53ce7de30b50d8f';
	// 	$appsecret =  '3a4805a4253481aba919a831f15fe3b8';
	// 	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
	// 	//2初始化
	// 	$ch = curl_init();
	// 	//3.设置参数
	// 	curl_setopt($ch , CURLOPT_URL, $url);
	// 	curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
	// 	//4.调用接口 
	// 	$res = curl_exec($ch);
	// 	//5.关闭curl
	// 	curl_close( $ch );
	// 	if( curl_errno($ch) ){
	// 		var_dump( curl_error($ch) );
	// 	}
	// 	$arr = json_decode($res, true);
	// 	var_dump( $arr );
	// }


	function getWxServerIp(){
		$accessToken = "6vOlKOh7r5uWk_ZPCl3DS36NEK93VIH9Q9tacreuxJ5WzcVc235w_9zONy75NoO11gC9P0o4FBVxwvDiEtsdX6ZRFR0Lfs_ymkb8Bf6kRfo";
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		echo "<pre>";
		var_dump( $arr );
		echo "</pre>";


	}

	//返回access_token *session解决方法 存mysql memcache 
	public function getWxAccessToken(){
		//将access_token 存在session/cookie中

		if ( $_SESSION['access_token'] && $_SESSION['expire_time']>time()) {
			//如果access_token 在session并没有过期
			return $_SESSION['access_token'];
		}else{
			//如果access_token不存在或者已经过期，重新取access_token
		$appid = 'wxf53ce7de30b50d8f';
		$appsecret =  '3a4805a4253481aba919a831f15fe3b8';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

		$res = $this->http_curl($url,'get','json');

		$access_token = $res['access_token'];

		//将重新获取到access_token存到session
		$_SESSION['access_token'] = $access_token;
		$_SESSION['expire_time'] = time()+7000;

		return $access_token;


		}

	}

public function definedItem(){
	//创建微信菜单
	//目前微信接口的调用方式都是通过curl post/get
	echo $access_token = $this->getWxAccessToken();
	echo '<br/>';
	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;

	$postArr = array(
		'button'=>array(

				array(
					'name'=>'菜单一',
					'type'=>'click',
					'key'=>'item1',
				),//第一个一级菜单
				array(
					'name'=>'菜单二',
					'sub_button'=>array(
						array(
							'name'=>'歌曲',
							'type'=>'click',
							'key'=>'songs',
						),//第一个二级菜单
						array(
							'name'='电影',
							'type'=>'view',
							'url'=>'http://www.baidu.com',
						),//第二个二级菜单

					),
				),//第二个一级菜单
				array(
					'name'=>'菜单三',
					'type'='view',
					'url'=>'http://www.qq.com'

				),//第三个一级菜单
			),
			
		);

	echo $postJson = json_encode( $postArr );
	$res = $this->http_curl($http_curl,'post','json',$postJson);

	var_dump($res);
}

















}

