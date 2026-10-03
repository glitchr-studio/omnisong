<?php

namespace Omnisong\Model;

/** The label a release came out on: who to show first, and where its shop is. */
final class Label
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $url = null,
        public readonly ?string $shopUrl = null,
    ) {
    }
}
