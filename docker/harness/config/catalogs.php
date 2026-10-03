<?php

/**
 * The catalogues, in the order the aggregator asks them, their options from
 * the environment (.env): a catalogue is configured only when every key
 * under "needs" is set. Odesli needs none to be asked, but refuses keyless
 * calls (401): without ODESLI_API_KEY it is skipped and said so.
 *
 * @return array<string, array{factory: string, needs: list<string>, options: array<string, mixed>}>
 */
$env = static fn (string $key, mixed $default = null): mixed => (false !== ($v = getenv($key)) && '' !== $v) ? $v : $default;

return [
    'odesli' => ['factory' => 'odesli', 'needs' => [], 'options' => ['api_key' => $env('ODESLI_API_KEY'), 'country' => $env('ODESLI_COUNTRY')]],
    'itunes' => ['factory' => 'itunes', 'needs' => [], 'options' => ['country' => $env('ITUNES_COUNTRY', 'us')]],
];
