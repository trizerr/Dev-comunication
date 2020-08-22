<?php

namespace Core;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{

  public function render($viewName, $params = [])
  {
    $loader = new FilesystemLoader(dirname(__DIR__) . '/App/Views');
    $twig = new Environment($loader);

    try {
      echo $twig->render($viewName, $params);
    } catch (LoaderError $e) {
      echo 'LoaderError';
    } catch (RuntimeError $e) {
      echo 'RuntimeError';
    } catch (SyntaxError $e) {
      echo 'SyntaxError';
    }
  }

}