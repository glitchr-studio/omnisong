<?php

namespace Omnisong\Model;

/** A performer as a catalogue names it, with its ids on the platforms that gave one. */
final class Artist
{
    /** @param array<string, string> $ids platform value => the platform's id */
    public function __construct(
        public readonly string $name,
        public readonly array $ids = [],
        public readonly ?string $url = null,
        public readonly ?string $imageUrl = null,
    ) {
    }
}
