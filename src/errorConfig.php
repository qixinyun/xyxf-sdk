<?php
/**
1-99 系统错误规范
100-1000 通用错误规范
1001-2000 用户通用错误提示规范
2001-3000 前台用户错误提示规范
3001-4000 实名认证错误提示规范
4001-5000 企业错误提示规范
5001-6000 员工错误提示规范
6001-7000 政策错误提示规范
7001-8000 政策解读错误提示规范
8001-9000 发文部门错误提示规范
9001-10000 标签错误提示规范
10001-11000 服务分类错误提示规范
11001-12000 成为服务商错误提示规范
12001-13000 发布需求错误提示规范
13001-14000 服务错误提示规范
 */
/**
 * csrf 验证失效
 */
define('CSRF_VERIFY_FAILURE', 15);
/**
 * 滑动验证失败
 */
define('AFS_VERIFY_FAILURE', 16);
/**
 * 用户未登录
 */
define('NEED_SIGNIN', 17);
/**
 * 短信发送太频繁
 */
define('SMS_SEND_TOO_QUICK', 18);
/**
 * 数据重复
 */
define('PARAMETER_IS_UNIQUE', 100);
/**
 * 数据格式不正确
 */
define('PARAMETER_FORMAT_INCORRECT', 101);
/**
 * 参数不能为空
 */
define('PARAMETER_IS_EMPTY', 102);
/**
 * 状态已上架
 */
define('RESOURCE_STATUS_ON_SHELF', 103);
/**
 * 状态已下架
 */
define('RESOURCE_STATUS_OFF_STOCK', 104);
/**
 * 审核状态非待审核
 */
define('RESOURCE_STATUS_NOT_PENDING', 105);
/**
 * 审核状态非已拒绝
 */
define('RESOURCE_STATUS_NOT_REJECT', 106);
/**
 * 状态非上架状态
 */
define('RESOURCE_STATUS_NOT_ON_SHELF', 107);
/**
 * 状态非正常状态
 */
define('RESOURCE_STATUS_NOT_NORMAL', 108);
/**
 * 状态已禁用
 */
define('RESOURCE_STATUS_DISABLED', 109);
/**
 * 状态已启用
 */
define('RESOURCE_STATUS_ENABLED', 110);

/**
 * 图片格式不正确
 */
define('IMAGE_FORMAT_ERROR', 201);
/**
 * 附件格式不正确
 */
define('ATTACHMENT_FORMAT_ERROR', 202);
/**
 * 姓名格式不正确
 */
define('REAL_NAME_FORMAT_ERROR', 203);
/**
 * 手机号格式不正确
 */
define('CELLPHONE_FORMAT_ERROR', 204);
/**
 * 价格格式不正确
 */
define('PRICE_FORMAT_ERROR', 205);
/**
 * 身份证格式不正确
 */
define('CARDID_FORMAT_ERROR', 206);
/**
 * 日期格式不正确
 */
define('DATE_FORMAT_ERROR', 207);
/**
 * 名称格式不正确
 */
define('NAME_FORMAT_ERROR', 208);
/**
 * 详细地址格式不正确
 */
define('ADDRESS_FORMAT_ERROR', 209);
/**
 * url格式不正确
 */
define('URL_FORMAT_ERROR', 210);
/**
 * 标题格式不正确
 */
define('TITLE_FORMAT_ERROR', 211);
/**
 * 描述格式不正确
 */
define('DESCRIPTION_FORMAT_ERROR', 212);
/**
 * 驳回原因格式不正确
 */
define('REJECT_REASON_FORMAT_ERROR', 213);
/**
 * 详情格式不正确
 */
define('DETAIL_FORMAT_ERROR', 214);
// 用户通用----------------------------------------------------------------
/**
 * 性别类型不存在
 */
define('GENDER_TYPE_NOT_EXIST', 1001);
/**
 * 密码格式不正确
 */
define('PASSWORD_FORMAT_ERROR', 1002);
/**
 * 旧密码不正确
 */
define('OLD_PASSWORD_INCORRECT', 1003);
/**
 * 密码错误
 */
define('PASSWORD_INCORRECT', 1004);
/**
 * 手机号已存在
 */
define('CELLPHONE_EXIST', 1005);
/**
 * 账号不存在
 */
define('CELLPHONE_NOT_EXIST', 1006);
/**
 * 验证码错误
 */
