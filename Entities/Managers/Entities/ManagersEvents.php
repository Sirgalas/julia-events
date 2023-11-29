<?php

namespace app\Entities\Managers\Entities;

use app\Entities\Events\Entities\Events;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "managers_events".
 *
 * @property int $managers_id
 * @property int $events_id
 *
 * @property Events $events
 * @property Managers $managers
 */
class ManagersEvents extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'managers_events';
    }

    public function getEvents():ActiveQuery
    {
        return $this->hasOne(Events::class, ['id' => 'events_id']);
    }

    public function getManagers(): ActiveQuery
    {
        return $this->hasOne(Managers::class, ['id' => 'managers_id']);
    }
}
