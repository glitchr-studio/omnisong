<?php

namespace Omnisong\Player;

use Omnisong\Model\Embed;
use Omnisong\Model\PlatformLink;
use Omnisong\Platform;

/** Turns a platform link into the iframe that plays it - without any key, for the platforms that allow it. */
interface EmbedderInterface
{
    public function supports(Platform $platform): bool;

    /** null when the URL is not one this platform embeds (an artist page, a search...). */
    public function embed(PlatformLink $link, ?EmbedOptions $options = null): ?Embed;
}
