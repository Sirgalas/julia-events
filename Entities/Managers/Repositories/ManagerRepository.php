<?php

declare(strict_types=1);

namespace app\Entities\Managers\Repositories;

use app\Entities\Managers\Entities\Managers;
use app\Helpers\ErrorHelpers;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ManagerRepository
{
    public function one(int $id): Managers
    {
        if(!$events = Managers ::findOne($id)) {
            throw new NotFoundHttpException('событие не найдено');
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
}