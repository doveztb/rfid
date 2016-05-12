<?php
namespace Common\Model;
use Think\Model;
/**
 * 考勤月记录模型
 */
class AttendanceMonthModel extends Model{
    /**
     * 自动验证规则
     */
    protected $_validate = array(
        //迟到次数
        array('latetimes', '/^(?:\d|[12]\d|30)$/', '请输入小于30', self::EXISTS_VALIDATE, 'regex', self::MODEL_UPDATE),
//      array('latetimes', 'array(array('gt',1),array('lt',30))','小于20', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
//      array('email', '', '邮箱被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

        //早退次数
        array('earlytimes', '/^(?:\d|[12]\d|30)$/', '请输入小于30', self::EXISTS_VALIDATE, 'regex', self::MODEL_UPDATE),
//      array('mobile', '', '手机号被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

        //扣掉的钱
        array('deductmoney', '/^(?:[1-9]\d?|[12]\d{2}|300)$/', '请输入小于500', self::MUST_VALIDATE, 'regex', self::MODEL_UPDATE),
//      array('password', '6,30', '密码长度为6-30位', self::MUST_VALIDATE, 'length', self::MODEL_INSERT),
//      array('password', '/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+)$)^[\w~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+$/', '密码至少由数字、字符、特殊字符三种中的两种组成', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
//      array('repassword', 'password', '两次输入的密码不一致', self::EXISTS_VALIDATE, 'confirm', self::MODEL_INSERT),

        //请假天数
        array('leavedays', '/^(?:\d|[12]\d|30)$/', '请输入小于30', self::MUST_VALIDATE, 'regex', self::MODEL_UPDATE),
//      array('username', '3,32', '用户名长度为1-32个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
//      array('username', '', '用户名被占用', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
//      array('username', 'checkIP', '注册太频繁请稍后再试', self::MUST_VALIDATE, 'callback', self::MODEL_INSERT), //IP限制
//      array('username', 'checkUsername', '该用户名禁止使用', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH), //用户名敏感词检测
//      array('username', '/^(?!_)(?!\d)(?!.*?_$)[\w\一-\龥]+$/', '用户名只可含有汉字、数字、字母、下划线且不以下划线开头结尾，不以数字开头！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

     
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
       
    );



}
