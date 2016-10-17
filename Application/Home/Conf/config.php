<?php
return array(
	//'配置项'=>'配置值'
    'MODULE_ALLOW_LIST'    =>    array('Home','M','K__H56'), //网站首页商户后台、管理后台、微信下单页
    'DEFAULT_MODULE'       =>    'Home',

    //'APP_GROUP_LIST' => 'Home,J__D88',
    //'DEFAULT_GROUP' => 'Home',
    //'DEFAULT_MODULE' => 'Home', //默认模块
    //'DEFAULT_ACTION' => 'Index',
    'URL_CASE_INSENSITIVE' =>true, //访问action 不区分大小写

    'MULTI_MODULE'			=>	true,
    'URL_MODEL'          	=>	'2', 	//URL模式
    //'LAYOUT_ON' 			=>	true,
    //'LAYOUT_NAME' 		=>	'main',

    //基本配置
    'URL_CASE_INSENSITIVE' => true,
    'SHOW_PAGE_TRACE' => false,

    //数控信息
    'DB_TYPE'      =>  'mysql',                 // 数据库类型
    'DB_HOST'      =>  '101.200.229.148',        // 服务器地址
    'DB_NAME'      =>  'kh2',           // 数据库名
    'DB_USER'      =>  'kanghao2',                  // 用户名
    'DB_PWD'       =>  'KPzA9QYW6TUAwDJW',                // 密码
    'DB_PORT'      =>  '3306',                  // 端口
    'DB_PREFIX'    =>  'kh_',                      // 数据库表前缀
    'DB_DSN'       =>  '',                      // 数据库连接DSN 用于PDO方式
    'DB_CHARSET'   =>  'utf8mb4',                  // 数据库的编码 默认为utf8

    'SITE_URL' => 'http://haiou.maizhanghao.com',
    // 'SITE_URL' => 'http://kh2.51dangao.cn',
    /*
    mysql ip:101.200.229.148
    帐号: dazuidiancan
    密码: StLPjETE6VcEXycj
     */

    //平台服务号相关设置 [康浩家纺平台]
    'APPID' => 'wxa40cdef102e2992b',
    'APPSECRET' => 'e0251fa8d1d0af32e7a7c7b9534ce3b4',

    //平台服务号相关设置 [微信测试]
    // 'APPID' => 'wx7810e46570594762',
    // 'APPSECRET' => '31bfa6ec29692830d5733450d333a575',

    //平台对商户打款相关设置
    'QYFK_APPID' => 'wxa40cdef102e2992b', //企业付款：绑定支付的APPID
    'QYFK_MCHID' => '1293748801', //企业付款：商户号
    'QYFK_KEY' => '2axpoS1eTw2nT9lw1RZccJNedrhMMqNu', //企业付款：商户支付密钥
    'QYFK_APPSECRET' => 'e0251fa8d1d0af32e7a7c7b9534ce3b4', //企业付款：公众帐号secert

);
