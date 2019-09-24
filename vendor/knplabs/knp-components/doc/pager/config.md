## Configuration


Some subscribers will take into account some options.  
These options can be passed as the 4th argument of `Paginator::paginate()`.

For example, Doctrine ORM subscriber will generate different sql queries if the `distinct` options changes.


The list of existing options are:

| name                       | type           | default value | subscribers                                     |
| -------------------------- | -------------- | ------------- | ----------------------------------------------- |
| wrap-queries               | bool           | false         | orm QuerySubscriber, orm QueryBuilderSubscriber |
| distinct                   | bool           | true          | QuerySubscriber, QueryBuilderSubscriber         |
| pageParameterName          | string         | page          | SortableSubscriber                              |
| defaultSortFieldName       | string\|array* |               | SortableSubscriber                              |
| defaultSortDirection       | string         | asc           | SortableSubscriber                              |
| sortFieldWhitelist         | array          | []            | SortableSubscriber                              |
| sortFieldParameterName     | string         | sort          | SortableSubscriber                              |
| sortDirectionParameterName | string         | direction     | SortableSubscriber                              |
| defaultFilterFields        | string\|array* |               | FiltrationSubscriber                            |
| filterFieldWhitelist       | array          |               | FiltrationSubscriber                            |
| filterFieldParameterName   | string         | filterParam   | FiltrationSubscriber                            |
| filterValueParameterName   | string         | filterValue   | FiltrationSubscriber                            |


## Noticeable behaviors of some options

### `distinct`

If set to true, will add a distinct sql keyword on orm queries to ensuire unicity of counted results


### `wrap-queries`

If set to true, will take advantage of doctrine 2.3 output walkers by using subqueries to handle composite keys and HAVING queries.
This can considerably impact performances depending on the query and the platform, you will have to consider it at some point.

If you want to order your results by a column from a fetch joined t-many association,
you have to set `wrap-queries` to `true`. Otherwise you will get an exception with this warning:
*"Cannot select distinct identifiers from query with LIMIT and ORDER BY on a column from a fetch joined to-many association. Use output walkers."*


### `defaultSortFieldName`

Used as default field name for the sorting. It can take an array for sorting by multiple fields.

\* **Attention**: Arrays are only supported for *Doctrine's ORM*.


### `defaultFilterFields`

Used as default field names for the filtration. It can take an array for filtering by multiple fields.
