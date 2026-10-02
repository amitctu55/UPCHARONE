<?php
$passwords = array_filter(array_unique([
    getenv("FTP_PASSWORD"),
    "Upchar@123",
    "Ranu@28010"
]));
$server = getenv("FTP_SERVER") ?: "87.232.72.4";
$user = getenv("FTP_USERNAME") ?: "upchar5510";
$active_pwd = null;

foreach ($passwords as $pwd) {
    if (empty($pwd)) continue;
    $conn = @ftp_connect($server, 21, 5);
    if ($conn && @ftp_login($conn, $user, $pwd)) {
        $active_pwd = $pwd;
        ftp_close($conn);
        break;
    }
    if ($conn) @ftp_close($conn);
}

if (!$active_pwd) {
    echo "::error::Could not authenticate with FTP server using any configured password.\n";
    exit(1);
}

echo "::add-mask::" . $active_pwd . "\n";
$env_file = getenv("GITHUB_ENV");
if ($env_file) {
    file_put_contents($env_file, "ACTIVE_FTP_PASSWORD=" . $active_pwd . "\n", FILE_APPEND);
}
echo "Successfully verified and activated working FTP credentials.\n";
