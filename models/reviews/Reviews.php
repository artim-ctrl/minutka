<?php

namespace app\models\reviews;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\User;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id Код
 * @property int $user_id Код пользователя
 * @property int|null $review_id Код комментария
 * @property string $content Содержание
 * @property bool $deleted Удален
 * @property int $created_at Дата создания
 * @property int $updated_at Дата изменения
 *
 * @property Reviews $review
 * @property Reviews[] $reviews
 * @property User $user
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }
 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'safe'],
            [['user_id', 'content', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'review_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'review_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['deleted'], 'boolean'],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['review_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'user_id' => 'Код пользователя',
            'review_id' => 'Код отзыва',
            'content' => 'Содержание',
            'deleted' => 'Удален',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    public function deleteRow($id) {
        $model = self::findOne($id);

        $model->deleted = true;

        $model->update();
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'review_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['review_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
