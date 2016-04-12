<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台管理添加公司高层人士控制器
 */
class UserAdminController extends AdminController{
    /**
     * 用户列表
     */
    public function index(){
        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|username|email|mobile'] = array($condition, $condition, $condition, $condition,'_multi'=>true);
//		$uid=is_login();
		//var_dump($uid);die();
        //获取所有用户
        $map['status'] = array('egt', '0'); //禁用和正常状态
		 $map['group'] = 3; //禁用和正常状态
        $data_list = D('User')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('sort desc,id desc')->select();
        foreach($data_list as $key=>$val){
        	$data_list[$key]['company']=M('Company')->where("id= '$val[companyid]'")->getField('name');
        }
        $page = new \Common\Util\Page(D('User')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') //设置页面标题
                ->addTopButton('addnew')  //添加新增按钮
//              ->addTopButton('resume')  //添加启用按钮
//              ->addTopButton('forbid')  //添加禁用按钮
//              ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入ID/用户名/邮箱/手机号', U('index'))
                ->addTableColumn('id', 'UID')
//              ->addTableColumn('usertype', '类型')
                ->addTableColumn('username', '用户名')
                ->addTableColumn('email', '邮箱')
                ->addTableColumn('mobile', '手机号')
                ->addTableColumn('company', '所属公司')
//              ->addTableColumn('score', '积分')
//              ->addTableColumn('money', '余额')
                ->addTableColumn('last_login_time', '最后登录时间时间', 'time')
//              ->addTableColumn('reg_type', '注册方式')
//              ->addTableColumn('sort', '排序', 'text')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
//              ->addRightButton('forbid') //添加禁用/启用按钮
                ->addRightButton('delete',array('href'=>U('/admin/user_admin/delete/id/__data_id__/'))) //添加删除按钮
                ->display();
    }

    /**
     * 新增用户
     */
    public function add(){
        if(IS_POST){
            $user_object = D('User');
            $data = $user_object->create();
            if($data){
                $id = $user_object->add();
                if($id){
                    $this->success('新增成功', U('index'));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($user_object->getError());
            }
        }else{
            $user_object = D('User');
			
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增用户') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
//                  ->addFormItem('reg_type', 'hidden', '注册方式', '注册方式')
//                  ->addFormItem('usertype', 'radio', '用户类型', '用户类型', $user_object->user_type())
					->addFormItem('group', 'select', '权限', '系统权限', select_list_as_tree('UserGroup', null, '默认权限'))
                    ->addFormItem('companyid', 'select', '所属公司', '所属公司',$user_object->user_company())
                    ->addFormItem('username', 'text', '用户名', '用户名')
//					->addFormItem('group', 'select', '权限', '系统权限', select_list_as_tree('UserGroup', null, '默认权限'))
                    ->addFormItem('email', 'text', '邮箱', '邮箱')
                    ->addFormItem('mobile', 'text', '手机号码', '手机号码')
                    ->addFormItem('password', 'password', '密码', '密码')
                    ->addFormItem('avatar', 'picture', '用户头像', '用户头像')
//                  ->addFormItem('vip', 'radio', 'VIP等级', 'VIP等级', $user_object->user_vip_level())
                    ->setFormData(array('reg_type' => 1)) //注册方式为后台添加
                    ->display();
        }
    }

    /**
     * 编辑用户
     */
    public function edit($id){
        //获取用户信息
        $info = D('User')->find($id);

        if(IS_POST){
            $user_object = M('User');
            //不修改密码时销毁变量
            if($_POST['password'] == '' || $info['password'] == $_POST['password']){
                unset($_POST['password']);
            }else{
                $_POST['password'] = user_md5($_POST['password']);
            }
            //不允许更改超级管理员用户组
            if($_POST['id'] == 1){
                unset($_POST['group']);
            }
            if($_POST['extend']){
                $_POST['extend'] = json_encode($_POST['extend']);
            }
            if($user_object->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $user_object->getError());
            }
        }else{
            $user_object = D('User');
            $info = $user_object->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑用户') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
//                  ->addFormItem('usertype', 'radio', '用户类型', '用户类型', $user_object->user_type())
                    ->addFormItem('group', 'select', '权限', '系统权限', select_list_as_tree('UserGroup', null, '默认权限'))
                   ->addFormItem('companyid', 'select', '所属公司', '所属公司',$user_object->user_company())
				    ->addFormItem('username', 'text', '用户名', '用户名')
                    ->addFormItem('email', 'text', '邮箱', '邮箱')
                    ->addFormItem('mobile', 'text', '手机号码', '手机号码')
                    ->addFormItem('password', 'password', '密码', '密码')
                    ->addFormItem('avatar', 'picture', '用户头像', '用户头像')
//                  ->addFormItem('vip', 'radio', 'VIP等级', 'VIP等级', $user_object->user_vip_level())
                    ->setFormData($info)
                    ->display();
        }
    }

	/*
	 *删除用户 
	 */
	public function delete(){
		$map['id']=$_GET['id'];
		 $result = M('User')->where($map)->delete();
		    if($result){
		        $this->success('删除成功，不可恢复！');
		    }else{
		        $this->error('删除失败');
		    }
	}





}
