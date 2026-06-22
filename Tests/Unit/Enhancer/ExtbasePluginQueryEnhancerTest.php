<?php

declare(strict_types=1);

namespace Remind\Routing\Tests\Unit\Enhancer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Remind\Routing\Enhancer\ExtbasePluginQueryEnhancer;
use TYPO3\CMS\Core\Routing\Route;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(ExtbasePluginQueryEnhancer::class)]
class ExtbasePluginQueryEnhancerTest extends UnitTestCase
{
    #[Test]
    public function buildResultBuildsExpectedArgumentsAndUsesDecoratedType(): void
    {
        $subject = new ExtbasePluginQueryEnhancer([
            'extension' => 'news',
            'plugin' => 'Pi1',
            '_controller' => 'News::detail',
        ]);

        $route = new Route('/', [], [], [
            'deflatedParameters' => ['news' => 123],
            '_decoratedParameters' => ['type' => 999],
            '_page' => [
                'l10n_parent' => 0,
                'MPvar' => '1-2',
                'sys_language_uid' => 0,
                't3ver_oid' => 20,
                'uid' => 10,
            ],
        ]);

        $result = $subject->buildResult($route, [], ['type' => 0]);

        self::assertSame(20, $result->getPageId());
        self::assertSame('999', $result->getPageType());
        self::assertSame('1-2', $result->get('MP'));
        self::assertSame([
            'action' => 'detail',
            'controller' => 'News',
            'news' => 123,
        ], $result->get('tx_news_pi1'));
    }

    #[Test]
    public function buildResultUsesLanguageParentAndFallbackTypeFromQueryParameters(): void
    {
        $subject = new ExtbasePluginQueryEnhancer([
            'extension' => 'news',
            'plugin' => 'Pi1',
            '_controller' => 'News::list',
        ]);

        $route = new Route('/', [], [], [
            'deflatedParameters' => [],
            '_page' => [
                'l10n_parent' => 30,
                'sys_language_uid' => 0,
                't3ver_oid' => 20,
                'uid' => 10,
            ],
        ]);

        $result = $subject->buildResult($route, [], ['type' => 123]);

        self::assertSame(30, $result->getPageId());
        self::assertSame('123', $result->getPageType());
        self::assertNull($result->get('MP'));
        self::assertSame([
            'action' => 'list',
            'controller' => 'News',
        ], $result->get('tx_news_pi1'));
    }
}
