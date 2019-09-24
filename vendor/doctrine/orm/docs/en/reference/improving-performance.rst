Improving Performance
=====================

Bytecode Cache
--------------

It is highly recommended to make use of a bytecode cache like APC.
A bytecode cache removes the need for parsing PHP code on every
request and can greatly improve performance.

    "If you care about performance and don't use a bytecode
    cache then you don't really care about performance. Please get one
    and start using it."
    
    *Stas Malyshev, Core Contributor to PHP and Zend Employee*


Metadata and Query caches
-------------------------

As already mentioned earlier in the chapter about configuring
Doctrine, it is strongly discouraged to use Doctrine without a
Metadata and Query cache (preferably with APC or Memcache as the
cache driver). Operating Doctrine without these caches means
Doctrine will need to load your mapping information on every single
request and has to parse each DQL query on every single request.
This is a waste of resources.

Alternative Query Result Formats
--------------------------------

Make effective use of the available alternative query result
formats like nested array graphs or pure scalar results, especially
in scenarios where data is loaded for read-only purposes.

Read-Only Entities
------------------

Starting with Doctrine 2.1 you can mark entities as read only (See metadata mapping
references for details). This means that the entity marked as read only is never considered
for updates, which means when you call flush on the EntityManager these entities are skipped
even if properties changed. Read-Only allows to persist new entities of a kind and remove existing
ones, they are just not considered for updates.

Extra-Lazy Collections
----------------------

If entities hold references to large collections you will get performance and memory problems initializing them.
To solve this issue you can use the EXTRA_LAZY fetch-mode feature for collections. See the :doc:`tutorial <../tutorials/extra-lazy-associations>`
for more information on how this fetch mode works.

Temporarily change fetch mode in DQL
------------------------------------

See :ref:`Doctrine Query Language chapter <dql-temporarily-change-fetch-mode>`


Apply Best Practices
--------------------

A lot of the points mentioned in the Best Practices chapter will
also positively affect the performance of Doctrine.


Change Tracking policies
------------------------

See: :doc:`Change Tracking Policies <reference/change-tracking-policies>`
