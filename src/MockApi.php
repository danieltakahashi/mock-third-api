<?php

namespace MockThirdApi;

use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use MockThirdApi\DTO\RequestData;
use MockThirdApi\Responses\ResponseInterface;

use function FastRoute\simpleDispatcher;

class MockApi
{
    private RequestData $requestData;
    private ResponseInterface $response;

    public function __construct(RequestData $requestData, ResponseInterface $response)
    {
        $this->requestData = $requestData;
        $this->response = $response;
    }

    public function serve(): void
    {
        $dispatcher = $this->buildRoutes();

        $this->dispatchRoutes($dispatcher);
    }

    private function buildRoutes(): GroupCountBased
    {
        $contents = $this->response->getResponses();

        return simpleDispatcher(function (RouteCollector $route) use ($contents) {
            foreach ($contents as $content) {
                $route->addRoute($content['method'], $content['path'], $content['response']);
            }
        });
    }

    private function dispatchRoutes(GroupCountBased $dispatcher): void
    {
        $routeInfo = $dispatcher->dispatch($this->requestData->getHttpMethod(), $this->requestData->getApiPath());
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo 'NOT FOUND';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                echo 'NOT ALLOWED';
                break;
            case Dispatcher::FOUND:
                $response = $routeInfo[1];
                http_response_code($response['statusCode']);
                echo json_encode($response['body']);
                break;
            default:
                http_response_code(500);
                echo 'GENERAL ERROR';
                break;
        }
    }
}
