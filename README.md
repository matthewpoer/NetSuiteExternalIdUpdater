# NetSuiteExternalIdUpdater
A quick script to help update the External ID parameter of an existing NetSuite Entity record. Simply define a `config.php` file with your NetSuite connectivity info and the internal and external IDs of the NetSuite record and run the script in CLI mode.

Leverages the very helpful  [ryanwinchester/netsuite-php](https://github.com/ryanwinchester/netsuite-php). 

## Setup and Run
* Download/clone to local machine
* Create a config file by copying the example (`cp config_default.php config.php`) or creating a new one. Ensure config specifies all parameter will values relevant to your NetSuite instances.
 * Pay special attention to the **NS_OBJECT** param. Use the list in [RecordType list NetSuite documentation](http://www.netsuite.com/help/helpcenter/en_US/srbrowser/Browser2015_1/schema/enum/recordtype.html) since the names are not intuitive.
* Run `composer install` to fetch the ryanwinchester/netsuite-php library
* Run the script, `php -f NetSuiteExternalIdUpdater.php`

## Did it work?
If all goes well, your run and output should resemble the following:
~~~
$ php -f NetSuiteExternalIdUpdater.php
Found record 12345
Found existing externalId value of myCRM_123
This matches expectations. Will attempt to update externalId to myCRM_456
The upsert was sent and no errors were detected. Done.
~~~

That's well and good, but how do we verify? Simply re-run the program and the new externalId will be detected and the program will abort the update. 

~~~
$ php -f NetSuiteExternalIdUpdater.php
Found record 12345
Found existing externalId value of myCRM_456
This does not match the expected values of 12345 and myCRM_123
~~~
