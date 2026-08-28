# ABDM/ABHA Integration Design Document
UPCHAR Healthcare Platform

## 1. Module Overview

### 1.1 Purpose
Integrate the UPCHAR platform with the Ayushman Bharat Digital Mission (ABDM) ecosystem to enable:
- Creation and linking of ABHA (Ayushman Bharat Health Account) IDs for users
- Registration of healthcare professionals in the Healthcare Professionals Registry (HPR)
- Registration of healthcare facilities in the Health Facility Registry (HFR)
- Consent-based exchange of health records through the Health Information Exchange (HIE)
- Compliance with ABDM specifications and standards

### 1.2 Scope
This integration will cover:
- ABHA ID generation and linking for patients/users
- Healthcare Professional Registration (HPR) for doctors
- Health Facility Registration (HFR) for hospitals, clinics, labs, and pharmacies
- Consent management framework for health data exchange
- Basic interoperability with ABDM gateways
- Audit logging and compliance reporting

### 1.3 Objectives
1. Enable users to create/link ABHA IDs through UPCHAR
2. Allow healthcare providers to register in HPR/HFR via UPCHAR
3. Facilitate consent-based sharing of medical records
4. Ensure compliance with ABDM technical specifications
5. Provide admin dashboard for monitoring ABDM integration status
6. Maintain backward compatibility with existing UPCHAR functionality

## 2. Technical Architecture

### 2.1 System Components
```
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   UPCHAR App    │    │  ABDM Gateway    │    │  ABDM Sandbox      │
│ (PHP/CodeIgniter)│    │ (API Endpoint)   │    │  (For Testing)     │
└─────────┬───────┘    └─────────┬────────┘    └─────────┬──────────┘
          │                      │                       │
          │ HTTPS API Calls      │                       │
          ▼                      ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│ ABDM Service    │◄──►│  Consent Manager │◄──►│  Health Information│
│ Layer           │    │  & Trust Framework│    │  Exchange (HIE)    │
└─────────┬───────┘    └─────────┬────────┘    └─────────┬──────────┘
          │                      │                       │
          │ Database             │                       │
          ▼                      ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   ABDM Tables   │    │  Audit Logs      │    │  External Systems  │
│ (MySQL)         │    │                  │    │  (HPR, HFR, etc.)  │
└─────────────────┘    └──────────────────┘    └────────────────────┘
```

### 2.2 Module Structure
```
admin1947/
└── application/
    ├── modules/
    │   └── abdm/                    ← NEW MODULE
    │       ├── controllers/
    │       │   ├── Abdm.php         ← Main ABDM controller
    │       │   ├── Consent.php      ← Consent management
    │       │   ├── Hpr.php          ← Healthcare Professionals Registry
    │       │   ├── Hfr.php          ← Health Facility Registry
    │       │   └── Sandbox.php      ← ABDM sandbox interaction
    │       ├── models/
    │       │   ├── Abdm_model.php
    │       │   ├── Consent_model.php
    │       │   ├── Hpr_model.php
    │       │   └── Hfr_model.php
    │       ├── views/
    │       │   ├── abdm_dashboard.php
    │       │   ├── consent_management.php
    │       │   ├── hpr_registration.php
    │       │   └── hfr_registration.php
    │       └── config/
    │           └── abdm.php         ← ABDM configuration
    ├── libraries/
    │   └── Abdm_api.php             ← ABDM API client library
    └── third_party/
        └── abdm_sdk/                ← ABDM SDK (if available)
```

### 2.3 Dependencies
- PHP 7.4+
- CodeIgniter 3.x
- MySQL 5.7+
- cURL extension for HTTP requests
- JSON extension
- Optional: ABDM SDK (if provided by NHA)

## 3. Database Schema

### 3.1 New Tables

#### abdm_users - Links UPCHAR users to ABHA IDs
```sql
CREATE TABLE `abdm_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL COMMENT 'References userlogin.id',
  `abha_address` VARCHAR(100) NOT NULL UNIQUE COMMENT 'ABHA address (like xyz@abdm)',
  `abha_number` VARCHAR(14) UNIQUE COMMENT '14-digit ABHA number',
  `status` ENUM('pending', 'active', 'verified', 'revoked') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verified_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_abha_address` (`abha_address`),
  INDEX `idx_abha_number` (`abha_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### abdm_consent - Manages consent for health data exchange
