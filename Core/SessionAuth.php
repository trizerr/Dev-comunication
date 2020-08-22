<?php

namespace Core;

use App\Entity\User;

class SessionAuth implements Auth
{

  public static function logIn(User $user)
  {
      session_regenerate_id();
    $_SESSION['id'] = $user->getId();

  }

  public static function logOut()
  {
      unset($_SESSION);

    self::requireLogIn();
  }

  public static function requireLogIn()
  {
    header('Location: /');
  }

  public static function isLoggedIn()
  {
    return isset($_SESSION['id']);
  }
}