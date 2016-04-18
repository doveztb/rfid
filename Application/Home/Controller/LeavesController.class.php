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
			$data['status']=1;
			$data['ctime']=time();
			$data['companyid']=$companyid;
			$data['timestart']=strtotime($_POST['timestart']);
			$data['timeend']=strtotime($_POST['timeend']);
            $result = $user_object->add($data);
            if($result){
                $this->success('请假成功');
            }else{
                $this->error($user_object->getError());
            }
        }else{
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('请假')  //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('to_uid', 'text', '上级','上级')
                    ->addFormItem('title', 'text', '标题', '标题')
                    ->addFormItem('timestart', 'date', '开始时间', '结束时间')
                    ->addFormItem('timeend', 'date', '结束时间', '结束时间')
                    ->addFormItem('days', 'num', '请假天数', '天数')
                    ->setTemplate('_Builder/formbuilder_user')
                    ->display();
        }
    }

}
