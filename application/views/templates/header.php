<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/header', isset($data) ? $data : (isset($meta_array) ? ['meta_array' => $meta_array] : []));
