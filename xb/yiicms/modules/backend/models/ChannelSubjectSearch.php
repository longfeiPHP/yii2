<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChannelSubject;

/**
 * ChannelSubjectSearch represents the model behind the search form about `app\models\ChannelSubject`.
 */
class ChannelSubjectSearch extends ChannelSubject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'show_start_time', 'show_end_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['channel_key', 'channel_title', 'active_title'], 'safe'],
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
        $query = ChannelSubject::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array(
                        'pageSize' => 10
                ),
            'sort'=>array(
                'defaultOrder'=> [
                    'id' => SORT_DESC,         
                ],
                'attributes'=>['id']
            ),
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
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like', 'channel_key', $this->channel_key])
            ->andFilterWhere(['like', 'channel_title', $this->channel_title])
            ->andFilterWhere(['like', 'active_title', $this->active_title]);

        return $dataProvider;
    }
}
