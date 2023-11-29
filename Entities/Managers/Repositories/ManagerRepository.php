<?php

declare(strict_types=1);

namespace app\Entities\Managers\Repositories;

use app\Entities\Events\Entities\Events;
use app\Entities\Managers\Entities\Managers;
use app\Entities\Managers\Entities\ManagersEvents;
use app\Helpers\ErrorHelpers;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ManagerRepository
{
    public function one(int $id): Managers
    {
        if(!$events = Managers ::findOne($id)) {
            throw new NotFoundHttpException('Организатор не найдено');
        }
        return $events;
    }
    public function find(int $id): ?Managers
    {
        if(!$events = Managers ::findOne($id)) {
            return null;
        }
        return $events;
    }

    public function save(Managers $events): Managers
    {
        if(!$events->save())
        {
            throw new BadRequestHttpException(ErrorHelpers::errorsToStr($events->errors));
        }
        return $events;
    }

    public function remove(int $id): void
    {
        $event = $this->one($id);
        $event->delete();
    }

    public function findAllByCriteria(array $criteria = []): array
    {
        $event = Managers::find();
        if(!empty($criteria)) {
            $event->where($criteria);
        }
        return $event->all();
    }

    public function findAllByUnique(Events $event): array
    {
        $managerIds = ArrayHelper::getColumn($event->managers,'id');
        $managerEvents = ManagersEvents::find()->select('managers_id')->where(['in','managers_id', $managerIds]);
        return  Managers::find()->where(['not in','id', $managerEvents])->all();
    }

}