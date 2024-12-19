<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function dashboard()
    {
        $this->render('dashboard', []);
    }
}
