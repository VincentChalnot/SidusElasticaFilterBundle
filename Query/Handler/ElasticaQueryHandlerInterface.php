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
