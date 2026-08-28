# Upchar Platform Modernization Blueprint (`landing.md`)

## 1. Executive Summary
This document outlines the UI/UX redesigns, component restructuring, responsive adjustments, navigation alignment, partner authentication views, universal header/footer modules, ABDM/ABHA integration, and the complete modernization across all **Master, Medical, Facility, Pathology, and Administration** pages within the Upchar platform.

---

## 2. Global Design System Specifications

* **Primary Background:** `#F8F9FA` (Soft Light Gray)
* **Card Containers:** `#FFFFFF` (Pure White) with `border-radius: 12px` and `box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05)`
* **Primary Accent Color:** `#00A896` (Clinical Teal for CTAs, active indicators, and highlight pills)
* **Secondary Accent Color:** `#05668D` / `#0284C7` (Deep Navy / Sky Blue for headers and badges)
* **Typography:** `Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`
* **Status Badges:** Rounded pill badges (`.badge-pill-status`) with active green (`#DCFCE7` / `#15803D`) and inactive red (`#FEE2E2` / `#B91C1C`)

---

## 3. Completed Platform Modules Overview

### A. Masters Management Views (Two-Column Layout)
1. `/masters/specilization/index` - Doctor Clinical Specializations
2. `/masters/council/index` - Medical Councils
3. `/masters/degree/index` - Medical Degrees & Qualifications
4. `/masters/location/index` - Localities & Geographical Areas
5. `/masters/services/index` - Clinical Services & Offerings
6. `/masters/city/index` - Operational Cities Directory

### B. Doctors Module
1. `/doctor/doctorreg` - Add New Doctor (4-step tabbed wizard card)
2. `/doctor/doctorview` - Doctors Directory with instant AJAX status verification & Excel export
3. `/doctor/doctorview/viewgallery` - Responsive media grid cards for doctor portfolio & certificates

### C. Clinics & Hospitals Module
1. `/doctor/clinicreg/add` - Add Clinic / Hospital (4-step tabbed wizard card)
2. `/doctor/clinicreg/viewclinic` - Clinics Directory
3. `/doctor/clinicreg/viewhospital` - Hospitals Directory with Private/Govt sector badges
4. `/doctor/clinicreg/viewgallery` - Hospital Media Gallery Cards
5. `/doctor/package/index` - Healthcare Packages with Pricing & Thumbnails
6. `/doctor/hospital_bed/index` - Real-time Hospital Bed Inventory & Capacity Tracking

### D. Pathology Master Module
1. `/doctor/pathlabreg/index` - Add Pathology Center (Multi-step wizard with NABL document dropzones)
2. `/doctor/pathlabreg/viewpathology` - Diagnostic Labs Directory
3. `/doctor/pathtest/category` - Pathology Categories (Two-column layout)
4. `/doctor/pathtest/index` - Diagnostic Tests Catalog
5. `/doctor/pathtest/unit` - Laboratory Measurement Units (Two-column layout)
6. `/doctor/pathtest/parameter` - Test Parameters & Reference Ranges

### E. General Administration & Appointments
1. `/doctor/newsreg/viewnews` - Healthcare News & Announcements
2. `/users/userlogincreate/userview` - Patient User Directory
3. `/users/usercreate` - Admin Staff & User Management (Two-column layout)
4. `/users/changepassword` - Change Account Password
5. `/doctor/appointment/doctorappointment` - Doctor Appointments Directory
6. `/doctor/appointment/todayappointment` - Today's Live Queue & Patient Queue
7. `/abdm` - Ayushman Bharat Digital Mission (ABDM / ABHA) Management

---

## 4. Verification & Testing

All 21 administrative routes across all modules have been verified through automated test suites:
- **HTTP Response:** `200 OK` across all views
- **PHP Errors/Notices:** `0 Errors, 0 Warnings`
- **Design System Consistency:** `100% Inter font, soft shadow cards, standardized toolbars, and pill badges`
