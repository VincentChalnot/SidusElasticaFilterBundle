<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2018 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
