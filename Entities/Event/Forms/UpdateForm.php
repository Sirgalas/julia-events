<?php

declare(strict_types=1);

namespace app\Entities\Event\Forms;


use app\Entities\Event\Entities\Events;

class UpdateForm extends CreateForm
{
    public int $id;
    public function __construct(Events $events = null, $config = [])
    {
        parent::__construct($config);
        if($events) {
            $this->date = $events->date;
            $this->description = $events->description;
            $this->name = $events->name;
        }
    }

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Events::class,
                'targetAttribute' => ['id' => 'id']
            ]
        );
    }
}