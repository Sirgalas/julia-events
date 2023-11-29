<?php

declare(strict_types=1);

namespace app\Entities\Managers\Repositories;

use app\Entities\Managers\Entities\ManagersEvents;

class ManagerEventsRepository
{
    public function uniqueFind(int $event_id, $manager_id): bool
    {
        return ManagersEvents::find()->where(['events_id' => $event_id,'managers_id' => $manager_id])->exists();
    }
}