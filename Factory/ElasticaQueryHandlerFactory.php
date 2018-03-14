<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
