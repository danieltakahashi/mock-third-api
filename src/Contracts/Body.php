<?php

declare(strict_types=1);

namespace MockThirdApi\Contracts;

interface Body
{
    public function content(): string;

    public function parsed(): string;
}