define('CAPTCHA_ERROR', 1007);
/**
 * 密码与确认密码不一致
 */
define('INCONSISTENT_PASSWORD', 1008);
/**
 * 该账户已禁用
 */
define('STATUS_DISABLED', 1009);
/**
 * 确认密码必须和新密码一致
 */
define('INCONSISTENT_NEW_PASSWORD', 1010);
// 前台用户----------------------------------------------------------------
/**
 * 昵称格式不正确
 */
define('NICK_NAME_FORMAT_ERROR', 2001);
/**
 * 简介格式不正确
 */
define('BRIEF_INTRODUCTION_FORMAT_ERROR', 2002);
// 企业----------------------------------------------------------------
/**
 * 统一社会信用代码格式不正确
 */
define('UNIFIED_SOCIAL_CREDIT_CODE_FORMAT_ERROR', 4001);
/**
 * 该企业已存在
 */
define('ENTERPRISE_EXIST', 4002);
/**
 * 联系人电话格式不正确
 */
define('CONTACTS_PPHONE_FORMAT_ERROR', 4003);
// 政策----------------------------------------------------------------
/**
 * 适用对象不存在
 */
define('APPLICABLE_OBJECT_NOT_EXIST', 6001);
/**
 * 适用行业不存在
 */
define('APPLICABLE_INDUSTRIES_NOT_EXIST', 6002);
/**
 * 政策级别不存在
 */
define('LEVEL_NOT_EXIST', 6003);
/**
 * 政策分类不存在
 */
define('CLASSIFY_NOT_EXIST', 6004);
/**
 * 受理地址格式不正确
 */
define('ADMISSIBLE_ADDRESS_FORMAT_ERROR', 6005);
// 发文部门----------------------------------------------------------------
/**
 * 部门名称格式不正确
 */
define('DISPATCH_DEPARTMENT_NAME_FORMAT_ERROR', 8001);
/**
 * 备注格式不正确
 */
define('DISPATCH_DEPARTMENT_REMARK_FORMAT_ERROR', 8002);
/**
 * 发文部门名称已存在
 */
define('DISPATCH_DEPARTMENT_NAME_EXIST', 8003);
// 标签----------------------------------------------------------------
/**
 * 标签名称格式不正确
 */
define('LABEL_NAME_FORMAT_ERROR', 9001);
/**
 * 标签分类不存在
 */
define('LABEL_CATEGORY_NOT_EXIST', 9002);
/**
 * 标签备注格式不正确
 */
define('LABEL_REMARK_FORMAT_ERROR', 9003);
/**
 * 标签名称已存在
 */
define('LABEL_NAME_EXIST', 9004);
// 服务分类----------------------------------------------------------------
/**
 * 服务分类名称格式不正确
 */
define('SERVICE_CATEGORY_NAME_FORMAT_ERROR', 10001);
/**
 * 服务分类资质认证名称格式不正确
 */
define('SERVICE_CATEGORY_QUALIFICATION_NAME_FORMAT_ERROR', 10002);
/**
 * 是否需要资质认证分类不存在
 */
define('SERVICE_CATEGORY_IS_QUALIFICATION_NOT_EXIST', 10003);
/**
 * 分类已存在
 */
define('CATEGORY_IS_EXIST', 10004);
// 发布需求----------------------------------------------------------------
/**
 * 需求标题格式不正确
 */
define('SERVICE_REQUIREMENT_TITLE_FORMAT_ERROR', 12001);
/**
 * 最大价格不能低于最小价格
 */
define('MIN_PRICE_CAN_NOT_THAN_MAX_PRICE', 12002);
// 发布服务----------------------------------------------------------------
/**
 * 服务标题格式不正确
 */
define('SERVICE_TITLE_FORMAT_ERROR', 13001);

/**
 * 服务对象不存在
 */
define('SERVICE_OBJECT_NOT_EXIST', 13002);
/**
 * 服务价格格式不正确
 */
define('SERVICE_PRICE_FORMAT_ERROR', 13003);

/**
 * 服务合同格式不正确
 */
define('SERVICE_CONTRACT_FORMAT_ERROR', 13004);

/**
 * 该企业未认证该分类
 */
define('ENTERPRISE_NOT_AUTHENTICATION_SERVICE_CATEGORY', 13005);
