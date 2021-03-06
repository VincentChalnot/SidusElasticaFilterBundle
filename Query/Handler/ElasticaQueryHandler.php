<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle\Query\Handler;

use Sidus\ElasticaFilterBundle\Registry\ElasticaFinderRegistry;
use Elastica\Query;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Sidus\FilterBundle\DTO\SortConfig;
use Sidus\FilterBundle\Query\Handler\AbstractQueryHandler;
use Sidus\FilterBundle\Query\Handler\Configuration\QueryHandlerConfigurationInterface;
use Sidus\FilterBundle\Registry\FilterTypeRegistry;

/**
 * Handles filtering on EAV model
 *
 * @author Vincent Chalnot <vincent@sidus.fr>
 */
class ElasticaQueryHandler extends AbstractQueryHandler implements ElasticaQueryHandlerInterface
{
    /** @var PaginatedFinderInterface */
    protected $finder;

    /** @var Query */
    protected $query;

    /** @var Query\BoolQuery */
    protected $rootBoolQuery;

    /**
     * @param FilterTypeRegistry                 $filterTypeRegistry
     * @param QueryHandlerConfigurationInterface $configuration
     * @param ElasticaFinderRegistry             $finderRegistry
     *
     * @throws \UnexpectedValueException
     */
    public function __construct(
        FilterTypeRegistry $filterTypeRegistry,
        QueryHandlerConfigurationInterface $configuration,
        ElasticaFinderRegistry $finderRegistry
    ) {
        parent::__construct($filterTypeRegistry, $configuration);

        try {
            $this->finder = $finderRegistry->getFinder($this->configuration->getOption('reference'));
        } catch (\Exception $e) {
            throw new \UnexpectedValueException(
                "Wrong index 'reference' option for filter configuration {$this->getConfiguration()->getCode()}",
                0,
                $e
            );
        }
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        if (null === $this->query) {
            $this->query = new Query($this->getRootBoolQuery());
        }

        return $this->query;
    }

    /**
     * @return Query\BoolQuery
     */
    public function getRootBoolQuery(): Query\BoolQuery
    {
        if (null === $this->rootBoolQuery) {
            $this->rootBoolQuery = new Query\BoolQuery();
        }

        return $this->rootBoolQuery;
    }

    /**
     * @param Query\AbstractQuery $query
     */
    public function addMustQuery(Query\AbstractQuery $query)
    {
        $this->getRootBoolQuery()->addMust($query);
    }

    /**
     * @throws \UnexpectedValueException
     *
     * @return PaginatedFinderInterface
     */
    public function getFinder(): PaginatedFinderInterface
    {
        return $this->finder;
    }

    /**
     * @param SortConfig $sortConfig
     */
    protected function applySort(SortConfig $sortConfig)
    {
        if ($sortConfig->getColumn()) {
            $this->getQuery()->addSort([$sortConfig->getColumn() => $sortConfig->getDirection() ? 'desc' : 'asc']);
        }
    }

    /**
     * @param int $selectedPage
     *
     * @throws \UnexpectedValueException
     * @throws \Pagerfanta\Exception\NotIntegerMaxPerPageException
     * @throws \Pagerfanta\Exception\LessThan1MaxPerPageException
     * @throws \Pagerfanta\Exception\OutOfRangeCurrentPageException
     * @throws \Pagerfanta\Exception\NotIntegerCurrentPageException
     * @throws \Pagerfanta\Exception\LessThan1CurrentPageException
     */
    protected function applyPager($selectedPage = null)
    {
        if ($selectedPage) {
            $this->sortConfig->setPage($selectedPage);
        }

        $query = $this->getQuery();
        $this->pager = $this->getFinder()->findPaginated($query);
        $this->pager->setMaxPerPage($this->getConfiguration()->getResultsPerPage());
        try {
            $this->pager->setCurrentPage($this->sortConfig->getPage());
        } catch (NotValidCurrentPageException $e) {
            $this->sortConfig->setPage($this->pager->getCurrentPage());
        }
    }
}
