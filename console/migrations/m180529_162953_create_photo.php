<?php

class m180529_162953_create_photo extends \yii\mongodb\Migration {

    public function up() {
        $this->createCollection(['gallery', 'photo'], [
            'file' => '',
            'gallery_id' => ''
        ]);
    }

    public function down() {
        echo "m180529_162953_create_photo cannot be reverted.\n";

        $this->dropCollection(['gallery', 'photo']);

        return false;
    }

}
