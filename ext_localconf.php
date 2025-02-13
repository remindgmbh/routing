<?php

declare(strict_types=1);

use Remind\Routing\Aspect\DynamicValueMapper;
use Remind\Routing\Aspect\PersistedValueMapper;
use Remind\Routing\Enhancer\ExtbasePluginQueryEnhancer;

defined('TYPO3') || die('Access denied.');

(function (): void {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['PersistedValueMapper'] = PersistedValueMapper::class;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['aspects']['DynamicValueMapper'] = DynamicValueMapper::class;

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['enhancers']['ExtbaseQuery'] = ExtbasePluginQueryEnhancer::class;
})();
