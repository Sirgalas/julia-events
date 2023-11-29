<?php

namespace app\Entities\Managers\Entities;

use Yii;

/**
 * This is the model class for table "managers".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 *
 * @property Events[] $events
 * @property ManagersEvents[] $managersEvents
 */
class Managers extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 512],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
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
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::class, ['id' => 'events_id'])->viaTable('managers_events', ['managers_id' => 'id']);
    }

    /**
     * Gets query for [[ManagersEvents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManagersEvents()
    {
        return $this->hasMany(ManagersEvents::class, ['managers_id' => 'id']);
    }
}
