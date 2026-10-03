<?php

namespace Omnisong\Model;

/** Something an <audio> element can play: a file of the site's, or a catalogue's preview. */
final class Source
{
    public const FILE = 'file';
    public const PREVIEW = 'preview';

    public function __construct(
        public readonly string $url,
        public readonly string $kind = self::FILE,
        public readonly ?string $mime = null,
        /** seconds, when known */
        public readonly ?int $duration = null,
    ) {
    }
}
