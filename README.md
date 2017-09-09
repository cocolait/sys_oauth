# sys_auth
thinkphp 3 第三方登录扩展包包含（QQ,新浪，微信）

# 安装
> 确保已经安装composer 否则无法执行
```php
composer require cocolait/sys_oauth
```

# 示列

#配置信息
```php
config.php
<?php
//定义回调URL通用的URL
define('URL_CALLBACK', 'http://' . $_SERVER['HTTP_HOST'] . '/index.php/Api/Oauth/callback/type/');
return [
    //腾讯QQ登录配置
    'SYA_AUTH_QQ'      => [
        'APP_KEY'       => '', //应用注册成功后分配的 APP ID
        'APP_SECRET'    => '',  //应用注册成功后分配的KEY
        'CALLBACK'      => '', // 应用回调地址
    ],
    //新浪微博配置
    'SYA_AUTH_SINA'    => [
        'APP_KEY'       => '', //应用注册成功后分配的 APP ID
        'APP_SECRET'    => '', //应用注册成功后分配的KEY
        'CALLBACK'      => '', // 应用回调地址
    ],
    //微信登录
    'SYA_AUTH_WEIXIN' => [
        'APP_KEY' => '',//应用注册成功后分配的 APP ID
        'APP_SECRET' => '',//应用注册成功后分配的KEY
        'CALLBACK' => "http://" . $_SERVER['HTTP_HOST'] . "/users/oauth/callback/type/weixin",//应用回调地址
    ]
);
```

# 示列
>thinkPHP 3.2.3 为例
```php
namespace Home\Controller;
use Think\Controller;
class OauthController extends Controller {
	//登录地址
	public function login($type = null){
		empty($type) && $this->error('参数错误');
		$_SESSION['login_http_referer']=$_SERVER["HTTP_REFERER"];
		$sns  = \Cp\Sys\Oauth::getInstance($type);
		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}

	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type)) && $this->error('参数错误');

		if(empty($code)){
			redirect(__ROOT__."/");
		}

		$sns  = \Cp\Sys\Oauth::getInstance($type);
		$extend = null;
        // 获取TOKEN
		$token = $sns->getAccessToken($code , $extend);

		//获取当前第三方登录用户信息
		if(is_array($token)){
			$user_info = \Cp\Sys\GetInfo::getInstance($type,$token);
			var_dump($user_info);
		}else{
            echo "获取基本信息失败";
		}
	}
}
```
