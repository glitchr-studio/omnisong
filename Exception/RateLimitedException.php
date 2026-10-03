<?php

namespace Omnisong\Exception;

/** The service asks to slow down (Odesli: 10 requests a minute without a key). */
final class RateLimitedException extends UnavailableException
{
    public function __construct(string $catalog, public readonly ?int $retryAfter = null, ?\Throwable $previous = null)
    {
        parent::__construct($catalog, $retryAfter ? \sprintf('rate limited, retry in %d s', $retryAfter) : 'rate limited', 429, $previous);
    }
}
