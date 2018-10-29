<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsersInfo;

/**
 * UsersInfoSearch represents the model behind the search form about `app\models\UsersInfo`.
 */
class UsersInfoSearch extends UsersInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stype', 'id_status', 'hospital_id', 'department_id', 'jobtitle_id', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['uid', 'sid', 'mobile', 'realname', 'id_card_type', 'id_card_no', 'id_card_img', 'id_card_bg_img', 'id_card_usr_img', 'real_card_img', 'reg_cert_img', 'job_title_img'], 'safe'],
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
        $query = UsersInfo::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array(
                        'pageSize' => 10
                ),
            'sort'=>array(
                'defaultOrder'=> [
                    'id_status' => SORT_DESC,
                    'id' => SORT_DESC,         
                ],
                'attributes' =>['id','id_status']
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
            'stype' => $this->stype,
            'id_status' => $this->id_status,
            'mobile' => $this->mobile,

        ]);

        // $query->andFilterWhere(['like', 'uid', $this->uid])
        //     ->andFilterWhere(['like', 'sid', $this->sid])
        //     ->andFilterWhere(['like', 'mobile', $this->mobile]);
            

        return $dataProvider;
    }
}
