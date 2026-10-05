<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clinical & Metabolic Health Assessment Helper for Upchar Platform
 * 
 * Provides automated, evidence-based clinical calculations for:
 * - Precise age calculation from Date of Birth (DOB)
 * - Height & Weight extraction and metric normalization
 * - Body Mass Index (BMI) and clinical categorization (WHO standards)
 * - Basal Metabolic Rate (BMR) using the Mifflin-St Jeor equation
 * - Total Daily Energy Expenditure (TDEE) and maintenance caloric intake
 * - Healthy target weight ranges (BMI 18.5 - 24.9)
 * - Personalized clinical nutritionist guidance with dynamic pronouns
 */

if (!function_exists('calculate_patient_age')) {
    /**
     * Calculate patient's exact age in years from DOB string
     *
     * @param string|null $dob e.g. '1996-05-14'
     * @return int Age in years (default 30 if unparseable)
     */
    function calculate_patient_age($dob) {
        if (empty($dob)) {
            return 30;
        }
        try {
            $dobDate = new DateTime(trim($dob));
            $now = new DateTime();
            if ($dobDate > $now) {
                return 30;
            }
            return (int)$now->diff($dobDate)->y;
        } catch (\Throwable $e) {
            return 30;
        }
    }
}

if (!function_exists('parse_clinical_height')) {
    /**
     * Parse and normalize patient height to centimeters (cm)
     *
     * @param mixed $height Raw height string (e.g. '155', '155 cm', '5.1', '5 ft 1 in')
     * @return float Height in cm
     */
    function parse_clinical_height($height) {
        if (empty($height)) {
            return 0.0;
        }
        $str = trim((string)$height);
        
        // Handle ft/in format like 5'1" or 5ft 1in
        if (preg_match('/(\d+)\s*(?:\'|ft)\s*(\d+)?/i', $str, $matches)) {
            $ft = intval($matches[1]);
            $in = isset($matches[2]) ? intval($matches[2]) : 0;
            return round(($ft * 30.48) + ($in * 2.54), 1);
        }

        // Numeric extraction
        if (preg_match('/(\d+(?:\.\d+)?)/', $str, $matches)) {
            $val = floatval($matches[1]);
            // If entered as feet (e.g. 5.1), convert to cm
            if ($val > 0 && $val < 10) {
                return round($val * 30.48, 1);
            }
            return round($val, 1);
        }

        return 0.0;
    }
}

if (!function_exists('parse_clinical_weight')) {
    /**
     * Parse and normalize patient weight to kilograms (kg)
     *
     * @param mixed $weight Raw weight string (e.g. '46', '46 kg', '101 lbs')
     * @return float Weight in kg
     */
    function parse_clinical_weight($weight) {
        if (empty($weight)) {
            return 0.0;
        }
        $str = trim((string)$weight);

        // Check for lbs
        if (stripos($str, 'lb') !== false && preg_match('/(\d+(?:\.\d+)?)/', $str, $matches)) {
            return round(floatval($matches[1]) * 0.45359237, 1);
        }

        if (preg_match('/(\d+(?:\.\d+)?)/', $str, $matches)) {
            return round(floatval($matches[1]), 1);
        }

        return 0.0;
    }
}

if (!function_exists('calculate_bmi')) {
    /**
     * Calculate Body Mass Index (BMI) and clinical classification
     *
     * @param float $height_cm
     * @param float $weight_kg
     * @return array [bmi, status, color, badge]
     */
    function calculate_bmi($height_cm, $weight_kg) {
        if ($height_cm <= 0 || $weight_kg <= 0) {
            return [
                'bmi' => 0.0,
                'status' => 'Unknown',
                'color' => '#64748b',
                'badge' => 'secondary'
            ];
        }

        $height_m = $height_cm / 100.0;
        $bmi = round($weight_kg / ($height_m * $height_m), 1);

        if ($bmi < 18.5) {
            $status = 'Underweight';
            $color = '#f59e0b'; // Amber
            $badge = 'warning';
        } elseif ($bmi <= 24.9) {
            $status = 'Normal';
            $color = '#10b981'; // Emerald green
            $badge = 'success';
        } elseif ($bmi <= 29.9) {
            $status = 'Overweight';
            $color = '#f97316'; // Orange
            $badge = 'warning';
        } else {
            $status = 'Obese';
            $color = '#ef4444'; // Red
            $badge = 'danger';
        }

        return [
            'bmi' => $bmi,
            'status' => $status,
            'color' => $color,
            'badge' => $badge
        ];
    }
}

