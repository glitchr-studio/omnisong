<?php

namespace Omnisong\Player;

/** How an embed should look: the theme of the page it sits in, compact or full, autoplay (only after a click). */
final class EmbedOptions
{
    public const LIGHT = 'light';
    public const DARK = 'dark';

    public function __construct(
        public readonly string $theme = self::LIGHT,
        public readonly bool $compact = false,
        public readonly bool $autoplay = false,
        /** ISO 3166-1 alpha-2: the store Apple Music opens (its URLs carry one; this overrides) */
        public readonly ?string $country = null,
        /** A hex colour without '#', for the players that take one (SoundCloud) */
        public readonly ?string $color = null,
    ) {
    }

    public function dark(): bool
    {
        return self::DARK === $this->theme;
    }
}
