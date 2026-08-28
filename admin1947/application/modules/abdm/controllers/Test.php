<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('abdm/abdm_model');
    }

    public function index() {
        echo "ABDM Module Test<br>";

        // Test getting stats
        $stats = $this->abdm_model->get_abdm_stats();
        echo "<pre>";
        print_r($stats);
        echo "</pre>";

        echo "ABDM module is working correctly!";
    }
}