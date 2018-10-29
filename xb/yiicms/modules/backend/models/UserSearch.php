<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'star_level', 'id_status', 'verified', 'is_share_sm', 's_status', 'is_fill_information', 'is_zombie', 'shut_up_count', 'weight', 'temp', 'is_star', 'is_activity', 'state', 'created', 'updated', 'online_state', 'is_fraud', 's_type'], 'integer'],
            [['uid', 'sid', 'mobile', 'third_type', 'third_account', 'unionid', 'mpopenid', 'nickname', 'realname', 'gender', 'birthday', 'blood_type', 'interest', 'job', 'id_card_type', 'id_card_no', 'id_card_image', 'organization_id', 'nanny_id', 'avatar', 'slogan', 'verified_reason', 'province', 'city', 'district', 'new_pop_url', 'wechat_info'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort'=>[
                'defaultOrder'=>[
                    'id'=>SORT_DESC,
                ]
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
            'level' => $this->level,
            'star_level' => $this->star_level,
            'birthday' => $this->birthday,
            'id_status' => $this->id_status,
            'verified' => $this->verified,
            'is_share_sm' => $this->is_share_sm,
            's_status' => $this->s_status,
            'is_fill_information' => $this->is_fill_information,
            'is_zombie' => $this->is_zombie,
            'shut_up_count' => $this->shut_up_count,
            'weight' => $this->weight,
            'temp' => $this->temp,
            'is_star' => $this->is_star,
            'is_activity' => $this->is_activity,
            'state' => $this->state,
            'created' => $this->created,
            'updated' => $this->updated,
            'online_state' => $this->online_state,
            'is_fraud' => $this->is_fraud,
            's_type' => $this->s_type,
        ]);

        $query->andFilterWhere(['like', 'uid', $this->uid])
            ->andFilterWhere(['like', 'sid', $this->sid])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'third_type', $this->third_type])
            ->andFilterWhere(['like', 'third_account', $this->third_account])
            ->andFilterWhere(['like', 'unionid', $this->unionid])
            ->andFilterWhere(['like', 'mpopenid', $this->mpopenid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'blood_type', $this->blood_type])
            ->andFilterWhere(['like', 'interest', $this->interest])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'id_card_type', $this->id_card_type])
            ->andFilterWhere(['like', 'id_card_no', $this->id_card_no])
            ->andFilterWhere(['like', 'id_card_image', $this->id_card_image])
            ->andFilterWhere(['like', 'organization_id', $this->organization_id])
            ->andFilterWhere(['like', 'nanny_id', $this->nanny_id])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'slogan', $this->slogan])
            ->andFilterWhere(['like', 'verified_reason', $this->verified_reason])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'new_pop_url', $this->new_pop_url])
            ->andFilterWhere(['like', 'wechat_info', $this->wechat_info]);

        return $dataProvider;
    }
}
