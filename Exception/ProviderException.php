<?php

namespace Omnisong\Exception;

/** The catalogue's service answered with an error. */
class ProviderException extends \RuntimeException implements OmnisongException
{
    public function __construct(
        public readonly string $catalog,
        string $message,
        public readonly ?int $status = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(\sprintf('[%s] %s', $catalog, $message), 0, $previous);
    }
}
