<?php

use Phoenix\Migration\AbstractMigration;

class Initialization extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('orders', 'id')
            ->setCharset('utf8mb4')
            ->setCollation('utf8mb4_unicode_ci')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('name', 'string', ['null' => true])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('sum', 'string', ['null' => true])
            ->create();
    }

    protected function down(): void
    {
        $this->table('orders')
            ->drop();
    }
}
