<?php

namespace VCR\PHPUnit\TestListener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
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
 * <listeners>
 *   <listener class="VCR\PHPUnit\TestListener\VCRTestListener" file="vendor/php-vcr/phpunit-testlistener-vcr/src/VCRTestListener.php" />
 * </listeners>
 * </code>
 *
 * @author    Adrian Philipp <mail@adrian-philipp.com>
 * @author    Davide Borsatto <davide.borsatto@gmail.com>
 * @copyright 2011-2017 Adrian Philipp <mail@adrian-philipp.com>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 *
 * @version   Release: @package_version@
 *
 * @see       http://www.phpunit.de/
 */
class VCRTestListener implements TestListener
{
    /**
     * @var array
     */
    protected $runs = array();

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var int
     */
    protected $suites = 0;

    /**
     * Constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
    }

    /**
     * An error occurred.
     *
     * @param Test      $test
     * @param Exception $e
     * @param float     $time
     */
    public function addError(Test $test, \Throwable $t, float $time): void
    {
    }

    /**
     * A warning occurred.
     *
     * @param Test    $test
     * @param Warning $e
     * @param float   $time
     *
     * @since Method available since Release 5.1.0
     */
    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }

    /**
     * A failure occurred.
     *
     * @param Test                 $test
     * @param AssertionFailedError $e
     * @param float                $time
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    /**
     * Incomplete test.
     *
     * @param Test       $test
     * @param \Exception $e
     * @param float      $time
     */
    public function addIncompleteTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * Skipped test.
     *
     * @param Test       $test
     * @param \Exception $e
     * @param float      $time
     */
    public function addSkippedTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * Risky test.
     *
     * @param Test       $test
     * @param \Exception $e
     * @param float      $time
     */
    public function addRiskyTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * A test started.
     *
     * @param Test $test
     *
     * @return bool|null
     */
    public function startTest(Test $test): void
    {
        $class = get_class($test);
        $method = $test->getName(false);

        if (!method_exists($class, $method)) {
            return;
        }

        $reflection = new \ReflectionMethod($class, $method);
        $docBlock = $reflection->getDocComment();

        // Use regex to parse the doc_block for a specific annotation
        $parsed = self::parseDocBlock($docBlock, '@vcr');
        $cassetteName = array_pop($parsed);

        // If the cassette name ends in .json, then use the JSON storage format
        if (substr($cassetteName, '-5') == '.json') {
            VCR::configure()->setStorage('json');
        }

        if (empty($cassetteName)) {
            return;
        }

        VCR::turnOn();
        VCR::insertCassette($cassetteName);
    }

    private static function parseDocBlock($docBlock, $tag)
    {
        $matches = array();

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

    /**
     * A test ended.
     *
     * @param Test  $test
     * @param float $time
     */
    public function endTest(Test $test, float $time): void
    {
        VCR::turnOff();
    }

    /**
     * A test suite started.
     *
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite): void
    {
    }

    /**
     * A test suite ended.
     *
     * @param TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite): void
    {
    }
}
