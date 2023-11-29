<?php

declare(strict_types=1);

namespace app\Entities\Managers\Forms;

use app\Entities\Events\Entities\Events;
use yii\base\Model;

class EventsForm extends Model
{
    public ?int $event_id = null;

    public function rules()
    {
        return [
            [
                ['event_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Events::class,
                'targetAttribute' => ['event_id' => 'id']
            ]
        ];
    }
}