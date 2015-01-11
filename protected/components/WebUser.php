<?php

class WebUser extends CWebUser {

    private $_model;

    public function getFullName() {
        if (!$this->isGuest) {
            $user = $this->loadUser($this->getName());
            return $user->fullName;
        } else {
            return $this->name;
        }
    }

    public function getId() {
        $user = $this->loadUser($this->getName());
        return $user->id;
    }

    public function getPicture() {
        $user = $this->loadUser($this->getName());
        return $user->picture;
    }

    public function getUnavailability() {
        $unavailability = array();
        date_default_timezone_set('America/Los_Angeles');
        $user = $this->loadUser($this->getName());
        $busyTimes = $user->userBusyTimes;
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
        foreach ($user->userEvents as $eventLinkage) {
            $event = $eventLinkage->event;
            $unavailability[] = array('start' => $event->startTime, 'end' => $event->endTime);
        }

        function cmp_by_startTime($a, $b) {
            return $a["start"] - $b["start"];
        }
        usort($unavailability, "cmp_by_startTime");
        return $unavailability;
    }

    public function generateEventCriteria() {
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
        $criteria = new CDbCriteria();
        foreach ($availability as $timeFrame) {
            $criteria->addCondition('(startTime BETWEEN ' . $timeFrame['start'] . ' AND ' . $timeFrame['end'] . ')'
                    . ' AND (endTime BETWEEN ' . $timeFrame['start'] . ' AND ' . $timeFrame['end'] . ')', 'OR');
        }
        $criteria->addCondition('isUserEvent = 0');
        return $criteria;
    }

    public function isAvailable(Event $event) {
        $user = $this->loadModel($this->getName());
    }

    protected function loadUser($email = null) {
        if ($this->_model === null) {
            if ($email !== null) {
                $this->_model = User::model()->findByAttributes(array('email' => $email));
            }
        }
        return $this->_model;
    }

}
