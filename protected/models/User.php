<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $fullName
 * @property string $email
 * @property integer $maxBudget
 * @property string $refreshToken
 *
 * The followings are the available model relations:
 * @property UserBusyTimes[] $userBusyTimes
 * @property UserFriend[] $userFriends
 * @property UserFriend[] $userFriends1
 * @property UserTypePreferences[] $userTypePreferences
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fullName, email', 'required'),
			array('maxBudget', 'numerical', 'integerOnly'=>true),
			array('fullName, email, refreshToken', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fullName, email, maxBudget, refreshToken', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'userBusyTimes' => array(self::HAS_MANY, 'UserBusyTimes', 'userId'),
			'userFriends' => array(self::HAS_MANY, 'UserFriend', 'friendId'),
			'userFriends1' => array(self::HAS_MANY, 'UserFriend', 'userId'),
			'userTypePreferences' => array(self::HAS_MANY, 'UserTypePreferences', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fullName' => 'Full Name',
			'email' => 'Email',
			'maxBudget' => 'Max Budget',
			'refreshToken' => 'Refresh Token',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('fullName',$this->fullName,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('maxBudget',$this->maxBudget);
		$criteria->compare('refreshToken',$this->refreshToken,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
