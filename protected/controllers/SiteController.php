<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login', 'error'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('index', 'calendarSync', 'page', 'logout',
                    'invite', 'addFriend', 'cleanCurrentUser', 'signUpForEvent'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (Yii::app()->user->isGuest) {
            
        }
        $dataProvider = new CActiveDataProvider('Event', [
            'criteria' => Yii::app()->user->generateEventCriteria(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->render('results', array('dataProvider' => $dataProvider));
    }

    public function actionInvite() {
        //renders the invite page
        $dataProvider = new CActiveDataProvider('User', [
            'criteria' => [
                'condition' => 'id<>' . Yii::app()->user->id,
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->render('invite', array('dataProvider' => $dataProvider));
    }

    public function actionCalendarSync($isNewUser = false) {
        if (isset(Yii::app()->session['access_token'])) {
            $client = new Google_Client();
            $client->setClientId('1019880111828-rih5k3iugp8k1p7ha550uofhec3cj0jd.apps.googleusercontent.com');
            $client->setClientSecret('ad9qK6uRBI37s3LS9wY_HlNm');
            $client->setAccessToken(Yii::app()->session['access_token']);
            $calendar = new Google_Service_Calendar($client);
            if (isset($_POST['calendar'])) {
                $calId = $_POST['calendar'];
                $user = Yii::app()->user->getModel();
                $user->calendar = $calId;
                $user->update(array('calendar'));
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
                        $eventModel->startTime = strtotime($event['start']['dateTime']);
                        $eventModel->endTime = strtotime($event['end']['dateTime']);
                        $eventModel->isUserEvent = 1;
                        if ($eventModel->save()) {
                            $userEvent = new UserEvent();
                            $userEvent->userId = Yii::app()->user->id;
                            $userEvent->eventId = $eventModel->id;
                            $userEvent->save();
                        }
                    }
                }
                $this->redirect($isNewUser ? $this->createUrl('invite') : $this->createUrl('index'));
            }
            $calendars = array();
            foreach ($calendar->calendarList->listCalendarList() as $calObj) {
                $calendars[$calObj['id']] = $calObj['summary'];
            }
            $this->render('calendarSync', array(
                'calendars' => $calendars,
            ));
        }
    }

    public function actionSignUpForEvent($eventId) {
        $event = Event::model()->findByPk($eventId);
        if (isset($event)) {
            if (isset(Yii::app()->session['access_token'])) {
                $client = new Google_Client();
                $client->setClientId('1019880111828-rih5k3iugp8k1p7ha550uofhec3cj0jd.apps.googleusercontent.com');
                $client->setClientSecret('ad9qK6uRBI37s3LS9wY_HlNm');
                $client->setAccessToken(Yii::app()->session['access_token']);
                $calendar = new Google_Service_Calendar($client);
                if (isset(Yii::app()->user->calendar)) {
                    $user = Yii::app()->user->getModel();
                    $attendees = array();
                    $guests = array();
                    foreach ($user->userFriends1 as $userFriend) {
                        $friend = $userFriend->friend;
                        $guests[] = $friend;
                        if ($friend->isAvailable($event)) {
                            $attendee = new Google_Service_Calendar_EventAttendee();
                            $attendee->setEmail($friend->email);
                            $attendees[] = $attendee;
                        }
                    }
                    $googleEvent = new Google_Service_Calendar_Event();
                    $objDateTime = new DateTime('NOW');
                    $objDateTime->setTimeStamp($event->startTime);
                    $startTime = $objDateTime->format(DateTime::ISO8601);
                    $googleStartTime = new Google_Service_Calendar_EventDateTime();
                    $googleStartTime->setDateTime($startTime);
                    $googleEvent->setStart($googleStartTime);
                    $objDateTime->setTimeStamp($event->endTime);
                    $endTime = $objDateTime->format(DateTime::ISO8601);
                    $googleEndTime = new Google_Service_Calendar_EventDateTime();
                    $googleEndTime->setDateTime($endTime);
                    $googleEvent->setEnd($googleEndTime);
                    $googleEvent->setSummary($event->title);
                    $googleEvent->setDescription($event->description);
                    $googleEvent->attendees = $attendees;
                    $calendar->events->insert(Yii::app()->user->calendar, $googleEvent);
                    $guests[] = $user;
                    foreach ($guests as $guest) {
                        $userEvent = new UserEvent();
                        $userEvent->userId = $guest->id;
                        $userEvent->eventId = $eventId;
                        $userEvent->save();
                    }
                    echo 1;
                }
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionAddFriend($friendId) {
        $other = User::model()->findByPk($friendId);
        if (isset($other) && !Yii::app()->user->isFriend($other)) {
            $userFriend1 = new UserFriend();
            $userFriend1->userId = Yii::app()->user->id;
            $userFriend1->friendId = $friendId;
            $userFriend2 = new UserFriend();
            $userFriend2->friendId = Yii::app()->user->id;
            $userFriend2->userId = $friendId;
            if ($userFriend1->save() && $userFriend2->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = "column0";
        if (isset($_POST['authResult'])) {
            $authResult = json_encode($_POST['authResult']);
            Yii::app()->session['access_token'] = $authResult;
            $client = new Google_Client();
            $client->setAccessToken($authResult);
            $userService = new Google_Service_Oauth2($client);
            $userInfo = $userService->userinfo->get();
            $name = $userInfo->name;
            $email = $userInfo->email;
            $picture = $userInfo->picture;
            $user = User::model()->findByAttributes(array('email' => $email));
            $newUser = false;
            if (isset($user)) {
                if ($picture != $user->picture) {
                    $user->picture = $picture;
                    $user->update(array('picture'));
                }
            } else {
                $newUser = true;
                $user = new User();
                $user->fullName = $name;
                $user->email = $email;
                $user->picture = $picture;
                $user->save();
            }
            $identity = new UserIdentity($email, '');
            Yii::app()->user->login($identity);
            $user->syncCalendar();
            echo $newUser ? $this->createUrl('site/calendarSync', array('isNewUser' => true)) : Yii::app()->user->returnUrl;
        } else {
            // display the login form
            $this->render('login');
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionCleanCurrentUser() {
        $user = Yii::app()->user->getModel();
        $events = $user->userEvents;
        foreach ($events as $event) {
            if (isset($event->event)) {
                $event->event->delete();
            }
        }
        $user->delete();
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('login'));
    }

}
