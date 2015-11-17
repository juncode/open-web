<?php

return array(
    //'配置项'=>'配置值'
    'APP_GROUP_LIST' => 'Home,Admin,Demo',
    'DEFAULT_GROUP' => 'Home',
    'APP_SUB_DOMAIN_DEPLOY' => 1, // 开启子域名配置
    /* 子域名配置 
     * 格式如: '子域名'=>array('分组名/[模块名]','var1=a&var2=b'); 
     */
    'APP_SUB_DOMAIN_RULES' => array(
        'www' => array('Home/'),
        'admin' => array('Admin/'), // admin域名指向Admin分组
        'demo' => array('Demo/'),
    ),
    'DB_LAGOU' =>array(
        'DB_TYPE'   => 'mysql',
        'DB_HOST'   => '127.0.0.1',
        'DB_NAME'   => 'lagou',
        'DB_USER'   => 'root',
        'DB_PWD'    => 'root',
        'DB_PORT'   => '3306',
        'DB_PREFIX' => 'la_',
    ),
);
