<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Standard Sidebar Proxy View
 * Ensures $this->load->view('sidebar') resolves reliably across all HMVC modules.
 */
$this->load->view('inc/sidebar');