if (!function_exists('calculate_bmr_mifflin')) {
    /**
     * Calculate Basal Metabolic Rate (BMR) using the Mifflin-St Jeor Equation
     * 
     * Formula:
     * - Women: (10 * weight_kg) + (6.25 * height_cm) - (5 * age) - 161
     * - Men:   (10 * weight_kg) + (6.25 * height_cm) - (5 * age) + 5
     *
     * @param float $height_cm
     * @param float $weight_kg
     * @param int $age
     * @param string $gender 'F', 'Female', 'M', 'Male', etc.
     * @return int BMR in kcal/day
     */
    function calculate_bmr_mifflin($height_cm, $weight_kg, $age, $gender) {
        if ($height_cm <= 0 || $weight_kg <= 0) {
            return 0;
        }
        $age = max(10, min(120, $age ?: 30));
        $gen = strtoupper(trim((string)$gender));
        $isFemale = in_array($gen, ['F', 'FEMALE', 'WOMAN', 'GIRL']);

        if ($isFemale) {
            $bmr = (10 * $weight_kg) + (6.25 * $height_cm) - (5 * $age) - 161;
        } else {
            $bmr = (10 * $weight_kg) + (6.25 * $height_cm) - (5 * $age) + 5;
        }

        return (int)round($bmr);
    }
}

