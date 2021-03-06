<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $fullName
 * @property string $email
 * @property integer $maxBudget
 * @property string $calendar
 * @property string $picture
 *
 * The followings are the available model relations:
 * @property UserBusyTimes[] $userBusyTimes
 * @property UserEvent[] $userEvents
 * @property UserFriend[] $userFriends
 * @property UserFriend[] $userFriends1
 * @property UserTypePreferences[] $userTypePreferences
 */
class User extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fullName, email', 'required'),
            array('maxBudget', 'numerical', 'integerOnly' => true),
            array('fullName, email, calendar', 'length', 'max' => 255),
            array('picture', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, fullName, email, maxBudget, calendar, picture', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userBusyTimes' => array(self::HAS_MANY, 'UserBusyTime', 'userId'),
            'userEvents' => array(self::HAS_MANY, 'UserEvent', 'userId'),
            'userFriends' => array(self::HAS_MANY, 'UserFriend', 'friendId'),
            'userFriends1' => array(self::HAS_MANY, 'UserFriend', 'userId'),
            'userTypePreferences' => array(self::HAS_MANY, 'UserTypePreference', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fullName' => 'Full Name',
            'email' => 'Email',
            'maxBudget' => 'Max Budget',
            'calendar' => 'Refresh Token',
            'picture' => 'Picture',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('fullName', $this->fullName, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('maxBudget', $this->maxBudget);
        $criteria->compare('calendar', $this->calendar, true);
        $criteria->compare('picture', $this->picture, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function isFriend(User $other) {
        $friends = $this->userFriends1;
        foreach ($friends as $friend) {
            if ($friend->friendId == $other->id) {
                return true;
            }
        }
        return false;
    }

    public function getUnavailability() {
        $unavailability = array();
        date_default_timezone_set('America/Los_Angeles');
        $busyTimes = $this->userBusyTimes;
        $baseDate = strtotime('today midnight');
        $todayOffset = date('N');
        foreach ($busyTimes as $time) {
            $daysOffset = ($time['day'] - $todayOffset);
            if ($daysOffset < 0) {
                $daysOffset = $daysOffset + 7;
            }
            $dayOffset = $daysOffset * (60 * 60 * 24);
            $start = $baseDate + $dayOffset + $time['startTime'];
            $end = $baseDate + $dayOffset + $time['endTime'];
            $unavailability[] = array('start' => $start, 'end' => $end);
        }
        foreach ($this->userEvents as $eventLinkage) {
            $event = $eventLinkage->event;
            if ($event->isUserEvent) {
                $unavailability[] = array('start' => $event->startTime, 'end' => $event->endTime);
            }
        }
        usort($unavailability, "cmp_by_startTime");
        return $unavailability;
    }

    public function getAvailability() {
        $unavailability = $this->getUnavailability();
        $availability = array();
        $lastStart = strtotime('today midnight');
        foreach ($unavailability as $timeFrame) {
            $availableStart = $lastStart;
            $availableEnd = $timeFrame['start'];
            $availability[] = array('start' => $availableStart, 'end' => $availableEnd);
            $lastStart = $timeFrame['end'];
        }
        $end = strtotime('+1 week 11:59:59 PM');
        $availability[] = array('start' => $lastStart, 'end' => $end);
        return $availability;
    }

    public function generateEventCriteria() {
        $availability = $this->getAvailability();
        $criteria = new CDbCriteria();
        foreach ($availability as $timeFrame) {
            $criteria->addCondition('(startTime BETWEEN ' . $timeFrame['start'] . ' AND ' . $timeFrame['end'] . ')'
                    . ' AND (endTime BETWEEN ' . $timeFrame['start'] . ' AND ' . $timeFrame['end'] . ')', 'OR');
        }
        $criteria->addCondition('isUserEvent = 0');
        $criteria->order = 'startTime ASC';
        return $criteria;
    }

    public function isAvailable(Event $event) {
        $unavailability = $this->getUnavailability();
        foreach ($unavailability as $timeFrame) {
            if (($event->startTime > $timeFrame['start'] && $event->startTime < $timeFrame['end']) ||
                    ($event->endTime > $timeFrame['start'] && $event->endTime < $timeFrame['end'])) {
                return false;
            }
        }
        return true;
    }
    
    public function isAttending(Event $event){
        foreach($this->userEvents as $userEvent){
            if($userEvent->eventId == $event->id){
                return true;
            }
        }
        return false;
    }

    public function syncCalendar() {
        if (isset(Yii::app()->session['access_token'])) {
            $client = new Google_Client();
            $client->setClientId('1019880111828-rih5k3iugp8k1p7ha550uofhec3cj0jd.apps.googleusercontent.com');
            $client->setClientSecret('ad9qK6uRBI37s3LS9wY_HlNm');
            $client->setAccessToken(Yii::app()->session['access_token']);
            $calendar = new Google_Service_Calendar($client);
            if (isset($this->calendar)) {
                foreach ($this->userEvents as $event) {
                    if (isset($event->event)) {
                        $event->event->delete();
                    }
                }
                $calId = $this->calendar;
                $objDateTime = new DateTime('NOW');
                $isoDate = $objDateTime->format(DateTime::ISO8601);
                $events = $calendar->events->listEvents($calId, array('timeMin' => $isoDate));
                foreach ($events['modelData']['items'] as $event) {
                    $id = $event['id'];
                    $eventModel = Event::model()->findByAttributes(array('googleCalendarId' => $id));
                    if (!isset($eventModel)) {
                        $eventModel = new Event();
                        $eventModel->title = $event['summary'];
                        $eventModel->googleCalendarId = $id;
                        if (isset($event['start']['dateTime'])) {
                            $eventModel->startTime = strtotime($event['start']['dateTime']);
                            $eventModel->endTime = strtotime($event['end']['dateTime']);
                        } else {
                            $eventModel->startTime = strtotime($event['start']['date']);
                            $eventModel->endTime = strtotime($event['end']['date']);
                        }
                        $eventModel->isUserEvent = 1;
                        if ($eventModel->save()) {
                            $userEvent = new UserEvent();
                            $userEvent->userId = Yii::app()->user->id;
                            $userEvent->eventId = $eventModel->id;
                            $userEvent->save();
                        }
                    }
                }
            }
        }
    }

}

function cmp_by_startTime($a, $b) {
    return $a["start"] - $b["start"];
}
