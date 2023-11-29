<?php

declare(strict_types=1);

namespace app\Entities\Events\Forms;

use app\Entities\Managers\Entities\Managers;
use yii\base\Model;

class ManagerForm extends Model
{
    public ?int $manager_id = null;

    public function rules()
    {
        return [
            [
                ['manager_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Managers::class,
                'targetAttribute' => ['manager_id' => 'id']
            ]
        ];
    }
}