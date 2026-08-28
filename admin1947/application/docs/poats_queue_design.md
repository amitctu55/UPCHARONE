# Advanced POATS Live Queue Algorithms Design Document
UPCHAR Healthcare Platform

## 1. Module Overview

### 1.1 Purpose
Design and implement an advanced Point of Attendance Tracking System (POATS) with live queue algorithms to optimize patient flow, reduce wait times, and improve resource utilization across all healthcare service points (doctors, hospitals, pathology labs, and medical stores) in the UPCHAR platform.

### 1.2 Scope
This module will cover:
- Real-time patient queue management for all service points
- Dynamic wait time estimation and prediction algorithms
- Intelligent resource allocation and scheduling
- Patient flow optimization using machine learning techniques
- Integration with appointment booking and EMR systems
- Multi-channel patient notifications (SMS, app push, display boards)
- Analytics and reporting on queue performance
- Admin dashboard for queue monitoring and management

### 1.3 Objectives
1. Reduce average patient wait times by 40% through intelligent queuing
2. Increase resource utilization efficiency by 30%
3. Provide real-time queue visibility to patients and staff
4. Implement predictive algorithms for wait time forecasting
5. Enable dynamic re-prioritization based on urgency and appointment type
6. Seamless integration with existing UPCHAR modules
7. Support for both walk-in and appointment-based patient flows

## 2. Technical Architecture

### 2.1 System Components
```
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   Frontend      │    │   POATS Engine   │    │   External Systems │
│ (Web/Mobile App)│    │ (Core Algorithms)│    │ (Payment, EMR, etc)│
└─────────┬───────┘    └─────────┬────────┘    └─────────┬──────────┘
          │                      │                       │
          │ REST/WebSocket API   │       HL7/FHIR        │
          ▼                      ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   API Gateway   │◄──►│  Queue Manager   │◄──►│  Appointment DB    │
│ (Rate Limiting) │    │  (Core Logic)    │    │  & EMR System      │
└─────────┬───────┘    └─────────┬────────┘    └─────────┬──────────┘
          │                      │                       │
          │ Database             │                       │
          ▼                      ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   Queue Tables  │    │  ML Prediction   │    │  Notification      │
│   (MySQL)       │    │  Service         │    │  Service (SMS/App) │
└─────────────────┘    └──────────────────┘    └────────────────────┘
                            │
                            ▼
                    ┌──────────────────┐
                    │  Admin Dashboard │
                    │  (React/Vue)     │
                    └──────────────────┘
```

### 2.2 Module Structure
```
admin1947/
└── application/
    ├── modules/
    │   └── poats/                    ← NEW MODULE
    │       ├── controllers/
    │       │   ├── Poats.php         ← Main POATS controller
    │       │   ├── Api.php           ← API endpoints
    │       │   ├── Admin.php         ← Admin dashboard controller
    │       │   └── Websocket.php     ← WebSocket handling
    │       ├── models/
    │       │   ├── Poats_model.php
    │       │   ├── Queue_model.php
    │       │   ├── Prediction_model.php
    │       │   └── Analytics_model.php
    │       ├── libraries/
    │       │   ├── Queue_algorithms.php   ← Core queuing algorithms
    │       │   ├── Prediction_engine.php  ← ML wait time prediction
    │       │   ├── Notification_manager.php
    │       │   └── Resource_optimizer.php
    │       ├── views/
    │       │   ├── patient_queue.php     ← Patient-facing queue view
    │       │   ├── staff_dashboard.php   ← Staff queue management
    │       │   ├── admin_analytics.php   ← Admin analytics dashboard
    │       │   └── display_board.php     ← Public display board view
    │       └── config/
    │           └── poats.php           ← POATS configuration
    ├── third_party/
    │   └── ml_libraries/             ← ML libraries for prediction (TensorFlow Lite, etc.)
    └── logs/
        └── poats/                    ← POATS-specific logs
```

### 2.3 Dependencies
- PHP 7.4+
- CodeIgniter 3.x
- MySQL 5.7+
- Ratchet or Workerman for WebSocket support
- Python/ML libraries for prediction models (optional, can be microservice)
- Redis for caching and real-time data sharing
- Chart.js or D3.js for visualizations

