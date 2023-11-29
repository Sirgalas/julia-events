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
    public string $name;
    public string $email;
    public string $phone;

    public function __construct(Managers $managers = null, $config = [])
    {
        parent::__construct($config);
        if($managers) {
            $this->name = $managers->name;
            $this->email = $managers->email;
            $this->phone = $managers->phone;
        }
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 512],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
        ];
    }
}