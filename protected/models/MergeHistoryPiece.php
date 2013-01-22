<?php

/**
 * This is the model class for table "{{merge_history}}".
 *
 * The followings are the available columns in table '{{merge_history}}':
 * @property integer $hid Id of this piece of merge history
 * @property integer $donor_id Merge donor uid
 * @property integer $acceptor_id Merge acceptor uid
 * @property integer $owner_id Merge owner uid (final successor of the merge chain
 * @property integer $time Merge event timestamp
 * @property object $account Data of account, through which merging operation started
 */
class MergeHistoryPiece extends CActiveRecord {

    /**
     * This method simply unserializes data attribute
     */
    protected function unserializeData() {
        $this->account = unserialize($this->account);
    }

    /**
     * This method simply serializes data attribute
     */
    protected function serializeData() {
        $this->account = serialize($this->account);
    }

    /**
     * After find handler, gets executed after model instance being retrieved from database
     */
    protected function afterFind() {
        parent::afterFind();
        $this->unserializeData();
    }

    /**
     * After save handler, gets executed after model instance being saved to database
     */
    protected function afterSave() {
        parent::afterSave();
        $this->unserializeData();
    }

    /**
     * Before save handler, gets executed before model instance being saved to database
     * @return bool true, we haven't to disallow saving action
     */
    protected function beforeSave() {
        parent::beforeSave();
        $this->serializeData();
        return true;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MergeHistoryPiece the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{merge_history}}';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'owner' => array(self::BELONGS_TO, 'LUser', 'owner_id'),
            'donor' => array(self::HAS_ONE, 'LUser', 'donor_id'),
            'acceptor' => array(self::HAS_ONE, 'LUser', 'acceptor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'hid' => Yii::t('ls', 'Hid'),
            'donor_id' => Yii::t('ls', 'Donor'),
            'acceptor_id' => Yii::t('ls', 'Acceptor'),
            'owner_id' => Yii::t('ls', 'Owner id'),
            'time' => Yii::t('ls', 'Time'),
            'account' => Yii::t('ls', 'Account'),
        );
    }
    
    /**
     * callback for user merging
     * @static
     * @param LMergeEvent $event
     */
    public static function userMergeCallback(LMergeEvent $event){
        $model = self::model();
        $model->dbConnection->createCommand()->update($model->tableName(),array('owner_id'=>$event->newUid),'owner_id=:uid', array(':uid'=>$event->oldUid));
        $piece = new MergeHistoryPiece();
        $piece->owner_id = $piece->acceptor_id = $event->newUid;
        $piece->donor_id = $event->oldUid;
        $piece->time = time();
        $piece->account = isset($event->aid)?LAccount::model()->findByPk($event->aid):null;
        $piece->save();
    }

}