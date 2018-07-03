<?php
declare(strict_types=1);

namespace Tests\VCR\PHPUnit\TestListener;

use PHPUnit\Framework\TestCase;

final class VCRTestListenerTest extends TestCase
{
    /**
     * @vcr unittest_annotation_test
     */
    public function testInterceptsWithAnnotations(): void
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is a annotation test dummy".
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }

    /**
     * @vcr unittest_annotation_test.yml
     */
    public function testInterceptsWithAnnotationsAndFileExtension(): void
    {
        $result = file_get_contents('http://google.com');
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations).');
    }

    /**
     * @vcr unittest_annotation_test
     *
     * @dataProvider dummyDataProvider
     */
    public function testInterceptsWithAnnotationsWhenUsingDataProvider(int $dummyValue): void
    {
        // Content of tests/fixtures/unittest_annotation_test: "This is an annotation test dummy".
        $result = file_get_contents('http://google.com');
        // Just to avoid the dummy to annoy the static analyzers
        \assert(\is_int($dummyValue));
        $this->assertEquals('This is a annotation test dummy.', $result, 'Call was not intercepted (using annotations with data provider).');
    }

    /**
     * @group https://github.com/php-vcr/phpunit-testlistener-vcr/issues/29
     */
    public function testNoVcrAnnotationRunsSuccessfulAndDoesNotProduceWarnings()
    {
        $this->assertTrue(true, 'just adding an assertion here');
    }

    public function dummyDataProvider(): array
    {
        return [
            [1],
            [2],
        ];
    }
}
