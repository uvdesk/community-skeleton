# Upgrade Paginator to 2.3 version

Changes to adapt to on view:

- Pagination:
    - Before

            {{ pagination.render()|raw }}

    - After

            {{ knp_pagination_render(pagination) }}

- Sortable:
    - Before:

            {{ pagination.sortable('Name', 'name')|raw }}

    - After:

            {{ knp_pagination_sortable(pagination, 'Name', 'name') }}



# Upgrade Paginator to 2.2 version

Changes to adapt to

- paginator option **alias** was removed, different names for query parameters can be set from now
on see the [configuration options](http://github.com/KnpLabs/KnpPaginatorBundle/blob/master/README.md#configuration)
and [changing query parameters](http://github.com/KnpLabs/KnpPaginatorBundle/blob/master/Resources/doc/templates.md#query-parameters) documentation
- paginator option **whitelist** has changed to **sortFieldWhitelist**
- regarding changes of query parameter handling, if you have extended pagination view, you will need
to adapt query parameter name key usage, see [default
template](http://github.com/KnpLabs/KnpPaginatorBundle/blob/master/Resources/views/Pagination/sliding.html.twig)

All these will help to use SEO friendly urls and makes it possible to inject translated parameter
names into the paginator service as default options. Documentation on this part will be next in todo
list.
