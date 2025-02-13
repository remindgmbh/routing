<?php

declare(strict_types=1);

namespace Remind\Routing\Aspect;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper;

class PersistedValueMapper extends PersistedAliasMapper
{
    public function generate(string $value): ?string
    {
        $exists = $this->exists($value);
        return $exists ? $value : null;
    }

    public function resolve(string $value): ?string
    {
        $exists = $this->exists($value);
        return $exists ? $value : null;
    }

    private function exists(string $value): bool
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryResult = $queryBuilder
            ->select('uid')
            ->where($queryBuilder->expr()->eq(
                $this->routeFieldName,
                $queryBuilder->createNamedParameter($value, Connection::PARAM_STR)
            ))
            ->setMaxResults(1)
            ->executeQuery();
        return $queryResult->rowCount() > 0;
    }
}
