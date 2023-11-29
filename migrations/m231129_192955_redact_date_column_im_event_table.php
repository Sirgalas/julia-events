<?php

use app\Entities\Events\Entities\Events;
use yii\db\Migration;

/**
 * Class m231129_192955_redact_date_column_im_event_table
 */
class m231129_192955_redact_date_column_im_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Events::tableName(),'date');
        $this->addColumn(Events::tableName(),'date',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Events::tableName(),'date');
        $this->addColumn(Events::tableName(),'date',$this->dateTime());

    }

}
