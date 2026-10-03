<?php

namespace Omnisong\Catalog;

use Omnisong\Config;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * The Omnibus way, at its simplest: a catalogue's factory fills a Config -
 * its name ("omnisong.factory_name"), the options it needs
 * ("omnisong.required_options") and their defaults - then builds the
 * catalogue from it, on the application's HTTP client when one is given.
 */
abstract class CatalogFactory implements CatalogFactoryInterface
{
    public function __construct(protected readonly ?HttpClientInterface $http = null)
    {
    }

    public function getName(): string
    {
        return $this->createConfig()['omnisong.factory_name'];
    }

    public function create(array $options = []): CatalogInterface
    {
        $config = $this->createConfig($options);
        $config->validateNotEmpty($config->get('omnisong.required_options', []));

        return $this->build($config);
    }

    /** @param array<string, mixed> $options */
    public function createConfig(array $options = []): Config
    {
        $config = new Config($options);
        $this->populate($config);

        return $config;
    }

    /** The factory's name, its required options, the defaults of the others. */
    abstract protected function populate(Config $c): void;

    /** The catalogue, from a Config that holds everything it needs. */
    abstract protected function build(Config $c): CatalogInterface;
}
