<?php


use Phinx\Migration\AbstractMigration;

class FormSubmissionsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {

        $users = $this->table('form_submissions');
        $users->addColumn('fullName', 'string', ['limit' => 60])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('message', 'text', ['limit' => 100])
            ->save();
    }
}
