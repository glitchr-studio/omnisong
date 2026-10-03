<?php

namespace Omnisong\Catalog;

use Omnisong\Model\PlatformLinks;
use Omnisong\Model\Reference;
use Omnisong\Model\Release;

/**
 * A service that knows recordings: where they are (the links), what they
 * are (a release with its tracks and previews), what an artist put out.
 * A catalogue answers what it can and throws NotSupportedException for
 * the rest; the aggregator (Catalog) asks the next one.
 */
interface CatalogInterface
{
    /** The name it is configured as: "odesli", "itunes"... */
    public function getName(): string;

    /** The same recording on every platform this catalogue knows. */
    public function links(Reference $reference): PlatformLinks;

    /** The release (its tracks, previews, cover, label...) the reference names, or null when unknown. */
    public function release(Reference $reference): ?Release;

    /**
     * What an artist put out, newest first.
     *
     * @return list<Release>
     */
    public function releases(string $artist, int $limit = 50, ?string $country = null): array;
}
