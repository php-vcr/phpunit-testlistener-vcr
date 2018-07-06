<?php
declare(strict_types=1);

namespace VCR\PHPUnit\TestListener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use VCR\VCR;

/**
 * A TestListener that integrates with PHP-VCR.
 *
 * Here is an example XML configuration for activating this listener:
 *
 * <code>
 *   <listeners>
 *     <listener class="VCR\PHPUnit\TestListener\VCRTestListener" file="vendor/php-vcr/phpunit-testlistener-vcr/src/VCRTestListener.php" />
 *   </listeners>
 * </code>
 *
 * @author    Adrian Philipp  <mail@adrian-philipp.com>
 * @author    Davide Borsatto <davide.borsatto@gmail.com>
 * @author    Renato Mefi     <gh@mefi.in>
 */
final class VCRTestListener implements TestListener
{
    public function startTest(Test $test): void
    {
        $class = \get_class($test);
        \assert($test instanceof TestCase);
        $method = $test->getName(false);

        if (!method_exists($class, $method)) {
            return;
        }

        $reflection = new \ReflectionMethod($class, $method);
        $docBlock = $reflection->getDocComment();

        // Use regex to parse the doc_block for a specific annotation
        $parsed = self::parseDocBlock($docBlock, '@vcr');
        $cassetteName = array_pop($parsed);

        if (empty($cassetteName)) {
            return;
        }

        // If the cassette name ends in .json, then use the JSON storage format
        if (substr($cassetteName, -5) === '.json') {
            VCR::configure()->setStorage('json');
        }

        VCR::turnOn();
        VCR::insertCassette($cassetteName);
    }

    private static function parseDocBlock($docBlock, $tag): array
    {
        $matches = [];

        if (empty($docBlock)) {
            return $matches;
        }

        $regex = "/{$tag} (.*)(\\r\\n|\\r|\\n)/U";
        preg_match_all($regex, $docBlock, $matches);

        if (empty($matches[1])) {
            return array();
        }

        // Removed extra index
        $matches = $matches[1];

        // Trim the results, array item by array item
        foreach ($matches as $ix => $match) {
            $matches[$ix] = trim($match);
        }

        return $matches;
    }

    public function endTest(Test $test, float $time): void
    {
        VCR::turnOff();
    }

    public function addError(Test $test, \Throwable $t, float $time): void
    {
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    public function addIncompleteTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function addSkippedTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function addRiskyTest(Test $test, \Throwable $e, float $time): void
    {
    }

    public function startTestSuite(TestSuite $suite): void
    {
    }

    public function endTestSuite(TestSuite $suite): void
    {
    }
}
