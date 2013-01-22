<?php

/**
 * This is the model class for table "{{profile}}".
 *
 * The followings are the available columns in table '{{profile}}':
 * @property integer $pid Profile id
 * @property integer $uid User id
 * @property string $name Name of user (such as "John Doe")
 * @property string $username Username of user (such as "john_doe")
 * @property string $about Information about user (which is typed by himself)
 * @property boolean $merged Is user merged to some other user (means inactive)
 */
class Profile extends LUserModel {
    const USERNAME_PATTERN = '~[0-9a-z\\-_.]{5,20}~i';
    /**
     * Callback for user name
     * @static
     * @param LUser $user
     * @return null
     */
    public static function getName(LUser $user)
    {
        return isset($user->profile->name) ? $user->profile->name : Yii::t("ls","<Name not set>");
    }
    
    public function onUserMerge(LMergeEvent $event) {
        parent::onUserMerge($event);
        $this->merged = 1;
        $this->save();
    }
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Profile the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{profile}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max' => 255, 'min' => 1),          
            array('username', 'match', 'pattern' => self::USERNAME_PATTERN, 'message' => Yii::t('ls','{attribute} must contain only latin letters (both upper and lower cases), numbers and -._ symbols. Length of {attribute} should be from 5 to 20 symbols.')),
            array('username', 'unique'),
            array('about', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pid, uid, name, username, about', 'safe', 'on' => 'search'),
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
            'pid' => Yii::t('ls', 'Pid'),
            'uid' => Yii::t('ls', 'Uid'),
            'name' => Yii::t('ls', 'Name'),
            'username' => Yii::t('ls', 'Username'),
            'about' => Yii::t('ls', 'About'),
            'merged' => Yii::t('ls', 'Is merged'),
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

        $criteria->compare('pid', $this->pid);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('about', $this->about, true);
        $criteria->compare('merged', $this->merged);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                ));
    }

}