<?php

namespace Omnisong\Exception;

/** A catalogue misconfigured: a key missing, an unknown factory. */
final class InvalidConfigException extends \LogicException implements OmnisongException
{
}
