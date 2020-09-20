<?php

namespace app\models\reviews;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\reviews\Reviews;

/**
 * ReviewsSearch represents the model behind the search form of `app\models\reviews\Reviews`.
 */
class ReviewsSearch extends Reviews
{
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'id', 'user_id', 'created_at', 'updated_at', 'username'], 'safe'],
            [['deleted'], 'boolean'],
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
        $query = Reviews::find()->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
                'attributes' => [
                    'id',
                    'user.username',
                    'content',
                    'deleted',
                    'created_at',
                    'updated_at',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
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
            'reviews.id' => $this->id,
            'user.username' => $this->username,
            'reviews.deleted' => $this->deleted,
        ]);

        if ($this->created_at != ''){
            $created_at = explode(' - ', $this->created_at);
            $query->andWhere('reviews.created_at BETWEEN :dt0 and :dt1', [':dt0' => strtotime($created_at[0]), ':dt1' => strtotime($created_at[1])]);
        }

        if ($this->updated_at != ''){
            $updated_at = explode(' - ', $this->updated_at);
            $query->andWhere('reviews.updated_at BETWEEN :dt0 and :dt1', [':dt0' => strtotime($updated_at[0]), ':dt1' => strtotime($updated_at[1])]);
        }

        $query->andFilterWhere(['ilike', 'content', $this->content]);

        return $dataProvider;
    }
}
