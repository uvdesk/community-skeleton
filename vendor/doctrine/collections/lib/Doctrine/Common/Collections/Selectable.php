<?php

namespace Doctrine\Common\Collections;

/**
 * Interface for collections that allow efficient filtering with an expression API.
 *
 * Goal of this interface is a backend independent method to fetch elements
 * from a collections. {@link Expression} is crafted in a way that you can
 * implement queries from both in-memory and database-backed collections.
 *
 * For database backed collections this allows very efficient access by
 * utilizing the query APIs, for example SQL in the ORM. Applications using
 * this API can implement efficient database access without having to ask the
 * EntityManager or Repositories.
 *
 * @psalm-template TKey as array-key
 * @psalm-template T
 */
interface Selectable
{
    /**
     * Selects all elements from a selectable that match the expression and
     * returns a new collection containing these elements.
     *
     * @return Collection
     *
     * @psalm-return Collection<TKey,T>
     */
    public function matching(Criteria $criteria);
}
