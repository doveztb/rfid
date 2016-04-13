# RFID
## 目录结构
test
```
├─index.php 入口文件
│
├─Addons 插件目录
├─Application 应用模块目录
│  ├─Admin 后台模块
│  │  ├─Conf 后台配置文件目录
│  │  ├─Common 后台函数目录
│  │  ├─Controller 后台控制器目录
│  │  ├─Model 后台模型目录
│  │  └─View 后台视图文件目录
│  │
│  ├─Common 公共模块目录（不能直接访问）
│  │  ├─Behavior 行为扩展目录
│  │  ├─Builder Builder目录
│  │  ├─Common 公共函数文件目录
│  │  ├─Conf 公共配置文件目录
│  │  ├─Controller 公共控制器目录
│  │  ├─Model 公共模型目录
│  │  └─Util 第三方类库目录
│  │
│  ├─Home 前台模块
│  │  ├─Conf 前台配置文件目录
│  │  ├─Common 前台函数目录
│  │  ├─Controller 前台控制器目录
│  │  ├─Model 前台模型目录
│  │  ├─TagLib 前台标签库目录
│  │  └─View 模块视图文件目录
│  │
│  ├─Install 安装模块
│  │  ├─Conf 配置文件目录
│  │  ├─Common 函数目录
│  │  ├─Controller 控制器目录
│  │  ├─Model 模型目录
│  │  └─View 模块视图文件目录
│  │
│  └─... 扩展的可装卸功能模块
│
├─Public 应用资源文件目录
│  ├─libs 第三方插件类库目录
│  ├─css gulp编译样式结果存放目录
│  └─js gulp编译脚本结果存放目录
│
├─Runtime 应用运行时目录
├─ThinkPHP 框架目录
└─Uploads 上传根目录

