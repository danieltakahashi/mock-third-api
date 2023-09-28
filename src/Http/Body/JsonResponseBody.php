<?php

declare(strict_types=1);

namespace MockThirdApi\Http\Body;

readonly class JsonResponseBody extends AbstractBody
{
    public function parsed(): string
    {
        return $this->content();
    }
}
