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
use Elastica\Query\Term;
use Sidus\FilterBundle\Exception\BadQueryHandlerException;
use Sidus\FilterBundle\Filter\FilterInterface;
use Sidus\FilterBundle\Query\Handler\QueryHandlerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Replaces the standard ChoiceFilterType
 */
class ChoiceFilterType extends AbstractElasticaFilterType
{
    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function handleForm(QueryHandlerInterface $queryHandler, FilterInterface $filter, FormInterface $form)
    {
        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }
        $data = $form->getData();
        if (null === $data || (\is_array($data) && 0 === \count($data))) {
            return;
        }

        /** @var AbstractQuery[] $terms */
        $terms = [];
        foreach ($filter->getAttributes() as $attributePath) {
            $terms[] = new Term([$attributePath => $data]);
        }

        $this->handleTerms($queryHandler, $terms);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormOptions(QueryHandlerInterface $queryHandler, FilterInterface $filter): array
    {
        if (isset($filter->getFormOptions()['choices'])) {
            return parent::getFormOptions($queryHandler, $filter);
        }

        if (!$queryHandler instanceof ElasticaQueryHandlerInterface) {
            throw new BadQueryHandlerException($queryHandler, ElasticaQueryHandlerInterface::class);
        }

        // @todo
        $choices = [];

        return array_merge(
            $this->formOptions,
            $filter->getFormOptions(),
            ['choices' => $choices]
        );
    }
}
