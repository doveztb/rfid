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


	 public function index1(){
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
}
