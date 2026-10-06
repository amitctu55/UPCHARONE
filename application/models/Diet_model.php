<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_tables();
    }

    /**
     * Ensure database tables exist automatically
     */
    private function ensure_tables() {
        try {
            if (!$this->db->table_exists('food_database')) {
                $this->db->query("CREATE TABLE IF NOT EXISTS `food_database` (
                  `id` INT AUTO_INCREMENT PRIMARY KEY,
                  `name` VARCHAR(150) NOT NULL,
                  `category` VARCHAR(50) DEFAULT 'General',
                  `serving_size` DECIMAL(8,2) NOT NULL DEFAULT 100.00,
                  `serving_unit` VARCHAR(50) NOT NULL DEFAULT 'g',
                  `calories` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `protein` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `carbs` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `fats` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `fiber` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `iron` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `calcium` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `vitamin_c` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `is_verified` TINYINT(1) NOT NULL DEFAULT 1,
                  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                  INDEX `idx_food_name` (`name`),
                  INDEX `idx_food_category` (`category`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            }

            if (!$this->db->table_exists('user_diet_logs')) {
                $this->db->query("CREATE TABLE IF NOT EXISTS `user_diet_logs` (
                  `id` INT AUTO_INCREMENT PRIMARY KEY,
                  `user_id` INT NOT NULL,
                  `food_id` INT DEFAULT NULL,
                  `food_name` VARCHAR(150) NOT NULL,
                  `meal_category` ENUM('breakfast', 'brunch', 'lunch', 'snacks', 'dinner') NOT NULL DEFAULT 'breakfast',
                  `quantity` DECIMAL(8,2) NOT NULL DEFAULT 1.00,
                  `serving_unit` VARCHAR(50) NOT NULL DEFAULT 'serving',
                  `log_date` DATE NOT NULL,
                  `calories` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `protein` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `carbs` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `fats` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `fiber` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `iron` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `calcium` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `vitamin_c` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                  `notes` VARCHAR(255) DEFAULT NULL,
                  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                  INDEX `idx_user_log_date` (`user_id`, `log_date`),
                  INDEX `idx_meal_cat` (`meal_category`),
                  INDEX `idx_log_date` (`log_date`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            }
        } catch (\Throwable $e) {
            log_message('error', 'Diet_model ensure_tables exception: ' . $e->getMessage());
        }
    }

    /**
     * Search foods for autocomplete input
     */
    public function search_foods($keyword, $limit = 20) {
        $keyword = trim($keyword);
        if (empty($keyword)) {
            // Return top popular items
            return $this->db->select('*')
                ->from('food_database')
                ->order_by('is_verified', 'DESC')
                ->order_by('name', 'ASC')
                ->limit($limit)
                ->get()
                ->result_array();
        }

        return $this->db->select('*')
            ->from('food_database')
            ->group_start()
                ->like('name', $keyword)
                ->or_like('category', $keyword)
            ->group_end()
            ->order_by('is_verified', 'DESC')
            ->order_by('name', 'ASC')
            ->limit($limit)
            ->get()
            ->result_array();
    }

    /**
     * Get single food item by ID
     */
    public function get_food_by_id($id) {
        return $this->db->get_where('food_database', array('id' => intval($id)))->row_array();
    }

    /**
     * Add a custom food item to food_database
     */
    public function add_custom_food($data) {
        $insert = [
            'name'         => trim($data['name']),
            'category'     => trim($data['category'] ?? 'Custom'),
            'serving_size' => max(0.1, floatval($data['serving_size'] ?? 1)),
            'serving_unit' => trim($data['serving_unit'] ?? 'serving'),
            'calories'     => max(0, floatval($data['calories'] ?? 0)),
            'protein'      => max(0, floatval($data['protein'] ?? 0)),
            'carbs'        => max(0, floatval($data['carbs'] ?? 0)),
            'fats'         => max(0, floatval($data['fats'] ?? 0)),
            'fiber'        => max(0, floatval($data['fiber'] ?? 0)),
            'iron'         => max(0, floatval($data['iron'] ?? 0)),
            'calcium'      => max(0, floatval($data['calcium'] ?? 0)),
            'vitamin_c'    => max(0, floatval($data['vitamin_c'] ?? 0)),
            'is_verified'  => 0,
            'created_at'   => date('Y-m-d H:i:s')
        ];
        $this->db->insert('food_database', $insert);
        return $this->db->insert_id();
    }

    /**
     * Standardize and normalize dates (supports Y-m-d, d-m-Y, d/m/Y, etc.)
     */
    public function normalize_date($date_str = null) {
        $date_str = trim($date_str ?? '');
        if (empty($date_str)) {
            return date('Y-m-d');
        }
        // YYYY-MM-DD
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $date_str, $m)) {
            return sprintf('%04d-%02d-%02d', (int)$m[1], (int)$m[2], (int)$m[3]);
        }
        // DD-MM-YYYY
        if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $date_str, $m)) {
            return sprintf('%04d-%02d-%02d', (int)$m[3], (int)$m[2], (int)$m[1]);
        }
        // DD/MM/YYYY
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $date_str, $m)) {
            return sprintf('%04d-%02d-%02d', (int)$m[3], (int)$m[2], (int)$m[1]);
        }
        // YYYY/MM/DD
        if (preg_match('/^(\d{4})\/(\d{1,2})\/(\d{1,2})$/', $date_str, $m)) {
            return sprintf('%04d-%02d-%02d', (int)$m[1], (int)$m[2], (int)$m[3]);
        }

        $ts = strtotime($date_str);
        return $ts ? date('Y-m-d', $ts) : date('Y-m-d');
    }

    /**
     * Log a meal item for a user with calculated nutrition
     */
    public function log_meal($user_id, $data) {
        $user_id = intval($user_id);
        if ($user_id <= 0) return false;

        $food_id = !empty($data['food_id']) ? intval($data['food_id']) : null;
        $quantity = max(0.1, floatval($data['quantity'] ?? 1.0));
        $meal_category = strtolower(trim($data['meal_category'] ?? 'breakfast'));
        
        $allowed_cats = ['breakfast', 'brunch', 'lunch', 'snacks', 'dinner'];
        if (!in_array($meal_category, $allowed_cats)) {
            $meal_category = 'breakfast';
        }

        $log_date = $this->normalize_date($data['log_date'] ?? null);

        // Defaults
        $food_name    = trim($data['food_name'] ?? 'Meal Item');
        $serving_unit = trim($data['serving_unit'] ?? 'serving');
        $calories     = 0.0;
        $protein      = 0.0;
        $carbs        = 0.0;
        $fats         = 0.0;
        $fiber        = 0.0;
        $iron         = 0.0;
        $calcium      = 0.0;
        $vitamin_c    = 0.0;

        if ($food_id) {
            $food = $this->get_food_by_id($food_id);
            if ($food) {
                $food_name    = $food['name'];
                $serving_unit = $food['serving_unit'];
                $base_serv    = floatval($food['serving_size']) > 0 ? floatval($food['serving_size']) : 1.0;
                $multiplier   = $quantity / $base_serv;

                $calories  = round($food['calories'] * $multiplier, 1);
                $protein   = round($food['protein'] * $multiplier, 1);
                $carbs     = round($food['carbs'] * $multiplier, 1);
                $fats      = round($food['fats'] * $multiplier, 1);
                $fiber     = round($food['fiber'] * $multiplier, 1);
                $iron      = round($food['iron'] * $multiplier, 2);
                $calcium   = round($food['calcium'] * $multiplier, 1);
                $vitamin_c = round($food['vitamin_c'] * $multiplier, 1);
            }
        } else {
            // Manual overrides from user
            $calories  = round(floatval($data['calories'] ?? 0), 1);
            $protein   = round(floatval($data['protein'] ?? 0), 1);
            $carbs     = round(floatval($data['carbs'] ?? 0), 1);
            $fats      = round(floatval($data['fats'] ?? 0), 1);
            $fiber     = round(floatval($data['fiber'] ?? 0), 1);
            $iron      = round(floatval($data['iron'] ?? 0), 2);
            $calcium   = round(floatval($data['calcium'] ?? 0), 1);
            $vitamin_c = round(floatval($data['vitamin_c'] ?? 0), 1);
        }

        $insert_data = [
            'user_id'       => $user_id,
            'food_id'       => $food_id,
            'food_name'     => $food_name,
            'meal_category' => $meal_category,
            'quantity'      => $quantity,
            'serving_unit'  => $serving_unit,
            'log_date'      => $log_date,
            'calories'      => $calories,
            'protein'       => $protein,
            'carbs'         => $carbs,
            'fats'          => $fats,
            'fiber'         => $fiber,
            'iron'          => $iron,
            'calcium'       => $calcium,
            'vitamin_c'     => $vitamin_c,
            'notes'         => !empty($data['notes']) ? substr(trim($data['notes']), 0, 255) : null,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->insert('user_diet_logs', $insert_data);
        return $this->db->insert_id();
    }

    /**
     * Delete a logged food entry ensuring ownership
     */
    public function delete_log($log_id, $user_id) {
        return $this->db->where([
            'id'      => intval($log_id),
            'user_id' => intval($user_id)
        ])->delete('user_diet_logs');
    }

    /**
     * Get all logs for a user on a given date, structured into the 5 meal categories
     */
    public function get_logs_by_date($user_id, $date = null) {
        $user_id = intval($user_id);
        $date = $this->normalize_date($date);

        $rows = $this->db->select('*')
            ->from('user_diet_logs')
            ->where('user_id', $user_id)
            ->where('log_date', $date)
            ->order_by('id', 'ASC')
            ->get()
            ->result_array();

        // 5 mandatory meal categories
        $categories = [
            'breakfast' => ['title' => 'Breakfast', 'icon' => 'fa-coffee',      'color' => '#f59e0b', 'items' => [], 'subtotal' => ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0]],
            'brunch'    => ['title' => 'Brunch',    'icon' => 'fa-bread-slice', 'color' => '#8b5cf6', 'items' => [], 'subtotal' => ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0]],
            'lunch'     => ['title' => 'Lunch',     'icon' => 'fa-utensils',    'color' => '#10b981', 'items' => [], 'subtotal' => ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0]],
            'snacks'    => ['title' => 'Snacks',    'icon' => 'fa-apple-alt',   'color' => '#06b6d4', 'items' => [], 'subtotal' => ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0]],
            'dinner'    => ['title' => 'Dinner',    'icon' => 'fa-moon',        'color' => '#3b82f6', 'items' => [], 'subtotal' => ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0, 'fiber' => 0]],
        ];

        foreach ($rows as $row) {
            $cat = strtolower($row['meal_category']);
            if (!isset($categories[$cat])) {
                $cat = 'breakfast';
            }

            $categories[$cat]['items'][] = $row;
            $categories[$cat]['subtotal']['calories'] += floatval($row['calories']);
            $categories[$cat]['subtotal']['protein']  += floatval($row['protein']);
            $categories[$cat]['subtotal']['carbs']    += floatval($row['carbs']);
            $categories[$cat]['subtotal']['fats']     += floatval($row['fats']);
            $categories[$cat]['subtotal']['fiber']    += floatval($row['fiber']);
        }

        // Round subtotals
        foreach ($categories as $k => $c) {
            $categories[$k]['subtotal']['calories'] = round($c['subtotal']['calories'], 1);
            $categories[$k]['subtotal']['protein']  = round($c['subtotal']['protein'], 1);
            $categories[$k]['subtotal']['carbs']    = round($c['subtotal']['carbs'], 1);
            $categories[$k]['subtotal']['fats']     = round($c['subtotal']['fats'], 1);
            $categories[$k]['subtotal']['fiber']    = round($c['subtotal']['fiber'], 1);
            $categories[$k]['count']                = count($categories[$k]['items']);
        }

        return $categories;
    }

    /**
     * Get user's recommended daily targets based on BMR/BMI/Nutrition Goals
     */
    public function get_user_targets($user_id) {
        $user_id = intval($user_id);

        // 1. Check patient_nutrition_goals table
        if ($this->db->table_exists('patient_nutrition_goals')) {
            $goal = $this->db->get_where('patient_nutrition_goals', ['user_id' => $user_id])->row_array();
            if ($goal && !empty($goal['target_calories']) && floatval($goal['target_calories']) > 500) {
                return [
                    'source'          => 'custom_goals',
                    'target_calories' => round(floatval($goal['target_calories'])),
                    'protein_g'       => round(floatval($goal['protein_g'] ?? 65)),
                    'carbs_g'         => round(floatval($goal['carbs_g'] ?? 250)),
                    'fat_g'           => round(floatval($goal['fat_g'] ?? 55)),
                    'fiber_g'         => 30.0,
                    'iron_mg'         => 18.0,
                    'calcium_mg'      => 1000.0,
                    'vitamin_c_mg'    => 75.0,
                    'bmr'             => round(floatval($goal['bmr'] ?? 1500)),
                    'tdee'            => round(floatval($goal['tdee'] ?? 2000)),
                    'goal_name'       => ucwords($goal['fitness_goal'] ?? 'maintain')
                ];
            }
        }

        // 2. Fallback: compute from user vitals (height, weight, age, gender)
        $user = $this->db->get_where('userlogin', ['USERID' => $user_id])->row_array();
        $weight = floatval($user['WEIGHT'] ?? 65);
        $height = floatval($user['HEIGHT'] ?? 170);
        $gender = strtoupper(trim($user['GENDER'] ?? 'M'));

        // Age calculation
        $age = 30;
        if (!empty($user['DOB'])) {
            try {
                $age = (new DateTime())->diff(new DateTime($user['DOB']))->y;
            } catch (\Throwable $e) { $age = 30; }
        }

        // Height cm normalization
        if ($height > 0 && $height < 10) {
            $height = round($height * 30.48); // feet to cm
        }
        if ($height <= 0) $height = 168.0;
        if ($weight <= 0) $weight = 65.0;

        // Mifflin-St Jeor Formula
        if ($gender === 'F' || $gender === 'FEMALE') {
            $bmr = round((10 * $weight) + (6.25 * $height) - (5 * $age) - 161);
        } else {
            $bmr = round((10 * $weight) + (6.25 * $height) - (5 * $age) + 5);
        }
        $tdee = round($bmr * 1.35); // light-to-moderate activity default

        $target_calories = max(1300, $tdee);
        $protein = round(($target_calories * 0.25) / 4); // 25% protein
        $carbs   = round(($target_calories * 0.50) / 4); // 50% carbs
        $fats    = round(($target_calories * 0.25) / 9); // 25% fats

        return [
            'source'          => 'calculated_vitals',
            'target_calories' => $target_calories,
            'protein_g'       => $protein,
            'carbs_g'         => $carbs,
            'fat_g'           => $fats,
            'fiber_g'         => 30.0,
            'iron_mg'         => 18.0,
            'calcium_mg'      => 1000.0,
            'vitamin_c_mg'    => 75.0,
            'bmr'             => $bmr,
            'tdee'            => $tdee,
            'goal_name'       => 'Healthy Maintenance'
        ];
    }

    /**
     * Get complete Daily Summary (Consumed vs Targets with percentages)
     */
    public function get_daily_summary($user_id, $date = null) {
        $user_id = intval($user_id);
        $date = $this->normalize_date($date);

        $meal_categories = $this->get_logs_by_date($user_id, $date);
        $targets = $this->get_user_targets($user_id);

        $consumed = [
            'calories'  => 0.0,
            'protein'   => 0.0,
            'carbs'     => 0.0,
            'fats'      => 0.0,
            'fiber'     => 0.0,
            'iron'      => 0.0,
            'calcium'   => 0.0,
            'vitamin_c' => 0.0,
            'total_items' => 0
        ];

        foreach ($meal_categories as $cat) {
            foreach ($cat['items'] as $item) {
                $consumed['calories']  += floatval($item['calories']);
                $consumed['protein']   += floatval($item['protein']);
                $consumed['carbs']     += floatval($item['carbs']);
                $consumed['fats']      += floatval($item['fats']);
                $consumed['fiber']     += floatval($item['fiber']);
                $consumed['iron']      += floatval($item['iron']);
                $consumed['calcium']   += floatval($item['calcium']);
                $consumed['vitamin_c'] += floatval($item['vitamin_c']);
                $consumed['total_items']++;
            }
        }

        // Round consumed values
        $consumed['calories']  = round($consumed['calories'], 1);
        $consumed['protein']   = round($consumed['protein'], 1);
        $consumed['carbs']     = round($consumed['carbs'], 1);
        $consumed['fats']      = round($consumed['fats'], 1);
        $consumed['fiber']     = round($consumed['fiber'], 1);
        $consumed['iron']      = round($consumed['iron'], 2);
        $consumed['calcium']   = round($consumed['calcium'], 1);
        $consumed['vitamin_c'] = round($consumed['vitamin_c'], 1);

        // Progress percentages (capped at 100 for display bar, raw kept)
        $pct = [
            'calories'  => $targets['target_calories'] > 0 ? round(($consumed['calories'] / $targets['target_calories']) * 100) : 0,
            'protein'   => $targets['protein_g'] > 0 ? round(($consumed['protein'] / $targets['protein_g']) * 100) : 0,
            'carbs'     => $targets['carbs_g'] > 0 ? round(($consumed['carbs'] / $targets['carbs_g']) * 100) : 0,
            'fats'      => $targets['fat_g'] > 0 ? round(($consumed['fats'] / $targets['fat_g']) * 100) : 0,
            'fiber'     => $targets['fiber_g'] > 0 ? round(($consumed['fiber'] / $targets['fiber_g']) * 100) : 0,
            'iron'      => $targets['iron_mg'] > 0 ? round(($consumed['iron'] / $targets['iron_mg']) * 100) : 0,
            'calcium'   => $targets['calcium_mg'] > 0 ? round(($consumed['calcium'] / $targets['calcium_mg']) * 100) : 0,
            'vitamin_c' => $targets['vitamin_c_mg'] > 0 ? round(($consumed['vitamin_c'] / $targets['vitamin_c_mg']) * 100) : 0,
        ];

        // Remaining calculations
        $remaining = [
            'calories' => max(0, round($targets['target_calories'] - $consumed['calories'])),
            'protein'  => max(0, round($targets['protein_g'] - $consumed['protein'], 1)),
            'carbs'    => max(0, round($targets['carbs_g'] - $consumed['carbs'], 1)),
            'fats'     => max(0, round($targets['fat_g'] - $consumed['fats'], 1)),
            'fiber'    => max(0, round($targets['fiber_g'] - $consumed['fiber'], 1))
        ];

        return [
            'date'            => $date,
            'date_formatted'  => date('l, M d, Y', strtotime($date)),
            'is_today'        => ($date === date('Y-m-d')),
            'consumed'        => $consumed,
            'targets'         => $targets,
            'percentages'     => $pct,
            'remaining'       => $remaining,
            'meal_categories' => $meal_categories
        ];
    }
}
