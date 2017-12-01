<?php

// ensure we have config and connection info
if(!file_exists('config.php')){
  die('You neglected to specify a configuration file' . PHP_EOL);
}
require_once('config.php');
if(!isset($config) || empty($config)) die('Did not define $config' . PHP_EOL);
if(!defined('ENTITY_ID') || empty(ENTITY_ID)) die('Did not define ENTITY_ID' . PHP_EOL);
if(!defined('OldExternalId') || empty(OldExternalId)) die('Did not define OldExternalId' . PHP_EOL);
if(!defined('NewExternalId') || empty(NewExternalId)) die('Did not define NewExternalId' . PHP_EOL);

require_once('vendor/autoload.php');
use NetSuite\NetSuiteService;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\Customer;
use NetSuite\Classes\UpdateRequest;

// connect
$service = new NetSuiteService($config);

// pull record data
try {
  $request = new GetRequest();
  $request->baseRef = new RecordRef();
  $request->baseRef->internalId = ENTITY_ID;
  $request->baseRef->type = NS_OBJECT;
  $response = $service->get($request);
} catch (\Exception $e) {
  $e_message = $e->getMessage();
  die('Get API Call failed with error message ' . $e_message . PHP_EOL);
}

// validate API response
if (!$response->readResponse->status->isSuccess) {
  die('Unable to locate record '
  . ENTITY_ID
  . '. API response: '
  . print_r($response->readResponse->status->statusDetail, TRUE)
  . PHP_EOL);
}

// validate existing external ID
$customer = $response->readResponse->record;
echo 'Found record ' . $customer->internalId . PHP_EOL;
echo 'Found existing externalId value of ' . $customer->externalId . PHP_EOL;
if($customer->internalId != ENTITY_ID || $customer->externalId != OldExternalId){
  die('This does not match the expected values of '
  . ENTITY_ID
  . ' and '
  . OldExternalId
  . PHP_EOL);
}

echo 'This matches expectations. Will attempt to update externalId to '
  . NewExternalId
  . PHP_EOL;

// set new External ID
$customer->externalId = NewExternalId;

// remove params we cannot write to
unset($customer->dateCreated);
unset($customer->lastModifiedDate);
unset($customer->balance);
unset($customer->depositBalance);

// attept the update
try {
  $request = new UpdateRequest();
  $request->record = $customer;
  $response = $service->update($request);
} catch (\Exception $e) {
  $e_message = $e->getMessage();
  die('Upsert API Call failed with error message ' . $e_message . PHP_EOL);
}
if (!$response->writeResponse->status->isSuccess) {
  die('Unable to update record '
  . ENTITY_ID
  . '. API response: '
  . print_r($response->writeResponse->status->statusDetail, TRUE)
  . PHP_EOL);
}

echo 'The update was sent and no errors were detected. Done.' . PHP_EOL;
