<?php

class LoginController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->redirect('/');
        };

//        session_start();
    }

    public function indexAction() {
//        session_start();
//        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $form = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $my_auth = new Application_Model_MyAuth();
                $isAuth = $my_auth->login(
                        $request->getParam('email'), $request->getParam('passwd')
                );
                if ($isAuth === 1) {
                    $this->redirect('/');
                    return;
                } elseif ($isAuth === 0) {
                    $this->view->login_error = "<div class='alert alert-danger' role='alert'>
                            Invalid username or pwassword.. If you don't have an account
                            <a href='#' class='alert-link'>Sign Up</a>
                            here.
                        </div>";
                } else {
                    $this->view->login_error = "<div class='alert alert-danger' role='alert'>
                            Your account have been blocked, please <a href='#' class='alert-link'>Contact Us</a>.
                        </div>";
                }
            }
        }
        $fb = new Facebook\Facebook([
              'app_id' => '1440015369404805',
              'app_secret' => 'fdf89c0b59765f9f1d896e26a95b5018',
              'default_graph_version' => 'v2.5',
            ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_likes']; // optional
        $loginUrl = $helper->getLoginUrl('http://zendecom.com/login/fbcallback', $permissions);

        // echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
        $this->view->fb_login_button = '<a class="btn btn-primary" href="' . $loginUrl . '">Log in with Facebook!</a>';
        $this->view->login_form = $form;
    }

    public function fbcallbackAction() {
//        session_start();
        $fb = new Facebook\Facebook([
            'app_id' => '1440015369404805',
            'app_secret' => 'fdf89c0b59765f9f1d896e26a95b5018',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            // Logged in!
            $_SESSION['facebook_access_token'] = (string) $accessToken;

            // Now you can redirect to another page and use the
            // access token from $_SESSION['facebook_access_token']
        }
        // Sets the default fallback access token so we don't have to pass it to each request
        $fb->setDefaultAccessToken($accessToken);

        try {
            $response = $fb->get('/me?fields=email');
            $userNode = $response->getGraphUser();
            //var_dump($userNode);exit;
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // echo 'Logged in as ' . $userNode->getName();
        // exit;
        if ($userNode) {
            
            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $user = (new Application_Model_User())->selectUserByEmail($userNode['email']);
            unset($user['password']);
            $user['cart_id'] = (new Application_Model_Shoppingcart())
                    ->getUserShoppingCart($user['id']);
            $storage->write((object)$user);
            $this->redirect('/');
        }
    }

}
