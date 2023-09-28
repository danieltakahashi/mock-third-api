<?php

declare(strict_types=1);

namespace MockThirdApi\Enums;

enum ResponseType: string
{
    case XML = 'xml';
    case JSON = 'json';
}
