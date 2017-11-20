<?php

use yii\db\Migration;

/**
 * Class m171119_220638_new_table_products
 */
class m171119_220638_new_table_products extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('economy_products', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'category' => $this->integer(),
            'count' => $this->integer(),
        ]);
        return false;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('economy_products');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171119_220638_NewTableProducts cannot be reverted.\n";

        return false;
    }
    */
}
