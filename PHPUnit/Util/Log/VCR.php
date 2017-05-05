<?php
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\Warning;
use PHPUnit\Framework\TestSuite;

/**
 * A TestListener that integrates with PHP-VCR.
 *
 * Here is an example XML configuration for activating this listener:
 *
 * <code>
 * <listeners>
 *  <listener class="PHPUnit_Util_Log_VCR" file="PHPUnit/Util/Log/VCR.php" />
 * </listeners>
 * </code>
 *
 * @package    PHPUnit
 * @subpackage Util_Log
 * @author     Adrian Philipp <mail@adrian-philipp.com>
 * @copyright  2011-2016 Adrian Philipp <mail@adrian-philipp.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 1.0.0
 */
class PHPUnit_Util_Log_VCR implements TestListener
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
     * @var integer
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
    public function addError(Test $test, Exception $e, $time)
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
    public function addWarning(Test $test, Warning $e, $time)
    {
    }

    /**
     * A failure occurred.
     *
     * @param Test                 $test
     * @param AssertionFailedError $e
     * @param float                $time
     */
    public function addFailure(Test $test, AssertionFailedError $e, $time)
    {
    }

    /**
     * Incomplete test.
     *
     * @param Test      $test
     * @param Exception $e
     * @param float     $time
     */
    public function addIncompleteTest(Test $test, Exception $e, $time)
    {
    }

    /**
     * Skipped test.
     *
     * @param Test      $test
     * @param Exception $e
     * @param float     $time
     */
    public function addSkippedTest(Test $test, Exception $e, $time)
    {
    }

    /**
     * Risky test.
     *
     * @param Test      $test
     * @param Exception $e
     * @param float     $time
     */
    public function addRiskyTest(Test $test, Exception $e, $time)
    {

    }

    /**
     * A test started.
     *
     * @param Test $test
     * @return bool|null
     */
    public function startTest(Test $test)
    {
        $class      = get_class($test);
        $method     = $test->getName(false);

        if (!method_exists($class, $method)) {
            return;
        }

        $reflection = new ReflectionMethod($class, $method);
        $doc_block  = $reflection->getDocComment();

        // Use regex to parse the doc_block for a specific annotation
        $parsed = self::parseDocBlock($doc_block, '@vcr');
        $cassetteName = array_pop($parsed);

        // If the cassette name ends in .json, then use the JSON storage format
        if (substr($cassetteName, '-5') == '.json') {
            \VCR\VCR::configure()->setStorage('json');
        }

        if (empty($cassetteName)) {
            return true;
        }

        \VCR\VCR::turnOn();
        \VCR\VCR::insertCassette($cassetteName);
    }

    private static function parseDocBlock($doc_block, $tag)
    {
        $matches = array();

        if (empty($doc_block))
        return $matches;

        $regex = "/{$tag} (.*)(\\r\\n|\\r|\\n)/U";
        preg_match_all($regex, $doc_block, $matches);

        if (empty($matches[1])) {
            return array();
        }

        // Removed extra index
        $matches = $matches[1];

        // Trim the results, array item by array item
        foreach ($matches as $ix => $match)
        $matches[$ix] = trim( $match );

        return $matches;
    }

    /**
     * A test ended.
     *
     * @param Test $test
     * @param float                  $time
     */
    public function endTest(Test $test, $time)
    {
        \VCR\VCR::turnOff();
    }

    /**
     * A test suite started.
     *
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite)
    {
    }

    /**
     * A test suite ended.
     *
     * @param TestSuite $suite
     */
    public function endTestSuite(TestSuite $suite)
    {

    }
}
