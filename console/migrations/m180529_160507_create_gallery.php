<?php

class m180529_160507_create_gallery extends \yii\mongodb\Migration {

    public function up() {

        $this->createCollection(['gallery', 'gallery'], [
            'title' => 'Baan Kata Villa',
            'detail'=>'',
            'cate_id'=>''
        ]);

    }

    public function down() {
        echo "m180529_160507_create_gallery cannot be reverted.\n";

        $this->dropCollection(['gallery', 'gallery']);

        return false;
    }

}
