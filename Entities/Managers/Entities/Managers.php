<?php

namespace app\Entities\Managers\Entities;

use app\Entities\Events\Entities\Events;
use app\Entities\Managers\Forms\CreateForm;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "managers".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 *
 * @property Events[] $events
 */
class Managers extends \yii\db\ActiveRecord
{
    public static function create(CreateForm $form): self
    {
        $manager = new static();
        $manager->name = $form->name;
        $manager->email = $form->email;
        $manager->phone = $form->phone;
        return $manager;
    }

    public function edit(CreateForm $form):void
    {
        $this->name = $form->name;
        $this->email = $form->email;
        $this->phone = $form->phone;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'managers';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }


    public function getEvents():ActiveQuery
    {
        return $this->hasMany(Events::class, ['id' => 'events_id'])->viaTable('managers_events', ['managers_id' => 'id']);
    }


}
