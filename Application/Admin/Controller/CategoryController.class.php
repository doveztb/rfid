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
 * 后台分类控制器
 * @author jry <598821125@qq.com>
 */
class CategoryController extends AdminController{
        //文档类型切换触发操作JS
        private $extra_html = <<<EOF
        <script type="text/javascript">
            //选择模型时页面元素改变
            $(function(){
                $('input[name="doc_type"]').change(function(){
                    var model_id = $(this).val();
                    if(model_id == 1){ //超链接
                        $('.item_url').removeClass('hidden');
                        $('.item_content').addClass('hidden');
                        $('.item_index_template').addClass('hidden');
                        $('.item_detail_template').addClass('hidden');
                    }else if(model_id == 2){ //单页文档
                        $('.item_url').addClass('hidden');
                        $('.item_content').removeClass('hidden');
                        $('.item_index_template').addClass('hidden');
                        $('.item_detail_template').removeClass('hidden');
                    }else{
                        $('.item_url').addClass('hidden');
                        $('.item_content').addClass('hidden');
                        $('.item_index_template').removeClass('hidden');
                        $('.item_detail_template').removeClass('hidden');
                    }
                });
            });
        </script>
EOF;

    /**
     * 分类列表
     * @author jry <598821125@qq.com>
     */
    public function index($group = 1){
        //搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition,'_multi'=>true);

        //获取所有分类
        $map['status'] = array('egt', '0'); //禁用和正常状态
        if(I('get.pid')){
            $map['pid'] = array('eq', I('get.pid')); //父分类ID
        }
        $map['group'] = array('eq', $group);
        $data_list = D('Category')->field('id,pid,group,doc_type,title,url,icon,ctime,sort,status')
                                  ->where($map)->order('sort asc,id asc')->select();

        //非系统特殊类型则给标题加上链接以便于进入相应文档列表
        foreach($data_list as &$item){
            $document_type = D('DocumentType')->find($item['doc_type']); //获取当前文档类型
            if($document_type['system'] === '0'){
                $item['title'] = '<a href="'.U('Document/index', array('cid' => $item['id'])).'">'.$item['title'].'</a>';
            }
        }

        //转换成树状列表
        $tree = new \Common\Util\Tree();
        $data_list = $tree->toFormatTree($data_list);

        //设置Tab导航数据列表
        $category_group_list = C('CATEGORY_GROUP_LIST'); //获取分类分组
        foreach($category_group_list as $key => $val){
            $tab_list[$key]['title'] = $val;
            $tab_list[$key]['href']  = U('index', array('group' => $key));
        }

        $attr['title'] = '编辑';
        $attr['class'] = 'label label-primary';
        $attr['href']  = U('Admin/Category/edit', array('group' => $group, 'id' => '__data_id__'));

        //使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('分类列表') //设置页面标题
                ->addTopButton('addnew', array('href' => U('Admin/Category/add/group/'.$group))) //添加新增按钮
                ->addTopButton('resume') //添加启用按钮
                ->addTopButton('forbid') //添加禁用按钮
                ->setSearch('请输入ID/分类名称', U('Admin/Category/index/group/'.$group))
                ->setTabNav($tab_list, $group) //设置页面Tab导航
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title_show', '分类')
                ->addTableColumn('url', '链接')
                ->addTableColumn('icon', '图标', 'icon')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)  //数据列表
                ->addRightButton('self', $attr) //添加编辑按钮
                ->addRightButton('hide') //添加隐藏/显示按钮
                ->addRightButton('forbid') //添加禁用/启用按钮
                ->addRightButton('delete') //添加删除按钮
                ->display();
    }

    /**
     * 新增分类
     * @author jry <598821125@qq.com>
     */
    public function add($group = 1){
        if(IS_POST){
            $category_object = D('Category');
            $data = $category_object->create();
            if($data){
                $id = $category_object->add();
                if($id){
                    $this->success('新增成功', U('Category/index', array('group' => I('post.group'))));
                }else{
                    $this->error('新增失败');
                }
            }else{
                $this->error($category_object->getError());
            }
        }else{
            //获取前台模版供选择
            $category_object = D('Category');
            $current_theme = D('SystemTheme')->where(array('current' => 1))->order('id asc')->getField('name'); //从系统主题数据表获取当前主题的名称
            $template_list = \Common\Util\File::get_dirs(getcwd().'/Application/Home/View/'.$current_theme.'/Document');
            foreach($template_list['file'] as $val){
                $val = substr($val, 0, -5);
                if(strstr($val, 'index')){
                    $template_list_index[$val] =  $val;
                }elseif(strstr($val, 'detail')){
                    $template_list_detail[$val] =  $val;
                }
            }

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增分类')  //设置页面标题
                    ->setPostUrl(U('add')) //设置表单提交地址
                    ->addFormItem('group', 'radio', '分组', '分组', C('CATEGORY_GROUP_LIST'))
                    ->addFormItem('pid', 'select', '上级分类', '所属的上级分类', select_list_as_tree('Category', array('group' => $group), '顶级分类'))
                    ->addFormItem('title', 'text', '分类标题', '分类标题')
                    ->addFormItem('doc_type', 'radio', '分类内容模型', '分类内容模型', select_list_as_tree('DocumentType'))
                    ->addFormItem('url', 'text', '链接', 'U函数解析的URL或者外链', null, 'hidden')
                    ->addFormItem('content', 'kindeditor', '内容', '单页模型填写内容', null, 'hidden')
                    ->addFormItem('index_template', 'select', '列表模版', '文档列表或封面模版', $template_list_index, 'hidden')
                    ->addFormItem('detail_template', 'select', '详情页模版', '单页使用的模版或其他模型文档详情页模版', $template_list_detail, 'hidden')
                    ->addFormItem('icon', 'icon', '图标', '菜单图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->addFormItem('post_auth', 'radio', '投稿权限', '前台用户投稿权限', $category_object->post_auth())
                    ->setFormData(array('group' => $group, 'post_auth' => 1))
                    ->setExtraHtml($this->extra_html)
                    ->display();
        }
    }

    /**
     * 编辑分类
     * @author jry <598821125@qq.com>
     */
    public function edit($id, $group){
        if(IS_POST){
            $category_object = D('Category');
            $data = $category_object->create();
            if($data){
                if($category_object->save()!== false){
                    $this->success('更新成功', U('Category/index', array('group' => I('post.group'))));
                }else{
                    $this->error('更新失败');
                }
            }else{
                $this->error($category_object->getError());
            }
        }else{
            //获取分类信息
            $category_object = D('Category');
            $info = $category_object->find($id);

            //获取前台模版供选择
            $current_theme = D('SystemTheme')->where(array('current' => 1))->order('id asc')->getField('name'); //从系统主题数据表获取当前主题的名称
            $template_list = \Common\Util\File::get_dirs(getcwd().'/Application/Home/View/'.$current_theme.'/Document');
            foreach($template_list['file'] as $val){
                $val = substr($val, 0, -5);
            if(strstr($val, 'index')){
                    $template_list_index[$val] =  $val;
                }elseif(strstr($val, 'detail')){
                    $template_list_detail[$val] =  $val;
                }
            }

            //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑分类')  //设置页面标题
                    ->setPostUrl(U('Admin/Category/edit/id/'.$id.'/group/'.$group)) //设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('group', 'radio', '分组', '分组', C('CATEGORY_GROUP_LIST'))
                    ->addFormItem('pid', 'select', '上级分类', '所属的上级分类', select_list_as_tree('Category', array('group' => $group), '顶级分类'))
                    ->addFormItem('title', 'text', '分类标题', '分类标题')
                    ->addFormItem('doc_type', 'radio', '分类内容模型', '分类内容模型', select_list_as_tree('DocumentType'))
                    ->addFormItem('url', 'text', '链接', 'U函数解析的URL或者外链', null, $info['doc_type'] == 1 ? : 'hidden')
                    ->addFormItem('content', 'kindeditor', '内容', '单页模型填写内容', null, $info['doc_type'] == 2 ? : 'hidden')
                    ->addFormItem('index_template', 'select', '模版', '文档列表或封面模版', $template_list_index, $info['doc_type'] > 2 ? : 'hidden')
                    ->addFormItem('detail_template', 'select', '详情页模版', '单页使用的模版或其他模型文档详情页模版', $template_list_detail, $info['doc_type'] > 1 ? : 'hidden')
                    ->addFormItem('icon', 'icon', '图标', '菜单图标')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->addFormItem('post_auth', 'radio', '投稿权限', '前台用户投稿权限', $category_object->post_auth())
                    ->setFormData($info)
                    ->setExtraHtml($this->extra_html)
                    ->display();
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author jry <598821125@qq.com>
     */
    public function setStatus($model = CONTROLLER_NAME){
        $ids    = I('request.ids');
        $status = I('request.status');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map['id'] = array('in',$ids);
        switch($status){
            case 'delete' : //删除条目
                $category_object = D('Category');
                $con['cid'] = array('in',$ids);
                $count = D('Document')->where($con)->count();
                if($count == 0){
                    $result = $category_object->where($map)->delete();
                    if($result){
                        $this->success('删除分类成功');
                    }
                }else{
                    $this->error('请先删除或移动该分类下文档');
                }
                break;
            default :
                parent::setStatus($model);
                break;
        }
    }
}
