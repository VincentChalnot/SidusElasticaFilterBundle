<?php
/*
 *  Sidus/ElasticaFilterBundle : Elastic Search support for Sidus/FilterBundle
 *  Copyright (C) 2015-2018 Vincent Chalnot
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
