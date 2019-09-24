Association Updates: Owning Side and Inverse Side
=================================================

When mapping bidirectional associations it is important to
understand the concept of the owning and inverse sides. The
following general rules apply:

-  Relationships may be bidirectional or unidirectional.
-  A bidirectional relationship has both an owning side and an inverse side
-  A unidirectional relationship only has an owning side.
-  Doctrine will **only** check the owning side of an association for changes.

Bidirectional Associations
--------------------------

The following rules apply to **bidirectional** associations:

- The inverse side has to have the ``mappedBy`` attribute of the OneToOne,
  OneToMany, or ManyToMany mapping declaration. The mappedBy
  attribute contains the name of the association-field on the owning side.
- The owning side has to have the ``inversedBy`` attribute of the
  OneToOne, ManyToOne, or ManyToMany mapping declaration. 
  The inversedBy attribute contains the name of the association-field
  on the inverse-side.
- ManyToOne is always the owning side of a bidirectional association.
- OneToMany is always the inverse side of a bidirectional association.
- The owning side of a OneToOne association is the entity with the table
  containing the foreign key.
- You can pick the owning side of a many-to-many association yourself.

Important concepts
------------------

**Doctrine will only check the owning side of an association for changes.**

To fully understand this, remember how bidirectional associations
are maintained in the object world. There are 2 references on each
side of the association and these 2 references both represent the
same association but can change independently of one another. Of
course, in a correct application the semantics of the bidirectional
association are properly maintained by the application developer
(that's his responsibility). Doctrine needs to know which of these
two in-memory references is the one that should be persisted and
which not. This is what the owning/inverse concept is mainly used
for.

**Changes made only to the inverse side of an association are ignored. Make sure to update both sides of a bidirectional association (or at least the owning side, from Doctrine's point of view)**

The owning side of a bidirectional association is the side Doctrine
"looks at" when determining the state of the association, and
consequently whether there is anything to do to update the
association in the database.

.. note::

    "Owning side" and "inverse side" are technical concepts of
    the ORM technology, not concepts of your domain model. What you
    consider as the owning side in your domain model can be different
    from what the owning side is for Doctrine. These are unrelated.

