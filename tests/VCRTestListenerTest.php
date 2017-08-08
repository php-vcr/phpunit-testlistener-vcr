<?php

namespace Tests\VCR\PHPUnit\TestListener;

use PHPUnit\Framework\TestCase;

/**
 * Test integration of PHPVCR with PHPUnit using annotations.
 */
class VCRTestListenerTest extends TestCase
{
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
