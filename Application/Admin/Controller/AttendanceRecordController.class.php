<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台考勤记录
 */
class AttendanceRecordController extends AdminController{
    /**
     * 本月统计
     */
    public function index(){
    	$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group =='3'){
		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		//计算统计图日期
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('AttendanceRecord');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map['islate']=1;	//迟到
			$map['companyid']=$companyid;	//公司
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map1['isearly']=1;	//早退
			$map1['companyid']=$companyid;	//公司
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->count();	//迟到
			$isearly[] = (int)$user_object->where($map1)->count();	//早退
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "当月考勤");
		$this->assign('group',$group);
        $this->display('');
		}else{
		$companyid=I('companyid');
		$company_object=M('Company')->select();
		//计算统计图日期
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('AttendanceRecord');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map['islate']=1;	//迟到
			$map['companyid']=$companyid;	//公司
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map1['isearly']=1;	//早退
			$map1['companyid']=$companyid;	//公司
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->count();	//迟到
			$isearly[] = (int)$user_object->where($map1)->count();	//早退
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "当月考勤");
		$this->assign('group',$group);
		$this->assign('company_object',$company_object);
        $this->display('');
		}

    }

    /**
     * 上月考勤
     */
    public function last(){
          	$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group =='3'){
		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		//计算统计图日期
		$month = date('m');
		$year = date('Y');
		$last_month = date('m') - 1;
		if($month == 1){
 			$last_month = 12;
			$year = $year - 1;
		}
        $beginThismonth=mktime(23, 59, 59, $last_month, 0, $year);
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = mktime(0, 0, 0, $month, 0, $year); 
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('AttendanceRecord');
        for($i = 1; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map['islate']=1;	//迟到
			$map['companyid']=$companyid;	//公司
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map1['isearly']=1;	//早退
			$map1['companyid']=$companyid;	//公司
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->count();	//迟到
			$isearly[] = (int)$user_object->where($map1)->count();	//早退
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "当月考勤");
		$this->assign('group',$group);
        $this->display('');
		}else{
		$companyid=I('companyid');
		$company_object=M('Company')->select();
		//计算统计图日期
       $month = date('m');
		$year = date('Y');
		$last_month = date('m') - 1;
		if($month == 1){
 			$last_month = 12;
			$year = $year - 1;
		}
        $beginThismonth=mktime(0, 0, 0, $last_month, 0, $year);
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = mktime(0, 0, 0, $month, 0, $year); 
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('AttendanceRecord');
        for($i = 1; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map['islate']=1;	//迟到
			$map['companyid']=$companyid;	//公司
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
			$map1['isearly']=1;	//早退
			$map1['companyid']=$companyid;	//公司
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->count();	//迟到
			$isearly[] = (int)$user_object->where($map1)->count();	//早退
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "当月考勤");
		$this->assign('group',$group);
		$this->assign('company_object',$company_object);
        $this->display('');
		}
    }
	
	 /**
     * 个人详情
     */
    public function userinfo(){
//      $uid=is_login();
		$keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
//      $map['id|username|email|mobile'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
//		$group=D('User')->where("id='$uid'")->getField('group');
//		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		//计算统计图日期
		  $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $count_day  = ($end_date-$start_date)/86400; //查询最近n天
        $user_object = D('AttendanceRecord');
        for($i = 0; $i < $count_day; $i++){
            $day = $start_date + $i*86400; //第n天日期
            $day_after = $start_date + ($i+1)*86400; //第n+1天日期
            $map['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
//			$map['islate']=1;	//迟到
			$map['uid']=$condition;	
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
//			$map1['isearly']=1;	//早退
			$map1['uid']=$condition;
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->getField('secondtime');	//晚上签到时间
			$isearly[] = (int)$user_object->where($map1)->getField('firsttime');	//早上签到 时间
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "当月考勤");
        $this->display('');		
    }
	
	/**
     * 个人详情列表
     */
    public function userlist(){
    	$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group =='3'){
		$companyid=D('User')->where("id='$uid'")->getField('companyid');
		//计算统计图日期
		$keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['uid'] = $condition;
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $user_object = D('AttendanceRecord');
        $map['ctime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
        );
		$map['companyid']=$companyid;
		$map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceRecord')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        foreach($data_list as $key=>$value){
			$data_list[$key]['companyid']=M('Company')->where("id= '$value[companyid]'")->getField('name');
		}
        $page = new \Common\Util\Page(D('AttendanceRecord')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		  //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('考勤报表') //设置页面标题
//              ->addTopButton('self',array('title'=>'导出excel','href'=>''))  //添加新增按钮
//              ->addTopButton('edit')  //添加启用按钮
                ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入用户id', U(''))
                ->addTableColumn('id', 'id')
                ->addTableColumn('uid', '用户id')
                ->addTableColumn('companyid', '公司id')
                ->addTableColumn('firsttime', '早上签到','time')
                ->addTableColumn('secondtime', '晚上签到','time')
                ->addTableColumn('islate', '是否迟到')
                ->addTableColumn('isearly', '是否早退')
				 ->addTableColumn('ctime', '日期','date')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
                ->addRightButton('forbid') //添加禁用/启用按钮
                ->addRightButton('delete') //添加删除按钮
                ->display();
                }else{
                $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['uid'] = $condition;
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = strtotime(date('Y-m-d', time())); //今天
        $start_date = $beginThismonth;
        $end_date   = $today+86400;
        $user_object = D('AttendanceRecord');
        $map['ctime'] = array(
                array('egt', $start_date),
                array('lt', $end_date)
        );
		$map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceRecord')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        foreach($data_list as $key=>$value){
			$data_list[$key]['companyid']=M('Company')->where("id= '$value[companyid]'")->getField('name');
		}
        $page = new \Common\Util\Page(D('AttendanceRecord')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		  //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('考勤报表') //设置页面标题
//              ->addTopButton('self',array('title'=>'导出excel','href'=>''))  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
                ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入用户id', U(''))
                ->addTableColumn('id', 'id')
                ->addTableColumn('uid', '用户id')
                ->addTableColumn('companyid', '公司id')
                ->addTableColumn('firsttime', '早上签到','time')
                ->addTableColumn('secondtime', '晚上签到','time')
                ->addTableColumn('islate', '是否迟到')
                ->addTableColumn('isearly', '是否早退')
				 ->addTableColumn('ctime', '日期','date')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
                ->addRightButton('forbid') //添加禁用/启用按钮
                ->addRightButton('delete') //添加删除按钮
                ->display();	
           }
		
    }


	  public function edit($id){
        //获取用户信息
        $info = D('AttendanceRecord')->find($id);

        if(IS_POST){
            $user_object = D('AttendanceRecord');
            //不修改密码时销毁变量
            $_POST['firsttime']=strtotime($_POST['firsttime']);
			$_POST['secondtime']=strtotime($_POST['secondtime']);
            if($user_object->save($_POST)){
                $this->success('更新成功', U('userlist'));
            }else{
                $this->error('更新失败', $user_object->getError());
            }
        }else{
            $user_object = D('AttendanceRecord');
            $info = $user_object->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('uid', 'text', '用户id', '用户id')
                    ->addFormItem('firsttime', 'time', '上班签到时间', '上班签到时间')
                    ->addFormItem('secondtime', 'time', '下班签到时间', '下班签到')
                    ->addFormItem('islate', 'num', '是否迟到', '1迟到 0没有')
                    ->addFormItem('isearly', 'text', '是否 早退', '1早退 0 没有')
                    ->setFormData($info)
                    ->display();
        }
    }
	



}
