<?php
namespace Common\Model;
use Think\Model;

class LeavesModel extends Model{
    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('days','require','必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        // array('title', '1,1024', '消息长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
//      array('to_uid','require','收信人必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('result', '0', self::MODEL_INSERT),
        array('ctime', NOW_TIME, self::MODEL_INSERT),
        // array('utime', NOW_TIME, self::MODEL_BOTH),
        // array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 消息类型
     * @author jry <598821125@qq.com>
     */
    public function message_type($id){
        $list[0] = '系统消息';
        $list[1] = '评论消息';
        $list[2] = '私信消息';
        return $id ? $list[$id] : $list;
    }

    /**
     * 发送消息
     * @author jry <598821125@qq.com>
     */
    public function sendMessage($data){
        $msg_data['title']    = $data['title']; //消息标题
        $msg_data['content']  = $data['content'] ? : ''; //消息内容
        $msg_data['to_uid']   = $data['to_uid']; //消息收信人ID
        $msg_data['type']     = $data['type'] ? : 0; //消息类型
        $msg_data['from_uid'] = $data['from_uid'] ? : 0; //消息发信人
        $result = $this->create($msg_data);
//		return $$msg_data;
		return D('UserMessage')->add($result);
//      if($result){
//          hook('SendMessage', $msg_data); //发送消息钩子，用于消息发送途径的扩展
//          return $this->add($result);
//      }
    }
	 /**
     * 发送消息
     * @author jry <598821125@qq.com>
     */
    public function sendMessage_all($data){
        $msg_data['title']    = $data['title']; //消息标题
        $msg_data['content']  = $data['content'] ? : ''; //消息内容
        $msg_data['to_uid']   = $data['to_uid']; //消息收信人ID
        $msg_data['type']     = $data['type'] ? : 0; //消息类型
        $msg_data['from_uid'] = $data['from_uid'] ? : 0; //消息发信人       
		foreach($data['to_uid'] as $key=>$val){
					$data['to_uid']=$val;
					$result = $this->create($msg_data);
					$result = D('UserMessage')->add($result);
				}
		return $result;
    }
    /**
     * 获取当前用户未读消息数量
     * @param $type 消息类型
     * @author jry <598821125@qq.com>
     */
    public function newMessageCount($type = null){
        $map['status'] = array('eq', 1);
        $map['to_uid'] = array('eq', is_login());
        $map['is_read'] = array('eq', 0);
        if($type !== null){
            $map['type'] = array('eq', $type);
        }
        return D('UserMessage')->where($map)->count();
    }
}
