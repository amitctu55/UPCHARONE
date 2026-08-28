# B2B Subscription Billing Module Design Document
UPCHAR Healthcare Platform

## 1. Module Overview

### 1.1 Purpose
Design and implement a Business-to-Business (B2B) subscription billing system that allows healthcare providers (doctors, hospitals, pathology labs, medical stores) to subscribe to premium plans, access advanced features, and make recurring payments through integrated payment gateways.

### 1.2 Scope
This module will cover:
- Subscription plan management (creation, pricing, features)
- Provider subscription lifecycle (trial, active, expired, cancelled)
- Recurring billing and payment processing
- Invoice generation and payment history
- Payment gateway integration (multiple providers)
- Proration and plan change handling
- Dunning management for failed payments
- Tax calculation and compliance
- Analytics and reporting on subscription metrics
- Admin dashboard for managing subscriptions and revenue
- Provider self-service portal for subscription management

### 1.3 Objectives
1. Enable monetization of premium UPCHAR features through recurring subscriptions
2. Provide flexible pricing models (tiered, per-user, feature-based)
3. Automate billing cycles and payment collection
4. Reduce churn through proactive dunning management
5. Ensure compliance with tax regulations and payment standards
6. Provide seamless experience for providers to upgrade/downgrade/cancel
5. Generate accurate financial reports for business intelligence
6. Support multiple payment gateways and currencies (INR primary, extensible)

## 2. Technical Architecture

### 2.1 System Components
```
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   Provider      │    │ Subscription     │    │   Payment Gateways │
│   (Web Portal)  │    │   Billing Engine │    │ (Razorpay, Stripe, │
└─────────┬───────┘    └─────────┬────────┘    │   PayU, CCAvenue)  │
          │                      │               └─────────┬──────────┘
          │ REST API             │                           │
          ▼                      ▼                           ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│   API Gateway   │◄──►│  Subscription    │◄──►│  Payment Webhooks  │
│ (Rate Limiting) │    │  Service         │    │  & Payment Gateway │
└─────────┬───────┘    └─────────┬────────┘    └─────────┬──────────┘
          │                      │                       │
          │ Database             │                       │
          ▼                      ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌────────────────────┐
│ Subscription    │    │  Invoice &       │    │  Email/SMS         │
│   Tables        │    │  Payment Records │    │  Notification Svc  │
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
    │   └── subscription/               ← NEW MODULE
    │       ├── controllers/
    │       │   ├── Subscription.php    ← Provider-facing subscription management
    │       │   ├── Billing.php         ← Billing and payment processing
    │       │   ├── Invoice.php         ← Invoice generation and management
    │       │   ├── Webhook.php         ← Payment gateway webhooks
    │       │   └── Admin.php           ← Admin dashboard controller
    │       ├── models/
    │       │   ├── Subscription_model.php
    │       │   ├── Plan_model.php
    │       │   ├── Invoice_model.php
    │       │   ├── Payment_model.php
    │       │   └── Billing_model.php
    │       ├── libraries/
    │       │   ├── Payment_gateway.php   ← Abstract payment gateway interface
    │       │   ├── Razorpay_gateway.php  ← Razorpay implementation
    │       │   ├── Stripe_gateway.php    ← Stripe implementation
    │       │   ├── Payu_gateway.php      ← PayU implementation
    │       │   ├── Ccavenue_gateway.php  ← CCAvenue implementation
    │       │   ├── Tax_calculator.php    ← Tax calculation logic
    │       │   ├── Dunning_manager.php   ← Failed payment handling
    │       │   └── Subscription_helper.php
    │       ├── views/
    │       │   ├── provider/
    │       │   │   ├── dashboard.php       ← Provider subscription overview
    │       │   │   ├── plans.php           ← Available plans comparison
    │       │   │   ├── manage.php          ← Manage current subscription
    │       │   │   ├── billing_history.php ← Payment and invoice history
    │       │   │   └── update_payment.php  ← Update payment method
    │       │   ├── admin/
    │       │   │   ├── dashboard.php       ← Admin subscription analytics
    │       │   │   ├── plans.php           ← Manage subscription plans
    │       │   │   ├── subscriptions.php   ← View all provider subscriptions
    │       │   │   ├── invoices.php        ← View and manage invoices
    │       │   │   └── revenue.php         ← Revenue reporting
    │       │   └── emails/
    │       │       ├── payment_success.php ← Email templates
    │       │       ├── payment_failed.php
    │       │       ├── trial_ending.php
    │       │       └── subscription_updated.php
    │       └── config/
    │           └── subscription.php      ← Subscription configuration
    ├── third_party/
    │   └── payment_sdks/               ← Payment gateway SDKs
    └── logs/
        └── subscription/               ← Subscription-specific logs
```

