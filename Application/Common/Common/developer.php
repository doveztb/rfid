<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------

//开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。
/**
     * 消息类型
     */
    function leaves_type($id){
        $list[0] = '待审核';
        $list[1] = '已批准';
        $list[2] = '已拒绝';
        return $list[$id];
    }
	function export_csv($filename,$data) {
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    return $data;
}