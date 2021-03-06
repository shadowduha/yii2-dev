<?php

namespace biz\api\models\inventory\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use biz\api\models\inventory\StockOpname as StockOpnameModel;

/**
 * StockOpname represents the model behind the search form about `biz\api\models\inventory\StockOpname`.
 */
class StockOpname extends StockOpnameModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number', 'date', 'description', 'operator', 'created_at', 'updated_at'], 'safe'],
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
        $query = StockOpnameModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'warehouse_id' => $this->warehouse_id,
            'date' => $this->date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
