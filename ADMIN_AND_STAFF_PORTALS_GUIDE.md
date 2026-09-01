# 🏥 Upchar Platform & Admin1947 Enterprise Portals Management Guide

This comprehensive manual provides all login credentials, portal access URLs, architectural role definitions, and step-by-step workflows for managing the **Upchar Healthcare Platform** and **Admin1947 Executive Suite**.

---

## 🔐 1. Master Login Credentials Directory

All portals are pre-seeded with standardized credentials. You can log in via **Email, Phone Number, or Staff Code**.

### A. Staff & Enterprise Portals Login (`/staff/login`)
| Role / Portal | Identity (Email / Code / Phone) | Password | Default Landing Hub |
| :--- | :--- | :--- | :--- |
| **👑 Super Admin** | `admin@upcharr.com` <br> `UPC-ADM-001` <br> `9999990001` | `admin@123` | Master Hub / Universal Access |
| **👥 HR Manager** | `hr@upcharr.com` <br> `UPC-HR-001` <br> `9999990002` | `admin@123` | [`/hr/dashboard`](http://localhost/demo/upchar/hr/dashboard) |
| **💼 BDE Lead (CRM)** | `bde@upcharr.com` <br> `UPC-BDE-001` <br> `9999990003` | `admin@123` | [`/crm/dashboard`](http://localhost/demo/upchar/crm/dashboard) |
| **🧪 Phlebotomist (Collector)** | `collector@upcharr.com` <br> `UPC-COL-001` <br> `9999990004` | `admin@123` | [`/collector/dashboard`](http://localhost/demo/upchar/collector/dashboard) |
| **⚙️ Operations Officer** | `ops@upcharr.com` <br> `UPC-OPS-001` <br> `9999990005` | `admin@123` | [`/operations/dashboard`](http://localhost/demo/upchar/operations/dashboard) |

> 💡 **Demo 1-Click Switcher**: Visiting [`http://localhost/demo/upchar/staff/login`](http://localhost/demo/upchar/staff/login) features a 1-click role switcher at the bottom to test any portal instantly without typing!

---

### B. Admin1947 Master Control Center (`/admin1947/login`)
| Username | Password | Role Level | Access Scope |
| :--- | :--- | :--- | :--- |
| `admin` | `admin@123` | Level 1 (Super Admin) | Full System & Module Control |
| `amitadmin` | `admin@123` | Level 1 (Super Admin) | Master Management & Settings |
| `amitctu67` | `admin@123` | Level 1 (Super Admin) | Verification & Clinic Approvals |

---

## 🛡️ 2. Single-Session Role Isolation Security

To prevent session collision, account hijacking, and state contamination across the application:
1. **Strictly One Active Role per Browser Session**:
   - When a **Patient (User)** logs in, any existing **Admin, Staff, or Provider** session is immediately flushed, and the active session is locked strictly to `user`.
   - When an **Admin / Staff Member** logs in, any active **Patient** session is immediately terminated, ensuring that an admin cannot book services or perform patient actions as an overlapping user in the same browser session.
   - When a **Healthcare Provider (Doctor / Hospital / Lab)** logs in, contradictory user and staff session tokens are invalidated.
2. **Dedicated Cookie Scoping**:
   - `ci_admin_session` is isolated to the Admin1947 subsystem.
   - `ci_session` is isolated to the public and staff portals.
   - Logging in as a public user automatically revokes any dangling admin session cookies.

---

## 🌐 2. Complete Management URL Directory

### 👑 Executive Master Control (Admin1947)
- **Executive Master Dashboard**: [`http://localhost/demo/upchar/admin1947/masters/dashboard`](http://localhost/demo/upchar/admin1947/masters/dashboard)
- **Diagnostic Pathology Catalog**: [`http://localhost/demo/upchar/admin1947/doctor/pathology/assign_test`](http://localhost/demo/upchar/admin1947/doctor/pathology/assign_test)
- **Add Diagnostic Test / Health Package**: [`http://localhost/demo/upchar/admin1947/doctor/pathology/add`](http://localhost/demo/upchar/admin1947/doctor/pathology/add)
- **Google / Gmail Patients Directory**: [`http://localhost/demo/upchar/admin1947/users/userlogincreate/gmail_users`](http://localhost/demo/upchar/admin1947/users/userlogincreate/gmail_users)
- **Sponsored Healthcare Ads Manager**: [`http://localhost/demo/upchar/admin1947/doctor/clinicreg/advertisment`](http://localhost/demo/upchar/admin1947/doctor/clinicreg/advertisment)
- **Revenue & Commission Ledger**: [`http://localhost/demo/upchar/admin_revenue`](http://localhost/demo/upchar/admin_revenue)
- **Payment & Settlements Center**: [`http://localhost/demo/upchar/admin_payment`](http://localhost/demo/upchar/admin_payment)

---

### 👥 HR & Staff Management Portal (`/hr`)
- **HR Command Hub**: [`http://localhost/demo/upchar/hr/dashboard`](http://localhost/demo/upchar/hr/dashboard)
- **Staff Directory & Onboarding**: [`http://localhost/demo/upchar/hr/employees`](http://localhost/demo/upchar/hr/employees)
- **Daily Attendance & GPS Roster**: [`http://localhost/demo/upchar/hr/attendance`](http://localhost/demo/upchar/hr/attendance)
- **Leave Requests & Approvals**: [`http://localhost/demo/upchar/hr/leaves`](http://localhost/demo/upchar/hr/leaves)
- **Monthly Automated Payroll**: [`http://localhost/demo/upchar/hr/payroll`](http://localhost/demo/upchar/hr/payroll)

---

### ⚙️ Central Operations & Logistics Desk (`/operations`)
- **Operations Overview**: [`http://localhost/demo/upchar/operations/dashboard`](http://localhost/demo/upchar/operations/dashboard)
- **Lab Sample Handoffs Verification**: [`http://localhost/demo/upchar/operations/handoffs`](http://localhost/demo/upchar/operations/handoffs)
- **Expense & Reimbursement Claims**: [`http://localhost/demo/upchar/operations/expenses`](http://localhost/demo/upchar/operations/expenses)

---

### 💼 BDE Partner CRM (`/crm`)
- **BDE Revenue Dashboard**: [`http://localhost/demo/upchar/crm/dashboard`](http://localhost/demo/upchar/crm/dashboard)
- **Interactive Kanban Pipeline**: [`http://localhost/demo/upchar/crm/leads`](http://localhost/demo/upchar/crm/leads)
- **Convert Signed Lead to Partner**: [`http://localhost/demo/upchar/crm/onboard_partner/1`](http://localhost/demo/upchar/crm/onboard_partner/1)

---

### 🧪 Sample Collector Phlebotomist App (`/collector`)
- **Collector Dashboard (Task Queue)**: [`http://localhost/demo/upchar/collector/dashboard`](http://localhost/demo/upchar/collector/dashboard)
- **Step-by-Step Pickup Flow**: [`http://localhost/demo/upchar/collector/pickup/1`](http://localhost/demo/upchar/collector/pickup/1)
- **Generate Dynamic UPI QR**: [`http://localhost/demo/upchar/collector/generate_qr?amount=400&booking_id=1`](http://localhost/demo/upchar/collector/generate_qr?amount=400&booking_id=1)

---

### ⏱️ Biometric & GPS Attendance (`/attendance`)
- **Daily Punch-In / Punch-Out**: [`http://localhost/demo/upchar/attendance/punch`](http://localhost/demo/upchar/attendance/punch)
- **Monthly Attendance Log**: [`http://localhost/demo/upchar/attendance/history`](http://localhost/demo/upchar/attendance/history)
- **1-Click Reset for Testing**: [`http://localhost/demo/upchar/attendance/reset_today_punch`](http://localhost/demo/upchar/attendance/reset_today_punch)

---

## 🛠️ 3. Step-by-Step User Workflows

### 🔹 Workflow 1: Managing Operations & Sample Handoffs
1. Log in as `admin@upcharr.com` or `ops@upcharr.com` at `/staff/login`.
2. Navigate to [`/operations/handoffs`](http://localhost/demo/upchar/operations/handoffs).
3. Under **"Pending Samples from Field Collectors"**, you will see samples collected by phlebotomists.
4. Scan or enter the sample tube barcode (`UPC-VIAL-XXXXX`).
5. Select sample tube physical condition (`Good / Intact`, `Hemolyzed`, `Temperature Warning`, `Leaking`).
6. Click **"Verify & Accept into Lab"**. The sample is marked as verified and handed over for testing.

---

### 🔹 Workflow 2: Managing Staff Attendance & Payroll
1. Log in as `hr@upcharr.com` or `admin@upcharr.com` at `/staff/login`.
2. Go to [`/hr/attendance`](http://localhost/demo/upchar/hr/attendance) to view live employee check-ins, exact GPS coordinates, and Haversine distance from the Lucknow central hub.
3. If an employee applies for leave, open [`/hr/leaves`](http://localhost/demo/upchar/hr/leaves) and click **"Approve"** or **"Reject"** with custom reviewer notes.
4. Go to [`/hr/payroll`](http://localhost/demo/upchar/hr/payroll) to generate the monthly payroll sheet with automated calculation of present days, unpaid leaves, gross salary, and net salary.

---

### 🔹 Workflow 3: BDE Lead Pipeline & Healthcare Provider Onboarding
1. Log in as `bde@upcharr.com` at `/staff/login`.
2. Open [`/crm/leads`](http://localhost/demo/upchar/crm/leads).
3. Click **"+ Add Partner Lead"** to register a hospital, clinic, diagnostic lab, or pharmacy.
4. Drag and drop the card across Kanban columns (*New* $\rightarrow$ *Contacted* $\rightarrow$ *Meeting Scheduled* $\rightarrow$ *Proposal Sent* $\rightarrow$ *Signed*).
5. When a lead reaches **Signed**, click **"Onboard Partner"** to automatically provision their provider profile!

---

### 🔹 Workflow 4: Doorstep Sample Collection (Phlebotomist Flow)
1. Log in as `collector@upcharr.com` at `/staff/login` on mobile or desktop.
2. Open [`/collector/dashboard`](http://localhost/demo/upchar/collector/dashboard) to view assigned doorstep pickups.
3. Click on a patient's booking task (e.g. [`/collector/pickup/1`](http://localhost/demo/upchar/collector/pickup/1)).
4. Click **"Start Journey (En Route)"** $\rightarrow$ Click **"Arrived at Location"**.
5. Click **"Scan Barcode"** to link the vial barcode.
6. Click **"Generate UPI QR"** for the patient to scan with GPay/PhonePe or click **"Record Cash Payment"**.
7. Click **"Mark Sample Collected"**. The order updates instantly across the system.
