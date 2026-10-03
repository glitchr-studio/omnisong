<?php

namespace Omnisong\Catalog;

/** Builds a catalogue from its options (a key, a country...). */
interface CatalogFactoryInterface
{
    /** The name catalogues are configured with: "odesli", "itunes"... */
    public function getName(): string;

    /** @param array<string, mixed> $options */
    public function create(array $options = []): CatalogInterface;
}
