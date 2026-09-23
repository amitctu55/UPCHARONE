<?php
/**
 * Test Suite: Pharmacy Reports Print & PDF Export Verification
 * Validates print stylesheet, print header, print footer, and DOM elements
 */

$ch = curl_init('http://localhost/demo/upchar/pharmacy/reports');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "========================================================\n";
echo "🧪 PHARMACY REPORTS PRINT & PDF FUNCTIONALITY VERIFICATION\n";
echo "========================================================\n";

$tests = [];

// 1. HTTP 200
$tests['HTTP 200 OK Response'] = ($httpCode === 200);

// 2. Print Media Query
$tests['@media print CSS Stylesheet'] = (strpos($html, '@media print') !== false);

// 3. Topbar & Sidebar Hiding Rules in Print CSS
$tests['Print CSS Hides Fixed Topbar & Sidebar'] = (
    strpos($html, 'header.topbar') !== false &&
    strpos($html, '.sidebar') !== false &&
    strpos($html, 'display: none !important') !== false
);

// 4. Print Width & Margin Reset (Eliminating 250px left margin)
$tests['Print CSS Resets Main Content Margins'] = (
    strpos($html, '.main-content') !== false &&
    strpos($html, 'margin: 0 !important') !== false
);

// 5. Print Color Adjust Exact
$tests['Print Color Adjust (Preserves Badges & Charts)'] = (
    strpos($html, 'print-color-adjust: exact !important') !== false
);

// 6. Formal Print-Only Letterhead Header
$tests['Print-Only Document Header (Store, D.L. No, GSTIN)'] = (
    strpos($html, 'class="print-only-header"') !== false &&
    strpos($html, 'UPCHAR HEALTHCARE') !== false &&
    strpos($html, 'D.L. No:') !== false &&
    strpos($html, 'GSTIN:') !== false
);

// 7. Formal Print-Only Sign-off Footer
$tests['Print-Only Document Footer (Sign-off & Seal Block)'] = (
    strpos($html, 'class="print-only-footer"') !== false &&
    strpos($html, 'Authorized Pharmacist') !== false || strpos($html, 'Registered Pharmacist') !== false
);

// 8. Chart.js Print Adaptation Event Listeners
$tests['Chart.js Print Event Listeners (beforeprint/afterprint)'] = (
    strpos($html, 'beforeprint') !== false &&
    strpos($html, 'afterprint') !== false
);

// 9. Window Print Trigger
$tests['Window.print() Trigger Button'] = (
    strpos($html, 'window.print()') !== false
);

$passCount = 0;
foreach ($tests as $title => $result) {
    if ($result) {
        $passCount++;
        echo "  [PASS] {$title}\n";
    } else {
        echo "  [FAIL] {$title}\n";
    }
}

echo "--------------------------------------------------------\n";
echo "Summary: {$passCount} / " . count($tests) . " checks passed (" . round(($passCount / count($tests)) * 100) . "%)\n";
echo "========================================================\n";

if ($passCount === count($tests)) {
    exit(0);
} else {
    exit(1);
}
