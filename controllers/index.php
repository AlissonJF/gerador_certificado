
<?php
class Index extends Controller {
    function __construct() {
        parent::__construct();
		$this->view->js = array("index/index.js");
		$this->view->css = array("index/index.css");
    }
    function index()
    {
        $this->view->title = " Index";
        $this->view->render("header");
        $this->view->render("index/index");
        $this->view->render("footer");
    }

    function ImageBackgroundRemove()
    {
        $this->model->ImageBackgroundRemove();
    }

    function getDados()
    {
        $this->model->getDados();
    }
}