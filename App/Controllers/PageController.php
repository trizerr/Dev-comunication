<?php 

namespace Controllers;


use Core\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
      $this->render('page/index.twig');
    }


}