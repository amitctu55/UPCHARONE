<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'modules/diet/controllers/Diet.php');

class Admin_diet extends Diet {
    public function __construct() {
        parent::__construct();
    }
}
