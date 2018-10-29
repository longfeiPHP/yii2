<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;

/**
 * ContentSearch represents the model behind the search form about `app\models\Content`.
 */
class NewsSearch extends News
{
//    public $status = 0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type','admin_user_id','hits'], 'integer'],
            [['title', 'status', 'image', 'description', 'created_at'], 'safe'],
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
     * 创建时间
     * @return array|false|int
     */
    public function getCreatedAt()
    {
        if(empty($this->created_at)){
            return null;
        }
        $createAt = is_string($this->created_at)?strtotime($this->created_at):$this->created_at;
        if(date('H:i:s', $createAt)=='00:00:00'){
            return [$createAt, $createAt+3600*24];
        }
        return $createAt;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $pageSize
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize=10)
    {
        $this->load($params);
        $query = News::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['status'=>SORT_DESC,'id'=>SORT_DESC,],
                'attributes'=>['id','status']

            ],
            'pagination' => ['pageSize'=>$pageSize]
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            // ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status]);
        // $this->load($params);
        // \Yii::info($this->validate());
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // var_dump($this->id);var_dump($this->title);

        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'status' => $this->status,
        //     // 'admin_user_id' => $this->admin_user_id,
        //     // 'hits' => $this->hits,
        //     // 'updated_at' => $this->updated_at,
        // ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        /*
        $createAt = $this->getCreatedAt();
        if(is_array($createAt)) {
            $query->andFilterWhere(['>=','created_at', $createAt[0]])
                ->andFilterWhere(['<=','created_at', $createAt[1]]);
        }else{
            $query->andFilterWhere(['created_at'=>$createAt]);
        }*/

        return $dataProvider;
    }
}