if (!function_exists('calculate_patient_health_goals')) {
    /**
     * Generate full clinical health goals and metabolic profile for a patient
     *
     * @param object|array $user
     * @return array|null Health goals array or null if vitals unavailable
     */
    function calculate_patient_health_goals($user) {
        if (empty($user)) {
            return null;
        }

        // Helper to extract property from object or array
        $get = function($prop) use ($user) {
            if (is_object($user)) {
                $u = strtoupper($prop);
                $l = strtolower($prop);
                if (isset($user->$u) && $user->$u !== '') return $user->$u;
                if (isset($user->$l) && $user->$l !== '') return $user->$l;
                if (isset($user->$prop) && $user->$prop !== '') return $user->$prop;
            } elseif (is_array($user)) {
                $u = strtoupper($prop);
                $l = strtolower($prop);
                if (isset($user[$u]) && $user[$u] !== '') return $user[$u];
                if (isset($user[$l]) && $user[$l] !== '') return $user[$l];
                if (isset($user[$prop]) && $user[$prop] !== '') return $user[$prop];
            }
            return '';
        };

        $rawHeight = $get('HEIGHT') ?: $get('height');
        $rawWeight = $get('WEIGHT') ?: $get('weight');
        $rawDob    = $get('DOB') ?: $get('dob');
        $rawGender = $get('GENDER') ?: $get('gender');
        $rawBGroup = $get('BGROUP') ?: ($get('blood_group') ?: $get('bgroup'));

        $height_cm = parse_clinical_height($rawHeight);
        $weight_kg = parse_clinical_weight($rawWeight);

        if ($height_cm <= 0 || $weight_kg <= 0) {
            return null;
        }

        $age = calculate_patient_age($rawDob);
        $dobFormatted = '';
        if (!empty($rawDob)) {
            try {
                $dobFormatted = (new DateTime($rawDob))->format('M d, Y');
            } catch (\Throwable $e) {}
        }

        $genClean = strtoupper(trim((string)$rawGender));
        $isFemale = in_array($genClean, ['F', 'FEMALE', 'WOMAN', 'GIRL']);
        $genderLabel = $isFemale ? 'Female' : ($genClean === 'O' || $genClean === 'OTHER' ? 'Other' : 'Male');
        $pronounSubj = $isFemale ? 'she' : 'he';
        $pronounPoss = $isFemale ? 'her' : 'his';

        // BMI Calculation
        $bmiData   = calculate_bmi($height_cm, $weight_kg);
        $bmi       = $bmiData['bmi'];
        $bmiStatus = $bmiData['status'];
        $bmiColor  = $bmiData['color'];
        $bmiBadge  = $bmiData['badge'];

        // BMR Calculation (Mifflin-St Jeor)
        $bmr = calculate_bmr_mifflin($height_cm, $weight_kg, $age, $genderLabel);

        // Healthy Weight Range & Targets (WHO BMI 18.5 – 24.9)
        $height_m = $height_cm / 100.0;
        $h_sq = $height_m * $height_m;
        $target_min_weight   = round(18.5 * $h_sq, 1);
        $target_ideal_weight = round(21.0 * $h_sq, 1);
        $target_max_weight   = round(24.9 * $h_sq, 1);

        // Total Daily Energy Expenditure (Sedentary Multiplier: 1.2)
        $maintenance_cal = (int)round($bmr * 1.2);

        if ($bmi < 18.5) {
            $goal_action = 'gain';
            $min_gain = max(0.5, round($target_min_weight - $weight_kg, 1));
            $ideal_gain = max(1.0, round($target_ideal_weight - $weight_kg, 1));
            $min_loss = 0.0;
            $ideal_loss = 0.0;
            $target_cal = $maintenance_cal + 400;
            $summary_text = "Your Basal Metabolic Rate (BMR) is " . number_format($bmr) . " kcal/day, meaning your body burns approximately " . number_format($bmr) . " calories at rest. To reach a minimum healthy BMI of 18.5, aim to gain at least {$min_gain} kg (with an optimal target of {$ideal_gain} kg for a BMI of 21.0). We recommend a gentle daily calorie surplus of +300 to +500 kcal (targeting ~" . number_format($target_cal) . " kcal/day) focusing on nutrient-dense proteins and healthy fats.";
            $caloric_rec = "+300 to +500 kcal/day surplus (Target: ~" . number_format($target_cal) . " kcal/day)";
        } elseif ($bmi > 24.9) {
            $goal_action = 'lose';
            $min_gain = 0.0;
            $ideal_gain = 0.0;
            $min_loss = max(0.5, round($weight_kg - $target_max_weight, 1));
            $ideal_loss = max(1.0, round($weight_kg - $target_ideal_weight, 1));
            $safe_floor = $isFemale ? 1200 : 1500;
            $target_cal = max($safe_floor, $maintenance_cal - 450);
            $summary_text = "Your Basal Metabolic Rate (BMR) is " . number_format($bmr) . " kcal/day, representing your baseline resting expenditure. To achieve a healthy BMI of 24.9, your initial goal is to lose {$min_loss} kg (with an ideal target of {$ideal_loss} kg for optimal wellness). We recommend a moderate daily calorie deficit of 300 to 500 kcal (targeting ~" . number_format($target_cal) . " kcal/day) paired with regular low-impact physical activity.";
            $caloric_rec = "-300 to -500 kcal/day deficit (Target: ~" . number_format($target_cal) . " kcal/day)";
        } else {
            $goal_action = 'maintain';
            $min_gain = 0.0;
            $ideal_gain = 0.0;
            $min_loss = 0.0;
            $ideal_loss = 0.0;
            $target_cal = $maintenance_cal;
            $summary_text = "Your Basal Metabolic Rate (BMR) is " . number_format($bmr) . " kcal/day, and your current BMI of {$bmi} is within the optimal healthy range. Continue your balanced nutrition and hydration to maintain your healthy weight. Aim for approximately " . number_format($maintenance_cal) . " kcal/day to sustain your daily energy needs.";
            $caloric_rec = "Maintain ~" . number_format($maintenance_cal) . " kcal/day for energy balance";
        }

        return [
            'age'                    => $age,
            'dob_formatted'          => $dobFormatted,
            'gender'                 => $genderLabel,
            'pronoun_subj'           => $pronounSubj,
            'pronoun_poss'           => $pronounPoss,
            'height_cm'              => $height_cm,
            'height_m'               => round($height_m, 2),
            'weight_kg'              => $weight_kg,
            'blood_group'            => $rawBGroup ?: 'Not specified',
            'bmi'                    => $bmi,
            'bmi_status'             => $bmiStatus,
            'bmi_color'              => $bmiColor,
            'bmi_badge'              => $bmiBadge,
            'bmr'                    => $bmr,
            'maintenance_calories'   => $maintenance_cal,
            'target_min_weight'      => $target_min_weight,
            'target_ideal_weight'    => $target_ideal_weight,
            'target_max_weight'      => $target_max_weight,
            'goal_action'            => $goal_action,
            'min_gain'               => $min_gain,
            'ideal_gain'             => $ideal_gain,
            'min_loss'               => $min_loss,
            'ideal_loss'             => $ideal_loss,
            'summary_text'           => $summary_text,
            'caloric_recommendation' => $caloric_rec
        ];
    }
}
