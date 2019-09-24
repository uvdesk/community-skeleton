Getting Started: Model First
============================

.. note:: *Development Workflows*

    When you :doc:`Code First <getting-started>`, you
    start with developing Objects and then map them onto your database. When
    you :doc:`Model First <getting-started-models>`, you are modelling your application using tools (for
    example UML) and generate database schema and PHP code from this model.
    When you have a :doc:`Database First <getting-started-database>`, then you already have a database schema
    and generate the corresponding PHP code from it.

.. note::

    This getting started guide is in development.

There are applications when you start with a high-level description of the
model using modelling tools such as UML. Modelling tools could also be Excel,
XML or CSV files that describe the model in some structured way. If your
application is using a modelling tool, then the development workflow is said to
be a  *Model First* approach to Doctrine2.

In this workflow you always change the model description and then regenerate
both PHP code and database schema from this model.
