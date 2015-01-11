<?php

class SiteController extends Controller {

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
            $this->redirect($this->createUrl('login'));
        }
        $dataProvider = new CActiveDataProvider('Event', [
            'criteria' => Yii::app()->user->generateEventCriteria(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->render('results', array('dataProvider' => $dataProvider));
    }

    public function actionCalendarSync() {
        if (isset(Yii::app()->session['access_token'])) {
            $client = new Google_Client();
            $client->setClientId('1019880111828-rih5k3iugp8k1p7ha550uofhec3cj0jd.apps.googleusercontent.com');
            $client->setClientSecret('ad9qK6uRBI37s3LS9wY_HlNm');
            $client->setAccessToken(Yii::app()->session['access_token']);
            $calendar = new Google_Service_Calendar($client);
            if (isset($_POST['calendar'])) {
                $calId = $_POST['calendar'];
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

    public function actionTest() {
        $events = Event::model()->findAll();
        foreach ($events as $event) {
            echo Yii::app()->user->isAvailable($event) ? "1" : "0";
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
            if (isset($user)) {
                if ($picture != $user->picture) {
                    $user->picture = $picture;
                    $user->update(array('picture'));
                }
            } else {
                $user = new User();
                $user->fullName = $name;
                $user->email = $email;
                $user->picture = $picture;
                $user->save();
            }
            $identity = new UserIdentity($email, '');
            Yii::app()->user->login($identity);
            echo Yii::app()->user->returnUrl;
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

}
