<?php

declare(strict_types=1);

namespace Remind\Routing\Aspect;

interface CTypeAwareInterface
{
    public function getCType(): string;

    public function setCType(string $cType): void;
}
