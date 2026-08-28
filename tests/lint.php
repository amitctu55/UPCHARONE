<?php
/**
 * UPCHAR Automated PHP Syntax & Lint Checker
 */

$root = dirname(__DIR__);
$directories = [
    $root . '/application',
    $root . '/admin1947/application',
    $root . '/system'
];

$errors = [];
$totalChecked = 0;

echo "====================================================\n";
echo "🧪 Running UPCHAR Automated PHP Syntax Verification\n";
echo "====================================================\n";
echo "PHP Version: " . PHP_VERSION . "\n\n";

function checkPhpSyntax($path, &$errors, &$totalChecked, $root) {
    // Skip third-party packages, vendor, caches, demo folders, legacy SDKs
    if (
        strpos($path, 'third_party') !== false ||
        strpos($path, 'vendor') !== false ||
        strpos($path, 'tcpdf') !== false ||
        strpos($path, 'PHPExcel') !== false ||
        strpos($path, 'cache') !== false ||
        strpos($path, 'demo.com') !== false ||
        strpos($path, 'google-api-php-client') !== false ||
        strpos($path, 'facebook-php-sdk') !== false ||
        strpos($path, 'linkedinoauth') !== false
    ) {
        return;
    }

    $totalChecked++;
    $relativePath = str_replace($root . DIRECTORY_SEPARATOR, '', $path);
    $code = file_get_contents($path);

    try {
        @token_get_all($code, TOKEN_PARSE);
    } catch (ParseError $e) {
        $errors[] = [
            'file' => $relativePath,
            'output' => $e->getMessage() . " on line " . $e->getLine()
        ];
        echo "❌ Error in: " . $relativePath . "\n";
        return;
    } catch (Throwable $e) {
        $errors[] = [
            'file' => $relativePath,
            'output' => $e->getMessage()
        ];
        echo "❌ Error in: " . $relativePath . "\n";
        return;
    }
}

function lintDirectory($dir, &$errors, &$totalChecked, $root) {
    if (!is_dir($dir)) return;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isDir()) continue;
        if (strtolower($file->getExtension()) !== 'php') continue;
        checkPhpSyntax($file->getPathname(), $errors, $totalChecked, $root);
    }
}

foreach ($directories as $d) {
    lintDirectory($d, $errors, $totalChecked, $root);
}

// Also check root PHP files
$rootFiles = glob($root . '/*.php');
foreach ($rootFiles as $rf) {
    if (basename($rf) === 'test_db.php') continue;
    checkPhpSyntax($rf, $errors, $totalChecked, $root);
}

echo "\n----------------------------------------------------\n";
echo "📊 Summary:\n";
echo "Scanned Files : " . $totalChecked . "\n";
echo "Syntax Errors : " . count($errors) . "\n";

if (count($errors) === 0) {
    echo "✅ SUCCESS: All " . $totalChecked . " PHP files passed syntax verification with 0 errors!\n";
    echo "----------------------------------------------------\n";
    exit(0);
} else {
    echo "\n❌ FAILED: " . count($errors) . " syntax errors encountered.\n";
    foreach ($errors as $e) {
        echo "\n[File]: " . $e['file'] . "\n";
        echo $e['output'] . "\n";
    }
    echo "----------------------------------------------------\n";
    exit(1);
}
