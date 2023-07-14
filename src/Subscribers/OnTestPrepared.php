<?php

declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Subscribers;

use PHPUnit\Event;
use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Test\Prepared;
use VCR\VCR;

class OnTestPrepared implements Event\Test\PreparedSubscriber
{
    /**
     * @param Prepared $event
     * @return void
     * @throws \ReflectionException
     */
    public function notify(Prepared $event): void
    {
        $cassette = $this->getCassette($event->test());

        if (empty($cassette)) {
            return;
        }

        // Use the JSON storage format if applicable
        if (str_ends_with('.json', $cassette)) {
            VCR::configure()->setStorage('json');
        }

        VCR::turnOn();
        VCR::insertCassette($cassette);
    }

    /**
     * @param Test $test
     * @param string $tag
     * @return string|null
     * @throws \ReflectionException
     */
    public function getCassette(Test $test, string $tag = '@vcr'): ?string
    {
        $reflection = new \ReflectionClass($test);
        $class = $reflection->getProperty('className')->getValue($test);
        $method = $test->name();

        $reflection = new \ReflectionMethod($class, $method);
        $docblock = $reflection->getDocComment();

        if (!empty($docblock)) {
            $parsed = self::parseDocBlock($docblock, $tag);
            return array_pop($parsed);
        }

        return null;
    }

    /**
     * @param string $docBlock
     * @param string $tag
     * @return array<string>
     */
    private static function parseDocBlock(string $docBlock, string $tag): array
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
}
