<?php

namespace Doctrine\DBAL\Schema\Visitor;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;

/**
 * Visit a SchemaDiff.
 */
interface SchemaDiffVisitor
{
    /**
     * Visit an orphaned foreign key whose table was deleted.
     */
    public function visitOrphanedForeignKey(ForeignKeyConstraint $foreignKey);

    /**
     * Visit a sequence that has changed.
     */
    public function visitChangedSequence(Sequence $sequence);

    /**
     * Visit a sequence that has been removed.
     */
    public function visitRemovedSequence(Sequence $sequence);

    public function visitNewSequence(Sequence $sequence);

    public function visitNewTable(Table $table);

    public function visitNewTableForeignKey(Table $table, ForeignKeyConstraint $foreignKey);

    public function visitRemovedTable(Table $table);

    public function visitChangedTable(TableDiff $tableDiff);
}
