<?php

namespace app\Entities\Events\Entities;

use app\Entities\Events\Forms\CreateForm;
use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Entities\ManagersEvents;
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
 * @property ManagersEvents[] $managerEvents
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
            'name' => 'Название',
            'date' => 'Дата',
            'description' => 'Описание',
        ];
    }

    public function getManagers():ActiveQuery
    {
        return $this->hasMany(Managers::class, ['id' => 'managers_id'])->via('managerEvents');
    }

    public function getManagerEvents(): ActiveQuery
    {
        return $this->hasMany(ManagersEvents::class,['events_id' => 'id']);
    }

}
