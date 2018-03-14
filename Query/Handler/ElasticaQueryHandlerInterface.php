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

use Elastica\Query;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;

/**
 * Handles filtering with Elastica Search
 *
 * @author Vincent Chalnot <vincent@sidus.fr>
 */
interface ElasticaQueryHandlerInterface extends QueryHandlerInterface
{
    /**
     * @return Query
     */
    public function getQuery(): Query;

    /**
     * @return Query\BoolQuery
     */
    public function getRootBoolQuery(): Query\BoolQuery;

    /**
     * @param Query\AbstractQuery $query
     */
    public function addMustQuery(Query\AbstractQuery $query);

    /**
     * @throws \UnexpectedValueException
     *
     * @return PaginatedFinderInterface
     */
    public function getFinder(): PaginatedFinderInterface;
}
