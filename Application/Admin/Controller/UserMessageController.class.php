<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
/**
 * 消息控制器
 * @author jry <598821125@qq.com>
 */
class UserMessageController extends AdminController{

    /**
     * 默认方法
     * @param $type 消息类型
     * @author jry <598821125@qq.com>
     */
    public function index(){
        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition,'_multi'=>true);

        //获取所有消息
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $uid=is_login();
        $map['from_uid|to_uid']=$uid;
        $data_list = D('UserMessage')->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))
                                     ->order('sort desc,id desc')
                                     ->where($map)
                                     ->select();
        $page = new \Common\Util\Page(D('UserMessage')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('消息列表') //设置页面标题
                ->addTopButton('addnew')  //添加新增按钮
                ->addTopButton('resume')  //添加启用按钮
                ->addTopButton('forbid')  //添加禁用按钮
                ->addTopButton('delete')  //添加删除按钮
                ->setSearch('请输入ID/消息标题', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('to_uid', '接收人')
                ->addTableColumn('title', '消息')
                ->addTableColumn('ctime', '创建时间', 'time')
                ->addTableColumn('sort', '排序')
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
     * 新增消息
     * @author jry <598821125@qq.com>
     */
    public function add(){
    	$user_message_object = D('UserMessage');
		$uid=is_login();
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
			
			$data['from_uid']=$uid;
			if($_POST['type'] =='0'){
				$companyid=D('User')->where("id='$uid'")->getField('companyid');
				$map1['companyid']=$companyid;
				$map1['group']='0';
				$to_uid=D('User')->where($map1)->getField('id',true);
//				$data['to_uid']=$to_uid;
				foreach($to_uid as $key=>$val){
					$data['to_uid']=$val;
					$result = $user_message_object->add($data);
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
            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增消息') //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('type', 'select', '消息类型', '系统消息、评论消息、私信消息',$user_message_object->message_type())
//                  ->addFormItem('to_all', 'checkbox', '所有人', '系统通知请选择')
                    ->addFormItem('to_uid', 'num', '消息收信用户', '若是系统消息不用填写')
                    ->addFormItem('title', 'textarea', '消息标题', '消息标题')
                    ->addFormItem('content', 'kindeditor', '消息内容', '消息内容')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        }
    }

    /**
     * 编辑消息
     * @author jry <598821125@qq.com>
     */
    public function edit($id){
        if(IS_POST){
            $user_message_object = D('UserMessage');
            $data = $user_message_object->create();
            if($data){
                if($user_message_object->save()!== false){
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
            $builder->setMetaTitle('编辑消息') //设置页面标题
                    ->setPostUrl(U('edit')) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('title', 'textarea', '消息标题', '消息标题')
                    ->addFormItem('content', 'kindeditor', '消息内容', '消息内容')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setFormData(D('UserMessage')->find($id))
                    ->display();
        }
    }

}
