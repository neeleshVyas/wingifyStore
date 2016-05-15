<?php

namespace Authenticator;

use DBC\UserMap;
use App\Factory;

class Authenticate
{
      private $sessionManager;
      private $userDB;

      public function __construct()
      {
            $this->sessionManager = Factory::getSessionManager();
            $this->userDB = Factory::getDatabaseFactory()->getUserMap();
      }

      public function authenticate()
      {
            if( !$this->isUserLoggedIn() ){
                  return $this->doLogin( $username, $password );
            }
            return false;
      }

      public function doLogin( $username, $password )
      {
            $status = false;
            $message = null;

            $user = $this->getUserByCredentials( $username, $password );
            if( $user instanceof UserMap ){
                  $this->setUserSession($user);
                  $status = true;
                  $message = 'Logged In Successfully';
            }
            else {
                  $message = 'Invalid Credentials';
            }
            return array('status' => $status, 'message' => $message);
      }

      private function setUserSession( $user )
      {
            $this->sessionManager->set( '_user', $user->getUserId() );
      }

      private function getUserByCredentials( $username, $password )
      {
            return $this->userDB->getUserByCredentials( $username, $password );
      }

      public function isUserLoggedIn()
      {
            $userId = $this->sessionManager->get('_user');
            $user = $this->userDB->getUserById( $userId );
            return ($user instanceof UserMap);
      }


}


 ?>
