<?php

namespace app\Entities\Managers\Forms;

use app\Entities\Managers\Entities\ManagersEvents;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Entities\Managers\Entities\Managers;

/**
 * ManagerSearch represents the model behind the search form of `app\Entities\Managers\Entities\Managers`.
 */
class ManagerSearch extends Managers
{
    public $events;
    public function rules()
    {
        return [
            [['id','events'], 'integer'],
            [['name', 'email', 'phone'], 'safe'],
        ];
    }


    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Managers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if($this->events) {
            $managersEvents = ManagersEvents::find()
                ->select('managers_id')
                ->where(['events_id' => $this->events]);
            $query->andFilterWhere(['in','id',$managersEvents]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
