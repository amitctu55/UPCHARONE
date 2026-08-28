# ABDM Integration Module for UPCHAR Healthcare Platform

## Overview
This module integrates the UPCHAR platform with the Ayushman Bharat Digital Mission (ABDM) ecosystem to enable:
- Creation and linking of ABHA (Ayushman Bharat Health Account) IDs for users
- Registration of healthcare professionals in the Healthcare Professionals Registry (HPR)
- Registration of healthcare facilities in the Health Facility Registry (HFR)
- Consent-based exchange of health records through the Health Information Exchange (HIE)
- Compliance with ABDM specifications and standards

## Features Implemented

### 1. Dashboard Enhancement
- Added ABDM integration metrics to the main dashboard's "God's Eye View" section
- Displays key ABDM statistics:
  - Total ABHA IDs linked (with active count)
  - Total consent records (with active count)
  - Total HPR registrations (with approved count)
  - Total HFR registrations (with approved count)

### 2. Core Components Created

#### Controllers (`admin1947/application/modules/abdm/controllers/`)
- `Abdm.php` - Main ABDM controller with methods for:
  - ABHA management (linking, verification)
  - Consent management (giving, revoking consent)
  - HPR registration and status checking
  - HFR registration and status checking
- `Test.php` - Simple test controller to verify module functionality

#### Models (`admin1947/application/modules/abdm/models/`)
- `Abdm_model.php` - Main model with methods for all ABDM operations:
  - ABHA linking and verification
  - Consent management
  - HPR/HFR registration
  - Audit logging
  - Dashboard statistics retrieval

#### Configuration (`admin1947/application/modules/abdm/config/`)
- `abdm.php` - Configuration file for ABDM integration settings:
  - Environment settings (sandbox/staging/production)
  - API endpoint configurations
  - Credential placeholders
  - Feature flags

#### Libraries (`admin1947/application/modules/abdm/libraries/`)
- `Abdm_api.php` - ABDM API client library for interacting with ABDM gateways:
  - ABHA API methods
  - Consent API methods
  - HPR API methods
  - HFR API methods
  - HIE API methods

#### SQL (`admin1947/application/modules/abdm/sql/`)
- `abdm_tables.sql` - Database schema for ABDM integration:
  - `abdm_users` - Links UPCHAR users to ABHA IDs
  - `abdm_consent` - Manages consent for health data exchange
  - `abdm_hpr_registrations` - Tracks HPR registrations for doctors
  - `abdm_hfr_registrations` - Tracks HFR registrations for facilities
  - `abdm_audit_log` - Audit trail for ABDM operations

## Database Tables Created

The module creates the following tables in the database:

1. **abdm_users** - Links UPCHAR users to ABHA IDs
2. **abdm_consent** - Manages consent for health data exchange
3. **abdm_hpr_registrations** - Tracks HPR registrations for doctors
4. **abdm_hfr_registrations** - Tracks HFR registrations for facilities
5. **abdm_audit_log** - Audit trail for ABDM operations

## Implementation Approach

This implementation follows a phased approach:

### Phase 1: Core ABDM Service Layer (Completed)
- Created ABDM database tables
- Implemented ABDM API client library
- Created core ABDM service with methods for ABHA, consent, HPR/HFR operations
- Built basic admin dashboard for ABDM overview (enhanced existing dashboard)
- Implemented audit logging

### Future Phases (Planned)
- **Phase 2**: User-facing features (ABHA linking to user profile, consent management UI)
- **Phase 3**: Provider registration features (HPR/HFR registration flows)
- **Phase 4**: Health Information Exchange (basic HIE request/response handling)
- **Phase 5**: Production readiness (security review, performance optimization)

## Usage

To access the ABDM dashboard metrics:
1. Navigate to the main UPCHAR dashboard
2. Scroll to the "God's Eye View - Complete System Overview" section
3. View the ABDM metrics in the second row of metric cards

To test the ABDM module:
1. Visit: `http://your-domain.com/admin1947/abdm/test`
2. This will display basic test information and ABDM statistics

## Configuration

Before using the module in production:
1. Update the API credentials in `admin1947/application/modules/abdm/config/abdm.php`
2. Set the appropriate environment (sandbox/staging/production)
3. Run the SQL script in `admin1947/application/modules/abdm/sql/abdm_tables.sql` to create the necessary database tables
4. Configure webhook endpoints if implementing bidirectional communication with ABDM gateways

## Dependencies

- PHP 7.4+
- CodeIgniter 3.x
- MySQL 5.7+
- cURL extension for HTTP requests
- JSON extension

## References

- ABDM Documentation: https://abdm.gov.in/
- Ayushman Bharat Digital Mission Specifications
- UPCHAR Healthcare Platform Architecture

---
*Module implemented as part of UPCHAR Healthcare Platform enhancement*
*Last Updated: 2026-08-25*