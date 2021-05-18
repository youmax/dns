<?php

return [
    
    # Route Title
    'dashboards.index' => '仪表板',

    'roles.index' => '角色列表',
    'roles.create' => '创建角色',
    'roles.edit' => '编辑角色',
    'roles.destroy' => '删除角色',
    
    'users.index' => '用户列表',
    'users.create' => '创建用户',
    'users.edit' => '编辑用户',
    'users.destroy' => '删除用户',

    'logs.index' => '日志列表',

    'platforms.index' => '平台列表',
    'platforms.create' => '创建平台',
    'platforms.edit' => '编辑平台',
    'platforms.destroy' => '删除平台',
    'platforms.export' => '汇出平台',

    'domains.index' => '域名列表',
    'domains.create' => '创建域名',
    'domains.edit' => '编辑域名',
    'domains.destroy' => '删除域名',
    'domains.export' => '汇出域名',

    'create_success' => '创建:name成功',
    'edit_success' => '编辑:name成功',
    'restore' => '确定要还原该:name？',
    'restore_success' => '还原:name成功!',
    'delete' => '确定要删除该:name？',
    'delete_success' => '删除:name成功',
    'input' => '请输入:name',
    'not_found' => ':name不存在！',
    'item_available' => '可选:name',
    'item_selected' => '已选:name',

    'logout' => '登出',
    'view_all_messages' => '检视所有讯息',
    'create' => '创建',
    'loading' => '加载中',
    'export' => '汇出',
    'error' => '错误',
    'massDestroy' => '批次删除',
    'multiple_domain_tip' => '，多个域名以逗号区隔，例: yahoo.com,google.com',

    'email' => '邮箱',
    'password' => '密码',
    'password_confirmation' => '确认密码',
    'login' => '登入',
    'signup' => '注册',
    'forgot_password' => '忘记密码?',

    'role' => '角色',
    'permission' => '权限',

    'user' => '用户',
    'first_name' => '名',
    'last_name' => '姓',
    'full_name' => '姓名',

    'usage_period_avg' => '时段可用性统计(平均)',
    'avaliablity' => '可用性',
    'avg_response_time' => '平均响应时间',
    'expired_in_week' => '一周内过期',
    'expired_in_month' => '一月内过期',
    'expired_in_season' => '三月内过期',
    
    'created_at' => '创建日期',
    'updated_at' => '更新日期',
    
    'search' => '搜寻 ...',
    'filter' => '过滤',
    'trashed' => '删除',
    'with_trashed' => '包含已删除',
    'only_trashed' => '已删除',
    'reset' => '淸空',
    'id'    => '#',

    'domain' => '域名',
    'protocol' => '协定',
    'backup' => '备援',
    'renew' => '续约',
    'enable' => '启用',
    'usage' => '使用率',
    'remark' => '附言',
    'status_code' => '状态码',
    'expired_at' => '过期日期',
    'operation' => '操作',
    'main_domain' => '主域名',
    'domain_status_alert' => '域名告警视窗',

    'platform' => '平台',

    'pings.create' => 'Ping在线检测',
    'nslookups.create' => 'Nslookup在线检测',
    'whois.create' => 'Whois域名在線查詢',
    'traces.create' => '路由器追踪',
    'netcats.create' => '端口在線檢測工具',

    'domain_or_ip' => '域名或IP地址',
    'copy_result' => '复制结果',
    'copy_success' => '复制成功',
    'ping_check' => 'Ping检测',
    'query_type' => '查询类型',
    'dns_public_server' => 'DNS公共服务器',
    'nslookup_check' => 'Nslookup检测',
    'port' => '端口号',
    'port_check' => '檢測端口',

    'registrar' => '注册商',
    'contact_email'=>'联系邮箱',
    'contact_phone'=> '联系电话',
    'whois_server' => 'whois服务器',
    'whois_check' => 'Whois检测',
    'trace_check' => '路由器检测',

    'DNS_A' => 'A (指定域名对应的IPv4地址)',
    'DNS_AAAA' => 'AAAA (指定域名对应的IPv6地址)',
    'DNS_CNAME' => 'CNAME (别名记录)',
    'DNS_MX' => 'MX (邮件交换记录)',
    'DNS_NS' => 'NS (指定该域名由哪个DNS服务器来进行解析)',
    'DNS_TXT' => 'TXT (主机名或域名的说明)',
    'DNS_SOA' => 'SOA (起始授权机构)',
    'DNS_PTR' => 'PTR (反向IP查询)',
    'DNS_ANY' => 'ANY (所有DNS记录类型)',
];
