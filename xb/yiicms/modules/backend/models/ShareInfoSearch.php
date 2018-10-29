<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShareInfo;

/**
 * ShareInfoSearch represents the model behind the search form about `app\models\ShareInfo`.
 */
class ShareInfoSearch extends ShareInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event', 'status', 'created_at', 'updated_at'], 'integer'],
            [['platform', 'title', 'summary', 'img_url', 'target_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ShareInfo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,            
            'sort'=>[
                'attributes'=>['id','event','platform','status'],
                'defaultOrder'=>[
                    'status'=>SORT_DESC,
                    'id'=>SORT_DESC,
                ],
            ],
            'pagination'=>['pageSize'=>10],
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
            'event' => $this->event,
            'status' => $this->status,
            'platform'=> $this->platform,

        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'target_url', $this->target_url]);

        return $dataProvider;
    }
}
