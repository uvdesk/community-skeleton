Pagination
==========

.. versionadded:: 2.2

Starting with version 2.2 Doctrine ships with a Paginator for DQL queries. It
has a very simple API and implements the SPL interfaces ``Countable`` and
``IteratorAggregate``.

.. code-block:: php

    <?php
    use Doctrine\ORM\Tools\Pagination\Paginator;

    $dql = "SELECT p, c FROM BlogPost p JOIN p.comments c";
    $query = $entityManager->createQuery($dql)
                           ->setFirstResult(0)
                           ->setMaxResults(100);

    $paginator = new Paginator($query, $fetchJoinCollection = true);

    $c = count($paginator);
    foreach ($paginator as $post) {
        echo $post->getHeadline() . "\n";
    }

Paginating Doctrine queries is not as simple as you might think in the
beginning. If you have complex fetch-join scenarios with one-to-many or
many-to-many associations using the "default" LIMIT functionality of database
vendors is not sufficient to get the correct results.

By default the pagination extension does the following steps to compute the
correct result:

- Perform a Count query using `DISTINCT` keyword.
- Perform a Limit Subquery with `DISTINCT` to find all ids of the entity in from on the current page.
- Perform a WHERE IN query to get all results for the current page.

This behavior is only necessary if you actually fetch join a to-many
collection. You can disable this behavior by setting the
``$fetchJoinCollection`` flag to ``false``; in that case only 2 instead of the 3 queries
described are executed. We hope to automate the detection for this in
the future.
