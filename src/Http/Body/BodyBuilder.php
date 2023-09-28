<?php

declare(strict_types=1);

namespace MockThirdApi\Http\Body;

use MockThirdApi\Contracts\Body;
use MockThirdApi\Enums\ResponseType;
use Psr\Http\Message\StreamInterface;

class BodyBuilder
{
    private ResponseType $responseType;
    private StreamInterface $content;

    public static function create(): self
    {
        return new self();
    }

    public function setResponseType(ResponseType $responseType): self
    {
        $this->responseType = $responseType;
        return $this;
    }

    public function setContent(StreamInterface $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function build(): Body
    {
        if (!isset($this->responseType)) {
            throw new \InvalidArgumentException('The param responseType is required!');
        }

        return match ($this->responseType) {
            ResponseType::JSON => new JsonResponseBody($this->content),
            ResponseType::XML => new XmlResponseBody($this->content),
        };
    }

}
