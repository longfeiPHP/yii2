<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banner;

/**
 * BannerSearch represents the model behind the search form about `app\models\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jump_type', 'banner_type', 'banner_push', 'banner_sort', 'show_start_time', 'show_end_time', 'live_start_time', 'live_end_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sid', 'img', 'h5_url'], 'safe'],
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
        $query = Banner::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array(
                        'pageSize' => 10
                ),
            'sort'=>array(
                'defaultOrder'=> [
                    'status' => SORT_DESC,  
                    'banner_sort' => SORT_ASC,
                    'id' => SORT_DESC,         
                ],
                'attributes'=>[ 'status','banner_sort','id']
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
            'banner_type' => $this->banner_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
