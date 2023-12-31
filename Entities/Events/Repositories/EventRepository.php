<?php

declare(strict_types=1);

namespace app\Entities\Events\Repositories;

use app\Entities\Events\Entities\Events;
use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Entities\ManagersEvents;
use app\Helpers\ErrorHelpers;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class EventRepository
{
    public function one(int $id): Events
    {
        if(!$events = Events::findOne($id)) {
            throw new NotFoundHttpException('событие не найдено');
        }
        return $events;
    }
    public function find(int $id): ?Events
    {
        if(!$events = Events::findOne($id)) {
            return null;
        }
        return $events;
    }

    public function save(Events $events): Events
    {
        if(!$events->save())
        {
            throw new BadRequestHttpException(ErrorHelpers::errorsToStr($events->errors));
        }
        return $events;
    }

    public function findAllByCriteria(array $criteria = []): array
    {
        $event = Events::find();
        if(!empty($criteria)) {
            $event->where($criteria);
        }
        return $event->all();
    }

    public function findAllByUnique(Managers $managers): array
    {
        $eventIds = ArrayHelper::getColumn($managers->events,'id');
        $managerEvents = ManagersEvents::find()->select('events_id')->where(['in','events_id', $eventIds]);
        return  Events::find()->where(['not in','id', $managerEvents])->all();
    }


    public function remove(int $id): void
    {
        $event = $this->one($id);
        $event->delete();
    }
}