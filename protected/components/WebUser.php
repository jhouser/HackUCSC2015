<?php

class WebUser extends CWebUser {

    private $_model;

    public function getModel() {
        return $this->loadUser($this->getName());
    }

    public function getFullName() {
        if (!$this->isGuest) {
            $user = $this->loadUser($this->getName());
            return $user->fullName;
        } else {
            return $this->name;
        }
    }

    public function getId() {
        if (!$this->isGuest) {
            $user = $this->loadUser($this->getName());
            if (isset($user)) {
                return $user->id;
            } else {
                return parent::getId();
            }
        } else {
            return parent::getId();
        }
    }

    public function getPicture() {
        $user = $this->loadUser($this->getName());
        return $user->picture;
    }

    public function getUnavailability() {
        $user = $this->loadUser($this->getName());
        return $user->getUnavailability();
    }

    public function getAvailability() {
        $user = $this->loadUser($this->getName());
        return $user->getAvailability();
    }

    public function generateEventCriteria() {
        $user = $this->loadUser($this->getName());
        return $user->generateEventCriteria();
    }

    public function isAvailable(Event $event) {
        $user = $this->loadUser($this->getName());
        return $user->isAvailable($event);
    }
    
    public function syncCalendar(){
        $user = $this->loadUser($this->getName());
        $user->syncCalendar();
    }

    protected function loadUser($email = null) {
        if ($this->_model === null) {
            if ($email !== null) {
                $this->_model = User::model()->findByAttributes(array('email' => $email));
            }
            if($this->_model === null){
                $this->logout();
                Yii::app()->controller->redirect(Yii::app()->controller->createUrl('site/login'));
            }
        }
        return $this->_model;
    }

}
