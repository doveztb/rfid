<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 请假控制器
 */
class LeavesController extends HomeController{

    public function add(){
    	 if(IS_POST){
            $user_object = D('Leaves');
			$data=$_POST;
			$uid=is_login();
			$data['uid']=$uid;
			$companyid=D('User')->where("id='$uid'")->getField('companyid');
			$to_uid=D('User')->where(array('companyid'=>$companyid,'group'=>3))->getField('id');
			$data['status']=1;
			$data['ctime']=time();
			$data['to_uid']=$to_uid;
			$data['companyid']=$companyid;
			$data['timestart']=strtotime($_POST['timestart']);
			$data['timeend']=strtotime($_POST['timeend']);
			$data = $user_object->create($data);
           if($data){
                $id = $user_object->add($data);
                if($id){
                    $this->success('新增成功', U('add'));
                }else{
                    $this->error('新增失败');
                }
				}else{
					$this->error($user_object->getError());
				}
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('请假')  //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
//                  ->addFormItem('to_uid', 'text', '上级','上级')
                    ->addFormItem('title', 'text', '标题', '标题')
                    ->addFormItem('timestart', 'date', '开始时间', '结束时间')
                    ->addFormItem('timeend', 'date', '结束时间', '结束时间')
                    ->addFormItem('days', 'num', '请假天数', '天数')
                    ->setTemplate('_Builder/formbuilder_user')
                    ->display();
        }
    }
	 public function index(){
    
		$uid=is_login();
		$map['uid']=$uid;
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Leaves')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('User')->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		foreach($data_list as $key=>$value){
			switch ($value['result'])
				{
				case 1:
				  $data_list[$key]['result']='同意';
				  break;
				case 2:
				  $data_list[$key]['result']='拒绝';
				  break;
				default:
				  $data_list[$key]['result']='正在审核中';
				}
		}
        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') //设置页面标题
                ->addTopButton('self',array('title'=>'请假记录'))  //添加新增按钮
                ->addTableColumn('id', 'ID')
//              ->addTableColumn('usertype', '类型')
//              ->addTableColumn('uid', '用户id')
				->addTableColumn('title', '标题')
                ->addTableColumn('timestart', '开始时间','time')
                ->addTableColumn('timeend', '结束时间','time')
				->addTableColumn('days', '请假天数')
//				->addTableColumn('dept', '部门')
//              ->addTableColumn('vip', 'VIP')
//              ->addTableColumn('score', '积分')
//              ->addTableColumn('money', '余额')
                ->addTableColumn('result', '结果')
//              ->addTableColumn('reg_type', '注册方式')
                ->addTableColumn('status', '状态', 'status')
//              ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->setTemplate('_Builder/listbuilder_user')
//              ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
    }
}
