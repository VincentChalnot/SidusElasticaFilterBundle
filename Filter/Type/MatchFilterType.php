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

use Elastica\Query\Match;
use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;

/**
 * Standard filter type for text indexes
 */
class MatchFilterType extends AbstractElasticaFilterType
{
    public function handleData(QueryHandlerInterface $queryHandler, FilterInterface $filter, $data): void
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }

        $this->applyQuery(
            $queryHandler,
            $filter,
            $data,
            function (string $attributePath, $data) {
                return new Match($attributePath, $data);
            }
        );
    }
}
