<?php

namespace Omnisong\Model;

/**
 * An album, a single, an EP as the catalogues know it: its title, its
 * artist, its label, the UPC that names it, its cover, its tracks, and the
 * links to every platform (the label's first).
 */
final class Release
{
    public const ALBUM = 'album';
    public const SINGLE = 'single';
    public const EP = 'ep';

    /**
     * @param list<Track>           $tracks
     * @param array<string, string> $ids    platform value => the platform's id
     */
    public function __construct(
        public readonly string $title,
        public readonly ?string $artist = null,
        public readonly ?Label $label = null,
        public readonly ?string $upc = null,
        public readonly ?\DateTimeImmutable $releasedAt = null,
        public readonly ?string $coverUrl = null,
        public readonly string $type = self::ALBUM,
        public readonly array $tracks = [],
        public readonly ?PlatformLinks $links = null,
        public readonly ?string $genre = null,
        public readonly ?int $trackCount = null,
        public readonly array $ids = [],
        public readonly ?string $copyright = null,
    ) {
    }

    public function withLinks(PlatformLinks $links): self
    {
        return new self($this->title, $this->artist, $this->label, $this->upc, $this->releasedAt, $this->coverUrl, $this->type, $this->tracks, $links, $this->genre, $this->trackCount, $this->ids, $this->copyright);
    }

    /** @param list<Track> $tracks */
    public function withTracks(array $tracks): self
    {
        return new self($this->title, $this->artist, $this->label, $this->upc, $this->releasedAt, $this->coverUrl, $this->type, $tracks, $this->links, $this->genre, $this->trackCount ?? \count($tracks), $this->ids, $this->copyright);
    }

    public function withLabel(?Label $label): self
    {
        return new self($this->title, $this->artist, $label, $this->upc, $this->releasedAt, $this->coverUrl, $this->type, $this->tracks, $this->links, $this->genre, $this->trackCount, $this->ids, $this->copyright);
    }

    /** What another catalogue knew that this one did not: each null filled, tracks and links merged. */
    public function merge(?self $other): self
    {
        if (null === $other) {
            return $this;
        }
        $tracks = $this->tracks ?: $other->tracks;
        if ($this->tracks && $other->tracks) {
            $byIsrc = [];
            foreach ($other->tracks as $track) {
                if ($track->isrc) {
                    $byIsrc[$track->isrc] = $track;
                }
            }
            $tracks = [];
            foreach ($this->tracks as $i => $track) {
                $twin = ($track->isrc ? $byIsrc[$track->isrc] ?? null : null) ?? $other->tracks[$i] ?? null;
                $tracks[] = $twin && null === $track->previewUrl ? $track->withPreview($twin->previewUrl) : $track;
            }
        }

        return new self(
            $this->title,
            $this->artist ?? $other->artist,
            $this->label ?? $other->label,
            $this->upc ?? $other->upc,
            $this->releasedAt ?? $other->releasedAt,
            $this->coverUrl ?? $other->coverUrl,
            $this->type,
            $tracks,
            $this->links ? $this->links->merge($other->links) : $other->links,
            $this->genre ?? $other->genre,
            $this->trackCount ?? $other->trackCount,
            $this->ids + $other->ids,
            $this->copyright ?? $other->copyright,
        );
    }
}
