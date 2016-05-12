<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 请假控制器
 */
class LeavesController extends AdminController{

    /**
     * 默认方法
     */
    public function index(){
        //搜索
        $uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group == '3'){
			$companyid=D('User')->where("id='$uid'")->getField('companyid');
			$map['companyid']=$companyid;
		}
		$map['result']='0';
        //获取所有消息
        $map['status'] = array('egt', '0'); //禁用和正常状态
//      $map['from_uid|to_uid']=$uid;
        $data_list = D('Leaves')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))
                                     ->order('ctime desc')
                                     ->where($map)
                                     ->select();
		foreach($data_list as $key=>$val){
			$data_list[$key]['result']=leaves_type($val['result']);
			$data_list[$key]['username']=D('User')->where("id='$val[uid]'")->getField('username');
		}						
        $page = new \Common\Util\Page(D('Leaves')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('请假列表') //设置页面标题
//              ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
//              ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('uid', '用户id')
				->addTableColumn('username', '用户姓名')
                ->addTableColumn('title', '事由')
                ->addTableColumn('timestart', '开始时间', 'time')
                ->addTableColumn('timeend', '结束时间','time')
                ->addTableColumn('days', '天数')
				->addTableColumn('result', '状态')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
    }

    /**
     * 新增消息
     */
    public function add(){
    	$user_message_object = D('UserMessage');
		$uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
//		$companyid=D('User')->where("id='$uid'")->getField('companyid');
//		$map1['companyid']=$companyid;
//		$map1['group']='0';
//		$to_uid=D('User')->where($map1)->getField('id',true);
//		$map2['id']=array('in',$to_uid);
//		$info=D('User')->where($map2)->select();
//		var_dump($info);die();
        if(IS_POST){
            $user_message_object = D('UserMessage');
			$data=$_POST;
			if($group == '3'){
				$data['from_uid']=$uid;
			if($_POST['to_all'] =='1'){
				$companyid=D('User')->where("id='$uid'")->getField('companyid');
				$map1['companyid']=$companyid;
				$map1['group']='0';
				$to_uid=D('User')->where($map1)->getField('id',true);
//				$data['to_uid']=$to_uid;
				foreach($to_uid as $key=>$val){
					$data['to_uid']=$val;
					$result = $user_message_object->sendMessage($data);
				}
				
			}else{
				$result = $user_message_object->sendMessage($data);
			}
            
            if($result){
//          	var_dump($data);die();
                 $this->success('发送消息成功', U('index'));
            }else{
                $this->error('发送消息失败'.$user_message_object->getError());
            }
		}else{
			$data['from_uid']=$uid;
			if($_POST['to_all'] =='1'){
				$map['id']  = array('gt',1);
				$to_uid=D('User')->where($map)->getField('id',true);				
//				$data['to_uid']=$to_uid;
				foreach($to_uid as $key=>$val){
					$data['to_uid']=$val;
					$result = $user_message_object->sendMessage($data);
				}
				
			}else{
				$result = $user_message_object->sendMessage($data);
			}
            
            if($result){
//          	var_dump($data);die();
                 $this->success('发送消息成功', U('index'));
            }else{
                $this->error('发送消息失败'.$user_message_object->getError());
            }
		}
			
        }else{
        	if($group == '3'){
        		//使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增消息') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('type', 'select', '消息类型', '系统消息、评论消息、私信消息',$user_message_object->message_type())
                    ->addFormItem('to_all', 'radio', '所有人', '请选择是或不是',array('1'=>'是','2'=>'不是'))
                    ->addFormItem('to_uid', 'num', '消息收信用户', '若是系统消息不用填写')
                    ->addFormItem('title', 'textarea', '消息标题', '消息标题')
                    ->addFormItem('content', 'kindeditor', '消息内容', '消息内容')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        	}else{
        		//使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增消息') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('type', 'select', '消息类型', '系统消息、评论消息、私信消息',$user_message_object->message_type())
                    ->addFormItem('to_all', 'radio', '所有人', '请选择是或不是',array('1'=>'是','2'=>'不是'))
                    ->addFormItem('to_uid', 'num', '消息收信用户', '填写接收人id（所有人选择是则不用填写）')
                    ->addFormItem('title', 'textarea', '消息标题', '消息标题')
                    ->addFormItem('content', 'kindeditor', '消息内容', '消息内容')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        	}
            
        }
    }

    /**
     * 同意1 拒绝2
     */
    public function edit($id){
        if(IS_POST){
            $user_message_object = D('Leaves');
            $data = $user_message_object->create();
			$data['timestart']=strtotime($_POST['timestart']);
			$data['timeend']=strtotime($_POST['timeend']);
            if($data){
                if($user_message_object->save($data)!== false){
                	$data1['to_uid']=$_POST['uid'];
                	$data1['from_uid']=$_POST['to_uid'];
                	$data1['type']=0;
					$data1['title']=($_POST['result']=='1')?'已同意请假申请':'拒绝了你的请假申请';
                	$data1['content']=$_POST['ext'];
                	$data1['type']=0;
					$result = D('UserMessage')->sendMessage($data1);
					
					if($_POST['result'] == '1'){
						$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
						$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
						$map1['uid']=$_POST['uid'];
						$map1['createtime']=array(array('gt',$beginThismonth),array('lt',$endThismonth));
						$result_month=D('AttendanceMonth')->where($map1)->find();			
						if($result_month){
							//update
							$AttendanceMonth = D('AttendanceMonth'); // 
							// 要修改的数据对象属性赋值
							$data2= $_POST['days'];
//									$data['email'] = 'ThinkPHP@gmail.com';
							$map2['id']=$result_month['id'];
							$s=$AttendanceMonth->where($map2)->setInc('leavedays',$data2); // 根据条件更新记录
						}else{
							//add
							$AttendanceMonth = D('AttendanceMonth'); 
							// 要修改的数据对象属性赋值
							$data3['leavedays'] = $_POST['days'];
							$data3['uid'] = $_POST['uid'];
							$data3['createtime'] = time();
							$data3['status'] = 1;
							$data3['companyid'] = $_POST['companyid'];
							$c=$AttendanceMonth->data($data3)->add(); // 添加
						}
						}
                    $this->success('更新成功', U('index'));
                }else{
                    $this->error('更新失败');
                }
            }else{
                $this->error($user_message_object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('审核') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
					->addFormItem('companyid', 'hidden', 'ID', 'ID')
					->addFormItem('uid', 'num', '请假人', '请假人')
                    ->addFormItem('title', 'text', '请假原因', '请假原因')
                    ->addFormItem('timestart', 'time', '开始时间', '开始时间')
                    ->addFormItem('timeend', 'time', '结束时间', '结束时间')
					->addFormItem('days', 'num', '请假天数', '天')
                    ->addFormItem('result', 'radio', '是否同意', '选择同意或不同意',array('1'=>'同意','2'=>'拒绝'))
                    ->addFormItem('ext', 'textarea', '备注', '备注')
                    ->setFormData(D('Leaves')->find($id))
                    ->display();
        }
    }

  public function agree(){
        //搜索
        $uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group == '3'){
			$companyid=D('User')->where("id='$uid'")->getField('companyid');
			$map['companyid']=$companyid;
		}
		$map['result']='1';
        //获取所有消息
        $map['status'] = array('egt', '0'); //禁用和正常状态
//      $map['from_uid|to_uid']=$uid;
        $data_list = D('Leaves')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))
                                     ->order('ctime desc')
                                     ->where($map)
                                     ->select();
       if(isset($data_list)){
			foreach($data_list as $key=>$val){
			$data_list[$key][result]=leaves_type($val['result']);
				$data_list[$key]['username']=D('User')->where("id='$val[uid]'")->getField('username');
		}
		}	
        $page = new \Common\Util\Page(D('Leaves')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('请假列表') //设置页面标题
//              ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
//              ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('uid', '用户id')
				->addTableColumn('username', '用户姓名')
                ->addTableColumn('title', '事由')
                ->addTableColumn('timestart', '开始时间', 'time')
                ->addTableColumn('timeend', '结束时间','time')
                ->addTableColumn('days', '天数')
				->addTableColumn('result', '状态')
//              ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
//              ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
    }


public function refuse(){
        //搜索
        $uid=is_login();
		$group=D('User')->where("id='$uid'")->getField('group');
		if($group == '3'){
			$companyid=D('User')->where("id='$uid'")->getField('companyid');
			$map['companyid']=$companyid;
		}
		$map['result']='2';
        //获取所有消息
        $map['status'] = array('egt', '0'); //禁用和正常状态
//      $map['from_uid|to_uid']=$uid;
        $data_list = D('Leaves')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))
                                     ->order('ctime desc')
                                     ->where($map)
                                     ->select();
       if(isset($data_list)){
			foreach($data_list as $key=>$val){
			$data_list[$key][result]=leaves_type($val['result']);
				$data_list[$key]['username']=D('User')->where("id='$val[uid]'")->getField('username');
		}
		}	
        $page = new \Common\Util\Page(D('Leaves')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('请假列表') //设置页面标题
//              ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
//              ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('uid', '用户id')
				->addTableColumn('username', '用户姓名')
                ->addTableColumn('title', '事由')
                ->addTableColumn('timestart', '开始时间', 'time')
                ->addTableColumn('timeend', '结束时间','time')
                ->addTableColumn('days', '天数')
				->addTableColumn('result', '状态')
//              ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
//              ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
    }
















}
