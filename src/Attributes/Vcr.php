<?php declare(strict_types=1);

namespace VCR\PHPUnit\TestListener\Attributes;

use Attribute;

/**
 * @immutable
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class Vcr
{
    /**
     * @var non-empty-string
     */
    private string $cassette;

    /**
     * @param non-empty-string $cassette
     */
    public function __construct(string $cassette)
    {
        $this->cassette = $cassette;
    }

    /**
     * @return non-empty-string
     */
    public function cassette(): string
    {
        return $this->cassette;
    }
}
