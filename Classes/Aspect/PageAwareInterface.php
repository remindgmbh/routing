<?php

declare(strict_types=1);

namespace Remind\Routing\Aspect;

interface PageAwareInterface
{
    /**
     * @return mixed[]
     */
    public function getPage(): array;

    /**
     * @param mixed[] $page
     */
    public function setPage(array $page): void;
}
