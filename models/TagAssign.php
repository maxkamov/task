<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_assign".
 *
 * @property int $id
 * @property int $logo_id
 * @property int $tag_id
 *
 * @property Logo $logo
 * @property Tag $tag
 */
class TagAssign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo_id', 'tag_id'], 'required'],
            [['logo_id', 'tag_id'], 'integer'],
            [['logo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Logo::className(), 'targetAttribute' => ['logo_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo_id' => 'Logo ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(Logo::className(), ['id' => 'logo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
