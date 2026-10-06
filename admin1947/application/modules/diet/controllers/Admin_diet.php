<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(__DIR__ . '/Diet.php');

class Admin_diet extends Diet {
    public function __construct() {
        parent::__construct();
    }
}
