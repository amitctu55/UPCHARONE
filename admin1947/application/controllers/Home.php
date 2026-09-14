<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
    }

    /**
     * Redirect to the admin career management dashboard
     */
    public function career() {
        redirect(base_url('career'));
    }

    public function index() {
        redirect(base_url('career'));
    }
}
