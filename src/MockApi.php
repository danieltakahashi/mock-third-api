<?php

namespace MockThirdApi;

use MockThirdApi\Http\AppRouter;

readonly class MockApi
{
    public function __construct(private AppRouter $appRouter)
    {}

    public function serve(): void
    {
        $this->appRouter->run();
    }
}
