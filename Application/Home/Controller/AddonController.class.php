<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: ijry <ijry@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
/**
 * 扩展控制器
 * 该类参考了OneThink的部分实现
 * 用于调度各个扩展的URL访问需求
 */
class AddonController extends HomeController{
    /**
     * 初始化方法
     * @author jry <598821125@qq.com>
     */
    protected function _initialize(){
        parent::_initialize();
        $map['status'] = 1;
        $map['type'] = 1;
        $addon_list = D('Addon')->where($map)->select();
        $this->assign('addon_list', $addon_list);
    }

    /**
     * 微＋插件列表
     * @author jry <598821125@qq.com>
     */
    public function index(){
        $this->assign('meta_title', '微＋平台首页');
        $this->display();
    }

    /**
     * 外部执行插件方法
     * @author jry <598821125@qq.com>
     */
    public function execute($_addons = null, $_controller = null, $_action = null){
        if(C('URL_CASE_INSENSITIVE')){
            $_addons     = ucfirst(parse_name($_addons, 1));
            $_controller = parse_name($_controller,1);
        }

        $TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
        $TMPL_PARSE_STRING['__ADDONROOT__'] = __ROOT__ . "/Addons/{$_addons}";
        C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);

        if(!empty($_addons) && !empty($_controller) && !empty($_action)){
            $Addons = A("Addons://{$_addons}/{$_controller}")->$_action();
        } else {
            $this->error('没有指定插件名称，控制器或操作！');
        }
    }

    /**
     * 单个微＋插件主页
     * @param $name 插件名称
     * @author jry <598821125@qq.com>
     */
    public function adminList($name, $tab = 1){
        //获取插件实例
        $addon_class = get_addon_class($name);
        if(!class_exists($addon_class)){
            $this->error('插件不存在');
        }else{
            $addon = new $addon_class();
        }

        //获取插件的$admin_list配置
        $admin_list = $addon->admin_list;
        $tab_list = array();
        foreach($admin_list as $key => $val){
            $tab_list[$key]['title'] = $val['title'];
            $tab_list[$key]['href']  = U('Home/Addon/adminList/name/'.$name.'/tab/'.$key);
        }
        $admin = $admin_list[$tab];
        $param = D('Addons://'.$name.'/'.$admin['model'].'')->adminList;
        if($param){
            //搜索
            $keyword   = (string)I('keyword');
            $condition = array('like','%'.$keyword.'%');
            $map['id|'.$param['search_key']] = array($condition, $condition,'_multi'=>true);

            //获取数据列表
            $data_list = M($param['model'])->page(!empty($_GET["p"])?$_GET["p"]:1, C('ADMIN_PAGE_ROWS'))
                                           ->where($map)->field(true)->order($param['order'])->select();
            $page = new \Common\Util\Page(M($param['model'])->where($map)->count(), C('ADMIN_PAGE_ROWS'));

            //使用Builder快速建立列表页面。
            $builder = new \Common\Builder\ListBuilder();
            $builder->setMetaTitle($addon->info['title']) //设置页面标题
                    ->AddTopButton('addnew', array('href'  => U('Home/Addon/adminAdd/name/'.$name.'/tab/'.$tab))) //添加新增按钮
                    ->AddTopButton('resume', array('model' => $param['model'])) //添加启用按钮
                    ->AddTopButton('forbid', array('model' => $param['model'])) //添加禁用按钮
                    ->setSearch('请输入关键字', U('Home/Addon/adminList/name/'.$name, array('tab' => $tab)))
                    ->SetTabNav($tab_list, $tab) //设置Tab按钮列表
                    ->setTableDataList($data_list) //数据列表
                    ->setTableDataPage($page->show()); //数据列表分页

            //根据插件的list_grid设置后台列表字段信息
            foreach($param['list_grid'] as $key => $val){
                $builder->addTableColumn($key, $val['title'], $val['type']);
            }

            //根据插件的right_button设置后台列表右侧按钮
            foreach($param['right_button'] as $key => $val){
                $builder->addRightButton('self', $val);
            }

            //定义编辑按钮
            $attr = array();
            $attr['title'] = '编辑';
            $attr['class'] = 'label label-info';
            $attr['href']  = U('Home/Addon/adminEdit', array('name' => $name, 'tab' => $tab, 'id' => '__data_id__'));

            //显示列表
            $builder->addTableColumn('right_button', '操作', 'btn')
                    ->addRightButton('self', $attr) //添加编辑按钮
                    ->addRightButton('forbid', array('model' => $param['model'])) //添加禁用/启用按钮
                    ->addRightButton('delete', array('model' => $param['model'])) //添加删除按钮
                    ->setTemplate('_Builder/listbuilder_addon')
                    ->display();
        }else{
            $this->error('插件列表信息不正确');
        }
    }

    /**
     * 插件后台数据增加
     * @param string $name 插件名
     * @author jry <598821125@qq.com>
     */
     public function adminAdd($name, $tab){
        //获取插件实例
        $addon_class = get_addon_class($name);
        if(!class_exists($addon_class)){
            $this->error('插件不存在');
        }else{
            $addon = new $addon_class();
        }

        //获取插件的$admin_list配置
        $admin_list = $addon->admin_list;
        $admin = $admin_list[$tab];
        $addon_model_object = D('Addons://'.$name.'/'.$admin['model']);
        $param = $addon_model_object->adminList;
        if($param){
            if(IS_POST){
                $data = $addon_model_object->create();
                if($data){
                    $result = $addon_model_object->add($data);
                }else{
                    $this->error($addon_model_object->getError());
                }
                if($result){
                    $this->success('新增成功', U('Addon/adminList/name/'.$name.'/tab/'.$tab));
                }else{
                    $this->error('更新错误');
                }
            }else{
                //使用FormBuilder快速建立表单页面。
                $builder = new \Common\Builder\FormBuilder();
                $builder->setMetaTitle('新增数据')  //设置页面标题
                        ->setPostUrl(U('addon/adminAdd/name/'.$name.'/tab/'.$tab)) //设置表单提交地址
                        ->setExtraItems($param['field'])
                        ->setTemplate('_Builder/formbuilder_addon')
                        ->display();
            }
        }else{
            $this->error('插件列表信息不正确');
        }
     }

    /**
     * 插件后台数据编辑
     * @param string $name 插件名
     * @author jry <598821125@qq.com>
     */
     public function adminEdit($name, $tab, $id){
        //获取插件实例
        $addon_class = get_addon_class($name);
        if(!class_exists($addon_class)){
            $this->error('插件不存在');
        }else{
            $addon = new $addon_class();
        }

        //获取插件的$admin_list配置
        $admin_list = $addon->admin_list;
        $admin = $admin_list[$tab];
        $addon_model_object = D('Addons://'.$name.'/'.$admin['model']);
        $param = $addon_model_object->adminList;
        if($param){
            if(IS_POST){
                $data = $addon_model_object->create();
                if($data){
                    $result = $addon_model_object->save($data);
                }else{
                    $this->error($addon_model_object->getError());
                }
                if($result){
                    $this->success('更新成功', U('Addon/adminList/name/'.$name.'/tab/'.$tab));
                }else{
                    $this->error('更新错误');
                }
            }else{
                //使用FormBuilder快速建立表单页面。
                $builder = new \Common\Builder\FormBuilder();
                $builder->setMetaTitle('编辑数据')  //设置页面标题
                        ->setPostUrl(U('addon/adminEdit/name/'.$name.'/tab/'.$tab)) //设置表单提交地址
                        ->addFormItem('id', 'hidden', 'ID', 'ID')
                        ->setExtraItems($param['field'])
                        ->setFormData(M($param['model'])->find($id))
                        ->setTemplate('_Builder/formbuilder_addon')
                        ->display();
            }
        }else{
            $this->error('插件列表信息不正确');
        }
     }
}
