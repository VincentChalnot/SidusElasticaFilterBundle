<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle\Registry;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

/**
 * References all Elastica finder services in the same place, indexed by their service's id
 */
class ElasticaFinderRegistry
{
    /** @var PaginatedFinderInterface[] */
    protected $finders;

    /**
     * @return PaginatedFinderInterface[]
     */
    public function getFinders(): array
    {
        return $this->finders;
    }

    /**
     * @param string                   $name
     * @param PaginatedFinderInterface $finder
     */
    public function addFinder(string $name, PaginatedFinderInterface $finder)
    {
        $this->finders[$name] = $finder;
    }

    /**
     * @param string $name
     *
     * @throws \UnexpectedValueException
     *
     * @return PaginatedFinderInterface
     */
    public function getFinder(string $name)
    {
        if (!$this->hasFinder($name)) {
            throw new \UnexpectedValueException("Missing finder {$name}");
        }

        return $this->finders[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasFinder(string $name): bool
    {
        return array_key_exists($name, $this->finders);
    }
}
