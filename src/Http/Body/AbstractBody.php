<?php

declare(strict_types=1);

namespace MockThirdApi\Http\Body;

use MockThirdApi\Contracts\Body;
use Psr\Http\Message\StreamInterface;

abstract readonly class AbstractBody implements Body
{
    public function __construct(private StreamInterface $stream)
    {}

    public function content(): string
    {
        return $this->stream->getContents();
    }
}
