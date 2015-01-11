<?php

class SiteController extends Controller {

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
		$this->layout="column0";
        $this->render('index');
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
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['authResult'])) {
            $code = $_POST['authResult']['code'];
            $authResult = json_encode($_POST['authResult']);
            $client = new Google_Client();
            $client->setAccessToken($authResult);
            $userService = new Google_Service_Oauth2($client);
            $userInfo = $userService->userinfo->get();
            $name = $userInfo->name;
            $email = $userInfo->email;
            $picture = $userInfo->picture;
            $user = User::model()->findByAttributes(array('email' => $email));
            if (isset($user)) {
                if($picture != $user->picture){
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

            // collect user input data
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login())
                    $this->redirect(Yii::app()->user->returnUrl);
            }
            // display the login form
            $this->render('login', array('model' => $model));
        }
    }

	//get a data provider
	//render view
	
	
	public function actionResults() {
        $dataProvider = new CActiveDataProvider('Event',[
            
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        $this->render('results', array('dataProvider'=>$dataProvider));
    }
	
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
