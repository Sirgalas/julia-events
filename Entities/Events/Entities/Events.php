<?php

namespace app\Entities\Events\Entities;

use app\Entities\Event\Forms\CreateForm;
use app\Entities\Managers\Entities\Managers;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $date
 * @property string|null $description
 *
 * @property Managers[] $managers
 */
class Events extends \yii\db\ActiveRecord
{
    public static function create(CreateForm $form): self
    {
        $event = new static();
        $event->date = $form->date;
        $event->description = $form->description;
        $event->name = $form->name;
        return $event;
    }

    public function edit(CreateForm $form): void
    {
        $this->date = $form->date;
        $this->description = $form->description;
        $this->name = $form->name;
    }

    public static function tableName()
    {
        return 'events';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'description' => 'Description',
        ];
    }


    public function getManagers():ActiveQuery
    {
        return $this->hasMany(Managers::class, ['id' => 'managers_id'])->viaTable('managers_events', ['events_id' => 'id']);
    }

}
