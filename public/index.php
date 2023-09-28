<?php

declare(strict_types=1);

use MockThirdApi\DTO\RequestData;
use MockThirdApi\DTO\ResponseData;
use MockThirdApi\Http\AppRouter;
use MockThirdApi\MockApi;
use MockThirdApi\Responses\JsonFile;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

(function () {
	try {
		$apiName = $_SERVER['HTTP_HOST'];
		$apiPath = $_SERVER['REQUEST_URI'];
		$httpMethod = $_SERVER['REQUEST_METHOD'];

		if (false !== $pos = strpos($apiPath, '?')) {
			$apiPath = substr($apiPath, 0, $pos);
		}

		$apiPath = rawurldecode($apiPath);
		$requestData = new RequestData($apiName, $apiPath, $httpMethod);
        $appRouter = new AppRouter($requestData);

		$mockApi = new MockApi($appRouter);
		$mockApi->serve();
	} catch (\Exception $exception) {
		echo $exception->getMessage() . PHP_EOL;
	}
})();
