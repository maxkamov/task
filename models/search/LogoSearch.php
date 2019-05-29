<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Logo;

/**
 * LogoSearch represents the model behind the search form of `app\models\Logo`.
 */
class LogoSearch extends Logo
{
    public $tag_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'image','tag_name'], 'safe'],
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
        $query = Logo::find();



        /*if(isset($this->tag_name)){
            $query->joinWith('tagAssigns');
        }*/

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image]);
           //

        /*if(isset($this->tag_name)){
            $query->andFilterWhere(['IN',
                'logo.id',
                (new \yii\db\Query())->select('tag.id')->from('tag')
                    ->leftJoin('tag_assign','tag_assign.tag_id = tag.id')
                    ->leftJoin('logo','logo.id = tag_assign.logo_id')
                    ->where(['like', 'tag.name', $this->tag_name])
            ]);
        }*/

        if($this->tag_name!=''){
            $query->andFilterWhere(['IN',
                'id',
                (new \yii\db\Query())->select('tag_assign.logo_id')->from('tag_assign')
                    ->leftJoin('tag','tag_assign.tag_id = tag.id')
                    ->andWhere(['like', 'tag.name', $this->tag_name])
            ]);
        }

        return $dataProvider;
    }
}
