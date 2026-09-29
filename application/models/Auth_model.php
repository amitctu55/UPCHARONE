<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/**
 * Class Auth_model
 * 
 * Unified Identity and Single Sign-On (SSO) Model for Upchar Ecosystem.
 * Manages central authentication, master users table (upchar_users),
 * role-based profile extensions, and cross-application SSO tokens.
 */
class Auth_model extends CI_Model {

    const TABLE_MASTER_USERS     = 'upchar_users';
    const TABLE_PATIENT_PROFILES = 'patient_profiles';
    const TABLE_AMB_PROVIDERS    = 'ambulance_providers';
    const TABLE_DOCTOR_PROFILES  = 'doctor_profiles';
    const TABLE_HOSPITAL_ADMINS  = 'hospital_admins';

    // Shared HMAC Secret for Cross-Platform SSO Tokens
    private $sso_secret = 'UPCHAR_SECURE_SSO_KEY_2026_ECOSYSTEM_TOKEN';

    public function __construct() {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Kolkata');
    }

    /**
     * Generate secure UUIDv4
     */
    public function generate_uuid() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Find a user in the central master identity table by email, mobile, id, or uuid.
     *
     * @param string|int $identifier Mobile number, email address, numeric ID, or UUID
     * @return array|null Master user row with attached role flags and profiles
     */
    public function find_master_user($identifier) {
        if (empty($identifier)) {
            return null;
        }

        $clean = trim($identifier);

        $this->db->select('*');
        $this->db->from(self::TABLE_MASTER_USERS);

        if (is_numeric($clean)) {
            // Check numeric ID or 10-digit mobile
            $this->db->group_start();
            $this->db->where('id', (int)$clean);
            $this->db->or_where('mobile', $clean);
            $this->db->group_end();
        } else if (filter_var($clean, FILTER_VALIDATE_EMAIL)) {
            $this->db->where('LOWER(email)', strtolower($clean));
        } else if (strlen($clean) === 36 && strpos($clean, '-') !== false) {
            $this->db->where('uuid', $clean);
        } else {
            // Fallback search across mobile or email
            $this->db->group_start();
            $this->db->where('mobile', $clean);
            $this->db->or_where('LOWER(email)', strtolower($clean));
            $this->db->group_end();
        }

        $user = $this->db->limit(1)->get()->row_array();

        if ($user) {
            $user['roles'] = $this->get_user_roles($user['id']);
            $user['profiles'] = $this->get_user_profiles($user['id']);
        }

        return $user;
    }

