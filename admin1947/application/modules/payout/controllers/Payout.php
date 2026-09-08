<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'modules/admin_payment/controllers/Admin_payment.php';

/**
 * Payout Hub Controller Proxy
 * Seamlessly bridges /payout/dashboard and /payout/* requests to the Admin_payment engine.
 */
class Payout extends Admin_payment {
    public function __construct() {
        parent::__construct();
    }
}
