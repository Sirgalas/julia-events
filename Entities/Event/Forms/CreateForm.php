<?php

declare(strict_types=1);

namespace app\Entities\Event\Forms;

use app\Entities\Event\Entities\Events;
use yii\base\Model;

/**
 * @property string $date
 * @property string $description
 * @property string $name
 */
class CreateForm extends Model
{

    public string $date;
    public string $description;
    public string $name;

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}