<?php

return [

    # Route Title
    'dashboards.index' => 'Dashboard',

    'roles.index' => 'Role List',
    'roles.create' => 'Create Role',
    'roles.edit' => 'Edit Role',
    'roles.destroy' => 'Delete Role',
    
    'users.index' => 'User List',
    'users.create' => 'Create User',
    'users.edit' => 'Edit User',
    'users.destroy' => 'Delete User',

    'logs.index' => 'Log List',

    'platforms.index' => 'Platform List',
    'platforms.create' => 'Create Platform',
    'platforms.edit' => 'Edit Platform',
    'platforms.destroy' => 'Delete Platform',
    'platforms.export' => 'Export Platform',

    'domains.index' => 'Domain List',
    'domains.create' => 'Create Domain',
    'domains.edit' => 'Edit Domain',
    'domains.destroy' => 'Delete Domain',
    'domains.export' => 'Export Domain',

    'create_success' => 'Create :name Success!',
    'edit_success' => 'Edit :name Success!',
    'restore' => 'Are you sure restore selected :name？',
    'restore_success' => 'Restore Selected :name Success!',
    'delete' => 'Are you sure delete selected :name？',
    'delete_success' => 'Delete :name Success!',
    'input' => 'Please input :name',
    'not_found' => ':name are not found！',
    'item_available' => 'Available :name',
    'item_selected' => 'Selected :name',

    'logout' => 'Logout',
    'view_all_messages' => 'view all messages',
    'create' => 'Create',
    'loading' => 'loading',
    'export' => 'Export',
    'error' => 'Error',
    'massDestroy' => 'Mass Delete',
    'multiple_domain_tip' => ',multiple domain should be sperated by comma. For instance: yahoo.com,google.com',

    'email' => 'Email',
    'password' => 'Password',
    'password_confirmation' => 'Password Confirmation',
    'login' => 'Login',
    'signup' => 'Signup',
    'forgot_password' => 'Forgot Password?',

    'role' => 'Role',
    'permission' => 'Permission',

    'user' => 'User',
    'first_name' => 'First name',
    'last_name' => 'Last name',
    'full_name' => 'Full name',

    'usage_period_avg' => 'Time period availability statistics (average)',
    'avaliablity' => 'Avaliablity',
    'avg_response_time' => 'Response Time (average)',
    'expired_in_week' => 'Domain Expired in one week',
    'expired_in_month' => 'Domain Expired in a month',
    'expired_in_season' => 'Domain Expired in 3 month',
    
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    
    'search' => 'Search ...',
    'filter' => 'Filter',
    'trashed' => 'Trashed',
    'with_trashed' => 'With Trashed',
    'only_trashed' => 'Only Trashed',
    'reset' => 'Reset',
    'id'    => '#',

    'domain' => 'Domain',
    'protocol' => 'Protocol',
    'backup' => 'Backup',
    'renew' => 'Renew',
    'enable' => 'Enable',
    'usage' => 'Usage',
    'remark' => 'Remark',
    'status_code' => 'Status Code',
    'expired_at' => 'Expiration',
    'operation' => 'Operation',
    'main_domain' => 'Main Domain',
    'domain_status_alert' => 'Domain Status Alert',
    
    'platform' => 'Platform',

    'pings.create' => 'Ping tool',
    'nslookups.create' => 'Nslookup tool',
    'whois.create' => 'Whois tool',
    'traces.create' => 'Traceroute tool',
    'netcats.create' => 'Netcat tool',

    'domain_or_ip' => 'Domain Or IP Address',
    'copy_result' => 'Copy Results',
    'copy_success' => 'Copy Success!',
    'ping_check' => 'Ping Check',
    'query_type' => 'Query Type',
    'dns_public_server' => 'DNS public server',
    'nslookup_check' => 'Nslookup Check',
    'port' => 'Port',
    'port_check' => 'Port Check',

    'registrar' => 'Registrar',
    'contact_email'=>'Contact Email',
    'contact_phone'=> 'Contact Phone',
    'whois_server' => 'Whois Server',
    'whois_check' => 'Whois Check',
    'trace_check' => 'Traceroute Check',

    'DNS_A' => 'A (Specify the IPv4 address corresponding to the domain name)',
    'DNS_AAAA' => 'AAAA (Specify the IPv6 address corresponding to the domain name)',
    'DNS_CNAME' => 'CNAME (Alias record)',
    'DNS_MX' => 'MX (Mail exchange record)',
    'DNS_NS' => 'NS (Specify which DNS server to resolve the domain name)',
    'DNS_TXT' => 'TXT (Description of the host name or domain name)',
    'DNS_SOA' => 'SOA (Initial authority)',
    'DNS_PTR' => 'PTR (Reverse IP lookup)',
    'DNS_ANY' => 'ANY (All DNS record types)',
];
