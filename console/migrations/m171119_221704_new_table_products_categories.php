<?php

use yii\db\Migration;

/**
 * Class m171119_221704_new_table_products_categories
 */
class m171119_221704_new_table_products_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('economy_products_categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sort' => $this->integer(),
        ]);
        return false;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('economy_products_categories');
        return false;
    }
}
