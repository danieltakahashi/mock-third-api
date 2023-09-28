<?php

declare(strict_types=1);

namespace MockThirdApi\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use GuzzleHttp\Psr7\Utils;
use MockThirdApi\DTO\RequestData;
use MockThirdApi\Enums\HttpMethod;
use MockThirdApi\Enums\ResponseType;
use MockThirdApi\Http\Body\BodyBuilder;
use function FastRoute\simpleDispatcher;

class AppRouter
{
    private const ROUTES_CONFIGURATION_FILE = '%s/../data/%s/data.json';

    private array $routes;

    public function __construct(private readonly RequestData $requestData)
    {
        $this->routes = $this->loadRoutes($this->requestData->getApiName());
    }

    public function run(): void
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $router) {
            foreach ($this->routes as $route) {
                $httpMethod = HttpMethod::from($route['method']);
                $router->addRoute($httpMethod->value, $route['path'], json_encode($route['response']));
            }
        });

        $this->dispatchRoutes($dispatcher);
    }

    private function dispatchRoutes(Dispatcher $dispatcher): void
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
                $response = json_decode($routeInfo[1], associative: true);
                http_response_code($response['statusCode']);
                echo $this->processResponse($response);
                break;
            default:
                http_response_code(500);
                echo 'GENERAL ERROR';
                break;
        }
    }

    private function loadRoutes(string $host): array
    {
        $routesConfigurationFile = sprintf(self::ROUTES_CONFIGURATION_FILE, dirname(__DIR__), $host);
        if (!realpath($routesConfigurationFile)) {
            throw new \LogicException("Route configuration file not found for {$host}");
        }

        return json_decode(file_get_contents($routesConfigurationFile), associative: true);
    }

    private function processResponse(array $response): string
    {
        $responseType = ResponseType::from($response['type']);
        $responseStream = Utils::streamFor(json_encode($response['body']));
        $body = BodyBuilder::create()
            ->setResponseType($responseType)
            ->setContent($responseStream)
            ->build();

        return $body->parsed();
    }
}
