<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------

/**
 * 系统环境检测
 * @return array 系统环境数据
 * @author jry <598821125@qq.com>
 */
function check_env(){
    $items = array(
        'os' => array(
            'title'   => '操作系统',
            'limit'   => '不限制',
            'current' => PHP_OS,
            'icon'    => 'glyphicon-ok text-success',
        ),
        'php' => array(
            'title'   => 'PHP版本',
            'limit'   => '5.3+',
            'current' => PHP_VERSION,
            'icon'    => 'glyphicon-ok text-success',
        ),
        'upload' => array(
            'title'   => '附件上传',
            'limit'   => '不限制',
            'current' => ini_get('file_uploads') ? ini_get('upload_max_filesize'):'未知',
            'icon'    => 'glyphicon-ok text-success',
        ),
        'gd' => array(
            'title'   => 'GD库',
            'limit'   => '2.0+',
            'current' => '未知',
            'icon'    => 'glyphicon-ok text-success',
        ),
        'disk' => array(
            'title'   => '磁盘空间',
            'limit'   => '100M+',
            'current' => '未知',
            'icon'    => 'glyphicon-ok text-success',
        ),
    );

    //PHP环境检测
    if($items['php']['current'] < 5.3){
        $items['php']['icon'] = 'glyphicon-remove text-danger';
        session('error', true);
    }

    //GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if(!$tmp['GD Version']){
        $items['gd']['current'] = '未安装';
        $items['gd']['icon'] = 'glyphicon-remove text-danger';
        session('error', true);
    }else{
        $items['gd']['current'] = $tmp['GD Version'];
    }
    unset($tmp);

    //磁盘空间检测
    if(function_exists('disk_free_space')){
        $disk_size = floor(disk_free_space('./') / (1024*1024)).'M';
        $items['disk']['current'] = $disk_size.'MB';
        if($disk_size < 100){
            $items['disk']['icon'] = 'glyphicon-remove text-danger';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 * @author jry <598821125@qq.com>
 */
function check_dirfile(){
    $items = array(
        '0' => array(
            'type'  => 'file',
            'path'  => APP_PATH . 'Common/Conf/db.php',
            'title' => '可写',
            'icon'  => 'glyphicon-ok text-success',
        ),
        '1' => array(
            'type'  => 'dir',
            'path'  => APP_PATH . 'Common/Conf',
            'title' => '可写',
            'icon'  => 'glyphicon-ok text-success',
        ),
        '2' => array(
            'type'  => 'dir',
            'path'  => RUNTIME_PATH,
            'title' => '可写',
            'icon'  => 'glyphicon-ok text-success',
        ),
        '3' => array(
            'type'  => 'dir',
            'path'  => './Uploads',
            'title' => '可写',
            'icon'  => 'glyphicon-ok text-success',
        ),
    );

    foreach ($items as &$val){
        $path = $val['path'];
        if('dir' === $val['type']){
            if(!is_writable($path)){
                if(is_dir($path)) {
                    $val['title'] = '不可写';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }else{
                    $val['title'] = '不存在';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }
            }
        }else{
            if(file_exists($path)){
                if(!is_writable($path)){
                    $val['title'] = '不可写';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }
            }else{
                if(!is_writable(dirname($path))){
                    $val['title'] = '不存在';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }
            }
        }
    }
    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func_and_ext(){
    $items = array(
        '0' => array(
            'type'    => 'ext',
            'name'    => 'pdo',
            'title'   => '支持',
            'current' =>  extension_loaded('pdo'),
            'icon'    => 'glyphicon-ok text-success',
        ),
        '1' => array(
            'type'    => 'ext',
            'name'    => 'pdo_mysql',
            'title'   => '支持',
            'current' =>  extension_loaded('pdo_mysql'),
            'icon'    => 'glyphicon-ok text-success',
        ),
        '2' => array(
            'type'    => 'func',
            'name'    => 'file_get_contents',
            'title'   => '支持',
            'icon'    => 'glyphicon-ok text-success',
        ),
        '3' => array(
            'type'    => 'func',
            'name'    => 'mb_strlen',
            'title'   => '支持',
            'icon'    => 'glyphicon-ok text-success',
        ),
    );
    foreach($items as &$val){
        switch($val['type']){
            case 'ext':
                if(!$val['current']){
                    $val['title'] = '不支持';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }
                break;
            case 'func':
                if(!function_exists($val['name'])){
                    $val['title'] = '不支持';
                    $val['icon'] = 'glyphicon-remove text-danger';
                    session('error', true);
                }
                break;
        }
    }

    return $items;
}

/**
 * 创建数据表
 * @param  resource $db 数据库连接资源
 */
function create_tables($db, $prefix = ''){
    //读取SQL文件
    $sql = file_get_contents(MODULE_PATH . 'Data/install.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    //替换表前缀
    $orginal = C('ORIGINAL_TABLE_PREFIX');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    //开始安装
    show_msg('开始安装数据库...');
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "创建数据表{$name}";
            if(false !== $db->execute($value)){
                show_msg($msg . '...成功');
            } else {
                show_msg($msg . '...失败！', 'error');
                session('error', true);
            }
        } else {
            $db->execute($value);
        }
    }
}

/**
 * 写入配置文件
 * @param  array $config 配置信息
 */
function write_config($config, $auth){
    if(is_array($config)){
        //读取配置内容
        $conf = file_get_contents(MODULE_PATH . 'Data/config.tpl');
        //替换配置项
        foreach ($config as $name => $value) {
            $conf = str_replace("[{$name}]", $value, $conf);
        }
        $conf = str_replace('[AUTH_KEY]', $auth, $conf);
        //写入应用配置文件

        if(file_put_contents(APP_PATH . 'Common/Conf/db.php', $conf)){
            show_msg('配置文件写入成功');
        }else{
            show_msg('配置文件写入失败！', 'error');
            session('error', true);
        }
        return true;
    }
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = ''){
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}
