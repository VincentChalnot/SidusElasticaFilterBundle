<?php
/*
 * This file is part of the Sidus/FilterBundle package.
 *
 * Copyright (c) 2015-2021 Vincent Chalnot
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sidus\ElasticaFilterBundle\Filter\Type;

use Elastica\Query\AbstractQuery;
use Elastica\Query\BoolQuery;
use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\FilterBundle\Filter\FilterInterface;
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
    protected function handleTerms(ElasticaQueryHandlerInterface $queryHandler, $terms): void
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

    protected function applyQuery(
        ElasticaQueryHandlerInterface $queryHandler,
        FilterInterface $filter,
        $data,
        callable $callback
    ): void {
        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            if (\is_array($data)) {
                $bool = new BoolQuery();
                foreach ($data as $datum) {
                    $bool->addShould($callback($attributePath, $datum));
                }
                $terms[] = $bool;
            } else {
                $terms[] = $callback($attributePath, $data);
            }
        }

        $this->handleTerms($queryHandler, $terms);
    }
}
