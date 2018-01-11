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

namespace Sidus\ElasticaFilterBundle\Factory;

use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandler;
use Sidus\ElasticaFilterBundle\Registry\ElasticaFinderRegistry;
use Sidus\FilterBundle\Factory\QueryHandlerFactoryInterface;
use Sidus\FilterBundle\Query\Handler\Configuration\QueryHandlerConfigurationInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;
use Sidus\FilterBundle\Registry\FilterTypeRegistry;

/**
 * Builds query handler for elastica search filtering
 */
class ElasticaQueryHandlerFactory implements QueryHandlerFactoryInterface
{
    /** @var FilterTypeRegistry */
    protected $filterTypeRegistry;

    /** @var ElasticaFinderRegistry */
    protected $finderRegistry;

    /**
     * @param FilterTypeRegistry     $filterTypeRegistry
     * @param ElasticaFinderRegistry $finderRegistry
     */
    public function __construct(
        FilterTypeRegistry $filterTypeRegistry,
        ElasticaFinderRegistry $finderRegistry
    ) {
        $this->filterTypeRegistry = $filterTypeRegistry;
        $this->finderRegistry = $finderRegistry;
    }

    /**
     * @param QueryHandlerConfigurationInterface $queryHandlerConfiguration
     *
     * @throws \UnexpectedValueException
     *
     * @return QueryHandlerInterface
     */
    public function createQueryHandler(
        QueryHandlerConfigurationInterface $queryHandlerConfiguration
    ): QueryHandlerInterface {
        return new ElasticaQueryHandler(
            $this->filterTypeRegistry,
            $queryHandlerConfiguration,
            $this->finderRegistry
        );
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return 'sidus.elastica';
    }
}
