<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TagShow;

/**
 * TagShowSearch represents the model behind the search form about `app\models\TagShow`.
 */
class TagShowSearch extends TagShow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tag_region_id', 'tag_list_id', 'sort', 'status', 'is_empty', 'updated_at', 'created_at'], 'integer'],
            [['tag_app_key'], 'safe'],
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
        $query = TagShow::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>10],
            'sort'=>[
                'attributes'=>[ 'status','sort','id'],
                'defaultOrder'=>[
                    'status'=>SORT_DESC,
                    'sort'=>SORT_ASC,
                    'id'=>SORT_DESC
                ],
            ],
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
            'tag_region_id' => $this->tag_region_id,
            'tag_list_id' => $this->tag_list_id,
            'sort' => $this->sort,
            'status' => $this->status,
            'is_empty' => $this->is_empty,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'tag_app_key', $this->tag_app_key]);

        return $dataProvider;
    }
}
