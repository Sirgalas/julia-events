<?php

declare(strict_types=1);

namespace app\Entities\Managers\Forms;

use app\Entities\Managers\Entities\Managers;
use yii\base\Model;

/**
 * @property string $name
 * @property string $email
 * @property string $phone
 */

class CreateForm extends Model
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;

    public function __construct(Managers $events = null, $config = [])
    {
        parent::__construct($config);
        if($events) {
            $this->id = $events->id;
            $this->name = $events->name;
            $this->email = $events->email;
            $this->phone = $events->phone;
        }
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 512],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }
}