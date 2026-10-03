<?php

namespace Omnisong\Model;

/**
 * One recording of a release: its place, its title, who plays, the ISRC
 * that names it everywhere, and the preview a catalogue offers (iTunes:
 * 30 seconds, licensed for that use).
 */
final class Track
{
    /** @param array<string, string> $ids platform value => the platform's id */
    public function __construct(
        public readonly string $title,
        public readonly ?int $position = null,
        public readonly ?int $disc = null,
        /** seconds */
        public readonly ?int $duration = null,
        public readonly ?string $isrc = null,
        public readonly ?string $previewUrl = null,
        public readonly ?string $artist = null,
        public readonly ?string $composer = null,
        public readonly array $ids = [],
        public readonly ?string $url = null,
    ) {
    }

    public function withPreview(?string $previewUrl): self
    {
        return new self($this->title, $this->position, $this->disc, $this->duration, $this->isrc, $previewUrl, $this->artist, $this->composer, $this->ids, $this->url);
    }
}
