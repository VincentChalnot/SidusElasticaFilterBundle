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

use Elastica\SearchableInterface;

/**
 * References all Elastica Searchable services in the same place, indexed by their service's id
 */
class ElasticaSearchableRegistry
{
    /** @var SearchableInterface[] */
    protected $searchables;

    /**
     * @return SearchableInterface[]
     */
    public function getSearchables(): array
    {
        return $this->searchables;
    }

    /**
     * @param string                   $name
     * @param SearchableInterface $Searchable
     */
    public function addSearchable(string $name, SearchableInterface $Searchable)
    {
        $this->searchables[$name] = $Searchable;
    }

    /**
     * @param string $name
     *
     * @throws \UnexpectedValueException
     *
     * @return SearchableInterface
     */
    public function getSearchable(string $name)
    {
        if (!$this->hasSearchable($name)) {
            dump($this->searchables);
            throw new \UnexpectedValueException("Missing Searchable {$name}");
        }

        return $this->searchables[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasSearchable(string $name): bool
    {
        return array_key_exists($name, $this->searchables);
    }
}
