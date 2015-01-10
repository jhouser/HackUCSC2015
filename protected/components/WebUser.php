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

    public function getPicture() {
        $user = $this->loadUser($this->getName());
        return $user->picture;
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
