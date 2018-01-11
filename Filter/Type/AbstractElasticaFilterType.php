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

namespace Sidus\ElasticaFilterBundle\Filter\Type;

use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\FilterBundle\Filter\Type\AbstractFilterType;

/**
 * Generic methods for Elastica filters types
 */
abstract class AbstractElasticaFilterType extends AbstractFilterType
{
    /**
     * @return string
     */
    public function getProvider(): string
    {
        return 'sidus.elastica';
    }

    /**
     * @param ElasticaQueryHandlerInterface $queryHandler
     * @param AbstractQuery[]               $terms
     */
    protected function handleTerms(ElasticaQueryHandlerInterface $queryHandler, $terms)
    {
        if (1 === \count($terms)) {
            $queryHandler->addMustQuery(reset($terms));
        } else {
            $bool = new BoolQuery();
            foreach ($terms as $term) {
                $bool->addShould($term);
            }
            $queryHandler->addMustQuery($bool);
        }
    }
}
