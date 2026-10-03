<?php

namespace Omnisong\Model;

use Omnisong\Platform;

/** An iframe that plays from a platform: its markup, its size, where it loads from (for a CSP). */
final class Embed
{
    public function __construct(
        public readonly Platform $platform,
        public readonly string $html,
        public readonly string $src,
        public readonly int $width,
        public readonly int $height,
    ) {
    }
}