### 2.3 Dependencies
- PHP 7.4+
- CodeIgniter 3.x
- MySQL 5.7+
- Payment gateway SDKs (Razorpay, Stripe, PayU, CCAvenue)
- PHPMailer or similar for email notifications
- Optional: Redis for caching subscription states
- Optional: Queue system (RabbitMQ/Retry mechanism) for webhook processing

## 3. Database Schema

### 3.1 Core Tables

#### subscription_plans - Defines available subscription plans
```sql
CREATE TABLE `subscription_plans` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL COMMENT 'Plan name (e.g., Basic, Pro, Enterprise)',
  `plan_code` VARCHAR(20) NOT NULL UNIQUE COMMENT 'Unique code for API/reference',
  `description` TEXT NULL,
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Price in INR (or base currency)',
  `currency` VARCHAR(3) DEFAULT 'INR',
  `billing_interval` ENUM('monthly', 'quarterly', 'half_yearly', 'yearly') NOT NULL,
  `billing_interval_count` INT DEFAULT 1 COMMENT 'e.g., 2 for every 2 months',
  `trial_period_days` INT DEFAULT 0 COMMENT 'Free trial days',
  `setup_fee` DECIMAL(10,2) DEFAULT 0.00,
  `is_active` BOOLEAN DEFAULT TRUE,
  `is_public` BOOLEAN DEFAULT TRUE COMMENT 'Visible to providers for self-signup',
  `sort_order` INT DEFAULT 0 COMMENT 'For displaying plans in order',
  `features` TEXT NULL COMMENT 'JSON array of feature codes included',
  `limits` TEXT NULL COMMENT 'JSON object of usage limits (e.g., max appointments/day)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_plan_code` (`plan_code`),
  INDEX `idx_active_public` (`is_active`, `is_public`),
  INDEX `idx_billing_interval` (`billing_interval`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### provider_subscriptions - Tracks individual provider subscriptions
```sql
CREATE TABLE `provider_subscriptions` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `provider_id` INT NOT NULL COMMENT 'References provider table (doctorlogin, hospitallogin, etc.)',
  `provider_type` ENUM('doctor', 'hospital', 'pathlab', 'medical_store') NOT NULL,
  `plan_id` INT NOT NULL COMMENT 'References subscription_plans.id',
  `status` ENUM('trial', 'active', 'past_due', 'cancelled', 'expired', 'paused') NOT NULL DEFAULT 'trial',
  `current_period_start` TIMESTAMP NOT NULL,
  `current_period_end` TIMESTAMP NOT NULL,
  `trial_start` TIMESTAMP NULL DEFAULT NULL,
  `trial_end` TIMESTAMP NULL DEFAULT NULL,
  `cancelled_at` TIMESTAMP NULL DEFAULT NULL,
  `cancelled_at_period_end` BOOLEAN DEFAULT FALSE COMMENT 'Cancel at end of period if true',
  `ended_at` TIMESTAMP NULL DEFAULT NULL,
  `quantity` INT DEFAULT 1 COMMENT 'Number of seats/licenses if applicable',
  `tax_percent` DECIMAL(5,2) DEFAULT 0.00 COMMENT 'Tax rate applied',
  `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
  `amount` DECIMAL(10,2) NOT NULL COMMENT 'Total amount including tax',
  `currency` VARCHAR(3) DEFAULT 'INR',
  `payment_method_id` VARCHAR(100) NULL COMMENT 'Reference to payment method in gateway',
  `payment_gateway` VARCHAR(20) NULL COMMENT 'Gateway used (razorpay, stripe, etc.)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_provider` (`provider_id`, `provider_type`),
  INDEX `idx_status` (`status`),
  INDEX `idx_period_end` (`current_period_end`),
  INDEX `idx_plan_id` (`plan_id`),
  INDEX `idx_trial_end` (`trial_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### subscription_invoices - Records invoices generated for subscriptions
```sql
CREATE TABLE `subscription_invoices` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `provider_subscription_id` BIGINT NOT NULL,
  `invoice_number` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Human-readable invoice number',
  `amount` DECIMAL(10,2) NOT NULL COMMENT 'Total invoice amount',
  `amount_paid` DECIMAL(10,2) DEFAULT 0.00,
  `amount_due` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) DEFAULT 'INR',
  `status` ENUM('draft', 'open', 'paid', 'void', 'uncollectible') NOT NULL DEFAULT 'open',
  `period_start` TIMESTAMP NOT NULL COMMENT 'Billing period start',
  `period_end` TIMESTAMP NOT NULL COMMENT 'Billing period end',
  `issued_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `due_date` TIMESTAMP NOT NULL COMMENT 'Payment due date',
  `paid_at` TIMESTAMP NULL DEFAULT NULL,
  `attempt_count` INT DEFAULT 0 COMMENT 'Number of payment attempts made',
  `next_payment_attempt` TIMESTAMP NULL DEFAULT NULL,
  `description` TEXT NULL COMMENT 'Invoice description line items',
  `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
  `tax_percent` DECIMAL(5,2) DEFAULT 0.00,
  `subtotal` DECIMAL(10,2) NOT NULL COMMENT 'Amount before tax',
  `hosted_invoice_url` VARCHAR(255) NULL COMMENT 'URL to hosted invoice (if gateway provides)',
  `invoice_pdf` VARCHAR(255) NULL COMMENT 'Local path to generated PDF invoice',
  `failed_payment_reason` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_provider_subscription` (`provider_subscription_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_due_date` (`due_date`),
  INDEX `idx_period` (`period_start`, `period_end`),
  INDEX `idx_invoice_number` (`invoice_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### subscription_payments - Records payment attempts and successes
```sql
CREATE TABLE `subscription_payments` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `invoice_id` BIGINT NOT NULL COMMENT 'References subscription_invoices.id',
  `provider_subscription_id` BIGINT NOT NULL,
  `payment_gateway` VARCHAR(20) NOT NULL COMMENT 'Gateway used',
  `gateway_payment_id` VARCHAR(100) NOT NULL COMMENT 'Payment ID from gateway',
  `gateway_customer_id` VARCHAR(100) NULL COMMENT 'Customer ID in gateway',
  `amount` DECIMAL(10,2) NOT NULL,
  `amount_refunded` DECIMAL(10,2) DEFAULT 0.00,
  `currency` VARCHAR(3) DEFAULT 'INR',
  `status` ENUM('pending', 'succeeded', 'failed', 'canceled') NOT NULL,
  `paid_at` TIMESTAMP NULL DEFAULT NULL,
  `failure_code` VARCHAR(50) NULL COMMENT 'Gateway-specific failure code',
  `failure_message` VARCHAR(255) NULL,
  `payment_method_details` TEXT NULL COMMENT 'JSON of payment method used (last 4 digits, type)',
  `receipt_url` VARCHAR(255) NULL COMMENT 'URL to payment receipt',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_invoice_id` (`invoice_id`),
  INDEX `idx_provider_subscription` (`provider_subscription_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`),
  INDEX `idx_gateway_payment_id` (`gateway_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### subscription_events - Audit trail for subscription changes
```sql
CREATE TABLE `subscription_events` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `provider_subscription_id` BIGINT NOT NULL,
  `event_type` ENUM('created', 'trial_started', 'trial_ended', 'activated', 
                   'plan_changed', 'renewed', 'cancelled', 'paused', 
                   'resumed', 'payment_succeeded', 'payment_failed',
                   'invoice_created', 'invoice_paid', 'invoice_void') NOT NULL,
  `event_data` TEXT NULL COMMENT 'JSON snapshot of relevant data at time of event',
  `prev_status` VARCHAR(20) NULL,
  `new_status` VARCHAR(20) NULL,
  `created_by` INT NULL COMMENT 'User ID who triggered event (if applicable)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_provider_subscription` (`provider_subscription_id`),
  INDEX `idx_event_type` (`event_type`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3.2 Modified Existing Tables (Optional Enhancements)

#### Add subscription status to provider tables (if desired)
```sql
ALTER TABLE `doctorlogin` 
ADD COLUMN `subscription_status` ENUM('none', 'trial', 'active', 'past_due', 'cancelled') DEFAULT 'none' AFTER `status`,
ADD COLUMN `subscription_plan_id` INT NULL AFTER `subscription_status`,
ADD COLUMN `subscription_current_period_end` TIMESTAMP NULL AFTER `subscription_plan_id`;

-- Similar for hospitallogin, chemistlogin, etc.
```

## 4. Core Business Logic

### 4.1 Subscription Lifecycle
```
1. Provider selects plan → Creates subscription (starts in trial if trial_period_days > 0)
2. Trial period → Automatic conversion to paid subscription at trial end
3. Active subscription → Recurring invoice generation at billing interval
4. Invoice generated → Payment attempt via payment gateway
5. Payment success → Subscription remains active, next cycle scheduled
6. Payment failure → Dunning process initiated (retry attempts, notifications)
7. After max retries → Subscription marked past_due, then cancelled if not resolved
8. Provider can cancel anytime → Cancellation effective immediately or at period end
9. Plan changes → Proration applied, new plan effective immediately or at period end
```

### 4.2 Billing and Invoicing
- **Invoice Generation**: Automatically generated X days before period end (configurable)
- **Payment Collection**: Attempted on invoice date or grace period start
- **Proration Calculation**: For plan changes mid-cycle
  ```
  Prorated Credit = (Old plan price × unused days) / total days in cycle
  Prorated Charge = (New plan price × used days) / total days in cycle
  Net amount = Prorated Charge - Prorated Credit
  ```
- **Tax Calculation**: Based on provider location and applicable GST/VAT rules
- **Currency Handling**: Primary INR, extensible to multi-currency via exchange rates

### 4.3 Payment Gateway Abstraction
- **Common Interface**: 
  - `createCustomer($providerDetails)`
  - `createSubscription($customerId, $planId, $trialDays)`
  - `createOneTimePayment($amount, $currency, $description)`
  - `updatePaymentMethod($customerId, $paymentToken)`
  - `handleWebhook($payload)`
- **Gateway-Specific Implementations**: 
  - Razorpay (primary for India)
  - Stripe (for international if needed)
  - PayU, CCAvenue (alternatives)

### 4.4 Dunning Management
- **Failed Payment Handling**:
  - Attempt 1: Immediate retry (after 1 hour)
  - Attempt 2: Retry after 1 day
  - Attempt 3: Retry after 3 days
  - Attempt 4: Retry after 5 days
  - After 4 fails: Mark invoice past_due, notify provider
  - After 7 days past_due: Suspend subscription services
  - After 14 days past_due: Cancel subscription
- **Communication**: Email/SMS at each retry attempt and status change
- **Manual Retry**: Provider can manually retry payment from billing history

### 4.5 Plan Management
- **Feature Flags**: Plans define which premium features are enabled
- **Usage Limits**: Optional hard/soft limits on API calls, appointments, etc.
- **Add-ons**: Optional one-time or recurring add-ons (e.g., extra storage, premium support)
- **Coupons/Discounts**: Percentage or fixed amount discounts (time-limited or forever)

## 5. API Endpoints

### 5.1 Provider-Facing APIs (Requires Provider Authentication)

#### Get Available Plans
```
GET /api/subscription/plans
Response: {
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Basic",
      "plan_code": "basic",
      "price": 999.00,
      "billing_interval": "monthly",
      "trial_period_days": 14,
      "features": ["online_appointments", "basic_analytics"],
      "limits": {"max_appointments_per_day": 30}
    },
    {
      "id": 2,
      "name": "Pro",
      "plan_code": "pro",
      "price": 2499.00,
      "billing_interval": "monthly",
      "trial_period_days": 14,
      "features": ["online_appointments", "advanced_analytics", "telemedicine"],
      "limits": {"max_appointments_per_day": 100}
    }
  ]
}
```

#### Create Subscription (Start Trial)
```
POST /api/subscription/subscribe
Body: {
  "plan_id": 2,
  "payment_method_token": "tok_visa" (optional if trial only),
  "coupon_code": "WELCOME10" (optional)
}
Response: {
  "success": true,
  "data": {
    "subscription_id": 1001,
    "status": "trial",
    "trial_end": "2026-09-08T10:30:00Z",
    "current_period_end": "2026-09-08T10:30:00Z",
    "requires_payment": false
  }
}
```

#### Get Current Subscription
```
GET /api/subscription/current
Response: {
  "success": true,
  "data": {
    "id": 1001,
    "plan": {
      "id": 2,
      "name": "Pro",
      "price": 2499.00,
      "billing_interval": "monthly"
    },
    "status": "active",
    "current_period_start": "2026-08-25T10:30:00Z",
    "current_period_end": "2026-09-25T10:30:00Z",
    "amount": 2499.00,
    "currency": "INR",
    "days_until_renewal": 31,
    "trial_ended": true
  }
}
```

#### Update Payment Method
```
POST /api/subscription/update-payment-method
Body: {
  "payment_method_token": "tok_mastercard"
}
Response: {
  "success": true,
  "message": "Payment method updated successfully"
}
```

#### Change Plan
```
POST /api/subscription/change-plan
Body: {
  "new_plan_id": 1,
  "effective_immediately": true
}
Response: {
  "success": true,
  "data": {
    "prorated_amount": 416.58,
    "effective_date": "2026-08-25T10:30:00Z",
    "next_invoice_date": "2026-09-25T10:30:00Z",
    "new_plan_id": 1
  }
}
```

#### Cancel Subscription
```
POST /api/subscription/cancel
Body: {
  "at_period_end": false,
  "feedback": "Found alternative service"
}
Response: {
  "success": true,
  "data": {
    "subscription_id": 1001,
    "status": "cancelled",
    "cancelled_at": "2026-08-25T11:00:00Z",
    "ends_at": "2026-08-25T11:00:00Z"
  }
}
```

#### Get Billing History
```
GET /api/subscription/billing-history?limit=10&offset=0
Response: {
  "success": true,
  "data": {
    "invoices": [
      {
        "id": 2001,
        "invoice_number": "INV-2026-08-001",
        "amount": 2499.00,
        "status": "paid",
        "period_start": "2026-07-25T10:30:00Z",
        "period_end": "2026-08-25T10:30:00Z",
        "paid_at": "2026-07-26T09:15:00Z",
        "payment_method": "Visa ending in 4242"
      }
    ],
    "total_count": 12,
    "has_more": true
  }
}
```

### 5.2 Admin-Facing APIs (Requires Admin Authentication)

#### Get All Subscriptions
```
GET /api/admin/subscription/subscriptions?status=active&provider_type=hospital
Response: {
  "success": true,
  "data": {
    "subscriptions": [
      {
        "id": 1001,
        "provider_id": 501,
        "provider_type": "hospital",
        "provider_name": "City Hospital",
        "plan_name": "Enterprise",
        "status": "active",
        "current_period_end": "2026-09-30T10:30:00Z",
        "amount": 9999.00,
        "created_at": "2026-01-15T14:22:00Z"
      }
    ],
    "total_count": 45,
    "page": 1,
    "per_page": 25
  }
}
```

#### Create/Update Plan
```
POST /api/admin/subscription/plans
Body: {
  "name": "Enterprise",
  "plan_code": "enterprise",
  "price": 9999.00,
  "billing_interval": "monthly",
  "trial_period_days": 30,
  "features": ["all_features", "priority_support", "custom_integrations"],
  "limits": {"max_appointments_per_day": 1000},
  "is_public": true
}
Response: {
  "success": true,
  "data": {
    "id": 3,
    "plan_code": "enterprise"
  }
}
```

#### Get Revenue Analytics
```
GET /api/admin/subscription/revenue-analytics?range=30d
Response: {
  "success": true,
  "data": {
    "mrr": 125000.00, // Monthly Recurring Revenue
    "arr": 1500000.00, // Annual Recurring Revenue
    "new_subscriptions": 12,
    "churned_subscriptions": 3,
    "expansion_revenue": 5000.00,
    "contraction_revenue": 2000.00,
    "churn_rate": 0.02,
    "avg_revenue_per_user": 833.33,
    "revenue_by_plan": [
      {"plan_name": "Basic", "mrr": 25000.00, "count": 25},
      {"plan_name": "Pro", "mrr": 50000.00, "count": 20},
      {"plan_name": "Enterprise", "mrr": 50000.00, "count": 5}
    ],
    "revenue_by_provider_type": [
      {"type": "doctor", "mrr": 60000.00},
      {"type": "hospital", "mrr": 40000.00},
      {"type": "pathlab", "mrr": 15000.00},
      {"type": "medical_store", "mrr": 10000.00}
    ]
  }
}
```

### 5.3 Payment Gateway Webhooks (Public Endpoints)

#### Razorpay Webhook
```
POST /api/subscription/webhook/razorpay
Headers: X-Razorpay-Signature: <signature>
Body: (Razorpay webhook payload)
Response: HTTP 200 OK (if processed successfully)
```

#### Stripe Webhook
```
POST /api/subscription/webhook/stripe
Headers: Stripe-Signature: <signature>
Body: (Stripe webhook payload)
Response: HTTP 200 OK
```

## 6. Integration Points

### 6.1 Provider Account System
- When provider logs in, check subscription status to enable/disable premium features
- Redirect to subscription page if subscription expired and trying to access premium feature
- Show subscription status and renewal date in provider dashboard
- Allow provider to upgrade/downgrade/cancel from account settings

### 6.2 Feature Access Control
- Middleware or helper functions to check if provider's subscription includes a feature
- Example: 
  ```php
  if ($this->subscription_helper->hasFeature($providerId, 'telemedicine')) {
      // Allow access to telemedicine module
  }
  ```
- Feature codes defined in plans (e.g., 'online_appointments', 'advanced_analytics', 'telemedicine', 'api_access')

### 6.3 Usage Enforcement (Optional)
- For plans with hard limits, enforce limits at point of use
- Example: Check appointment count against plan limit before allowing new booking
- Soft limits: Track usage and warn/provider when approaching limit

### 6.4 Communication Systems
- Integrate with email/SMS services for:
  - Trial starting/ending notifications
  - Payment success/failure receipts
  - Subscription renewal reminders
  - Plan change confirmations
  - Dunning notices
- Use templates with merge tags for personalization

### 6.5 Analytics and Reporting
- Export subscription data to data warehouse for BI
- Provide CSV/Excel export of subscriptions, invoices, payments
- Scheduled reports emailed to finance/admin
- Real-time dashboard for MRR, churn, LTV, etc.

## 7. Security Considerations

### 7.1 Data Protection
- Payment tokenization: Never store raw card details; use gateway tokens
- Encrypt sensitive fields at rest if required (subscription amounts, provider IDs)
- Mask payment details in UI (show only last 4 digits)
- Secure transmission via HTTPS for all API calls
- Protect webhook endpoints with signature verification

### 7.2 Access Control
- Provider APIs require valid provider authentication (session or JWT)
- Admin APIs require admin role or specific subscription management permissions
- Rate limiting on public endpoints (webhooks excluded from strict limits)
- Input validation and sanitization on all parameters
- CSRF protection for web forms

### 7.3 Fraud Prevention
- Implement velocity checks for payment attempts
- Use gateway-provided fraud tools (Razorpay Third Party Protection, Stripe Radar)
- Monitor for unusual patterns (multiple failed payments, rapid plan changes)
- Require CVV for new payment methods where applicable
- Manual review queue for high-risk transactions

### 7.4 Compliance
- PCI DSS compliance: Use PCI-compliant gateways, never store raw card data
- GST compliance: Calculate and display GST correctly on invoices
- Invoice numbering: Follow sequential numbering as per local regulations
- Data retention: Keep financial records for required period (8 years typically)
- Provide invoices and receipts for tax purposes

## 8. Implementation Approach

### 8.1 Phase 1: Core Subscription Management
1. Create subscription database schema
2. Implement plan CRUD operations (admin)
3. Build subscription lifecycle management (create, trial, active, cancel)
4. Develop basic provider subscription dashboard
5. Implement plan-based feature access control
6. Create basic invoicing (manual generation for now)

### 8.2 Phase 2: Payment Gateway Integration
1. Integrate primary payment gateway (Razorpay recommended for India)
2. Implement recurring payment creation via gateway subscriptions
3. Build webhook handlers for payment events
4. Develop payment retry logic for failed payments
5. Create provider payment method management
6. Implement invoice generation tied to payment attempts

### 8.3 Phase 3: Billing Automation and Dunning
1. Automate invoice generation based on billing cycles
2. Implement proration calculation for plan changes
3. Add tax calculation based on provider location
4. Build dunning management with configurable retry schedules
5. Create billing history and receipt views for providers
6. Implement payment success/failure email/SMS notifications

### 8.4 Phase 4: Analytics and Admin Features
1. Build admin dashboard for subscription overview
2. Implement revenue analytics (MRR, ARR, churn, etc.)
3. Add plan performance metrics and A/B testing capabilities
4. Create subscription search and filtering for admin
5. Implement bulk operations (e.g., apply coupon to multiple subscriptions)
6. Add data export functionality (CSV/Excel)

### 8.5 Phase 5: Refinement and Extensibility
1. Add support for multiple payment gateways with fallback
2. Implement coupon and discount management
3. Add usage tracking and limit enforcement (if required)
4. Build provider portal for self-service billing management
5. Add multi-currency support (with exchange rate service)
6. Extend to support add-ons and one-time charges
7. Implement advanced dunning with collections integration
8. Performance optimization and load testing
9. Security audit and penetration testing
10. Documentation and training materials

## 8. Configuration

### 8.1 Subscription Configuration File (`admin1947/application/config/subscription.php`)
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['subscription'] = [
    // General Settings
    'version' => '1.0.0',
    'environment' => 'development',
    'currency' => 'INR',
    'default_timezone' => 'Asia/Kolkata',
    
    // Billing Cycles
    'invoice_generation_days_before' => 3, // Generate invoice 3 days before period start
    'grace_period_days' => 7, // Days after due date before marking past_due
    'max_payment_attempts' => 4, // Number of retry attempts for failed payments
    'retry_intervals' => [1, 1, 3, 5], // Days between attempts [hour1, day1, day3, day5]
    
    // Trial Settings
    'auto_convert_trial' => true, // Automatically convert trial to paid
    'require_payment_for_trial' => false, // Require payment method upfront for trial
    
    // Plan Settings
    'allow_plan_downgrade' => true,
    'proration_on_plan_change' => true,
    'proration_billing_cycle_anchor' => 'start', // or 'end'
    
    // Payment Gateway Settings
    'default_gateway' => 'razorpay',
    'gateways' => [
        'razorpay' => [
            'enabled' => true,
            'api_key' => '', // Set via environment variable
            'api_secret' => '', // Set via environment variable
            'webhook_secret' => '' // Set via environment variable
        ],
        'stripe' => [
            'enabled' => false,
            'api_key' => '',
            'webhook_secret' => ''
        ]
    ],
    
    // Tax Settings (India GST example)
    'tax_calculation' => [
        'enabled' => true,
        'default_rate' => 0.18, // 18% GST
        'hsn_code' => '998313', // IT Services
        'sac_code' => '998313'
    ],
    
    // Notification Settings
    'notifications' => [
        'trial_starting' => ['enabled' => true, 'days_before' => 3],
        'trial_ending' => ['enabled' => true, 'days_before' => 1, 'hours_before' => 24],
        'payment_success' => ['enabled' => true],
        'payment_failed' => ['enabled' => true, 'attempt' => 1], // Notify on each attempt
        'subscription_renewed' => ['enabled' => true],
        'subscription_cancelled' => ['enabled' => true],
        'plan_changed' => ['enabled' => true]
    ],
    
    // Usage Limits (if enabling hard limits)
    'usage_enforcement' => [
        'enabled' => false, // Set to true to enforce hard limits
        'buffer_percentage' => 0.10 // Allow 10% over limit before blocking
    ],
    
    // Analytics & Reporting
    'analytics' => [
        'mrr_calculation_day' => 1, // Day of month to calculate MRR snapshot
        'retention_period_days' => 1095 // Keep detailed records for 3 years
    ]
];
```

## 9. Testing Strategy

### 9.1 Unit Testing
- Test plan creation, validation, and retrieval
- Test subscription lifecycle transitions (trial → active → cancelled)
- Test proration calculations for various scenarios
- Test invoice generation and tax calculations
- Test payment success/failure handling
- Test dunning retry logic
- Test webhook signature verification
- Test feature access control logic

### 9.2 Integration Testing
- Test end-to-end subscription flow: sign up → trial → payment → active → renewal
- Test plan change scenarios with proration
- Test cancellation at period end vs immediate
- Test payment gateway integration (using test modes)
- Test webhook processing for various events
- Test provider self-service portal flows
- Test admin dashboard and bulk operations
- Test integration with feature access control

### 9.3 Performance Testing
- Load test subscription creation (100+/minute)
- Test invoice generation batch processing (1000+ subscriptions)
- Test payment retry simulation under load
- Test API response times for subscription queries (<200ms)
- Test webhook processing latency and throughput
- Database query optimization for subscription listings

### 9.4 User Acceptance Testing
- Simulate real provider scenarios:
  - New provider signs up for trial
  - Provider upgrades mid-cycle
  - Provider experiences payment failure and retries
  - Provider cancels subscription
  - Admin views revenue reports and manages plans
- Validate email/SMS notifications content and timing
- Verify invoice PDF generation and formatting
- Test multi-provider type scenarios (doctor, hospital, etc.)

### 9.5 Edge Case Testing
- Handle subscription with zero amount (100% discount)
- Test trial conversion when payment method fails
- Test plan change from free to paid and vice versa
- Test cancellation during trial period
- Test multiple failed payments leading to suspension
- Test subscription with very long billing interval (yearly)
- Test leap year and timezone handling in billing cycles
- Test concurrent subscription modifications
- Test currency conversion if multi-currency enabled

## 10. Deployment & Monitoring

### 10.1 Deployment Strategy
- Blue-green deployment for zero downtime
- Database migrations backward compatible (additive changes preferred)
- Feature flags for gradual rollout of new payment gateways
- Rollback procedures: disable new features, revert code, restore DB if needed
- Use environment variables for secrets (API keys, webhook secrets)
- Database backup before schema changes

### 10.2 Monitoring & Alerting
- **Key Metrics**:
  - Subscription creation rate
  - Monthly Recurring Revenue (MRR) growth
  - Churn rate and cancellation reasons
  - Payment success rate and average retry attempts
  - Invoice generation latency
  - Webhook processing success rate
  - Dunning workflow efficiency (time to resolve failed payments)
  
- **Alerting Thresholds**:
  - Payment success rate < 95% for 15+ minutes
  - Churn rate sudden increase > 20% week-over-week
  - Failed payment rate > 5% in hour
  - Webhook failure rate > 10% for 10+ minutes
  - Subscription creation failure rate > 2%
  
- **Health Checks**:
  - Payment gateway connectivity and API responsiveness
  - Database connectivity and subscription query performance
  - Webhook endpoint accessibility
  - Email/SMS service connectivity
  - Cache hit ratio (if using Redis)

### 10.3 Logging Strategy
- **Application Logs**: Structured JSON logging for subscription operations
- **Payment Logs**: Detailed payment gateway interactions (tokenized)
- **Webhook Logs**: Incoming webhook payloads and processing results
- **Dunning Logs**: Failed payment attempts and recovery actions
- **Audit Logs**: All subscription state changes for compliance
- **Billing Logs**: Invoice generation and payment attempt records
- **Security Logs**: Authentication failures, validation errors, potential fraud attempts

## 11. Future Enhancements

### 11.1 Short-Term (Phase 5)
- Multiple payment gateway support with intelligent routing
- Coupon and discount management system
- Usage-based billing (pay-per-use) for specific features
- Add-on management (recurring and one-time charges)
- Multi-currency support with automatic exchange rate updates
- Tax calculation for international VAT/GST compliance
- Revenue recognition automation (ASCII 606)

### 11.2 Medium-Term (Phase 6+)
- Self-service provider portal with advanced account management
- Integration with accounting software (Tally, QuickBooks, Zoho Books)
- Automated tax filing integration (GSTN APIs)
- Customer portal for patients to view provider subscription status
- Affiliate/referral program tracking and rewards
- Subscription analytics forecasting and LTV prediction
- Trial abuse prevention and fraud detection ML models

### 11.3 Long-Term (Research)
- Dynamic pricing based on demand and provider usage patterns
- Integration with procurement systems for medical supplies
- Embedded finance offerings (working capital loans based on subscription revenue)
- Blockchain-based subscription smart contracts for transparency
- AI-powered churn prediction and intervention recommendations
- Subscription marketplace for third-party add-ons and integrations

## 12. Compliance & Standards

### 12.1 Payment Standards
- PCI DSS Level 1 compliance through validated payment gateways
- 3D Secure 2.0 support for authentication
- EMVCo tokenization standards for payment methods
- NACHA standards for ACH/bank transfers (if applicable)
- SEPA for Euro transactions (if expanding internationally)

### 12.2 Tax & Accounting Standards
- GST compliance for Indian taxation (GSTR-1, GSTR-3B reporting)
- TDS compliance where applicable
- Invoice format as per GST regulations (HSN/SAC codes, place of supply)
- Revenue recognition principles (IFRS 15 / ASC 606)
- Audit trail requirements for financial transactions
- Electronic invoicing standards (where mandated)

### 12.3 Data Protection Standards
- GDPR compliance for EU providers (if applicable)
- India's Personal Data Protection Bill principles (when enacted)
- ISO 27001 for information security management
- SOC 2 Type II for security, availability, confidentiality
- ISO 27701 for privacy information management
- ePrivacy Directive for electronic communications

### 12.4 Healthcare Specific
- No direct handling of PHI in subscription module (focus on business relationship)
- Ensure subscription data does not inadvertently expose patient information
- Compliance with healthcare business associate agreements (if applicable)
- Separation of concerns: subscription data vs clinical data

---
*Document Version: 1.0*
*Last Updated: 2026-08-25*
*Next Review Date: 2026-09-25*