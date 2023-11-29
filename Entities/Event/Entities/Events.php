<?php

namespace app\Entities\Event\Entities;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $date
 * @property string|null $description
 *
 * @property Managers[] $managers
 * @property ManagersEvents[] $managersEvents
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagers()
    {
        return $this->hasMany(Managers::class, ['id' => 'managers_id'])->viaTable('managers_events', ['events_id' => 'id']);
    }

    /**
     * Gets query for [[ManagersEvents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagersEvents()
    {
        return $this->hasMany(ManagersEvents::class, ['events_id' => 'id']);
    }
}