    /**
     * Register a new master user in the central identity layer.
     *
     * @param array $data Master user payload ['name', 'email', 'mobile', 'password', 'google_auth_id', 'status']
     * @return array The created or existing master user record
     */
    public function register_master_user($data) {
        $email  = !empty($data['email']) ? strtolower(trim($data['email'])) : null;
        $mobile = !empty($data['mobile']) ? trim($data['mobile']) : null;
        $name   = !empty($data['name']) ? trim($data['name']) : 'Upchar User';
        $google = !empty($data['google_auth_id']) ? trim($data['google_auth_id']) : null;
        $status = !empty($data['status']) ? $data['status'] : 'Active';

        // Check if user already exists in master table
        $existing = null;
        if ($email) {
            $existing = $this->find_master_user($email);
        }
        if (!$existing && $mobile) {
            $existing = $this->find_master_user($mobile);
        }

        if ($existing) {
            // Update any missing data
            $updates = [];
            if (empty($existing['mobile']) && $mobile) {
                $updates['mobile'] = $mobile;
            }
            if (empty($existing['email']) && $email) {
                $updates['email'] = $email;
            }
            if (!empty($data['password'])) {
                $updates['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }
            if (!empty($updates)) {
                $this->db->where('id', $existing['id'])->update(self::TABLE_MASTER_USERS, $updates);
                $existing = $this->find_master_user($existing['id']);
            }
            return $existing;
        }

        // Hash password if provided
        $passwordHash = null;
        if (!empty($data['password'])) {
            $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);
        } else if (!empty($data['password_hash'])) {
            $passwordHash = $data['password_hash'];
        }

        $insert = [
            'uuid'           => $this->generate_uuid(),
            'name'           => $name,
            'mobile'         => $mobile,
            'email'          => $email,
            'password_hash'  => $passwordHash,
            'google_auth_id' => $google,
            'status'         => $status,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $this->db->insert(self::TABLE_MASTER_USERS, $insert);
        $masterId = (int)$this->db->insert_id();

        return $this->find_master_user($masterId);
    }

    /**
     * Link or update a role-specific profile for a master user.
     *
     * @param int $userId Master user ID (upchar_users.id)
     * @param string $role 'patient', 'ambulance_provider', 'doctor', 'hospital_admin'
     * @param array $profileData Data fields specific to the role
     * @return bool
     */
    public function link_role_profile($userId, $role, $profileData = []) {
        if (!$userId || empty($role)) {
            return false;
        }

        switch (strtolower($role)) {
            case 'patient':
            case 'patient_profile':
                $table = self::TABLE_PATIENT_PROFILES;
                $key = 'user_id';
                break;

            case 'ambulance_provider':
            case 'provider':
                $table = self::TABLE_AMB_PROVIDERS;
                $key = 'user_id';
                break;

            case 'doctor':
            case 'doctor_profile':
                $table = self::TABLE_DOCTOR_PROFILES;
                $key = 'user_id';
                break;

            case 'hospital_admin':
            case 'hospital':
                $table = self::TABLE_HOSPITAL_ADMINS;
                $key = 'user_id';
                break;

            default:
                return false;
        }

        $existing = $this->db->where($key, $userId)->get($table)->row_array();
        if ($existing) {
            $profileData['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where($key, $userId)->update($table, $profileData);
        } else {
            $profileData[$key] = $userId;
            $profileData['created_at'] = date('Y-m-d H:i:s');
            $profileData['updated_at'] = date('Y-m-d H:i:s');
            $this->db->insert($table, $profileData);
        }

        return true;
    }

    /**
     * Get active roles for a master user
     */
    public function get_user_roles($userId) {
        $roles = [];

        if ($this->db->where('user_id', $userId)->count_all_results(self::TABLE_PATIENT_PROFILES) > 0) {
            $roles[] = 'patient';
        }
        if ($this->db->where('user_id', $userId)->count_all_results(self::TABLE_AMB_PROVIDERS) > 0) {
            $roles[] = 'ambulance_provider';
        }
        if ($this->db->where('user_id', $userId)->count_all_results(self::TABLE_DOCTOR_PROFILES) > 0) {
            $roles[] = 'doctor';
        }
        if ($this->db->where('user_id', $userId)->count_all_results(self::TABLE_HOSPITAL_ADMINS) > 0) {
            $roles[] = 'hospital_admin';
        }

        return $roles;
    }

    /**
     * Get all profile detail models for a master user
     */
    public function get_user_profiles($userId) {
        return [
            'patient'            => $this->db->where('user_id', $userId)->get(self::TABLE_PATIENT_PROFILES)->row_array(),
            'ambulance_provider' => $this->db->where('user_id', $userId)->get(self::TABLE_AMB_PROVIDERS)->row_array(),
            'doctor'             => $this->db->where('user_id', $userId)->get(self::TABLE_DOCTOR_PROFILES)->row_array(),
            'hospital_admin'     => $this->db->where('user_id', $userId)->get(self::TABLE_HOSPITAL_ADMINS)->row_array(),
        ];
    }

    /**
     * Verify user password (supports Bcrypt and legacy MD5)
     */
    public function verify_master_password($masterUser, $plainPassword) {
        if (empty($masterUser['password_hash'])) {
            return false;
        }

        $hash = $masterUser['password_hash'];

        // Bcrypt check
        if (password_verify($plainPassword, $hash)) {
            return true;
        }

        // Legacy MD5 check fallback
        if (md5($plainPassword) === $hash) {
            // Upgrade password hash to secure Bcrypt in background
            $newHash = password_hash($plainPassword, PASSWORD_BCRYPT);
            $this->db->where('id', $masterUser['id'])->update(self::TABLE_MASTER_USERS, ['password_hash' => $newHash]);
            return true;
        }

        return false;
    }

    /**
     * Generate Cross-Subdomain/Cross-App SSO Token (JWT-Style signed payload)
     *
     * @param array $masterUser
     * @param int $expirySeconds (Default 7 days)
     * @return string Signed SSO token
     */
    public function generate_sso_token($masterUser, $expirySeconds = 604800) {
        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload = [
            'iss'     => 'upchar-sso',
            'sub'     => $masterUser['id'],
            'uuid'    => $masterUser['uuid'],
            'name'    => $masterUser['name'],
            'email'   => $masterUser['email'],
            'mobile'  => $masterUser['mobile'],
            'roles'   => $this->get_user_roles($masterUser['id']),
            'iat'     => time(),
            'exp'     => time() + $expirySeconds
        ];

        $b64Header  = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $b64Payload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');
        $signature  = hash_hmac('sha256', $b64Header . '.' . $b64Payload, $this->sso_secret, true);
        $b64Sig     = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        return $b64Header . '.' . $b64Payload . '.' . $b64Sig;
    }

    /**
     * Validate and decode Cross-Platform SSO Token
     *
     * @param string $token
     * @return array|false Returns token payload or false on failure
     */
    public function verify_sso_token($token) {
        if (empty($token)) {
            return false;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($b64Header, $b64Payload, $b64Sig) = $parts;

        // Verify HMAC signature
        $expectedSig = hash_hmac('sha256', $b64Header . '.' . $b64Payload, $this->sso_secret, true);
        $expectedB64Sig = rtrim(strtr(base64_encode($expectedSig), '+/', '-_'), '=');

        if (!hash_equals($expectedB64Sig, $b64Sig)) {
            return false;
        }

        $payload = json_decode(base64_decode(strtr($b64Payload, '-_', '+/')), true);
        if (!$payload || !isset($payload['exp']) || $payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }
}
