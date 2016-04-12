<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台考勤规则控制器
 */
class AttendanceRuleController extends AdminController{
    /**
     * 考勤规则列表
     */
    public function index(){
		$uid=is_login();
		$groupid=D('User')->where("id='$uid'")->getField('group');
		if($groupid == '3'){	//获取属于同一公司的员工
			$companyid=D('User')->where("id='$uid'")->getField('companyid');
			$map['companyid']=$companyid;
			$map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceRule')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(D('User')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') //设置页面标题
                ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
                ->addTopButton('delete')  //添加删除按钮
                ->addTableColumn('id', 'ID')
                ->addTableColumn('firsttime', '上班时间')
                ->addTableColumn('secondtime', '下班时间')
                ->addTableColumn('deductmoney', '迟到早退一次扣的钱数(元)')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
                ->addRightButton('delete') //添加删除按钮
                ->display();
		}else{
		$map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('AttendanceRule')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        foreach($data_list as $key=>$val){
        	$data_list[$key]['company']=M('Company')->where("id= '$val[companyid]'")->getField('name');
        }
        $page = new \Common\Util\Page(D('User')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') //设置页面标题
//              ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->addTableColumn('id', 'ID')
				->addTableColumn('company', '公司名称')
                ->addTableColumn('firsttime', '上班时间')
                ->addTableColumn('secondtime', '下班时间')
                ->addTableColumn('deductmoney', '迟到早退一次扣的钱数(元)')
//              ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
//              ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('delete') //添加删除按钮
                ->display();
		}
        
    }

    /**
     * 新增考勤规则
     */
    public function add(){
        if(IS_POST){
            $user_object = D('AttendanceRule');
            $data = $user_object->create();
			$data['status']=1;
			$uid=is_login();
			$groupid=D('User')->where("id='$uid'")->getField('group');
			if($groupid == '3'){
				$companyid=D('User')->where("id='$uid'")->getField('companyid');
			}
			$data['companyid']=$companyid;
            if($data){
                $id = $user_object->add($data);
                if($id){
                    $this->success('新增成功', U('index'));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($user_object->getError());
            }
        }else{
            $user_object = D('AttendanceRule');
			//使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增考勤规则') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址       
                    ->addFormItem('firsttime', 'text', '上班时间', '早上9点：9')
					->addFormItem('secondtime', 'text', '下班时间', '下午6点：18')               
                    ->addFormItem('deductmoney', 'text', '扣钱', '迟到早退一次扣的钱数(元)')
                    ->display();
			
           
        }
    }

    /**
     * 编辑用户
     * @author jry <598821125@qq.com>
     */
    public function edit($id){
        //获取用户信息
        $info = D('AttendanceRule')->find($id);

        if(IS_POST){
            $user_object = D('AttendanceRule');
            if($user_object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $user_object->getError());
            }
        }else{
            $user_object = D('AttendanceRule');
            $info = $user_object->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑用户') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                   ->addFormItem('firsttime', 'text', '上班时间', '早上9点：9')
					->addFormItem('secondtime', 'text', '下班时间', '下午6点：18')               
                    ->addFormItem('deductmoney', 'text', '扣钱', '迟到早退一次扣的钱数(元)')
                    ->setFormData($info)
                    ->display();
 
            
        }
    }
}
