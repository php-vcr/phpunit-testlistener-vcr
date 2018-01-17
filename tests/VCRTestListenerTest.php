<?php

namespace Tests\VCR\PHPUnit\TestListener;

use PHPUnit\Framework\TestCase;
use VCR\VCR;

/**
 * Test integration of PHPVCR with PHPUnit using annotations.
 */
class VCRTestListenerTest extends TestCase
{
    public function testTakesConfigurationFromListenerConfig()
    {
        // phpunit.xml.dist has already set the mode to "none", default is "new_episodes"
        $this->assertEquals(VCR::MODE_NONE, VCR::configure()->getMode());
    }

    /**
     * @vcr unittest_annotation_test
     */
    public function testInterceptsWithAnnotations()
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is a annotation test dummy".
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }

    /**
     * @vcr unittest_annotation_test.yml
     */
    public function testInterceptsWithAnnotationsAndFileExtension()
    {
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }

    /**
     * @vcr unittest_annotation_test
     * @dataProvider aDataProvider
     */
    public function testInterceptsWithAnnotationsWhenUsingDataProvider($dummyValue)
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is an annotation test dummy".
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations with data provider).');
    }

    public function aDataProvider()
    {
        return array(
            array(1),
            array(2),
        );
    }
}
