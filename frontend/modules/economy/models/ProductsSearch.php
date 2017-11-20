<?php

namespace app\modules\economy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\economy\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\modules\economy\models\Products`.
 */
class ProductsSearch extends Products
{
    public $category_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_category'], 'integer'],
            [['product_name', 'product_description'], 'safe'],
            ['category_name', 'safe'],
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
        $query = Products::find()->joinWith('category');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 5
                ],
            'sort'=>
                [
                    'defaultOrder'=>
                        [
                            'category_name' => SORT_ASC,
                            'product_name' => SORT_ASC,
                        ]
                ]
        ]);

        $dataProvider->sort->attributes['category_name'] = [
            'asc' => ['category_name' => SORT_ASC],
            'desc' => ['category_name' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product_id' => $this->product_id,
            'product_category' => $this->product_category,
            'product_count' => $this->product_count,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_description', $this->product_description])
            ->andFilterWhere(['like', 'category_name', $this->category_name]);

        return $dataProvider;
    }
}
