<?php

// define the ID of the Customer record you want to adjust
define('ENTITY_ID', '12345');

// define the existing ExternalId value on the record
define('OldExternalId', 'myCRM_123');

// define the new ExternalId value you wish to place on the record
define('NewExternalId', 'myCRM_456');

// connection details
$config = array(
   // required -------------------------------------
   "endpoint" => "2016_2",
   "host"     => "https://webservices.netsuite.com",
   "email"    => "jDoe@netsuite.com",
   "password" => "mySecretPwd",
   "role"     => "3",
   "account"  => "MYACCT1",
   "app_id"   => "4AD027CA-88B3-46EC-9D3E-41C6E6A325E2",
   // optional -------------------------------------
   "logging"  => true,
   "log_path" => "/var/www/myapp/logs/netsuite"
);
