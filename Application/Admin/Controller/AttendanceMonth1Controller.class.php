<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 考勤月记录
 */
class AttendanceMonth1Controller extends AdminController{
    /**
     */
    public function index(){
    	$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group== 3){
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['uid'] = $condition;
		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		$map['companyid']=$companyid;
		//当月时间
		 $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
		$map['createtime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
            );
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceMonth')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        foreach($data_list as $key=>$value){
			$data_list[$key]['username']=M('User')->where("id= '$value[uid]'")->getField('username');
		}
        $page = new \Common\Util\Page(D('AttendanceMonth')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('考勤报表') //设置页面标题
                ->addTopButton('self',array('title'=>'导出csv','href'=>U('out_csv')))  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入用户id', U('index'))
                ->addTableColumn('id', 'id')
                ->addTableColumn('uid', '用户id')
				->addTableColumn('username', '用户姓名')
                ->addTableColumn('latetimes', '迟到次数')
                ->addTableColumn('earlytimes', '早退次数')
                ->addTableColumn('deductmoney', '罚款')
                ->addTableColumn('leavedays', '请假天数')
                ->addTableColumn('createtime', '月份', 'date')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
			
		}else{
			        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id'] = $condition;
		//上月时间
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
		$map1['createtime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
            );
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = M('Company')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(M('Company')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		foreach($data_list as $key=>$val){
			$map1['companyid']=$val['id'];
			$data_list[$key]['usercount']=D('User')->where("companyid='$val[id]'")->count();
			$data_list[$key]['latetimes']=D('AttendanceMonth')->where($map1)->sum('latetimes');
			$data_list[$key]['earlytimes']=D('AttendanceMonth')->where($map1)->sum('earlytimes');
			$data_list[$key]['latetimes_user']=$data_list[$key]['latetimes']/$data_list[$key]['usercount'];
			$data_list[$key]['earlytimes_user']=$data_list[$key]['earlytimes']/$data_list[$key]['usercount'];
		}
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('考勤报表') //设置页面标题
                ->addTopButton('self',array('title'=>'导出csv','href'=>U('out_csv')))  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入公司id', U('index'))
                ->addTableColumn('id', '公司id')
                ->addTableColumn('name', '公司名称')
                ->addTableColumn('usercount', '公司人数')
                ->addTableColumn('latetimes', '迟到 总次数')
                ->addTableColumn('earlytimes', '早退总次数')
				->addTableColumn('latetimes_user', '人均迟到 次数')
                ->addTableColumn('earlytimes_user', '人均早退次数')
                ->addTableColumn('status', '状态', 'status')
//              ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
//              ->addRightButton('forbid') //添加禁用/启用按钮
                ->display();
		}
    }

  
    public function edit($id){
        //获取用户信息
        $info = D('AttendanceMonth')->find($id);

        if(IS_POST){
            $user_object = D('AttendanceMonth');
            //不修改密码时销毁变量
            $data = $user_object->create();
            if($data){
                if($user_object->save()!== false){
                    $this->success('更新成功', U('index'));
                }else{
                    $this->error('更新失败');
                }
            }else{
                $this->error($user_object->getError());
            }
        }else{
            $user_object = D('AttendanceMonth');
            $info = $user_object->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('uid', 'text', '用户id', '用户id')
                    ->addFormItem('latetimes', 'num', '迟到次数', '不能超过30次')
                    ->addFormItem('earlytimes', 'num', '早退次数', '不能超过30次')
                    ->addFormItem('deductmoney', 'num', '罚款', '不能超过300元')
                    ->addFormItem('leavedays', 'num', '请假天数', '不能超过30天')
                    ->setFormData($info)
                    ->display();
        }
    }

 	public function out_csv(){
    	$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group == 3){
			 $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['uid'] = $condition;
		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		$map['companyid']=$companyid;
		//当月时间
		 $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
		$map['createtime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
            );
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceMonth')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id asc')->select();
        foreach($data_list as $key=>$value){
        	$data[$key]['id']=$value['id'];
			$data[$key]['username']=M('User')->where("id= '$value[uid]'")->getField('username');
			$data[$key]['latetimes']=$value['latetimes'];
			$data[$key]['earlytimes']=$value['earlytimes'];
			$data[$key]['deductmoney']=$value['deductmoney'];
			$data[$key]['leavedays']=$value['leavedays'];
		}
//		var_dump($data);die();
		$csv=new \Think\Csv();
        $csv_title=array('编号','姓名','迟到次数','早退次数','罚款','请假天数');
        $csv->put_csv($data,$csv_title);
		}else{
			$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
		$map1['createtime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
            );
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = M('Company')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
		foreach($data_list as $key=>$val){
			$map1['companyid']=$val['id'];
			$data[$key]['name']=$val['name'];
			$data[$key]['usercount']=D('User')->where("companyid='$val[id]'")->count();
			$data[$key]['latetimes']=D('AttendanceMonth')->where($map1)->sum('latetimes');
			$data[$key]['earlytimes']=D('AttendanceMonth')->where($map1)->sum('earlytimes');
			$data[$key]['latetimes_user']=$data_list[$key]['latetimes']/$data_list[$key]['usercount'];
			$data[$key]['earlytimes_user']=$data_list[$key]['earlytimes']/$data_list[$key]['usercount'];
		}
		
		$csv=new \Think\Csv();
        $csv_title=array('公司名称','公司人数','迟到总次数','早退总次数','人均迟到次数','人均早退次数');
        $csv->put_csv($data,$csv_title);						
		}
       
    }
	
	


}
