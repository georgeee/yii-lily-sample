<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property integer $aid Article id
 * @property integer $uid User id of the creator
 * @property string $title Article's title
 * @property string $body Article's body
 * @property integer $updated Timestamp of moment, when article was last updated
 * @property integer $created Timestamp of moment, when article was created
 */
class Article extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Article the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{article}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'compare', 'compareValue'=>'', 'strict'=> true, 'operator'=>'!=', 'message'=>Yii::t('ls', '{attribute} must not be empty')),
            array('title', 'length', 'max' => 25),
            array('body', 'safe'),
            array('aid, uid, title, body, updated, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'LUser', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'aid' => Yii::t('ls', 'Aid'),
            'uid' => Yii::t('ls', 'Uid'),
            'title' => Yii::t('ls', 'Title'),
            'body' => Yii::t('ls', 'Body'),
            'updated' => Yii::t('ls', 'Updated'),
            'created' => Yii::t('ls', 'Created'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('aid', $this->aid);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('updated', $this->updated);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                ));
    }

}