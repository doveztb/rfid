<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台公司控制器
 */
class CompanyController extends AdminController{
    /**
     * 公司列表
     */
    public function index(){
        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|name'] = array($condition, $condition,'_multi'=>true);
//		$uid=is_login();
		//var_dump($uid);die();
        //获取所有公司
        $map['status'] = array('egt', '0'); //禁用和正常状态
		 //$map['group'] = 3; //禁用和正常状态
        $data_list = M('Company')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))->where($map)->order('id desc')->select();
        $page = new \Common\Util\Page(M('Company')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('公司列表') //设置页面标题
                ->addTopButton('addnew')  //添加新增按钮
                ->addTopButton('resume')  //添加启用按钮
                ->addTopButton('forbid')  //添加禁用按钮
                ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入ID/公司名称', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('name', '公司名称')
                ->addTableColumn('address', '公司地址')
                ->addTableColumn('tel', '电话')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list) //数据列表
                ->setTableDataPage($page->show()) //数据列表分页
                ->addRightButton('edit')   //添加编辑按钮
                ->addRightButton('forbid') //添加禁用/启用按钮
                ->addRightButton('delete') //添加删除按钮
                ->display();
    }

    /**
     * 新增公司
     */
    public function add(){
        if(IS_POST){
            $company_object  = D('Company');
            $data = $company_object ->create();
            if($data){
                $id = $company_object ->add();
                if($id){
                    $this->success('新增成功', U('index'));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($company_object ->getError());
            }
        }else{
            $company_object  = D('Company');

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增用户') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('name', 'text', '公司名称', '公司名称')
					->addFormItem('dept', 'tags', '部门', '可以输入多个')
                    ->addFormItem('address', 'text', '地址', '公司地址')
                    ->addFormItem('tel', 'text', '联系电话', '联系电话')
                    ->display();
        }
    }

    /**
     * 编辑公司
     */
    public function edit($id){
        //获取公司信息
        $info = D('Company')->find($id);

        if(IS_POST){
            $company_object  = D('Company');
            if($company_object ->save($_POST)){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败', $company_object ->getError());
            }
        }else{
            $company_object  = D('Company');
            $info = $company_object ->find($id);
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑公司') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('name', 'text', '公司名称', '公司名称')
					->addFormItem('dept', 'tags', '部门', '可以输入多个')
                    ->addFormItem('address', 'text', '公司地址', '公司地址')
                    ->addFormItem('tel', 'text', '公司电话', '公司电话')
                    ->setFormData($info)
                    ->display();
        }
    }
}