## 3. Database Schema

### 3.1 Core Tables

#### poats_service_points - Defines service points where queues exist
```sql
CREATE TABLE `poats_service_points` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL COMMENT 'e.g., Cardiology OPD, Lab Collection',
  `service_type` ENUM('doctor', 'hospital_opd', 'pathlab', 'medical_store', 'telemedicine') NOT NULL,
  `location_id` INT NULL COMMENT 'Reference to hospital/clinic location',
  `provider_id` INT NULL COMMENT 'Reference to doctor/staff when applicable',
  `capacity` INT DEFAULT 1 COMMENT 'Number of parallel service channels',
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_service_type` (`service_type`),
  INDEX `idx_location_provider` (`location_id`, `provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### poats_queue_entries - Tracks individual queue entries
```sql
CREATE TABLE `poats_queue_entries` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `service_point_id` INT NOT NULL,
  `patient_id` INT NOT NULL COMMENT 'References userlogin.id',
  `appointment_id` INT NULL COMMENT 'Reference to appointment if applicable',
  `queue_number` VARCHAR(20) NOT NULL COMMENT 'Display queue number (e.g., A101)',
  `priority_level` TINYINT DEFAULT 0 COMMENT '0=normal, 1=urgent, 2=emergency',
  `status` ENUM('waiting', 'called', 'in_service', 'completed', 'no_show', 'cancelled') DEFAULT 'waiting',
  `join_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `called_timestamp` TIMESTAMP NULL DEFAULT NULL,
  `start_service_timestamp` TIMESTAMP NULL DEFAULT NULL,
  `end_service_timestamp` TIMESTAMP NULL DEFAULT NULL,
  `estimated_wait_time` INT NULL COMMENT 'In minutes, calculated at join time',
  `actual_wait_time` INT NULL COMMENT 'In minutes, calculated on completion',
  `service_duration` INT NULL COMMENT 'In minutes, actual time spent in service',
  `notes` TEXT NULL COMMENT 'Any special notes or requirements',
  `token` VARCHAR(100) NULL COMMENT 'Unique token for patient lookup',
  INDEX `idx_service_point_status` (`service_point_id`, `status`),
  INDEX `idx_patient_id` (`patient_id`),
  INDEX `idx_join_timestamp` (`join_timestamp`),
  INDEX `idx_token` (`token`),
  INDEX `idx_queue_number` (`queue_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### poats_wait_time_predictions - Stores ML model predictions
```sql
CREATE TABLE `poats_wait_time_predictions` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `service_point_id` INT NOT NULL,
  `prediction_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `predicted_wait_5min` INT NULL COMMENT 'Predicted wait time in 5 minutes',
  `predicted_wait_15min` INT NULL COMMENT 'Predicted wait time in 15 minutes',
  `predicted_wait_30min` INT NULL COMMENT 'Predicted wait time in 30 minutes',
  `confidence_score` DECIMAL(3,2) NULL COMMENT 'Prediction confidence (0.00-1.00)',
  `model_version` VARCHAR(20) NULL COMMent 'Version of ML model used',
  `features_used` TEXT NULL COMMENT 'JSON of features used for prediction',
  INDEX `idx_service_point_time` (`service_point_id`, `prediction_timestamp`),
  INDEX `idx_timestamp` (`prediction_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### poats_service_metrics - Tracks service performance metrics
```sql
CREATE TABLE `poats_service_metrics` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `service_point_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `hour` TINYINT NOT NULL COMMENT '0-23',
  `total_patients` INT DEFAULT 0,
  `avg_wait_time` DECIMAL(5,2) NULL COMMENT 'Average wait time in minutes',
  `max_wait_time` INT NULL COMMENT 'Maximum wait time in minutes',
  `service_efficiency` DECIMAL(5,2) NULL COMMENT 'Percentage of time spent in service',
  `no_show_rate` DECIMAL(5,2) NULL COMMENT 'Percentage of no-shows',
  `patient_satisfaction` DECIMAL(3,2) NULL COMMENT 'Average satisfaction score (if collected)',
  `peak_hour_factor` DECIMAL(3,2) NULL COMMENT 'Relative busyness compared to average',
  INDEX `idx_service_point_date` (`service_point_id`, `date`),
  INDEX `idx_date_hour` (`date`, `hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### poats_notification_log - Tracks patient notifications
```sql
CREATE TABLE `poats_notification_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `queue_entry_id` BIGINT NOT NULL,
  `notification_type` ENUM('sms', 'push', 'display', 'email') NOT NULL,
  `trigger_event` ENUM('queue_join', 'called', 'delay', 'service_complete') NOT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `content` TEXT NULL COMMENT 'Actual notification content sent',
  `status` ENUM('sent', 'failed', 'pending') DEFAULT 'sent',
  `provider_response` TEXT NULL COMMENT 'Response from SMS/gateway provider',
  INDEX `idx_queue_entry` (`queue_entry_id`),
  INDEX `idx_timestamp` (`timestamp`),
  INDEX `idx_type_event` (`notification_type`, `trigger_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.2 Modified Existing Tables (Optional Enhancements)

#### Add queue-related fields to appointment table (if desired)
```sql
ALTER TABLE `appointment` 
ADD COLUMN `poats_queue_id` BIGINT NULL AFTER `id`,
ADD COLUMN `queue_join_time` TIMESTAMP NULL AFTER `poats_queue_id`,
ADD COLUMN `expected_service_time` TIMESTAMP NULL AFTER `queue_join_time`;
```

## 4. Core Algorithms

### 4.1 Queue Management Algorithms

#### 4.1.1 Fair Queuing with Priority Levels
- **FCFS Priority Queue**: First-Come-First-Served within each priority level
- **Priority Levels**: 
  - Level 0: Normal appointments/walk-ins
  - Level 1: Urgent cases (referred, follow-ups)
  - Level 2: Emergency/walk-in emergencies
- **Algorithm**: 
  ```
  When adding to queue:
  1. Assign priority based on appointment type/referral/emergency flag
  2. Insert at end of respective priority queue
  3. Assign queue number based on service point and prefix
  
  When calling next patient:
  1. Check Level 2 queue - if not empty, call from front
  2. Else check Level 1 queue - if not empty, call from front
  3. Else check Level 0 queue - if not empty, call from front
  ```

#### 4.1.2 Dynamic Queue Number Generation
- Format: `{ServicePrefix}{SequenceNumber}`
- Examples: 
  - Cardiology: C001, C002, ...
  - Lab: L001, L002, ...
  - Pharmacy: P001, P002, ...
- Reset daily or based on configuration
- Handle overflow gracefully (e.g., C001A, C001B after 999)

#### 4.1.3 No-Show Prediction and Mitigation
- **Features Used**:
  - Historical no-show rate for patient
  - Time of day/day of week
  - Appointment lead time
  - Weather conditions (if available)
  - Distance from facility
  - Previous appointment compliance
- **Model**: Logistic regression or lightweight decision tree
- **Action**: Overbook strategically or send reminder when no-show probability > threshold

### 4.2 Wait Time Prediction Algorithms

#### 4.2.1 Real-Time Wait Time Estimation (RTWTE)
- **Basic Formula**:
  ```
  Estimated Wait Time = (Number of Patients Ahead × Average Service Time) 
                       + Variance Factor
  ```
- **Enhanced with**:
  - Service point-specific service time distributions
  - Time-of-day adjustments
  - Provider-specific efficiency factors
  - Recent actual service times (exponential moving average)

#### 4.2.2 Machine Learning Prediction Models
- **Input Features**:
  - Current queue length
  - Historical service times (last 1hr, 4hr, 24hr)
  - Time of day, day of week
  - Provider identity and historical performance
  - Appointment types mix in queue
  - Seasonal factors
  - Weather (if available)
  - Special events/holidays
- **Models**:
  - Short-term (5-15 min): LightGBM or XGBoost for interpretability
  - Long-term (30-60 min): LSTM or Temporal Convolutional Network
  - Fallback: Moving averages with exponential weighting
- **Update Frequency**: Every 30 seconds to 5 minutes based on activity level

#### 4.2.3 Confidence Scoring
- Calculate prediction intervals using quantile regression or ensemble variance
- Provide confidence levels: High (>80%), Medium (50-80%), Low (<50%)
- Display appropriate UI indicators based on confidence

### 4.3 Resource Optimization Algorithms

#### 4.3.1 Provider Load Balancing
- Distribute patients across multiple providers at same service point
- Consider:
  - Provider specialization match
  - Current workload
  - Historical speed/quality metrics
  - Patient preferences (if recorded)
- Algorithm: Weighted round-robin with dynamic weights

#### 4.3.2 Appointment Slot Optimization
- Suggest optimal appointment times based on:
  - Predicted queue lengths
  - Provider availability
  - Patient preferences
  - Historical no-show patterns
- Use constraint satisfaction or greedy algorithms

#### 4.3.3 Dynamic Capacity Adjustment
- Temporarily increase/decrease effective capacity based on:
  - Real-time demand
  - Staff availability
  - Emergency situations
- Examples:
  - Open additional consultation rooms during peak hours
  - Reassign staff from less busy to busier service points
  - Activate telemedicine overflow for follow-ups

## 5. API Endpoints

### 5.1 Patient-Facing APIs

#### Join Queue
```
POST /api/poats/queue/join
Body: {
  "service_point_id": 123,
  "patient_id": 456,
  "appointment_id": 789 (optional),
  "priority_level": 0 (optional, default 0),
  "notes": "Patient requires wheelchair access"
}
Response: {
  "success": true,
  "data": {
    "queue_entry_id": 1001,
    "queue_number": "C042",
    "estimated_wait_time": 15,
    "token": "abc123xyz",
    "position_in_queue": 3
  }
}
```

#### Get Queue Status
```
GET /api/poats/queue/status/{token}
Response: {
  "success": true,
  "data": {
    "queue_entry_id": 1001,
    "current_position": 2,
    "estimated_wait_time": 8,
    "service_point_name": "Cardiology OPD",
    "expected_call_time": "2026-08-25 14:30:00",
    "status": "waiting",
    "queue_ahead": [
      {"queue_number": "C040", "estimated_service_time": 5},
      {"queue_number": "C041", "estimated_service_time": 7}
    ]
  }
}
```

#### Leave Queue (Cancel)
```
POST /api/poats/queue/leave
Body: {
  "queue_entry_id": 1001,
  "reason": "Patient decided to reschedule"
}
Response: {
  "success": true,
  "message": "Queue entry cancelled"
}
```

### 5.2 Staff/Facing APIs

#### Call Next Patient
```
POST /api/poats/queue/call-next
Body: {
  "service_point_id": 123,
  "provider_id": 456 (optional, if not using logged-in provider)
}
Response: {
  "success": true,
  "data": {
    "queue_entry_id": 1002,
    "patient_name": "John Doe",
    "queue_number": "C040",
    "wait_time": 12,
    "notes": "Diabetic follow-up"
  }
}
```

#### Mark Patient as In Service
```
POST /api/poats/queue/start-service
Body: {
  "queue_entry_id": 1002
}
Response: {
  "success": true
}
```

#### Mark Service as Complete
```
POST /api/poats/queue/complete-service
Body: {
  "queue_entry_id": 1002,
  "service_duration": 15,
  "satisfaction_rating": 4 (optional, 1-5 scale)
}
Response: {
  "success": true
}
```

#### Get Staff Dashboard Data
```
GET /api/poats/staff/dashboard/{service_point_id}
Response: {
  "success": true,
  "data": {
    "service_point": {
      "id": 123,
      "name": "Cardiology OPD",
      "current_load": 3,
      "capacity": 2
    },
    "queue": {
      "waiting": 5,
      "in_service": 2,
      "avg_wait_time": 14,
      "predicted_wait_15min": 18
    },
    "next_up": [
      {"queue_number": "C040", "patient_name": "John Doe", "wait_time": 12},
      {"queue_number": "C041", "patient_name": "Jane Smith", "wait_time": 18}
    ],
    "recent_completions": 12,
    "todays_stats": {
      "total_patients": 45,
      "avg_wait_time": 16,
      "max_wait_time": 45,
      "no_show_rate": 0.08
    }
  }
}
```

### 5.3 Admin APIs

#### Get Queue Analytics
```
GET /api/poats/admin/analytics?service_point_id=123&date_range=7d
Response: {
  "success": true,
  "data": {
    "wait_time_trends": [
      {"date": "2026-08-19", "avg_wait": 12},
      {"date": "2026-08-20", "avg_wait": 15},
      {"date": "2026-08-21", "avg_wait": 14}
    ],
    "peak_hours": [
      {"hour": 10, "avg_patients": 8.2},
      {"hour": 14, "avg_patients": 9.1},
      {"hour": 16, "avg_patients": 7.5}
    ],
    "provider_performance": [
      {"provider_id": 456, "name": "Dr. Smith", "avg_service_time": 12, "patients_seen": 22},
      {"provider_id": 457, "name": "Dr. Jones", "avg_service_time": 15, "patients_seen": 18}
    ],
    "efficiency_metrics": {
      "resource_utilization": 0.78,
      "patient_satisfaction": 4.2,
      "queue_length_variance": 0.34
    }
  }
}
```

#### Configure Service Point
```
PUT /api/poats/admin/service-point/{id}
Body: {
  "name": "Cardiology OPD",
  "service_type": "doctor",
  "capacity": 3,
  "is_active": true,
  "queue_prefix": "C",
  "reset_queue_daily": true,
  "priority_rules": {
    "emergency": 2,
    "referred": 1,
    "followup": 0,
    "new_patient": 0
  }
}
Response: {
  "success": true
}
```

### 5.4 WebSocket Events (Real-Time Updates)

#### Server → Client Events
- `queue-status-update`: When patient's position or wait time changes
- `queue-called`: When patient is called for service
- `queue-delay-alert`: When unexpected delays occur
- `service-point-status`: Overall service point status changes
- `announcement`: General announcements (e.g., "Lunch break in 10 minutes")

#### Client → Server Events
- `join-queue-request`: Patient requesting to join queue
- `leave-queue-request`: Patient cancelling queue entry
- `get-current-status`: Patient requesting current status
- `acknowledge-called`: Patient acknowledging they've been called

## 6. Integration Points

### 6.1 Appointment Booking System
- When appointment is booked, optionally pre-join queue with future timestamp
- Validate appointment against provider schedule in POATS
- Update appointment with actual service start/end times from POATS
- Handle no-shows: Mark as no-show in both systems

### 6.2 Electronic Medical Records (EMR)
- When service starts, optionally pull relevant patient history
- After service completion, push visit summary to EMR
- Link queue entry ID to EMR encounter ID for traceability

### 6.3 Payment System
- For services requiring payment before visit:
  - Hold queue position until payment confirmed
  - Automatically advance queue after payment timeout
- For post-visit billing:
  - Trigger invoice generation upon service completion
  - Link payment to queue entry for reporting

### 6.4 Notification Systems
- SMS: Send wait time updates, call notifications
- App Push: Real-time queue position updates with deep linking
- Display Boards: Show current queue status in waiting areas
- Email: Send visit summaries and satisfaction surveys post-visit

### 6.5 Telemedicine Integration
- Virtual service points with same queuing logic
- Automatic conversion to telemedicine when appropriate (e.g., follow-ups)
- Separate queue numbers but unified dashboard for staff

## 7. Security Considerations

### 7.1 Data Protection
- Queue entry tokens are random, unguessable strings (UUIDv4 recommended)
- Patient data in queue entries limited to minimum necessary
- Historical data anonymized for analytics and ML training
- Secure transmission via HTTPS/WSS for all API and WebSocket connections

### 7.2 Access Control
- Patients can only access their own queue entries via token
- Staff can only access service points they're assigned to
- Admin functions require appropriate role permissions
- API rate limiting to prevent abuse
- Input validation and sanitization on all endpoints

### 7.3 Audit & Compliance
- Comprehensive audit logging of all queue operations
- Immutable audit trail for regulatory compliance
- Regular security scanning and penetration testing
- HIPAA/GDPR compliance for patient data handling
- Consent management for data usage in ML models

## 8. Implementation Approach

### 8.1 Phase 1: Core Queue Management
1. Create POATS database schema
2. Implement basic queue entry management (join, leave, call, complete)
3. Develop simple FCFS queuing with priority levels
4. Build basic staff and patient views
5. Implement WebSocket real-time updates
6. Create basic admin dashboard

### 8.2 Phase 2: Wait Time Estimation
1. Implement basic wait time estimation (queue length × avg service time)
2. Add historical service time tracking
3. Implement exponential moving average for service times
4. Add time-of-day adjustments
5. Create wait time display in patient and staff views
6. Implement basic prediction logging

### 8.3 Phase 3: Machine Learning Enhancements
1. Set up ML pipeline for wait time prediction
2. Feature engineering for queue and service data
3. Train initial models on historical data
4. Implement model serving (local or microservice)
5. Add confidence scoring to predictions
6. A/B test ML predictions vs simple estimates

### 8.4 Phase 4: Resource Optimization & Advanced Features
1. Implement provider load balancing algorithm
2. Add appointment slot optimization suggestions
3. Implement dynamic capacity adjustment logic
4. Add no-show prediction and mitigation strategies
5. Enhance analytics dashboard with predictive insights
6. Implement multi-channel notification system

### 8.5 Phase 5: Integration & Polishing
1. Deep integration with appointment booking system
2. EMR integration for patient history and visit notes
3. Payment system integration for pre/post visit payments
4. Telemedicine integration as virtual service points
5. Performance optimization and load testing
6. User acceptance testing and feedback incorporation
7. Documentation and training materials

## 8. Configuration

### 8.1 POATS Configuration File (`admin1947/application/config/poats.php`)
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['poats'] = [
    // General Settings
    'version' => '1.0.0',
    'environment' => 'development', // development, staging, production
    
    // Queue Behavior
    'default_queue_capacity' => 2,
    'queue_reset_frequency' => 'daily', // daily, weekly, never
    'queue_number_padding' => 3, // C001, C002, etc.
    'enable_priority_queuing' => true,
    'priority_levels' => [
        'emergency' => 2,
        'referred' => 1,
        'followup' => 0,
        'new_patient' => 0,
        'walkin' => 0
    ],
    
    // Wait Time Estimation
    'enable_ml_predictions' => true,
    'ml_model_update_interval' => 3600, // seconds
    'min_predictions_for_confidence' => 50,
    'base_service_time_default' => 15, // minutes
    
    // Notification Settings
    'sms_notifications_enabled' => true,
    'push_notifications_enabled' => true,
    'display_board_enabled' => true,
    'notification_templates' => [
        'queue_join' => 'Your queue number is {queue_number}. Estimated wait: {wait_time} mins.',
        'queue_called' => 'Please proceed to {service_point} for your appointment.',
        'queue_delay' => 'Delay expected: {additional_time} mins due to {reason}.',
        'service_complete' => 'Thank you for visiting. Your visit summary is available in your account.'
    ],
    
    // Performance Thresholds
    'max_wait_time_alert' => 60, // minutes
    'queue_length_warning' => 10, // patients
    'staff_utilization_target' => 0.8, // 80%
    
    // Integration Settings
    'appointment_integration_enabled' => true,
    'emr_integration_enabled' => false, // Phase 2
    'payment_integration_enabled' => true,
    'telemedicine_enabled' => true,
    
    // Analytics & Reporting
    'analytics_retention_days' => 365,
    'export_formats' => ['csv', 'excel', 'pdf'],
    'scheduled_reports' => [
        'daily_summary' => ['time' => '08:00', 'recipients' => ['admin@upchar.com']],
        'weekly_trends' => ['time' => '09:00 Monday', 'recipients' => ['management@upchar.com']]
    ]
];
```

## 9. Testing Strategy

### 9.1 Unit Testing
- Test queue entry lifecycle (join → call → service → complete)
- Test priority queuing logic under various scenarios
- Test wait time estimation algorithms with known inputs
- Test token generation and validation
- Test notification triggering logic

### 9.2 Integration Testing
- Test end-to-end patient flow: join queue → get updates → be called → complete service
- Test staff workflow: view dashboard → call patient → start/complete service
- Test admin functions: configure service points → view analytics → adjust settings
- Test WebSocket real-time updates under load
- Test integration with appointment booking (create appointment → join queue)

### 9.3 Performance Testing
- Load test with 1000+ concurrent queue entries
- Measure API response times under load (<200ms target)
- Test WebSocket connection handling (1000+ concurrent clients)
- Database query optimization for queue listing and searching
- Memory usage analysis for long-running processes

### 9.4 User Acceptance Testing
- Simulate real clinic scenarios with test patients and staff
- Validate accuracy of wait time predictions
- Test usability of patient and staff interfaces
- Verify notification delivery and timing
- Collect feedback for UI/UX improvements

### 9.5 Edge Case Testing
- Handle system downtime and recovery
- Test behavior when service point capacity exceeds limits
- Test with zero patients in queue
- Test with all priority levels active simultaneously
- Test token collision handling (though UUID makes this extremely unlikely)
- Test daylight saving time and timezone handling
- Test behavior during holidays and special events

## 10. Deployment & Monitoring

### 10.1 Deployment Strategy
- Blue-green deployment for zero downtime
- Database migrations backward compatible where possible
- Feature flags for gradual rollout of new algorithms
- Rollback procedures for each component
- Database backup before schema changes

### 10.2 Monitoring & Alerting
- **Key Metrics**:
  - Average wait time by service point
  - Queue length trends
  - Resource utilization percentages
  - API response times and error rates
  - WebSocket connection counts and message throughput
  - Prediction accuracy (when actual wait time available)
  
- **Alerting Thresholds**:
  - Average wait time > 2x baseline for 15+ minutes
  - Queue length > 90% of capacity for 10+ minutes
  - API error rate > 5% for 5+ minutes
  - WebSocket disconnected clients > 10%
  - Prediction confidence consistently low (<30%) for extended period
  
- **Health Checks**:
  - Database connectivity and query performance
  - API endpoint responsiveness
  - WebSocket server availability
  - ML model serving availability (if applicable)
  - Notification service (SMS/gateway) connectivity

### 10.3 Logging Strategy
- **Application Logs**: Structured JSON logging for POATS operations
- **Access Logs**: API and WebSocket access patterns
- **Error Logs**: Exceptions and validation errors
- **Audit Logs**: All queue state changes for compliance
- **Performance Logs**: Timing metrics for bottleneck identification
- **ML Logs**: Prediction inputs, outputs, and model performance metrics

## 11. Future Enhancements

### 11.1 Short-Term (Phase 4-5)
- Patient-facing mobile app with AR wayfinding to service points
- Voice announcements in waiting areas for called patients
- Integration with wearable devices for patient vitals tracking
- AI-powered dynamic re-prioritization based on urgent symptoms
- Multilingual support for queue displays and notifications

### 11.2 Medium-Term (Phase 5+)
- Predictive staff scheduling based on forecasted demand
- Integration with hospital bed management for inpatient flow
- Supply chain integration for pharmacy and lab consumables
- Patient flow simulation for facility planning and design
- Integration with public health systems for outbreak detection

### 11.3 Long-Term (Research)
- Reinforcement learning for continuous queue optimization
- Federated learning across multiple healthcare facilities
- Integration with smart hospital IoT systems (beds, equipment)
- Patient journey analytics across multiple touchpoints
- Predictive no-show intervention with personalized incentives

## 12. Compliance & Standards

### 12.1 Healthcare Standards
- HL7 v2.x/FHIR for clinical data exchange where applicable
- DICOM for imaging workflow integration (future)
- LOINC for laboratory test ordering and results
- SNOMED CT for clinical terminology (where integrated with EMR)
- ICD-11 for diagnosis coding (when linked to EMR)

### 12.2 Data Standards
- ISO 20022 for financial transactions (payments)
- ISO 8601 for date/time representations
- RFC 4122 for UUID generation (queue tokens)
- WCAG 2.1 AA for web accessibility
- GDPR/PDPA for data protection and privacy

### 12.3 Quality Standards
- ISO 13485 for medical device software (where applicable)
- ISO 27001 for information security management
- ISO 9001 for quality management systems
- IEEE 802.11 for wireless connectivity (if using local displays)
- IEEE 11073 for personal health device communication

---
*Document Version: 1.0*
*Last Updated: 2026-08-25*
*Next Review Date: 2026-09-25*