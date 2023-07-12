<?php
declare(strict_types=1);

namespace VCR\PHPUnit\TestListener;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use VCR\PHPUnit\TestListener\Subscribers\BeforeTestEnds;
use VCR\PHPUnit\TestListener\Subscribers\OnTestPrepared;

/**
 * An extension that integrates with PHP-VCR.
 *
 * Here is an example XML configuration for activating this extension:
 *
 * <code>
 *   <extensions>
 *     <bootstrap class="VCR\PHPUnit\TestListener\VCRTestListener" />
 *   </listeners>
 * </code>
 *
 * @author    Adrian Philipp  <mail@adrian-philipp.com>
 * @author    Davide Borsatto <davide.borsatto@gmail.com>
 * @author    Renato Mefi     <gh@mefi.in>
 */
final class VCRTestListener implements Extension
{
    /**
     * @param Configuration $configuration
     * @param Facade $facade
     * @param ParameterCollection $parameters
     * @return void
     */
    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $facade->registerSubscribers(
            new OnTestPrepared(),
            new BeforeTestEnds(),
        );
    }
}
