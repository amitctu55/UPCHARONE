<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Chemist Master Layout Wrapper
 *
 * Dedicated master layout for the Chemist Partner Command Center & Pharmacy modules.
 * Standardizes:
 * 1. Global Chemist Header with Logo linking to /medical-dashboard and filtered profile menu
 * 2. Dedicated Chemist Sidebar Navigation strictly routing to chemist endpoints
 * 3. Dynamic content injection via $content_view or $body
 * 4. Clean non-overlapping footer
 */

// Include Global Chemist Header
include(FCPATH . 'assets/includes/header_medical.php');

// Include Chemist Sidebar Navigation
include(FCPATH . 'assets/includes/leftmenu_medical.php');

// Render Content View or Body
if (!empty($content_view)) {
    // Pass all controller data variables through to the content view
    $passData = !empty($content_data) && is_array($content_data) ? $content_data : (!empty($view_data) && is_array($view_data) ? $view_data : get_defined_vars());
    $this->load->view($content_view, $passData);
} elseif (!empty($body)) {
    echo $body;
}

// Include Standardized Chemist Footer
include(FCPATH . 'assets/includes/footer_medical.php');

