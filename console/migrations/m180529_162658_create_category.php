<?php

class m180529_162658_create_category extends \yii\mongodb\Migration {

    public function up() {
        $this->createCollection(['gallery', 'category'], [
            'title' => 'Pravince Phuket',
            'detail' => '',
            'pid' => ''
        ]);
    }

    public function down() {
        echo "m180529_162658_create_category cannot be reverted.\n";

        $this->dropCollection(['gallery', 'category']);

        return false;
    }

}
