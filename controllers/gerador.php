<?php

class Gerador extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array('gerador/js/index.js');
        $this->view->css = array('gerador/index.css');
    }
    
    function index() {
        $this->view->title = 'Gerar Certificado PDF em PHP';
		$this->view->render('header');
        $this->view->render('gerador/index');
		$this->view->render('footer');
    }

    function gerador()
    {
        $this->model->gerador();
    }

    function selectAssinatura()
    {
        $this->model->selectAssinatura();
    }

    function savePosition()
    {
        $this->model->savePosition();
    }
    
}