```sql
CREATE TABLE `abdm_consent` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL COMMENT 'Patient giving consent',
  `abha_address` VARCHAR(100) NOT NULL,
  `care_context` VARCHAR(100) NOT NULL COMMENT 'e.g., OPD, IP, specific treatment',
  `purpose` VARCHAR(50) NOT NULL COMMENT 'Treatment, insurance claim, etc.',
  `data_types` TEXT NOT NULL COMMENT 'JSON array of data types being shared',
  `health_facility_ids` TEXT COMMENT 'JSON array of HFR IDs of facilities',
  `health_professional_ids` TEXT COMMENT 'JSON array of HPR IDs of professionals',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `status` ENUM('active', 'expired', 'revoked') DEFAULT 'active',
  `consent_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `consent_artifact` TEXT COMMENT 'Reference to consent artifact/document',
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_abha_address` (`abha_address`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### abdm_hpr_registrations - Tracks HPR registrations for doctors
```sql
CREATE TABLE `abdm_hpr_registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `doctor_id` INT NOT NULL COMMENT 'References profile_dr.id or userlogin.id for doctors',
  `hpr_id` VARCHAR(50) UNIQUE COMMENT 'HPR ID issued by ABDM',
  `registration_number` VARCHAR(100) COMMENT 'Medical council registration number',
  `state medical council` VARCHAR(100),
  `qualifications` TEXT COMMENT 'JSON array of qualifications',
  `specializations` TEXT COMMENT 'JSON array of specializations',
  `status` ENUM('pending', 'submitted', 'approved', 'rejected') DEFAULT 'pending',
  `submitted_at` TIMESTAMP NULL DEFAULT NULL,
  `approved_at` TIMESTAMP NULL DEFAULT NULL,
  `rejection_reason` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_doctor_id` (`doctor_id`),
  INDEX `idx_hpr_id` (`hpr_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### abdm_hfr_registrations - Tracks HFR registrations for facilities
```sql
CREATE TABLE `abdm_hfr_registrations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `facility_type` ENUM('hospital', 'clinic', 'pathlab', 'medical_store') NOT NULL,
  `facility_id` INT NOT NULL COMMENT 'References respective facility table',
  `hfr_id` VARCHAR(50) UNIQUE COMMENT 'HFR ID issued by ABDM',
  `name` VARCHAR(255) NOT NULL,
  `address` TEXT NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `pincode` VARCHAR(10) NOT NULL,
  `contact_person` VARCHAR(100),
  `contact_phone` VARCHAR(20),
  `contact_email` VARCHAR(100),
  `facility_details` TEXT COMMENT 'JSON with facility-specific details',
  `status` ENUM('pending', 'submitted', 'approved', 'rejected') DEFAULT 'pending',
  `submitted_at` TIMESTAMP NULL DEFAULT NULL,
  `approved_at` TIMESTAMP NULL DEFAULT NULL,
  `rejection_reason` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_facility_id` (`facility_id`, `facility_type`),
  INDEX `idx_hfr_id` (`hfr_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### abdm_audit_log - Audit trail for ABDM operations
```sql
CREATE TABLE `abdm_audit_log` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL COMMENT 'User performing action (if applicable)',
  `abha_address` VARCHAR(100) NULL,
  `operation_type` VARCHAR(50) NOT NULL COMMENT 'e.g., abha_create, hpr_register, consent_give',
  `entity_type` VARCHAR(50) NOT NULL COMMENT 'e.g., user, doctor, hospital, consent',
  `entity_id` INT NULL,
  `request_payload` TEXT COMMENT 'JSON of request sent to ABDM',
  `response_payload` TEXT COMMENT 'JSON of response from ABDM',
  `status_code` INT COMMENT 'HTTP status code from ABDM',
  `is_success` BOOLEAN DEFAULT FALSE,
  `error_message` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_abha_address` (`abha_address`),
  INDEX `idx_operation_type` (`operation_type`),
  INDEX `idx_created_at` (`created_at`),
  INDEX `idx_is_success` (`is_success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.2 Modified Existing Tables (Optional Enhancements)

#### Add ABDM-related fields to userlogin (if desired)
```sql
ALTER TABLE `userlogin` 
ADD COLUMN `abha_verified` TINYINT(1) DEFAULT 0 AFTER `status`,
ADD COLUMN `abha_linked_at` TIMESTAMP NULL AFTER `abha_verified`;
```

## 4. API Endpoints

### 4.1 Internal API (Used by UPCHAR modules)

#### ABHA Management
```
POST /admin1947/abdm/users/link-abha
Body: {
  "user_id": 123,
  "abha_address": "xyz@abdm" (optional, if not provided will generate)
}
Response: {
  "success": true,
  "data": {
    "abha_address": "xyz@abdm",
    "abha_number": "12345678901234",
    "status": "pending"
  }
}

GET /admin1947/abdm/users/:user_id/abha
Response: {
  "success": true,
  "data": {
    "abha_address": "xyz@abdm",
    "abha_number": "12345678901234",
    "status": "active"
  }
}

POST /admin1947/abdm/users/verify-abha
Body: {
  "abha_address": "xyz@abdm",
  "otp": "123456"
}
Response: {
  "success": true,
  "message": "ABHA verified successfully"
}
```

#### Consent Management
```
POST /admin1947/abdm/consent/give
Body: {
  "user_id": 123,
  "abha_address": "xyz@abdm",
  "care_context": "OPD Consultation",
  "purpose": "Treatment",
  "data_types": ["OPD Consultation", "Prescription", "Lab Reports"],
  "health_facility_ids": ["HFR12345", "HFR67890"],
  "health_professional_ids": ["HPR12345", "HPR67890"],
  "start_date": "2026-08-25",
  "end_date": "2027-08-25"
}
Response: {
  "success": true,
  "consent_id": 456,
  "consent_timestamp": "2026-08-25 10:30:00"
}

GET /admin1947/abdm/consent/:user_id/active
Response: {
  "success": true,
  "consents": [
    {
      "id": 456,
      "care_context": "OPD Consultation",
      "purpose": "Treatment",
      "data_types": ["OPD Consultation", "Prescription"],
      "start_date": "2026-08-25",
      "end_date": "2027-08-25",
      "status": "active"
    }
  ]
}

POST /admin1947/abdm/consent/:consent_id/revoke
Response: {
  "success": true,
  "message": "Consent revoked successfully"
}
```

#### HPR Registration (Doctors)
```
POST /admin1947/abdm/hpr/register
Body: {
  "doctor_id": 123,
  "registration_number": "MCI12345",
  "state_medical_council": "Delhi Medical Council",
  "qualifications": ["MBBS", "MD (Cardiology)"],
  "specializations": ["Cardiology", "Interventional Cardiology"]
}
Response: {
  "success": true,
  "transaction_id": "txn_123456",
  "message": "HPR registration submitted successfully"
}

GET /admin1947/abdm/hpr/status/:doctor_id
Response: {
  "success": true,
  "registration": {
    "hpr_id": "HPR1234567890",
    "status": "approved",
    "submitted_at": "2026-08-20 14:30:00",
    "approved_at": "2026-08-22 09:15:00"
  }
}
```

#### HFR Registration (Facilities)
```
POST /admin1947/abdm/hfr/register
Body: {
  "facility_type": "hospital",
  "facility_id": 456,
  "name": "Apollo Hospital",
  "address": "123 Medical Street",
  "city": "New Delhi",
  "state": "Delhi",
  "pincode": "110001",
  "contact_person": "Dr. Gupta",
  "contact_phone": "9876543210",
  "contact_email": "info@apollohospital.com",
  "facility_details": {
    "bed_count": 500,
    "specialties": ["Cardiology", "Neurology", "Orthopedics"],
    "emergency_services": true,
    "icu_beds": 20
  }
}
Response: {
  "success": true,
  "transaction_id": "txn_789012",
  "message": "HFR registration submitted successfully"
}

GET /admin1947/abdm/hfr/status/:facility_id/:facility_type
Response: {
  "success": true,
  "registration": {
    "hfr_id": "HFR9876543210",
    "status": "approved",
    "submitted_at": "2026-08-20 14:30:00",
    "approved_at": "2026-08-22 09:15:00"
  }
}
```

### 4.2 External API (For ABDM Gateway Integration)

These would be exposed as webservices for ABDM gateways to call:

```
POST /webservices/abdm/consent/request
Body: (ABDM standard consent request format)
Response: (ABDM standard consent response)

POST /webservices/abdm/health-info/exchange
Body: (ABDM standard HIE request)
Response: (ABDM standard HIE response with health data or error)

GET /webservices/abdm/hpr/lookup/:hpr_id
Response: (ABDM standard HPR lookup response)

GET /webservices/abdm/hfr/lookup/:hfr_id
Response: (ABDM standard HFR lookup response)
```

## 5. Integration Flows

### 5.1 ABHA Creation/Linking Flow
```
User (Patient)                           UPCHAR System                  ABDM Gateway
    │                                       │                            │
    │ 1. Request ABHA ID creation/link      │                            │
    │──────────────────────────────────────▶│                            │
    │                                       │ 2. Validate user           │
    │                                       │◀───────────────────────────│
    │                                       │ 3. Call ABDM ABHA API      │
    │                                       │◀───────────────────────────│
    │                                       │ 4. Store ABHA details      │
    │                                       │◀───────────────────────────│
    │                                       │ 5. Return ABHA info        │
    │◀─────────────────────────────────────│                            │
    │ 2. Show ABHA ID to user               │                            │
```

### 5.2 Consent Management Flow
```
Patient                                  UPCHAR System                  ABDM HIE
    │                                       │                            │
    │ 1. Initiate consent sharing           │                            │
    │──────────────────────────────────────▶│                            │
    │                                       │ 2. Validate patient &      │
    │                                       │    consent details         │
    │                                       │◀───────────────────────────│
    │                                       │ 3. Create consent record   │
    │                                       │◀───────────────────────────│
    │                                       │ 4. Call ABDM consent API   │
    │                                       │◀───────────────────────────│
    │                                       │ 5. Store consent artifact  │
    │                                       │◀───────────────────────────│
    │                                       │ 6. Return consent ID       │
    │◀─────────────────────────────────────│                            │
    │ 3. Show consent confirmation          │                            │
```

### 5.3 Health Information Exchange Flow (When Requested)
```
Requesting Facility                      UPCHAR System (HIE)             Patient's Facility
    │                                       │                            │
    │ 1. Request health info with consent   │                            │
    │──────────────────────────────────────▶│                            │
    │                                       │ 2. Validate consent token  │
    │                                       │◀───────────────────────────│
    │                                       │ 3. Fetch patient health    │
    │                                       │    records from DB         │
    │                                       │◀───────────────────────────│
    │                                       │ 4. Apply data fiduciary    │
    │                                       │    rules (mask sensitive)  │
    │                                       │◀───────────────────────────│
    │                                       │ 5. Format per ABDM spec    │
    │                                       │◀───────────────────────────│
    │                                       │ 6. Return health info      │
    │◀─────────────────────────────────────│                            │
    │ 4. Receive health information         │                            │
```

### 5.4 HPR/HFR Registration Flow
```
Healthcare Provider                      UPCHAR System                  ABDM Registry
    │                                       │                            │
    │ 1. Submit registration details        │                            │
    │──────────────────────────────────────▶│                            │
    │                                       │ 2. Validate & format data  │
    │                                       │◀───────────────────────────│
    │                                       │ 3. Call ABDM registry API  │
    │                                       │◀───────────────────────────│
    │                                       │ 4. Store transaction ID    │
    │                                       │◀───────────────────────────│
    │                                       │ 5. Return acknowledgment   │
    │◀─────────────────────────────────────│                            │
    │ 2. Show submission confirmation       │                            │
    │                                       │                            │
    │                                       │ 6. Poll for status (bg job)│
    │                                       │◀───────────────────────────│
    │                                       │ 7. Update registration     │
    │                                       │    status when approved    │
    │                                       │◀───────────────────────────│
    │ 3. Notification of approval/rejection │                            │
```

## 6. Security Considerations

### 6.1 Data Protection
- All ABHA numbers and addresses treated as sensitive personal data
- Consent records contain sensitive health information - encrypted at rest
- Audit logs do not contain actual health data, only metadata
- Use HTTPS for all external API calls to ABDM gateways
- Implement rate limiting to prevent abuse

### 6.2 Authentication & Authorization
- Only authenticated users can initiate ABHA linking
- Patients can only manage their own consent
- Doctors can only manage their own HPR registrations
- Facility admins can only manage their own HFR registrations
- Admin users can view audit logs and aggregated statistics
- Implement CSRF protection for all forms
- Use secure, HTTP-only cookies for sessions

### 6.3 Consent Management
- Explicit consent required for any health data sharing
- Granular consent for specific data types, purposes, and time periods
- Ability to revoke consent at any time
- Consent artifacts stored for audit trail
- Consent expiration automatic handling

### 6.4 Audit & Compliance
- Comprehensive audit logging of all ABDM operations
- Immutable audit logs (append-only, regular backups)
- Regular compliance reporting capabilities
- Data minimization principles applied
- Right to be forgotten implementation (where consistent with legal requirements)

## 7. Implementation Approach

### 7.1 Phase 1: Core ABDM Service Layer
1. Create ABDM database tables
2. Implement ABDM API client library (`Abdm_api.php`)
3. Create core ABDM service with methods for:
   - ABHA creation/linking/verification
   - Consent management
   - HPR/HFR registration status checking
4. Build basic admin dashboard for ABDM overview
5. Implement audit logging

### 7.2 Phase 2: User-facing Features
1. Add ABHA linking to user profile/settings
2. Implement consent management UI in patient portal
3. Add ABHA ID display in user profile
4. Create patient-facing consent management pages

### 7.3 Phase 3: Provider Registration Features
1. Implement HPR registration flow for doctors
2. Implement HFR registration flow for hospitals, clinics, labs, pharmacies
3. Add registration status tracking in provider dashboards
4. Implement admin views for monitoring registration submissions

### 7.4 Phase 4: Health Information Exchange (Advanced)
1. Implement basic HIE request/response handling
2. Create consent validation middleware
3. Build health data extraction and formatting services
4. Add testing interfaces with ABDM sandbox

### 7.5 Phase 5: Production Readiness
1. Security review and penetration testing
2. Performance optimization
3. Documentation and training materials
4. Rollout plan and cutover procedures
5. Monitoring and alerting setup

## 8. Configuration

### 8.1 ABDM Configuration File (`admin1947/application/config/abdm.php`)
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['abdm'] = [
    // Environment: sandbox, staging, production
    'environment' => 'sandbox',
    
    // API Endpoints (would vary by environment)
    'api_endpoints' => [
        'sandbox' => [
            'base_url' => 'https://sandbox.abdm.gov.in/gateway',
            'abha' => '/abha/api/v1',
            'consent' => '/consent/api/v1',
            'hpr' => '/hpr/api/v1',
            'hfr' => '/hfr/api/v1',
            'hie' => '/hie/api/v1'
        ],
        'production' => [
            'base_url' => 'https://abdm.gov.in/gateway',
            // ... similar structure
        ]
    ],
    
    // Credentials (should be in environment variables or vault)
    'api_key' => '', // Set via environment variable
    'api_secret' => '', // Set via environment variable
    
    // Timeout settings
    'timeout' => 30,
    'ssl_verify' => true,
    
    // UPCHAR specific settings
    'upchar_hpr_id_prefix' => 'UPCHAR-DR',
    'upchar_hfr_id_prefix' => 'UPCHAR-FAC',
    
    // Consent defaults
    'default_consent_duration_days' => 365,
    'max_consent_duration_days' => 730, // 2 years max
    
    // Feature flags
    'enable_abha_creation' => true,
    'enable_consent_management' => true,
    'enable_hpr_registration' => true,
    'enable_hfr_registration' => true,
    'enable_hie_integration' => false // Phase 4 feature
];
```

## 9. Error Handling & Logging

### 9.1 Error Categories
- Validation errors (400) - Invalid input data
- Authentication errors (401) - Invalid/missing API credentials
- Authorization errors (403) - Not permitted to perform operation
- ABDM API errors (5xx) - Problems with ABDM gateway
- Network errors (503) - Unable to reach ABDM gateway
- Consent errors (409) - Consent conflicts or violations

### 9.2 Logging Structure
All ABDM operations logged to:
- Application logs (`application/logs/abdm_YYYY-MM-DD.php`)
- Audit trail table (`abdm_audit_log`)
- Structured JSON logs for external SIEM integration

Each log entry includes:
- Timestamp
- Operation type
- User/entity IDs (hashed/anonymized where needed)
- Request/response summaries (not full payloads for sensitive data)
- Success/failure status
- Error messages (sanitized)
- Correlation ID for tracing

## 10. Testing Strategy

### 10.1 Unit Testing
- Test ABDM API client methods
- Test service layer business logic
- Test data validation functions
- Test consent rule engines

### 10.2 Integration Testing
- Test end-to-end ABHA linking flow
- Test consent creation and validation flows
- Test HPR/HFR registration submission flows
- Test audit logging completeness

### 10.3 System Testing
- Test with ABDM sandbox environment
- Validate compliance with ABDM specifications
- Performance testing under load
- Security testing (OWASP Top 10)

### 10.4 User Acceptance Testing
- Validate user experience for ABHA linking
- Test consent UI clarity and usability
- Verify provider registration workflows
- Confirm admin monitoring capabilities

## 11. Deployment & Rollback

### 11.1 Deployment Steps
1. Backup current database
2. Deploy ABDM database migrations
3. Deploy ABDM module code
4. Clear application cache
5. Run database seeders (if any)
6. Execute health checks
7. Monitor logs for errors

### 11.2 Rollback Procedure
1. Pause new ABDM feature flags
2. Restore database from backup (if schema changes)
3. Revert to previous code version
4. Clear application cache
5. Verify core functionality restored

## 12. Future Enhancements

### 12.1 Short-term (Phase 3-4)
- Integration with ABDM Health Information Exchange (HIE)
- Personal Health Record (PHR) view for users
- Vaccination certificate integration via ABDM
- Telemedicine consultation recording to ABDM
- Insurance claim processing integration

### 12.2 Long-term (Phase 4+)
- AI-powered health insights from ABDM data (with consent)
- Interoperability with other national health systems
- Advanced analytics dashboard for administrators
- Machine learning models for health risk prediction (anonymized data)
- Integration with Ayushman Bharat Pradhan Mantri Jan Arogya Yojana (AB-PMJAY)

## 13. Compliance & Standards

### 13.1 ABDM Compliance
- Follow ABDM Health Information Exchange Specifications
- Implement ABDM Consent Management Framework
- Adhere to ABDM Health Data Standards
- Support ABDM Unique Identification Standards (ABHA)
- Follow ABDM Security & Privacy Guidelines

### 13.2 Data Standards
- Use ICD-11 for disease coding (where applicable)
- Use SNOMED CT for clinical terms (where applicable)
- Use LOINC for laboratory tests (where applicable)
- Use WHO ATC for medications (where applicable)
- Follow FHIR R4 for health data exchange formats (where aligned with ABDM)

### 13.3 Legal & Regulatory
- Compliant with Information Technology Act, 2000
- Adhere to Personal Data Protection Bill principles (when enacted)
- Follow National Digital Health Mission (NDHM) guidelines
- Comply with applicable healthcare regulations in India

---
*Document Version: 1.0*
*Last Updated: 2026-08-25*
*Next Review Date: 2026-09-25*