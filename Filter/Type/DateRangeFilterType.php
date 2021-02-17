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
use Elastica\Query\Range;
use Sidus\ElasticaFilterBundle\Query\Handler\ElasticaQueryHandlerInterface;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Form\Type\DateRangeType;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;

/**
 * Replaces the standard DateRangeFilterType
 */
class DateRangeFilterType extends AbstractElasticaFilterType
{
    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function handleData(QueryHandlerInterface $queryHandler, FilterInterface $filter, $data): void
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }
        if (!\is_array($data)) {
            return;
        }

        $params = $this->buildParams($data);
        if (0 === \count($params)) {
            return;
        }

        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            $terms[] = new Range($attributePath, $params);
        }

        $this->handleTerms($queryHandler, $terms);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function buildParams(array $data): array
    {
        $startDate = $data[DateRangeType::START_NAME] ?? null;
        $endDate = $data[DateRangeType::END_NAME] ?? null;
        $params = [];
        if ($startDate instanceof \DateTimeInterface) {
            $params['gte'] = $startDate->format(\DateTime::ATOM);
        }
        if ($endDate instanceof \DateTimeInterface) {
            $params['lte'] = $endDate->format(\DateTime::ATOM);
        }

        return $params;
    }
}
