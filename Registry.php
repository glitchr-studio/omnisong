<?php

namespace Omnisong;

use Omnisong\Catalog\CatalogFactoryInterface;
use Omnisong\Catalog\CatalogInterface;
use Omnisong\Exception\InvalidConfigException;

/**
 * The catalogues by name, each built once from its factory and options:
 *
 *   new Registry([new OdesliCatalogFactory($http), new ItunesCatalogFactory($http)], [
 *       'odesli' => ['factory' => 'odesli', 'options' => ['api_key' => null]],
 *       'itunes' => ['factory' => 'itunes', 'options' => ['country' => 'de']],
 *   ]);
 */
final class Registry
{
    /** @var array<string, CatalogFactoryInterface> */
    private array $factories = [];

    /** @var array<string, CatalogInterface> */
    private array $catalogs = [];

    /**
     * @param iterable<CatalogFactoryInterface>                                      $factories
     * @param array<string, array{factory: string, options?: array<string, mixed>}> $config
     */
    public function __construct(iterable $factories, private readonly array $config)
    {
        foreach ($factories as $factory) {
            $this->factories[$factory->getName()] = $factory;
        }
    }

    public function get(string $name): CatalogInterface
    {
        if (isset($this->catalogs[$name])) {
            return $this->catalogs[$name];
        }
        $catalog = $this->config[$name] ?? throw new InvalidConfigException(\sprintf('No "%s" catalogue; configured: %s.', $name, implode(', ', array_keys($this->config)) ?: 'none'));
        $factory = $this->factories[$catalog['factory']] ?? throw new InvalidConfigException(\sprintf('No "%s" factory for the "%s" catalogue; installed: %s.', $catalog['factory'], $name, implode(', ', array_keys($this->factories)) ?: 'none'));

        return $this->catalogs[$name] = $factory->create($catalog['options'] ?? []);
    }

    public function has(string $name): bool
    {
        return isset($this->config[$name]);
    }

    /** @return list<string> */
    public function names(): array
    {
        return array_keys($this->config);
    }

    /** @return array<string, CatalogInterface> in the configured order */
    public function all(): array
    {
        $all = [];
        foreach (array_keys($this->config) as $name) {
            $all[$name] = $this->get($name);
        }

        return $all;
    }

    /** @return list<string> the factories installed: what `factory:` may name */
    public function factories(): array
    {
        return array_keys($this->factories);
    }
}
