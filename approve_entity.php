<?php
/**
 * Upchar Healthcare Platform - Central Acquisition Verification & Approval API
 * Allows Super Admin & Acquisition Managers to verify or reject onboarding healthcare facilities.
 */

// Standalone MySQL runner
$mysqli = new mysqli('127.0.0.1', 'upchar5510', 'Ranu@28010', 'upchar5510_db');
if ($mysqli->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'DB Connection Failed']);
    exit();
}

$action       = $_REQUEST['action'] ?? 'list';
$entity_type  = $_REQUEST['entity_type'] ?? 'hospital';
$entity_id    = intval($_REQUEST['entity_id'] ?? 0);
$admin_id     = intval($_REQUEST['admin_id'] ?? 1);

$valid_tables = [
    'hospital'  => 'hospital',
    'doctor'    => 'profile_dr',
    'clinic'    => 'clinic',
    'pathlab'   => 'pathlab',
    'pathology' => 'pathlab'
];

$table = $valid_tables[strtolower($entity_type)] ?? 'hospital';

header('Content-Type: application/json');

if ($action === 'verify' && $entity_id > 0) {
    $stmt = $mysqli->prepare("UPDATE `$table` SET `verification_status` = 'verified', `is_active` = 1, `verified_at` = NOW(), `verified_by_admin_id` = ?, `approved` = '1' WHERE `id` = ?");
    $stmt->bind_param('ii', $admin_id, $entity_id);
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => "Facility #$entity_id ($entity_type) has been APPROVED and activated.",
            'entity_type' => $entity_type,
            'entity_id' => $entity_id,
            'verification_status' => 'verified',
            'is_active' => 1
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit();
}

if ($action === 'reject' && $entity_id > 0) {
    $stmt = $mysqli->prepare("UPDATE `$table` SET `verification_status` = 'rejected', `is_active` = 0, `approved` = '0' WHERE `id` = ?");
    $stmt->bind_param('i', $entity_id);
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => "Facility #$entity_id ($entity_type) has been REJECTED and locked.",
            'entity_type' => $entity_type,
            'entity_id' => $entity_id,
            'verification_status' => 'rejected',
            'is_active' => 0
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit();
}

if ($action === 'pending' && $entity_id > 0) {
    $stmt = $mysqli->prepare("UPDATE `$table` SET `verification_status` = 'pending', `is_active` = 0 WHERE `id` = ?");
    $stmt->bind_param('i', $entity_id);
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => "Facility #$entity_id ($entity_type) status set to PENDING.",
            'entity_type' => $entity_type,
            'entity_id' => $entity_id,
            'verification_status' => 'pending',
            'is_active' => 0
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit();
}

// Default action: List pending facilities across all entities
$results = [];
foreach ($valid_tables as $type => $tbl) {
    if ($type === 'pathology') continue;
    $name_col = ($tbl === 'profile_dr') ? "CONCAT(fname, ' ', lname)" : "name";
    $query = "SELECT id, $name_col as entity_name, email, mobile, verification_status, is_active, creat_date FROM `$tbl` WHERE `verification_status` = 'pending' OR `is_active` = 0 ORDER BY id DESC LIMIT 50";
    $q = $mysqli->query($query);
    if ($q) {
        while ($row = $q->fetch_assoc()) {
            $row['entity_type'] = $type;
            $results[] = $row;
        }
    }
}

echo json_encode([
    'status' => 'success',
    'pending_count' => count($results),
    'pending_facilities' => $results
], JSON_PRETTY_PRINT);
