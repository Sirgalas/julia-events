<?php

namespace app\Entities\Events\Forms;

use app\Entities\Managers\Entities\ManagersEvents;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Entities\Events\Entities\Events;

/**
 * BookSearch represents the model behind the search form of `app\Entities\Event\Entities\Events`.
 */
class EventSearch extends Events
{
    public $date_from;
    public $date_to;
    public $managers;

    public function rules()
    {
        return [
            [['id','managers'], 'integer'],
            [['name'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Events::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        if($this->managers) {
            $managerEvent = ManagersEvents::find()
                ->select('events_id')
                ->where(['managers_id' => $this->managers]);
            $query->andFilterWhere(['in','id', $managerEvent]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'date', $this->date_from ?? null])
            ->andFilterWhere(['<=', 'date', $this->date_to ?? null]);

        return $dataProvider;
    }
}
