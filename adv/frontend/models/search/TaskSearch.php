<?php

namespace frontend\models\search;

use kartik\daterange\DateRangeBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form of `common\models\Task`.
 */
class TaskSearch extends Task
{
    public $createTimeStart;
    public $createTimeEnd;

    public $updatedTimeStart;
    public $updatedTimeEnd;

    public $startedTimeStart;
    public $startedTimeEnd;

    public $completedTimeStart;
    public $completedTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'created_at',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ],
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'updated_at',
                'dateStartAttribute' => 'updatedTimeStart',
                'dateEndAttribute' => 'updatedTimeEnd',
            ],
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'started_at',
                'dateStartAttribute' => 'startedTimeStart',
                'dateEndAttribute' => 'startedTimeEnd',
            ],
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'completed_at',
                'dateStartAttribute' => 'completedTimeStart',
                'dateEndAttribute' => 'completedTimeEnd',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'executor_id', 'creator_id', 'updater_id'], 'integer'],
            [['title', 'description'], 'safe'],
            [['created_at', 'updated_at', 'started_at', 'completed_at'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'task.project_id' => $this->project_id,
            'executor_id' => $this->executor_id,
            'task.creator_id' => $this->creator_id,
            'task.updater_id' => $this->updater_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['between', 'task.created_at', $this->createTimeStart, $this->createTimeEnd])
            ->andFilterWhere(['between', 'task.updated_at', $this->updatedTimeStart, $this->updatedTimeEnd])
            ->andFilterWhere(['between', 'task.started_at', $this->startedTimeStart, $this->startedTimeEnd])
            ->andFilterWhere(['between', 'task.completed_at', $this->completedTimeStart, $this->completedTimeEnd]);

        return $dataProvider;
    }
}
