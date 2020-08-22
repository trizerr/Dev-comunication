<?php


namespace Core;


use App\Entity\User;

interface Auth
{
  public static function logIn(User $user);

  public static function logOut();

  public static function requireLogIn();

  public static function isLoggedIn();
}