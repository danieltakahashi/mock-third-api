<?php

declare(strict_types=1);

namespace MockThirdApi\Http\Body;

readonly class XmlResponseBody extends AbstractBody
{
    /** @throws \Exception */
    public function parsed(): string
    {
        $xml = simplexml_load_string(json_decode($this->content()));
        if ($xml === false) {
            throw new \Exception('Invalid Body');
        }

        return $xml->asXML();
    }
}
