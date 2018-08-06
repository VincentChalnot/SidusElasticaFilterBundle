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

use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Elastica\Query\AbstractQuery;
use Elastica\Query\Wildcard;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;

/**
 * Replaces the standard TextFilterType
 */
class TextFilterType extends AbstractElasticaFilterType
{
    /**
     * {@inheritdoc}
     *
     * @throws \Elastica\Exception\InvalidException
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function handleData(QueryHandlerInterface $queryHandler, FilterInterface $filter, $data): void
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }

        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            $terms[] = $this->createQuery($attributePath, $data);
        }

        $this->handleTerms($queryHandler, $terms);
    }

    /**
     * @param string $attributePath
     * @param mixed  $data
     *
     * @return \Elastica\Param
     */
    protected function createQuery($attributePath, $data)
    {
        return new Wildcard($attributePath, '*'.$data.'*');
    }
}
