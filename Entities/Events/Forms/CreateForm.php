<?php

declare(strict_types=1);

namespace app\Entities\Events\Forms;

use app\Entities\Events\Entities\Events;
use yii\base\Model;

/**
 * @property string $date
 * @property string $description
 * @property string $name
 *
 */
class CreateForm extends Model
{
    public int $id;
    public ?string $date = null;
    public ?string $description = null;
    public ?string $name = null;

    public function __construct(Events $events = null, $config = [])
    {
        parent::__construct($config);
        if($events) {
            $this->id = $events->id;
            $this->name = $events->name;
            $this->date = $events->date;
            $this->description = $events->description;
        }
    }

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}