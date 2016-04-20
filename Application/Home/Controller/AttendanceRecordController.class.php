<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 后台考勤记录
 */
class AttendanceRecordController extends HomeController{
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
        $beginThismonth=mktime(0, 0, 0, $last_month, 0, $year);
//		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $today = mktime(0, 0, 0, $month, 0, $year); 
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
     * 个人详情
     */
    public function userinfo(){
        $uid=is_login();
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
			$map['uid']=$uid;	
			$map1['ctime'] = array(
                array('egt', $day),
                array('lt', $day_after)
            );
//			$map1['isearly']=1;	//早退
			$map1['uid']=$uid;
            $user_reg_date[] = date('m月d日', $day);
            $islatecount[] = (int)$user_object->where($map)->getField('secondtime');	//晚上签到时间
			$isearly[] = (int)$user_object->where($map1)->getField('firsttime');	//早上签到 时间
        }
        $this->assign('user_reg_date',json_encode($user_reg_date));
        $this->assign('islatecount', json_encode($islatecount));
		$this->assign('isearly',json_encode($isearly));
        $this->assign('meta_title', "个人考勤");
        $this->display('');		
    }




//<script type="text/javascript">
// setTimeout("document.getElementById('p1').value='2'",1000);
// self.setInterval('window.document.location.href="http://10.0.0.30/rfid/index.php?s=home/attendance_record/test"',10000);
//</script>


     /**
     * ce shi 
     */
    public function test(){
            $user_object = M('Test');
            $data['name']="dqadewq";
            $id = $user_object->add($data);
            if($id){
                    $this->success('新增成功','http://www.yii.com/index.php?r=site%2Fabout');
                }else{
                    $this->error('新增失败');
                
        }
    }






	
}
