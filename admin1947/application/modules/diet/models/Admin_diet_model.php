<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_diet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_tables();
    }

    /**
     * Ensure database tables exist and have necessary columns
     */
    private function ensure_tables() {
        if (!$this->db->table_exists('food_master')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `food_master` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL,
                `category` VARCHAR(60) DEFAULT 'General',
                `serving_size` DECIMAL(8,2) DEFAULT 1.00,
                `serving_unit` VARCHAR(30) DEFAULT 'serving',
                `calories` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `protein` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `carbs` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `fats` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `fiber` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `iron` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `calcium` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `vitamin_c` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `is_veg` TINYINT(1) DEFAULT 1,
                `status` ENUM('active', 'inactive') DEFAULT 'active',
                `is_verified` TINYINT(1) DEFAULT 1,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY `idx_name` (`name`),
                KEY `idx_category` (`category`),
                KEY `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            if ($this->db->table_exists('food_database')) {
                $this->db->query("INSERT IGNORE INTO food_master (id, name, category, serving_size, serving_unit, calories, protein, carbs, fats, fiber, iron, calcium, vitamin_c, is_veg, is_verified, created_at)
                    SELECT id, name, category, serving_size, serving_unit, calories, protein, carbs, fats, fiber, iron, calcium, vitamin_c, 1, is_verified, created_at FROM food_database");
            }
        }
    }

    /* ==========================================================
       1. FOOD MASTER DATABASE (CRUD)
       ========================================================== */

    /**
     * Get paginated foods list with search and filters
     */
    public function get_foods($limit = 20, $offset = 0, $filters = []) {
        $table = $this->db->table_exists('food_master') ? 'food_master' : 'food_database';
        $this->db->from($table);

        if (!empty($filters['keyword'])) {
            $kw = trim($filters['keyword']);
            $this->db->group_start();
            $this->db->like('name', $kw);
            $this->db->or_like('category', $kw);
            $this->db->group_end();
        }

        if (!empty($filters['category'])) {
            $this->db->where('category', $filters['category']);
        }

        if (isset($filters['status']) && $filters['status'] !== '' && $filters['status'] !== 'all') {
            if ($this->db->field_exists('status', $table)) {
                $this->db->where('status', $filters['status']);
            }
        }

        if (isset($filters['is_veg']) && $filters['is_veg'] !== '' && $filters['is_veg'] !== 'all') {
            if ($this->db->field_exists('is_veg', $table)) {
                $this->db->where('is_veg', intval($filters['is_veg']));
            }
        }

        $sort_col = !empty($filters['sort_col']) ? $filters['sort_col'] : 'name';
        $sort_dir = !empty($filters['sort_dir']) && strtolower($filters['sort_dir']) === 'desc' ? 'DESC' : 'ASC';
        $allowed_sort = ['id', 'name', 'category', 'calories', 'protein', 'carbs', 'fats', 'fiber', 'created_at'];
        if (!in_array($sort_col, $allowed_sort)) $sort_col = 'name';

        $this->db->order_by($sort_col, $sort_dir);

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Get count of foods matching filters
     */
    public function get_total_foods($filters = []) {
        $table = $this->db->table_exists('food_master') ? 'food_master' : 'food_database';
        $this->db->from($table);

        if (!empty($filters['keyword'])) {
            $kw = trim($filters['keyword']);
            $this->db->group_start();
            $this->db->like('name', $kw);
            $this->db->or_like('category', $kw);
            $this->db->group_end();
        }

        if (!empty($filters['category'])) {
            $this->db->where('category', $filters['category']);
        }

        if (isset($filters['status']) && $filters['status'] !== '' && $filters['status'] !== 'all') {
            if ($this->db->field_exists('status', $table)) {
                $this->db->where('status', $filters['status']);
            }
        }

        if (isset($filters['is_veg']) && $filters['is_veg'] !== '' && $filters['is_veg'] !== 'all') {
            if ($this->db->field_exists('is_veg', $table)) {
                $this->db->where('is_veg', intval($filters['is_veg']));
            }
        }

        return $this->db->count_all_results();
    }

    /**
     * Get single food item by ID
     */
    public function get_food_by_id($id) {
        $table = $this->db->table_exists('food_master') ? 'food_master' : 'food_database';
        return $this->db->get_where($table, ['id' => intval($id)])->row();
    }

    /**
     * Save (Insert / Update) a food item and synchronize both tables
     */
    public function save_food($data, $id = null) {
        $clean = [
            'name'         => trim($data['name']),
            'category'     => !empty($data['category']) ? trim($data['category']) : 'General',
            'serving_size' => max(0.1, floatval($data['serving_size'] ?? 1.00)),
            'serving_unit' => !empty($data['serving_unit']) ? trim($data['serving_unit']) : 'serving',
            'calories'     => max(0, floatval($data['calories'] ?? 0)),
            'protein'      => max(0, floatval($data['protein'] ?? 0)),
            'carbs'        => max(0, floatval($data['carbs'] ?? 0)),
            'fats'         => max(0, floatval($data['fats'] ?? 0)),
            'fiber'        => max(0, floatval($data['fiber'] ?? 0)),
            'iron'         => max(0, floatval($data['iron'] ?? 0)),
            'calcium'      => max(0, floatval($data['calcium'] ?? 0)),
            'vitamin_c'    => max(0, floatval($data['vitamin_c'] ?? 0)),
            'is_veg'       => isset($data['is_veg']) ? intval($data['is_veg']) : 1,
            'status'       => (!empty($data['status']) && in_array($data['status'], ['active', 'inactive'])) ? $data['status'] : 'active',
            'is_verified'  => 1
        ];

        $target_id = 0;

        if ($id && intval($id) > 0) {
            $target_id = intval($id);
            // Update food_master
            if ($this->db->table_exists('food_master')) {
                $this->db->where('id', $target_id)->update('food_master', $clean);
            }

            // Sync with food_database
            if ($this->db->table_exists('food_database')) {
                $sync_clean = $clean;
                unset($sync_clean['status']);
                if ($this->db->get_where('food_database', ['id' => $target_id])->row()) {
                    $this->db->where('id', $target_id)->update('food_database', $sync_clean);
                } else {
                    $sync_clean['id'] = $target_id;
                    $this->db->insert('food_database', $sync_clean);
                }
            }
        } else {
            // Insert new food
            if ($this->db->table_exists('food_master')) {
                $this->db->insert('food_master', $clean);
                $target_id = $this->db->insert_id();
            }

            // Sync into food_database
            if ($this->db->table_exists('food_database')) {
                $sync_clean = $clean;
                unset($sync_clean['status']);
                if ($target_id > 0) {
                    $sync_clean['id'] = $target_id;
                }
                $this->db->insert('food_database', $sync_clean);
                if (!$target_id) {
                    $target_id = $this->db->insert_id();
                }
            }
        }

        return $target_id;
    }

    /**
     * Delete food item
     */
    public function delete_food($id) {
        $id = intval($id);
        if ($id <= 0) return false;

        if ($this->db->table_exists('food_master')) {
            $this->db->where('id', $id)->delete('food_master');
        }
        if ($this->db->table_exists('food_database')) {
            $this->db->where('id', $id)->delete('food_database');
        }

        return true;
    }

    /**
     * Toggle food active / inactive status
     */
    public function toggle_food_status($id) {
        $id = intval($id);
        if ($id <= 0) return false;

        $food = $this->get_food_by_id($id);
        if (!$food) return false;

        $new_status = (isset($food->status) && $food->status === 'inactive') ? 'active' : 'inactive';

        if ($this->db->table_exists('food_master') && $this->db->field_exists('status', 'food_master')) {
            $this->db->where('id', $id)->update('food_master', ['status' => $new_status]);
        }

        return $new_status;
    }

    /**
     * Get distinct categories
     */
    public function get_categories() {
        $table = $this->db->table_exists('food_master') ? 'food_master' : 'food_database';
        $res = $this->db->distinct()->select('category')->where('category !=', '')->order_by('category', 'ASC')->get($table)->result();
        $cats = [];
        foreach ($res as $r) {
            if (!empty($r->category)) $cats[] = $r->category;
        }
        if (empty($cats)) {
            $cats = ['Grains & Breads', 'Dairy & Paneer', 'Lentils & Dals', 'Vegetables', 'Fruits', 'Poultry & Meat', 'Eggs', 'Nuts & Seeds', 'Beverages', 'Snacks & Sweets'];
        }
        return $cats;
    }

    /* ==========================================================
       2. PATIENT DIET TARGET OVERRIDES
       ========================================================== */

    /**
     * Search patient directory by keyword (Name, Email, Mobile, ID)
     */
    public function search_patients($keyword = '', $limit = 15) {
        $this->db->select('u.USERID as id, u.FNAME as fname, u.LNAME as lname, u.EMAIL as email, u.MOBILE as mobile, u.GENDER as gender, u.DOB as dob, u.HEIGHT as height, u.WEIGHT as weight, g.target_calories, g.is_custom_override, g.updated_at as goals_updated_at');
        $this->db->from('userlogin u');
        $this->db->join('patient_nutrition_goals g', 'g.user_id = u.USERID', 'left');

        if (!empty($keyword)) {
            $kw = trim($keyword);
            $this->db->group_start();
            $this->db->like('u.FNAME', $kw);
            $this->db->or_like('u.LNAME', $kw);
            $this->db->or_like('u.EMAIL', $kw);
            $this->db->or_like('u.MOBILE', $kw);
            if (is_numeric($kw)) {
                $this->db->or_where('u.USERID', intval($kw));
            }
            $this->db->group_end();
        }

        $this->db->order_by('u.USERID', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * Fetch complete patient target dossier & clinical baseline calculations
     */
    public function get_patient_targets($user_id) {
        $user_id = intval($user_id);
        if ($user_id <= 0) return null;

        $user = $this->db->get_where('userlogin', ['USERID' => $user_id])->row();
        if (!$user) return null;

        $goals = null;
        if ($this->db->table_exists('patient_nutrition_goals')) {
            $goals = $this->db->get_where('patient_nutrition_goals', ['user_id' => $user_id])->row();
        }

        $gender = strtoupper(trim($user->GENDER ?: 'M'));
        if ($gender === 'MALE') $gender = 'M';
        if ($gender === 'FEMALE') $gender = 'F';

        preg_match('/(\d+(\.\d+)?)/', (string)($user->HEIGHT ?? ''), $h_m);
        preg_match('/(\d+(\.\d+)?)/', (string)($user->WEIGHT ?? ''), $w_m);
        $height_raw = !empty($h_m[1]) ? floatval($h_m[1]) : 165;
        $height_cm  = ($height_raw < 10) ? round($height_raw * 30.48, 1) : $height_raw;
        $weight_kg  = !empty($w_m[1]) ? floatval($w_m[1]) : 65;

        $age = 30;
        if (!empty($user->DOB)) {
            try {
                $dob_dt = new DateTime($user->DOB);
                $age = (new DateTime())->diff($dob_dt)->y;
            } catch (Throwable $e) { $age = 30; }
        }

        // Baseline Mifflin-St Jeor BMR
        if ($gender === 'F') {
            $bmr = round((10 * $weight_kg) + (6.25 * $height_cm) - (5 * $age) - 161);
        } else {
            $bmr = round((10 * $weight_kg) + (6.25 * $height_cm) - (5 * $age) + 5);
        }
        $tdee = round($bmr * 1.35);

        $height_m = max(0.5, $height_cm / 100);
        $bmi = round($weight_kg / ($height_m * $height_m), 1);

        return [
            'user'               => $user,
            'user_id'            => $user_id,
            'full_name'          => trim(($user->FNAME ?? '') . ' ' . ($user->LNAME ?? '')),
            'email'              => $user->EMAIL ?? '',
            'mobile'             => $user->MOBILE ?? '',
            'age'                => $age,
            'gender'             => $gender,
            'height_cm'          => $height_cm,
            'weight_kg'          => $weight_kg,
            'bmi'                => $bmi,
            'bmr'                => $bmr,
            'tdee'               => $tdee,
            'is_custom_override' => $goals && !empty($goals->is_custom_override) ? 1 : 0,
            'target_calories'    => $goals && $goals->target_calories > 0 ? floatval($goals->target_calories) : $tdee,
            'protein_g'          => $goals && $goals->protein_g > 0 ? floatval($goals->protein_g) : round(($tdee * 0.20) / 4),
            'carbs_g'            => $goals && $goals->carbs_g > 0 ? floatval($goals->carbs_g) : round(($tdee * 0.50) / 4),
            'fat_g'              => $goals && $goals->fat_g > 0 ? floatval($goals->fat_g) : round(($tdee * 0.30) / 9),
            'fiber_g'            => $goals && isset($goals->fiber_g) && $goals->fiber_g > 0 ? floatval($goals->fiber_g) : 30.00,
            'iron_mg'            => $goals && isset($goals->iron_mg) && $goals->iron_mg > 0 ? floatval($goals->iron_mg) : 18.00,
            'calcium_mg'         => $goals && isset($goals->calcium_mg) && $goals->calcium_mg > 0 ? floatval($goals->calcium_mg) : 1000.00,
            'vitamin_c_mg'       => $goals && isset($goals->vitamin_c_mg) && $goals->vitamin_c_mg > 0 ? floatval($goals->vitamin_c_mg) : 75.00,
            'activity_level'     => $goals->activity_level ?? 'moderate',
            'fitness_goal'       => $goals->fitness_goal ?? 'maintain',
            'clinical_notes'     => $goals->clinical_notes ?? '',
            'updated_at'         => $goals->updated_at ?? null,
            'updated_by_admin'   => $goals->updated_by_admin ?? null
        ];
    }

    /**
     * Save custom clinical diet targets for a patient
     */
    public function save_patient_targets($user_id, $data, $admin_id = 0) {
        $user_id = intval($user_id);
        if ($user_id <= 0) return false;

        $payload = [
            'user_id'            => $user_id,
            'target_calories'    => max(800, floatval($data['target_calories'] ?? 2000)),
            'protein_g'          => max(10, floatval($data['protein_g'] ?? 65)),
            'carbs_g'            => max(10, floatval($data['carbs_g'] ?? 250)),
            'fat_g'              => max(10, floatval($data['fat_g'] ?? 55)),
            'fiber_g'            => max(0, floatval($data['fiber_g'] ?? 30)),
            'iron_mg'            => max(0, floatval($data['iron_mg'] ?? 18)),
            'calcium_mg'         => max(0, floatval($data['calcium_mg'] ?? 1000)),
            'vitamin_c_mg'       => max(0, floatval($data['vitamin_c_mg'] ?? 75)),
            'activity_level'     => !empty($data['activity_level']) ? trim($data['activity_level']) : 'moderate',
            'fitness_goal'       => !empty($data['fitness_goal']) ? trim($data['fitness_goal']) : 'clinical_custom',
            'clinical_notes'     => !empty($data['clinical_notes']) ? trim($data['clinical_notes']) : null,
            'is_custom_override' => 1,
            'updated_by_admin'   => intval($admin_id),
            'updated_at'         => date('Y-m-d H:i:s')
        ];

        if (!empty($data['height_cm'])) {
            $payload['height_cm'] = floatval($data['height_cm']);
            $this->db->where('USERID', $user_id)->update('userlogin', ['HEIGHT' => $data['height_cm']]);
        }
        if (!empty($data['weight_kg'])) {
            $payload['weight_kg'] = floatval($data['weight_kg']);
            $this->db->where('USERID', $user_id)->update('userlogin', ['WEIGHT' => $data['weight_kg']]);
        }

        $exists = $this->db->get_where('patient_nutrition_goals', ['user_id' => $user_id])->row();
        if ($exists) {
            $this->db->where('user_id', $user_id)->update('patient_nutrition_goals', $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('patient_nutrition_goals', $payload);
        }

        return true;
    }

    /* ==========================================================
       3. PATIENT LOG MONITORING (VIEW ONLY)
       ========================================================== */

    /**
     * Get itemized logs and nutrient aggregations for a patient on a specific date
     */
    public function get_patient_logs_by_date($user_id, $date = null) {
        $user_id = intval($user_id);
        $date = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');

        $categories = ['breakfast', 'brunch', 'lunch', 'snacks', 'dinner'];
        $grouped = [
            'breakfast' => [],
            'brunch'    => [],
            'lunch'     => [],
            'snacks'    => [],
            'dinner'    => []
        ];

        $consumed = [
            'calories'    => 0.0,
            'protein'     => 0.0,
            'carbs'       => 0.0,
            'fats'        => 0.0,
            'fiber'       => 0.0,
            'iron'        => 0.0,
            'calcium'     => 0.0,
            'vitamin_c'   => 0.0,
            'total_items' => 0
        ];

        if ($this->db->table_exists('user_diet_logs')) {
            $logs = $this->db->where('user_id', $user_id)
                ->where('log_date', $date)
                ->order_by('id', 'ASC')
                ->get('user_diet_logs')
                ->result();

            foreach ($logs as $item) {
                $meal = strtolower(trim($item->meal_category));
                if (!in_array($meal, $categories)) $meal = 'breakfast';

                $grouped[$meal][] = $item;

                $consumed['calories']    += floatval($item->calories);
                $consumed['protein']     += floatval($item->protein);
                $consumed['carbs']       += floatval($item->carbs);
                $consumed['fats']        += floatval($item->fats);
                $consumed['fiber']       += floatval($item->fiber);
                $consumed['iron']        += floatval($item->iron);
                $consumed['calcium']     += floatval($item->calcium);
                $consumed['vitamin_c']   += floatval($item->vitamin_c);
                $consumed['total_items']++;
            }
        }

        foreach ($consumed as $k => $v) {
            if ($k !== 'total_items') $consumed[$k] = round($v, 1);
        }

        $targets = $this->get_patient_targets($user_id);
        $tgt_cal   = $targets ? $targets['target_calories'] : 2000;
        $tgt_prot  = $targets ? $targets['protein_g'] : 65;
        $tgt_carbs = $targets ? $targets['carbs_g'] : 250;
        $tgt_fats  = $targets ? $targets['fat_g'] : 55;
        $tgt_fiber = $targets ? $targets['fiber_g'] : 30;

        $pct = [
            'calories'  => min(150, round(($consumed['calories'] / max(1, $tgt_cal)) * 100)),
            'protein'   => min(150, round(($consumed['protein'] / max(1, $tgt_prot)) * 100)),
            'carbs'     => min(150, round(($consumed['carbs'] / max(1, $tgt_carbs)) * 100)),
            'fats'      => min(150, round(($consumed['fats'] / max(1, $tgt_fats)) * 100)),
            'fiber'     => min(150, round(($consumed['fiber'] / max(1, $tgt_fiber)) * 100))
        ];

        return [
            'user_id'         => $user_id,
            'date'            => $date,
            'date_formatted'  => date('l, F j, Y', strtotime($date)),
            'meals'           => $grouped,
            'consumed'        => $consumed,
            'targets'         => $targets,
            'percentages'     => $pct
        ];
    }

    /**
     * High-level diet tracker KPIs for admin dashboard
     */
    public function get_diet_kpis() {
        $total_foods = $this->db->table_exists('food_master') ? $this->db->count_all('food_master') : 0;
        $active_foods = $this->db->table_exists('food_master') ? $this->db->where('status', 'active')->count_all_results('food_master') : $total_foods;
        $total_custom_targets = $this->db->table_exists('patient_nutrition_goals') ? $this->db->where('is_custom_override', 1)->count_all_results('patient_nutrition_goals') : 0;
        $today_logs = $this->db->table_exists('user_diet_logs') ? $this->db->where('log_date', date('Y-m-d'))->count_all_results('user_diet_logs') : 0;
        $total_logged_patients = $this->db->table_exists('user_diet_logs') ? $this->db->distinct()->select('user_id')->count_all_results('user_diet_logs') : 0;

        return [
            'total_foods'           => $total_foods,
            'active_foods'          => $active_foods,
            'total_custom_targets'  => $total_custom_targets,
            'today_logs'            => $today_logs,
            'total_logged_patients' => $total_logged_patients
        ];
    }
}
