<?php

namespace MockThirdApi;

use MockThirdApi\DTO\RequestData;
use MockThirdApi\Responses\JsonFile;

require_once __DIR__ . '/../vendor/autoload.php';

$apiName = $_SERVER['HTTP_HOST'];
$apiPath = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];

if (false !== $pos = strpos($apiPath, '?')) {
    $apiPath = substr($apiPath, 0, $pos);
}
$apiPath = rawurldecode($apiPath);

$requestData = new RequestData(apiName: $apiName, apiPath: $apiPath, httpMethod: $httpMethod);
$jsonFile = new JsonFile(apiName: $apiName);

$mockApi = new MockApi(requestData: $requestData, response: $jsonFile);

$mockApi->serve();
