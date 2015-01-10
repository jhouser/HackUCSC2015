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
    
    public function getId(){
        $user = $this->loadUser($this->getName());
        return $user->id;
    }

    public function getPicture() {
        $user = $this->loadUser($this->getName());
        return $user->picture;
    }
    
    public function getAvailability(){
        $user = $this->loadUser($this->getName());
        $busyTimes = $user->userBusyTimes;
        printR($busyTimes,true);
        exit;
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
