<?php


namespace App\helpers;


class ErrorHandler
{
  static public function getErrorName($error)
  {
    $errors = [
      E_ERROR => 'ERROR',
      E_WARNING => 'WARNING',
      E_PARSE => 'PARSE',
      E_NOTICE => 'NOTICE',
      E_CORE_ERROR => 'CORE_ERROR',
      E_CORE_WARNING => 'CORE_WARNING',
      E_COMPILE_ERROR => 'COMPILE_ERROR',
      E_COMPILE_WARNING => 'COMPILE_WARNING',
      E_USER_ERROR => 'USER_ERROR',
      E_USER_WARNING => 'USER_WARNING',
      E_USER_NOTICE => 'USER_NOTICE',
      E_STRICT => 'STRICT',
      E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
      E_DEPRECATED => 'DEPRECATED',
      E_USER_DEPRECATED => 'USER_DEPRECATED',
    ];
    if (array_key_exists($error, $errors)) {
      return $errors[$error] . " [$error]";
    }

    return $error;
  }


  public function register()
  {
    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exceptionHandler']);
    register_shutdown_function([$this, 'fatalErrorHandler']);

  }

  public function errorHandler($errno, $errostr, $file, $line)
  {
    $this->showError($errno, $errostr, $file, $line);

    return true;
  }

  public function fatalErrorHandler()
  {
    if (!empty($error = error_get_last()) and $error ['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR | E_RECOVERABLE_ERROR)) {
      ob_get_clean();
      $this->showError($error['type'], $error['message'], $error['file'], $error['line']);
    }
  }

  public function exceptionHandler(\Throwable $exept)
  {
    $this->showError(get_class($exept), $exept->getMessage(), $exept->getFile(), $exept->getline());

    return true;
  }

  public function showError($errno, $errostr, $file, $line, $status = 500)
  {

   //header("HTTP/1.1 $status");

    echo $message = '<mark><b>' . self::getErrorName($errno) . '</b></mark> <hr><mark>' . $errostr . '</mark><hr><mark> file: ' . $file . '<hr><mark><mark>line: ' . $line . '</mark><hr>';

    echo '<br>';
  }
}