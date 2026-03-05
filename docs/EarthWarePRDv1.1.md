# EarthWare

## Stone Slab Wholesale & Import Management Platform

### Product Requirements Document

**Version:** 1.1  
**Date:** February 2026  
**Status:** Draft  
**Technology Stack:** Laravel 12, Inertia.js, React 19, React Aria Components + shadcn/ui, PostgreSQL 18

---

## Table of Contents

1. [Executive Summary](#1-executive-summary)
2. [Product Overview](#2-product-overview)
3. [Inventory Management Module](#3-inventory-management-module)
4. [Purchasing and Import Module](#4-purchasing-and-import-module)
5. [Sales and Orders Module](#5-sales-and-orders-module)
6. [Customer Management Module](#6-customer-management-module)
7. [Customer Portal Module](#7-customer-portal-module)
8. [Warehouse Operations Module](#8-warehouse-operations-module)
9. [Financial Tracking Module](#9-financial-tracking-module)
10. [Reporting and Analytics Module](#10-reporting-and-analytics-module)
11. [User Management and Security](#11-user-management-and-security)
12. [Technical Requirements](#12-technical-requirements)
13. [Development Phases](#13-development-phases)
14. [Database Schema Overview](#14-database-schema-overview)
15. [Appendix](#15-appendix)

---

## 1. Executive Summary

### 1.1 Purpose

EarthWare is a comprehensive web-based enterprise resource planning (ERP) and customer relationship management (CRM) platform purpose-built for stone slab wholesale and import businesses. The platform addresses the unique operational challenges of managing natural stone, quartz, and engineered stone inventory while providing robust tools for customer management, sales operations, purchasing, and financial tracking.

### 1.2 Business Context

The natural stone distribution industry faces unique challenges not adequately addressed by generic ERP solutions. Each slab is a unique item with individual characteristics (dimensions, veining, color variation, quality grade) that must be tracked individually rather than as fungible inventory units. Additionally, the import process involves complex landed cost calculations across containers, and the sales process requires sophisticated hold management and customer relationship tracking.

### 1.3 Target Users

- **Primary:** Stone slab wholesale distributors and importers
- **Secondary:** Multi-location stone yards with warehousing operations
- **Tertiary:** Stone fabricators with significant inventory operations

### 1.4 Key Value Propositions

- **Individual Slab Tracking:** Track each slab as a unique inventory item with full lifecycle visibility
- **Landed Cost Accuracy:** Precise cost allocation from container to individual slab
- **Hold Management:** Sophisticated reservation system with time limits, deposits, and status tracking
- **Customer Intelligence:** CRM tailored to stone industry customer types and buying patterns
- **Multi-Location Support:** Manage inventory across multiple warehouses and consignment locations
- **Customer Dashboard:** Dedicated customer dashboard supporting order-management and communication features

---

## 2. Product Overview

### 2.1 System Architecture

EarthWare is built as a modern single-page application (SPA) utilizing the Laravel framework for backend operations combined with Inertia.js and React for a seamless frontend experience. The application follows a modular architecture allowing for future expansion and customization.

#### 2.1.1 Technology Stack

| Layer              | Technology                                       | Purpose                                     |
|--------------------|--------------------------------------------------|---------------------------------------------|
| Backend Framework  | Laravel 12                                       | API, business logic, authentication, queues |
| Frontend Bridge    | Inertia.js 2.0                                   | SPA without API complexity                  |
| Frontend Framework | React 19                                         | Component-based UI                          |
| UI Components      | React Aria Components + shadcn/ui + Tailwind CSS | Consistent, accessible design system        |
| Database           | PostgreSQL 18                                    | Relational data storage with JSON support   |
| Cache              | Redis                                            | Session management, caching, queues         |
| Search             | Laravel Scout + Typesense                        | Fast full-text search                       |
| File Storage       | S3-compatible                                    | Slab images, documents                      |
| PDF Generation     | Gotenberg + gotenberg-php                        | Document generation                         |
| Multi-Tenancy      | Tenancy for Laravel (stancl/tenancy)             | Facilitate multi-tenant data isolation      |

### 2.2 Core Modules Overview

The platform consists of eight core modules(domains) that work together to provide comprehensive business management capabilities:

| Module                | Primary Function          | Key Features                                             |
|-----------------------|---------------------------|----------------------------------------------------------|
| Inventory Management  | Track slabs and products  | Individual slab records, locations, status, images       |
| Purchasing & Import   | Manage procurement        | POs, container tracking, landed cost calculation         |
| Sales & Orders        | Process customer orders   | Quotes, holds, sales orders, invoices                    |
| Customer Management   | CRM functionality         | Customer profiles, tiers, history, communications        |
| Customer Portal       | Customer self-service     | Inventory browsing, hold requests, messaging, deliveries |
| Warehouse Operations  | Physical operations       | Receiving, transfers, picks, cycle counts                |
| Financial Tracking    | Revenue and cost tracking | AR/AP tracking, payment processing, reporting            |
| Reporting & Analytics | Business intelligence     | Dashboards, custom reports, KPIs                         |

---

## 3. Inventory Management Module

The Inventory Management module is the foundation of EarthWare, providing comprehensive tracking of individual stone slabs from receipt through sale.

### 3.1 Slab Data Model

Each slab record captures extensive information to support sales, operations, and financial reporting.

#### 3.1.1 Core Slab Attributes

| Attribute      | Type           | Description                                         | Required |
|----------------|----------------|-----------------------------------------------------|----------|
| Slab ID        | String (auto)  | Unique system identifier                            | Yes      |
| Bundle Number  | String         | Manufacturer bundle/lot identifier                  | Yes      |
| Slab Number    | Integer        | Position within bundle (1, 2, 3...)                 | Yes      |
| Material Type  | Enum           | Granite, Marble, Quartzite, Quartz, Porcelain, etc. | Yes      |
| Material Name  | String         | Commercial name (e.g., Calacatta Gold)              | Yes      |
| Color Family   | Enum           | White, Black, Gray, Beige, Brown, Blue, Green, etc. | Yes      |
| Finish         | Enum           | Polished, Honed, Leathered, Brushed, Flamed         | Yes      |
| Thickness      | Decimal        | Thickness in cm (2cm, 3cm, etc.)                    | Yes      |
| Length         | Decimal        | Length in inches or cm                              | Yes      |
| Width          | Decimal        | Width in inches or cm                               | Yes      |
| Square Footage | Decimal (calc) | Calculated from L · W                               | Auto     |
| Quality Grade  | Enum           | Premium, Standard, Commercial, Remnant              | Yes      |
| Origin Country | String         | Country of quarry origin                            | No       |
| Quarry Name    | String         | Specific quarry if known                            | No       |

#### 3.1.2 Financial Attributes

| Attribute     | Type           | Description                        |
|---------------|----------------|------------------------------------|
| FOB Cost      | Decimal        | Free on board cost from supplier   |
| Freight Cost  | Decimal        | Allocated shipping cost            |
| Duty Cost     | Decimal        | Allocated import duties            |
| Other Costs   | Decimal        | Insurance, handling, storage, etc. |
| Landed Cost   | Decimal (calc) | Total cost to warehouse            |
| Cost Per SqFt | Decimal (calc) | Landed cost · square footage       |
| List Price    | Decimal        | Standard selling price per sqft    |
| Minimum Price | Decimal        | Floor price per sqft               |

#### 3.1.3 Status and Location

| Attribute            | Type        | Description                                                  |
|----------------------|-------------|--------------------------------------------------------------|
| Status               | Enum        | Available, On Hold, Reserved, Sold, In Transit, Cut/Consumed |
| Location             | Foreign Key | Current warehouse/yard location                              |
| Bin/Slot             | String      | Physical position identifier (e.g., A-15-3)                  |
| Consignment Location | Foreign Key | If placed at customer location                               |
| Container ID         | Foreign Key | Source container for imports                                 |

#### 3.1.4 Media and Documentation

| Attribute       | Type              | Description                                |
|-----------------|-------------------|--------------------------------------------|
| Primary Image   | URL/File          | Main slab photograph                       |
| Gallery Images  | Array&lt;URL&gt;  | Additional photos showing veining, defects |
| SlabSmith Image | URL/File          | Digital layout image if applicable         |
| Certifications  | Array&lt;File&gt; | Quality certs, test results                |
| Notes           | Text              | Internal notes about the slab              |

### 3.2 Slab Status Workflow

Slabs progress through defined statuses that control availability and trigger business rules:

| Status       | Description                                  | Available for Sale | Triggers             |
|--------------|----------------------------------------------|--------------------|----------------------|
| In Transit   | Slab in shipping container, not yet received | No                 | Container created    |
| Available    | In warehouse, ready for sale                 | Yes                | Receiving completed  |
| On Hold      | Reserved for customer consideration          | No                 | Hold created         |
| Reserved     | Committed to confirmed order                 | No                 | Order confirmed      |
| Sold         | Invoiced and paid/terms agreed               | No                 | Invoice generated    |
| Cut/Consumed | Physically removed from inventory            | No                 | Delivery confirmed   |
| Returned     | Returned by customer, pending inspection     | No                 | Return processed     |
| Damaged      | Cannot be sold as-is                         | No                 | Damage reported      |
| Consigned    | At customer location on consignment          | Conditional        | Consignment transfer |

### 3.3 Bundle Management

Bundles are groups of slabs cut from the same block, sharing visual characteristics. EarthWare tracks bundles to support bookmatching and vein-matching sales.

- **Bundle Integrity:** Visual indicator when bundle slabs are separated across locations
- **Sequential Tracking:** Maintain slab order within bundle for bookmatching
- **Bundle Pricing:** Option to price entire bundle vs individual slabs
- **Bundle Discounts:** Incentivize full bundle purchases

### 3.4 Multi-Location Inventory

#### 3.4.1 Location Types

| Type                 | Description                              | Inventory Ownership |
|----------------------|------------------------------------------|---------------------|
| Primary Warehouse    | Main distribution facility               | Company owned       |
| Secondary Warehouse  | Additional company facilities            | Company owned       |
| Consignment Location | Customer premises with company inventory | Company owned       |
| In Transit           | Between locations or inbound             | Company owned       |

#### 3.4.2 Location Attributes

| Attribute         | Type    | Description                        |
|-------------------|---------|------------------------------------|
| Location ID       | Auto    | Unique identifier                  |
| Name              | String  | Display name                       |
| Type              | Enum    | Warehouse, Yard, Consignment       |
| Address           | Object  | Full address details               |
| Contact           | Object  | Primary contact information        |
| Bin Configuration | JSON    | Layout of storage bins/slots       |
| Active            | Boolean | Whether location accepts inventory |

### 3.5 Product Inventory (Non-Slab)

In addition to slabs, distributors often sell related products tracked as traditional SKU-based inventory:

- **Sinks:** Undermount, vessel, farmhouse styles
- **Edge Profiles:** Pre-fabricated edge pieces
- **Installation Materials:** Adhesives, sealers, support brackets
- **Samples:** Sample pieces for customer selection

### 3.6 Inventory Search and Filtering

Powerful search capabilities enable quick location of specific slabs:

| Filter Type   | Options                          | Use Case                     |
|---------------|----------------------------------|------------------------------|
| Text Search   | Material name, bundle #, slab ID | Quick lookup                 |
| Material Type | Multi-select checkboxes          | Browse by category           |
| Color Family  | Color swatches/chips             | Customer preference matching |
| Thickness     | 2cm, 3cm, other                  | Project requirements         |
| Size Range    | Min/max length and width         | Large project needs          |
| Price Range   | Slider or input fields           | Budget filtering             |
| Status        | Multi-select                     | Availability check           |
| Location      | Dropdown or multi-select         | Logistics planning           |
| Quality Grade | Multi-select                     | Application matching         |
| Arrival Date  | Date range picker                | New inventory discovery      |

---

## 4. Purchasing and Import Module

The Purchasing module manages the complete procurement lifecycle from vendor management through container receipt and cost allocation.

### 4.1 Supplier Management

#### 4.1.1 Supplier Profile

| Attribute     | Type                 | Description                     |
|---------------|----------------------|---------------------------------|
| Supplier ID   | Auto                 | Unique identifier               |
| Company Name  | String               | Legal business name             |
| Trade Name    | String               | DBA if different                |
| Country       | String               | Country of operation            |
| Payment Terms | Enum                 | Net 30, Net 60, COD, LC, etc.   |
| Currency      | Enum                 | Default transaction currency    |
| Tax ID        | String               | VAT or tax identification       |
| Contacts      | Array&lt;Contact&gt; | Multiple contact persons        |
| Addresses     | Array&lt;Address&gt; | Factory, port, office addresses |
| Bank Details  | Encrypted Object     | Wire transfer information       |
| Notes         | Text                 | Internal notes                  |
| Active        | Boolean              | Whether to show in dropdowns    |

#### 4.1.2 Supplier Performance Tracking

- Order history and volume
- On-time delivery rate
- Quality issue frequency
- Price competitiveness
- Communication responsiveness

### 4.2 Purchase Orders

#### 4.2.1 Purchase Order Workflow

| Status             | Description             | Next Actions         |
|--------------------|-------------------------|----------------------|
| Draft              | PO being prepared       | Edit, Submit, Cancel |
| Submitted          | Sent to supplier        | Confirm, Cancel      |
| Confirmed          | Supplier accepted       | Receive, Cancel      |
| Partially Received | Some items received     | Receive more, Close  |
| Received           | All items received      | Close                |
| Closed             | Complete and reconciled | View only            |
| Cancelled          | Order cancelled         | View only            |

#### 4.2.2 Purchase Order Structure

| Section    | Fields                                 | Purpose              |
|------------|----------------------------------------|----------------------|
| Header     | PO #, Date, Supplier, Terms, Currency  | Basic identification |
| Shipping   | Incoterms, Port, Container size, ETA   | Logistics details    |
| Line Items | Material, Qty, Unit, Unit Price, Total | What's being ordered |
| Costs      | FOB, Freight, Duty, Insurance, Other   | Cost breakdown       |
| Notes      | Internal notes, Supplier instructions  | Communication        |
| Documents  | PI, Packing list, BL, Certificates     | Supporting files     |

### 4.3 Container Management

For import operations, containers are the primary receiving unit. EarthWare provides comprehensive container tracking from booking through receipt.

#### 4.3.1 Container Data Model

| Attribute         | Type        | Description                      |
|-------------------|-------------|----------------------------------|
| Container Number  | String      | Shipping container ID            |
| PO Reference      | Foreign Key | Linked purchase order(s)         |
| Container Size    | Enum        | 20ft, 40ft, 40ft HC              |
| Seal Number       | String      | Security seal number             |
| Vessel Name       | String      | Ship name                        |
| Voyage Number     | String      | Voyage identifier                |
| Port of Loading   | String      | Origin port                      |
| Port of Discharge | String      | Destination port                 |
| ETD               | Date        | Estimated departure              |
| ETA               | Date        | Estimated arrival                |
| Actual Arrival    | Date        | When container arrived           |
| Customs Status    | Enum        | Pending, Cleared, Held, Released |
| Delivery Date     | Date        | When delivered to warehouse      |

#### 4.3.2 Container Status Tracking

| Status                | Description                | Trigger               |
|-----------------------|----------------------------|-----------------------|
| Booked                | Container reserved         | PO confirmed          |
| Loaded                | Material loaded at origin  | Packing list received |
| In Transit            | On vessel                  | BL received           |
| Arrived at Port       | At destination port        | Vessel arrival        |
| Customs Hold          | Awaiting customs clearance | Manual or API         |
| Customs Cleared       | Released from customs      | Clearance docs        |
| In Transit (Domestic) | En route to warehouse      | Pickup confirmed      |
| Delivered             | At warehouse               | Delivery confirmed    |
| Received              | Inventory checked in       | Receiving complete    |

### 4.4 Landed Cost Calculation

Accurate landed cost calculation is critical for pricing decisions and profitability analysis. EarthWare allocates all costs to individual slabs.

#### 4.4.1 Cost Components

| Cost Type          | Typical Allocation Method   | Example              |
|--------------------|-----------------------------|----------------------|
| FOB/FCA Cost       | Direct to each slab         | $500 per slab        |
| Ocean Freight      | By container, then by sqft  | $8,000 Ã· total sqft |
| Import Duty        | By value (ad valorem)       | 6% of FOB value      |
| Customs Brokerage  | Per container, then by sqft | $350 Ã· total sqft   |
| Insurance          | By value or flat            | 0.5% of total value  |
| Drayage            | Per container, then by sqft | $800 Ã· total sqft   |
| Handling/Unloading | Per container or per slab   | $200 Ã· slab count   |
| Storage (if any)   | Per day per sqft            | Pre-delivery storage |

#### 4.4.2 Allocation Methods

- **By Square Footage:** Most common; allocates based on each slab's proportion of total container sqft
- **By Value:** Used for duties; allocates based on FOB value proportion
- **By Weight:** Alternative for freight when weight-based
- **By Unit Count:** For handling costs that are per-piece
- **Fixed Per Unit:** Direct assignment when cost is per-slab

### 4.5 Receiving Process

The receiving process verifies container contents against documentation and creates inventory records.

#### 4.5.1 Receiving Workflow

1. **Container Arrival:** Record actual arrival date, check seal integrity
2. **Unload and Count:** Verify slab count against packing list
3. **Measure and Inspect:** Verify dimensions, check for damage, grade quality
4. **Photograph:** Capture images of each slab
5. **Label:** Print and apply barcode/QR labels
6. **Bin Assignment:** Assign storage location
7. **Discrepancy Handling:** Report damage, shortages, overages
8. **Finalize:** Apply landed costs, make inventory available

---

## 5. Sales and Orders Module

The Sales module manages the complete customer transaction lifecycle from initial quote through invoice and payment.

### 5.1 Quote Management

Quotes provide customers with pricing information without reserving inventory.

#### 5.1.1 Quote Structure

| Section    | Contents                                   | Purpose             |
|------------|--------------------------------------------|---------------------|
| Header     | Quote #, Date, Expiry, Customer, Sales Rep | Identification      |
| Line Items | Slab(s), Qty, Price/sqft, Line Total       | What's being quoted |
| Totals     | Subtotal, Tax, Delivery, Total             | Financial summary   |
| Terms      | Payment terms, validity period             | Conditions          |
| Notes      | Special instructions, disclaimers          | Communication       |

#### 5.1.2 Quote Workflow

| Status   | Description                              | Duration                      |
|----------|------------------------------------------|-------------------------------|
| Draft    | Being prepared                           | Unlimited                     |
| Sent     | Delivered to customer                    | Configurable (default 7 days) |
| Expired  | Past validity date                       | N/A                           |
| Accepted | Customer accepted, convert to hold/order | N/A                           |
| Declined | Customer declined                        | N/A                           |
| Revised  | New version created                      | N/A                           |

### 5.2 Hold Management

The hold system is critical for stone sales, allowing customers to reserve slabs while making final decisions. Effective hold management prevents lost sales while avoiding indefinite inventory locks.

#### 5.2.1 Hold Types

| Type          | Description                     | Typical Duration   | Requirements    |
|---------------|---------------------------------|--------------------|-----------------|
| Courtesy Hold | No commitment, first-come basis | 24-48 hours        | None            |
| Standard Hold | Soft reservation                | 3-7 days           | Contact info    |
| Deposit Hold  | Secured with payment            | 14-30 days         | Deposit payment |
| Project Hold  | For specified project           | Until project date | Project details |
| Builder Hold  | Volume/account holder           | Per agreement      | Account terms   |

#### 5.2.2 Hold Data Model

| Attribute      | Type                     | Description                          |
|----------------|--------------------------|--------------------------------------|
| Hold ID        | Auto                     | Unique identifier                    |
| Customer       | Foreign Key              | Customer placing hold                |
| Slabs          | Array&lt;Foreign Key&gt; | Slabs being held                     |
| Hold Type      | Enum                     | See hold types above                 |
| Created Date   | DateTime                 | When hold was placed                 |
| Expiry Date    | DateTime                 | When hold expires                    |
| Deposit Amount | Decimal                  | If deposit-backed                    |
| Deposit Status | Enum                     | Pending, Received, Refunded, Applied |
| Status         | Enum                     | Active, Expired, Converted, Released |
| Notes          | Text                     | Project name, special instructions   |
| Created By     | Foreign Key              | Sales rep who created                |
| Reminder Sent  | Boolean                  | Whether expiry reminder sent         |

#### 5.2.3 Hold Workflow

- **Creation:** Sales rep creates hold, slabs status changes to 'On Hold'
- **Portal Request:** Customer submits hold request via portal; sales rep reviews and approves/declines (see Section 7.5)
- **Extension:** Hold can be extended (with limits based on type)
- **Reminder:** Automated reminder sent 24 hours before expiry
- **Expiration:** If not converted, slabs return to 'Available'
- **Conversion:** Hold converts to sales order, deposit applied
- **Release:** Manual release by rep or customer cancellation

### 5.3 Sales Orders

Sales orders represent confirmed customer purchases ready for fulfillment.

#### 5.3.1 Sales Order Structure

| Section    | Contents                                                    |
|------------|-------------------------------------------------------------|
| Header     | Order #, Date, Customer, Ship-to, Bill-to, Sales Rep, Terms |
| Line Items | Slabs with pricing, products, delivery charges              |
| Pricing    | List price, discounts, net price per item                   |
| Totals     | Subtotal, discounts, tax, delivery, total                   |
| Payment    | Terms, deposits applied, balance due                        |
| Delivery   | Requested date, delivery method, instructions               |
| Documents  | Linked quotes, holds, signed contracts                      |

#### 5.3.2 Sales Order Workflow

| Status                    | Description              | Slab Status            |
|---------------------------|--------------------------|------------------------|
| Draft                     | Order being prepared     | On Hold (if from hold) |
| Confirmed                 | Customer confirmed       | Reserved               |
| Ready for Pickup/Delivery | Prepared for fulfillment | Reserved               |
| Partially Shipped         | Some items delivered     | Mixed                  |
| Shipped/Delivered         | All items delivered      | Sold                   |
| Invoiced                  | Invoice generated        | Sold                   |
| Closed                    | Payment complete         | Cut/Consumed           |
| Cancelled                 | Order cancelled          | Available              |

### 5.4 Invoicing

#### 5.4.1 Invoice Generation

- **From Sales Order:** Generate invoice from confirmed order
- **Direct Invoice:** Create invoice without order for simple transactions
- **Partial Invoice:** Invoice subset of order (partial shipments)
- **Progress Billing:** Multiple invoices against same order

#### 5.4.2 Invoice Data

| Field                | Description                         |
|----------------------|-------------------------------------|
| Invoice Number       | Unique, sequential identifier       |
| Invoice Date         | Date of issuance                    |
| Due Date             | Payment due date (from terms)       |
| PO Number            | Customer's PO reference             |
| Line Items           | Description, quantity, price, total |
| Tax Calculation      | Tax rate and amount                 |
| Terms                | Payment terms text                  |
| Payment Instructions | How to pay (check, wire, card)      |

### 5.5 Pricing Engine

#### 5.5.1 Price Determination Hierarchy

1. **Customer-Specific Price:** Negotiated price for specific customer
2. **Customer Tier Price:** Price based on customer's tier/category
3. **Volume Price:** Discounted price for quantity purchases
4. **Promotional Price:** Time-limited special pricing
5. **List Price:** Standard published price

#### 5.5.2 Pricing Models

| Model           | Description                    | Use Case                       |
|-----------------|--------------------------------|--------------------------------|
| Per Square Foot | Price Ã— total sqft of slab    | Most common, industry standard |
| Per Slab        | Fixed price regardless of size | Remnants, promotions           |
| Per Bundle      | Price for complete bundle      | Incentivize bundle purchases   |
| Tiered          | Price decreases with volume    | Volume customers               |

---

## 6. Customer Management Module

The CRM module provides comprehensive customer relationship management tailored to the stone distribution industry's unique customer types and sales patterns.

### 6.1 Customer Types

| Type             | Description                     | Typical Terms         | Volume      |
|------------------|---------------------------------|-----------------------|-------------|
| Fabricator       | Countertop manufacturers        | Net 30, account       | High        |
| Builder          | Residential/commercial builders | Net 30-60, by project | Medium-High |
| Designer         | Interior designers              | COD or Net 15         | Low-Medium  |
| Retail/Homeowner | End consumers                   | COD, credit card      | Low         |
| Contractor       | General contractors             | Net 30                | Medium      |
| Architect        | Design professionals            | By project            | Low-Medium  |

### 6.2 Customer Profile

#### 6.2.1 Core Customer Data

| Attribute       | Type        | Description                      |
|-----------------|-------------|----------------------------------|
| Customer ID     | Auto        | Unique identifier                |
| Company Name    | String      | Business name                    |
| Customer Type   | Enum        | See customer types               |
| Tier/Level      | Enum        | Platinum, Gold, Silver, Standard |
| Tax Exempt      | Boolean     | Whether tax exempt               |
| Tax ID          | String      | Resale certificate number        |
| Payment Terms   | Enum        | Default payment terms            |
| Credit Limit    | Decimal     | Maximum AR allowed               |
| Price Level     | Foreign Key | Default pricing tier             |
| Sales Rep       | Foreign Key | Assigned salesperson             |
| Referral Source | String      | How they found you               |
| Active          | Boolean     | Active customer flag             |

#### 6.2.2 Contact Management

- **Multiple Contacts:** Owner, buyer, accounts payable, site contact
- **Contact Roles:** Primary, billing, shipping, decision maker
- **Communication Preferences:** Email, phone, text preferences
- **Portal Access:** Which contacts can access customer portal

#### 6.2.3 Address Management

- **Billing Address:** Where invoices are sent
- **Shipping Addresses:** Multiple delivery locations
- **Showroom/Shop Location:** For fabricators, their facility address

### 6.3 Customer Tiers

Customer tiers provide differentiated service levels and pricing:

| Tier     | Criteria                | Benefits                                     |
|----------|-------------------------|----------------------------------------------|
| Platinum | >$500K annual, 5+ years | Best pricing, extended terms, priority holds |
| Gold     | >$200K annual, 2+ years | Preferred pricing, Net 45, extended holds    |
| Silver   | >$50K annual, 1+ year   | Standard pricing, Net 30                     |
| Standard | All others              | List pricing, COD or credit card             |

### 6.4 Customer Activity Tracking

#### 6.4.1 Transaction History

- All quotes, holds, orders, invoices
- Payment history and aging
- Returns and credits
- Lifetime value calculation

#### 6.4.2 Interaction Log

- Phone calls (notes and outcomes)
- Emails sent and received
- Showroom visits
- Material selections viewed
- Follow-up tasks and reminders

#### 6.4.3 Preference Tracking

- Preferred materials and colors
- Price sensitivity
- Typical order size
- Delivery preferences

### 6.5 Customer Portal

The Customer Portal is a major module detailed in its own section. See [Section 7: Customer Portal Module](#7-customer-portal-module) for comprehensive requirements covering portal access models, inventory browsing, hold requests, messaging, delivery scheduling, and the fabricator-to-end-customer sub-portal.

---

## 7. Customer Portal Module

The Customer Portal provides a dedicated, customer-facing interface that enables fabricators, builders, designers, and their end customers to interact with the wholesaler's inventory and operations through a self-service experience. The portal is a distinct application surface with its own authentication, navigation, and feature set — separate from the internal EarthWare admin interface.

### 7.1 Portal Access Model

#### 7.1.1 Account Hierarchy

The portal uses a three-tier access hierarchy that mirrors the stone industry's supply chain:

| Tier               | User Type                                     | Invited By               | Description                                                                              |
|--------------------|-----------------------------------------------|--------------------------|------------------------------------------------------------------------------------------|
| Wholesaler (Admin) | Internal staff                                | N/A                      | Manages all portal accounts, controls inventory visibility and pricing                   |
| Trade Customer     | Fabricators, builders, designers, contractors | Wholesaler               | Direct customers with trade accounts; can browse inventory, request holds, manage orders |
| End Customer       | Homeowners, retail buyers                     | Fabricator or Wholesaler | Project-specific access; limited feature set scoped to their fabricator's selections     |

#### 7.1.2 Invitation and Onboarding

Portal accounts are created exclusively through invitation — there is no self-registration.

- **Wholesaler invites Trade Customers:** Admin or sales rep sends email invitation to a customer contact. The invitation links the portal account to an existing customer record in EarthWare. Multiple contacts per customer can receive separate portal credentials with individually configurable permissions.
- **Fabricators invite End Customers:** Fabricators with portal access can invite their own end customers (homeowners) into a scoped sub-portal. The fabricator controls which slabs the end customer can see, the pricing displayed, and the level of interaction allowed. This lets fabricators use EarthWare as a customer-facing selection tool for their own business.
- **Invitation Workflow:** Invitation email → Account creation (name, email, password) → Email verification → First login with guided tour/onboarding.
- **Account Deactivation:** Wholesaler can deactivate any trade customer portal account. Fabricators can deactivate their own end customer accounts. Deactivated accounts lose access immediately but historical data is preserved.

#### 7.1.3 Portal Authentication

- Email/password authentication with optional 2FA
- Session timeout configurable by wholesaler (default: 8 hours)
- Password reset via email
- SSO integration (future consideration)

### 7.2 Inventory Browsing

#### 7.2.1 Inventory Visibility Controls

The wholesaler controls what each customer sees in the portal:

| Control                | Description                                         | Configured By                       |
|------------------------|-----------------------------------------------------|-------------------------------------|
| Material Visibility    | Which material types/names are browsable            | Wholesaler (global or per-customer) |
| Status Filter          | Only slabs with 'Available' status shown by default | System default                      |
| Location Filter        | Optionally restrict to specific warehouse locations | Wholesaler                          |
| New Arrival Highlights | Flag recently received inventory                    | Wholesaler (configurable window)    |
| Portal Visibility Flag | Per-slab toggle to include/exclude from portal      | Wholesaler                          |

#### 7.2.2 Pricing Visibility

Pricing visibility varies by portal user tier:

| User Type                                  | Pricing Shown                                              | Source                                                    |
|--------------------------------------------|------------------------------------------------------------|-----------------------------------------------------------|
| Trade Customer (Fabricator, Builder, etc.) | Customer-specific or tier-based wholesale pricing per sqft | EarthWare pricing engine (Section 5.5)                    |
| End Customer (invited by Fabricator)       | Fabricator-set retail pricing                              | Fabricator configures markup/pricing per slab or material |
| End Customer (invited by Wholesaler)       | Retail/list pricing or no pricing                          | Wholesaler configuration                                  |

Fabricators can set their own pricing for end customers in two ways: a global markup percentage applied to their wholesale cost, or per-slab/per-material custom pricing. The wholesaler's internal cost data is never visible to any portal user.

#### 7.2.3 Browse and Search Experience

The portal provides a visual, image-forward browsing experience optimized for material selection:

- **Gallery View:** Large slab images with key details (material, dimensions, price) in a responsive grid
- **Detail View:** Full-screen slab photos with zoom, gallery of all images, complete specifications
- **Bundle View:** View all slabs in a bundle together, with sequential ordering for bookmatch evaluation
- **Search and Filters:** Same filter capabilities as internal search (Section 3.6) — material type, color family, thickness, size range, price range — adapted for the portal UI
- **Favorites/Shortlist:** Customers can save slabs to a favorites list for later reference or sharing
- **Share:** Generate a shareable link to a specific slab or collection of slabs (respects access controls)

### 7.3 Hold Requests

Portal customers can request holds on available slabs. Hold requests from the portal are not immediately confirmed — they enter a review queue for the wholesaler's sales team.

#### 7.3.1 Hold Request Workflow

| Step | Actor     | Action                                                                                | System Behavior                                                                                                                        |
|------|-----------|---------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------|
| 1    | Customer  | Selects slab(s) and submits hold request with optional notes (project name, timeline) | Hold request created with status 'Pending Review'. Slab status does NOT change yet.                                                    |
| 2    | System    | Notifies assigned sales rep (in-app + email)                                          | Notification with customer details, slabs requested, and any notes                                                                     |
| 3    | Sales Rep | Reviews request; approves, declines, or contacts customer                             | If approved: hold is created per standard workflow (Section 5.2), slab status → 'On Hold'. If declined: customer notified with reason. |
| 4    | System    | Notifies customer of outcome                                                          | Portal notification + optional email with hold details or decline reason                                                               |
| 5    | Customer  | Views active hold in portal, sees expiry date and status                              | Hold visible in 'My Holds' section                                                                                                     |

#### 7.3.2 Hold Request Data

| Attribute           | Type                 | Description                                          |
|---------------------|----------------------|------------------------------------------------------|
| Request ID          | Auto                 | Unique identifier                                    |
| Customer            | Foreign Key          | Requesting customer                                  |
| Portal User         | Foreign Key          | Specific contact who submitted                       |
| Slabs               | Array\<Foreign Key\> | Requested slabs                                      |
| Project Name        | String               | Optional project reference                           |
| Notes               | Text                 | Customer notes or context                            |
| Requested Hold Type | Enum                 | Courtesy, Standard, Deposit (based on customer tier) |
| Status              | Enum                 | Pending Review, Approved, Declined, Expired          |
| Reviewed By         | Foreign Key          | Sales rep who handled                                |
| Review Notes        | Text                 | Internal notes on decision                           |
| Created At          | DateTime             | Submission timestamp                                 |
| Reviewed At         | DateTime             | When decision was made                               |

#### 7.3.3 Hold Visibility in Portal

Customers see all holds associated with their account regardless of how the hold was created (portal request or sales rep initiated):

- Active holds with expiry countdown
- Hold history (expired, converted, released)
- Slabs currently on hold with images and details
- Option to request extension (triggers notification to sales rep)
- Option to release hold early

### 7.4 Order and Document Tracking

#### 7.4.1 Order Status Visibility

Customers can view the status of all their orders through the portal:

| Information     | Visibility             | Notes                                              |
|-----------------|------------------------|----------------------------------------------------|
| Order summary   | Full                   | Order number, date, line items, totals             |
| Order status    | Full                   | Current status with timeline/progress indicator    |
| Slab details    | Full                   | Photos, dimensions, material for ordered slabs     |
| Invoices        | View + Download        | PDF invoices available for download                |
| Sales Orders    | View + Download        | PDF sales order confirmations                      |
| Quotes          | View + Approve/Decline | Active quotes with acceptance workflow             |
| Payment status  | View                   | Paid, partial, outstanding — amounts and due dates |
| Delivery status | View                   | Scheduled, in transit, delivered                   |
| Credit memos    | View + Download        | Any issued credits                                 |

#### 7.4.2 Document Center

A centralized area for all transactional documents associated with the customer's account:

- Filterable by document type (invoice, sales order, quote, credit memo)
- Searchable by document number, date range, or amount
- Bulk download capability
- Documents automatically appear as they are generated in the internal system

### 7.5 Delivery Scheduling

Portal customers can request delivery dates for confirmed orders, subject to wholesaler confirmation.

#### 7.5.1 Delivery Request Workflow

| Step | Actor      | Action                                                                                                | System Behavior                                                      |
|------|------------|-------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------|
| 1    | Wholesaler | Configures available delivery windows (dates, time slots, capacity)                                   | Calendar of available slots published to portal                      |
| 2    | Customer   | Selects preferred date and time window from available options; adds delivery address and instructions | Delivery request created with status 'Requested'                     |
| 3    | System     | Notifies warehouse/logistics team                                                                     | Request appears in delivery management queue                         |
| 4    | Wholesaler | Reviews and confirms, proposes alternative, or declines                                               | Status updates to 'Confirmed', 'Alternative Proposed', or 'Declined' |
| 5    | System     | Notifies customer of outcome (in-portal + email)                                                      | Customer sees updated status in portal                               |
| 6    | Customer   | If alternative proposed, accepts or requests different date                                           | Cycle continues until confirmed or cancelled                         |

#### 7.5.2 Delivery Request Data

| Attribute           | Type        | Description                                                                |
|---------------------|-------------|----------------------------------------------------------------------------|
| Request ID          | Auto        | Unique identifier                                                          |
| Order               | Foreign Key | Associated sales order                                                     |
| Customer            | Foreign Key | Requesting customer                                                        |
| Requested Date      | Date        | Preferred delivery date                                                    |
| Requested Window    | Enum        | Morning (8am-12pm), Afternoon (12pm-5pm), Full Day, or custom              |
| Delivery Address    | Foreign Key | Selected from customer's saved addresses                                   |
| Access Instructions | Text        | Gate codes, loading dock details, contact on site                          |
| Status              | Enum        | Requested, Confirmed, Alternative Proposed, Declined, Completed, Cancelled |
| Confirmed Date      | Date        | Actual confirmed delivery date (may differ from requested)                 |
| Confirmed Window    | String      | Confirmed time window                                                      |
| Notes               | Text        | Internal or customer-facing notes                                          |

### 7.6 Messaging System

The portal includes a contextual messaging system for communication between customers and the wholesaler's team. Messages are threaded, support rich content, and can be linked to specific business entities.

#### 7.6.1 Thread Types

| Type            | Description                                           | Participants                     | Example                                                            |
|-----------------|-------------------------------------------------------|----------------------------------|--------------------------------------------------------------------|
| General Inquiry | Standalone conversation not tied to a specific entity | Customer ↔ Sales rep / support   | "Do you have any Taj Mahal quartzite coming in soon?"              |
| Hold Thread     | Conversation linked to a specific hold                | Customer ↔ Sales rep             | "Can we extend this hold? My client needs another week to decide." |
| Order Thread    | Conversation linked to a specific order               | Customer ↔ Sales rep / logistics | "Can we change the delivery address for this order?"               |
| Delivery Thread | Conversation linked to a delivery request             | Customer ↔ Logistics             | "The loading dock is on the east side of the building."            |
| Slab Inquiry    | Conversation linked to a specific slab                | Customer ↔ Sales rep             | "Can you send me a close-up of the veining on this piece?"         |

#### 7.6.2 Message Data Model

| Attribute   | Type                | Description                                                 |
|-------------|---------------------|-------------------------------------------------------------|
| Message ID  | Auto                | Unique identifier                                           |
| Thread ID   | Foreign Key         | Parent conversation thread                                  |
| Sender      | Foreign Key         | User who sent the message (portal user or internal user)    |
| Body        | Rich Text           | Message content with basic formatting (bold, italic, links) |
| Attachments | Array\<Attachment\> | Files, images, or entity references                         |
| Read Status | Per-recipient       | Tracks read/unread per participant                          |
| Created At  | DateTime            | Timestamp                                                   |

#### 7.6.3 Rich Attachments and Entity Linking

Messages support two categories of attachments:

**Entity References (Linked Artifacts):** These are structured references to EarthWare objects that render as interactive cards within the message. Clicking an entity reference opens the relevant detail view within the portal.

| Entity Type | Rendered As                                  | Click Action                  |
|-------------|----------------------------------------------|-------------------------------|
| Slab        | Thumbnail image + material name + dimensions | Opens slab detail view        |
| Hold        | Hold status badge + slab summary + expiry    | Opens hold detail view        |
| Order       | Order number + status + total                | Opens order detail view       |
| Invoice     | Invoice number + amount + payment status     | Opens invoice / downloads PDF |
| Quote       | Quote number + total + expiry                | Opens quote detail view       |
| Delivery    | Delivery date + status                       | Opens delivery detail view    |

**File Attachments:** Standard file uploads for content not represented as EarthWare entities.

- Supported formats: Images (JPEG, PNG, HEIC), PDFs, common document formats
- Max file size: Configurable (default 25MB)
- Image attachments display inline with lightbox preview
- Files stored in S3-compatible storage, linked to the message record

#### 7.6.4 Notifications

| Event                          | Portal Notification                | Email Notification                          |
|--------------------------------|------------------------------------|---------------------------------------------|
| New message received           | In-app badge + notification center | Configurable (immediate, daily digest, off) |
| Hold request approved/declined | In-app notification                | Always                                      |
| Delivery confirmed/changed     | In-app notification                | Always                                      |
| Hold expiring (24hr warning)   | In-app notification                | Always                                      |
| New quote available            | In-app notification                | Always                                      |
| Order status change            | In-app notification                | Configurable                                |

#### 7.6.5 Internal Routing

When a customer sends a message, the system routes it to the appropriate internal user:

- Messages default to the customer's assigned sales rep
- Order-linked threads route to the rep on the order
- Delivery-linked threads route to the logistics/warehouse team
- Wholesaler admins can reassign threads to other staff members
- Internal-only notes can be added to threads (not visible to the customer)

### 7.7 Fabricator Sub-Portal (End Customer Management)

Fabricators with portal access can extend a scoped experience to their own end customers (homeowners, project managers, etc.). This allows fabricators to use EarthWare as a customer-facing selection and communication tool.

#### 7.7.1 Fabricator Controls

| Control              | Description                                                                         |
|----------------------|-------------------------------------------------------------------------------------|
| Invite End Customers | Send invitation emails to create scoped portal accounts                             |
| Curate Selections    | Select specific slabs to make visible to a specific end customer or project         |
| Set Pricing          | Apply global markup percentage or set per-slab retail prices that end customers see |
| Control Features     | Enable/disable hold requests, messaging, and document access per end customer       |
| Project Assignment   | Associate an end customer with a named project for organization                     |
| Deactivate Accounts  | Remove end customer portal access                                                   |

#### 7.7.2 End Customer Experience

End customers see a simplified portal experience:

- **Inventory:** Only slabs specifically curated by their fabricator, with fabricator-set pricing (or no pricing if the fabricator chooses)
- **Holds:** Can request holds if enabled by fabricator; requests go to the fabricator, who then coordinates with the wholesaler
- **Messaging:** Can message their fabricator through the portal; no direct communication with the wholesaler
- **Orders:** Can view order status for their project if the fabricator grants visibility
- **Documents:** Access limited to documents the fabricator shares with them
- **No Financial Data:** End customers never see wholesale pricing, cost data, or the fabricator's account details

#### 7.7.3 Data Isolation

End customer data is strictly scoped:

- End customers cannot see other end customers' data
- End customers cannot see the fabricator's full inventory view or account
- The wholesaler can see all end customer activity for reporting purposes
- Fabricator-set pricing is stored separately from wholesale pricing and is only visible within the fabricator-to-end-customer context

### 7.8 Portal Administration (Wholesaler Side)

The wholesaler manages the portal through the internal EarthWare admin interface.

#### 7.8.1 Portal Settings

| Setting                     | Description                                       | Default              |
|-----------------------------|---------------------------------------------------|----------------------|
| Portal Enabled              | Global on/off for the customer portal             | Off                  |
| Inventory Visibility        | Default visibility rules for new slabs            | Available slabs only |
| Hold Requests Enabled       | Whether portal customers can submit hold requests | On                   |
| Delivery Scheduling Enabled | Whether portal customers can request deliveries   | On                   |
| Messaging Enabled           | Whether the messaging system is active            | On                   |
| Fabricator Sub-Portal       | Whether fabricators can invite end customers      | Off                  |
| Session Timeout             | Portal session duration                           | 8 hours              |
| Email Notifications         | Global notification preferences                   | On                   |

#### 7.8.2 Portal Analytics

The wholesaler dashboard includes portal-specific metrics:

- Portal active users (daily/weekly/monthly)
- Most viewed slabs and materials
- Hold request volume and conversion rate
- Message response time
- Delivery request volume
- Fabricator sub-portal adoption

---

## 8. Warehouse Operations Module

The Warehouse module supports physical inventory operations including receiving, storage, picking, and shipping.

### 8.1 Barcode/QR Label System

#### 8.1.1 Label Contents

| Element       | Purpose                     | Format                  |
|---------------|-----------------------------|-------------------------|
| QR Code       | Quick scan for full details | URL to slab detail page |
| Barcode       | Scanner-friendly ID         | Code 128                |
| Slab ID       | Human-readable identifier   | Text                    |
| Material Name | Quick identification        | Text                    |
| Dimensions    | Size reference              | L Ã— W Ã— T             |
| Bundle/Slab # | Bundle reference            | Text                    |
| Location      | Current bin/slot            | Text                    |

#### 8.1.2 Label Printing

- **Batch Printing:** Print labels for entire container
- **Individual Reprint:** Replace damaged labels
- **Size Options:** 2Ã—4 inch standard, larger for yard visibility
- **Weather Resistant:** Support for durable outdoor labels

### 8.2 Inventory Movements

#### 8.2.1 Movement Types

| Type               | Description                  | Trigger                   |
|--------------------|------------------------------|---------------------------|
| Receipt            | New inventory from container | Receiving process         |
| Transfer           | Between locations            | Transfer request          |
| Bin Move           | Within same location         | Organization/optimization |
| Pick               | Reserved for order           | Order confirmation        |
| Ship               | Loaded for delivery          | Delivery scheduled        |
| Return             | Customer return              | Return authorization      |
| Adjustment         | Correction                   | Cycle count, damage, loss |
| Consignment Out    | To customer location         | Consignment agreement     |
| Consignment Return | Back from customer           | Return/sale               |

#### 8.2.2 Movement Recording

| Attribute         | Description                               |
|-------------------|-------------------------------------------|
| Movement ID       | Unique identifier                         |
| Type              | Movement type                             |
| Slab(s)           | Affected slabs                            |
| From Location/Bin | Origin                                    |
| To Location/Bin   | Destination                               |
| Date/Time         | When movement occurred                    |
| User              | Who performed movement                    |
| Reference         | Linked document (order, transfer request) |
| Notes             | Additional context                        |

### 8.3 Cycle Counting

Regular cycle counts maintain inventory accuracy:

- **Scheduled Counts:** Set frequency by location/material value
- **Random Counts:** System-generated sample counts
- **Full Physical:** Complete inventory verification
- **Discrepancy Workflow:** Investigate and resolve differences
- **Adjustment Approval:** Require approval for significant adjustments

### 8.4 Delivery Management

#### 8.4.1 Delivery Scheduling

- Calendar view of scheduled deliveries
- Route optimization suggestions
- Truck capacity planning
- Customer time window management
- Driver assignment

#### 8.4.2 Delivery Documentation

- **Delivery Ticket:** List of slabs being delivered
- **Packing List:** Detailed item list with dimensions
- **Proof of Delivery:** Signature capture, photos
- **Damage Documentation:** Record any delivery damage

---

## 9. Financial Tracking Module

The Financial module provides tracking for accounts receivable, accounts payable, and basic financial reporting. Note: This is not a full accounting system but integrates with external accounting software.

### 9.1 Accounts Receivable

#### 9.1.1 AR Tracking

- Invoice aging (Current, 30, 60, 90+ days)
- Customer balance tracking
- Credit limit monitoring
- Collection workflow
- Statement generation

#### 9.1.2 Payment Processing

- Record payments against invoices
- Partial payment handling
- Payment method tracking (check, wire, card)
- Deposit application
- Credit memo/refund processing

### 9.2 Accounts Payable

#### 9.2.1 AP Tracking

- Supplier invoice entry
- PO matching
- Payment due date tracking
- Expense categorization
- Payment recording

### 9.3 Accounting Integration

EarthWare integrates with popular accounting software to avoid duplicate data entry:

#### 9.3.1 QuickBooks Online Integration

- Sync customers and vendors
- Push invoices to QBO
- Pull payments from QBO
- Push bills to QBO
- Map chart of accounts

#### 9.3.2 Other Integrations (Future)

- Xero
- Sage
- Generic export (CSV, Excel)

---

## 10. Reporting and Analytics Module

### 10.1 Dashboard

The main dashboard provides at-a-glance visibility into key business metrics:

#### 10.1.1 Key Performance Indicators

| KPI                        | Description                   | Target/Benchmark |
|----------------------------|-------------------------------|------------------|
| Total Inventory Value      | Current value at cost         | Varies           |
| Inventory Turns            | Annual sales Ã· avg inventory | 4-6Ã— per year   |
| Days Inventory Outstanding | Avg days to sell              | 60-90 days       |
| Gross Margin               | Revenue âˆ’ COGS Ã· Revenue   | 25-35%           |
| AR Days Outstanding        | Avg days to collect           | 30-45 days       |
| Hold Conversion Rate       | Holds â†’ Orders %            | >60%             |
| Container Fill Rate        | Actual vs expected receipt    | >95%             |

#### 10.1.2 Dashboard Widgets

- Sales trend chart (daily/weekly/monthly)
- Inventory by status (pie chart)
- Containers in transit timeline
- Expiring holds alert
- Top customers this month
- Low stock alerts
- Recent activity feed

### 10.2 Standard Reports

#### 10.2.1 Inventory Reports

| Report              | Description               | Filters                  |
|---------------------|---------------------------|--------------------------|
| Inventory Valuation | All slabs with cost/value | Location, material, date |
| Inventory Aging     | Time in inventory by slab | Age buckets, material    |
| Slow Moving         | Slabs over threshold age  | Days threshold, material |
| Stock Status        | Available vs committed    | Location, status         |
| Container Contents  | Slabs by container        | Container, status        |

#### 10.2.2 Sales Reports

| Report            | Description                  | Filters                   |
|-------------------|------------------------------|---------------------------|
| Sales Summary     | Revenue, margin by period    | Date range, rep           |
| Sales by Customer | Customer purchase history    | Customer, date range      |
| Sales by Material | Performance by material type | Material, date range      |
| Sales by Rep      | Rep performance              | Rep, date range           |
| Hold Analysis     | Conversion rates, expiry     | Date range, customer type |
| Quote Analysis    | Quote to order conversion    | Date range, rep           |

#### 10.2.3 Financial Reports

| Report               | Description                      | Filters              |
|----------------------|----------------------------------|----------------------|
| AR Aging             | Outstanding by age bucket        | Customer, as-of date |
| AP Aging             | Payables by age bucket           | Supplier, as-of date |
| Gross Margin         | Margin by sale/material/customer | Date range, grouping |
| Landed Cost Analysis | Cost breakdown by container      | Container, supplier  |

### 10.3 Custom Reports

- **Report Builder:** Drag-and-drop interface for custom reports
- **Saved Reports:** Save configurations for reuse
- **Scheduled Reports:** Email reports on schedule
- **Export Options:** PDF, Excel, CSV export

---

## 11. User Management and Security

### 11.1 User Roles

| Role                   | Description                  | Key Permissions                                                            |
|------------------------|------------------------------|----------------------------------------------------------------------------|
| Admin                  | Full system access           | All features, settings, user management                                    |
| Sales Manager          | Sales team oversight         | All sales, pricing, customer, reports                                      |
| Sales Rep              | Direct sales activities      | Quotes, holds, orders, own customers                                       |
| Warehouse Manager      | Warehouse oversight          | All inventory, receiving, shipping                                         |
| Warehouse Staff        | Physical operations          | Scan, move, count inventory                                                |
| Purchasing             | Procurement                  | Suppliers, POs, containers, receiving                                      |
| Accounting             | Financial                    | Invoices, payments, AR/AP, reports                                         |
| Read Only              | View only access             | View all, no create/edit/delete                                            |
| Portal: Trade Customer | External customer access     | Browse inventory, request holds, view orders, messaging, delivery requests |
| Portal: End Customer   | Fabricator's customer access | View curated slabs, messaging with fabricator, limited order visibility    |

### 11.2 Permission Categories

| Category   | Actions                                                                         |
|------------|---------------------------------------------------------------------------------|
| Inventory  | View, Create, Edit, Delete, Transfer, Adjust                                    |
| Sales      | View, Create Quotes, Create Holds, Create Orders, Edit, Cancel, Price Override  |
| Customers  | View, Create, Edit, Delete, View Financial                                      |
| Purchasing | View, Create PO, Receive, Edit, Cancel                                          |
| Financial  | View AR, View AP, Record Payment, Issue Credit, View Reports                    |
| Reports    | View Standard, Create Custom, Export, Schedule                                  |
| Settings   | View, Edit Company, Edit Users, Edit System                                     |
| Portal     | Manage Invitations, Configure Visibility, View Portal Analytics, Manage Threads |

### 11.3 Security Features

- **Authentication:** Email/password with optional 2FA
- **Session Management:** Configurable timeout, device tracking
- **Audit Log:** All actions logged with user, timestamp, details
- **Data Encryption:** Sensitive data encrypted at rest
- **IP Restrictions:** Optional IP whitelist for admin access

---

## 12. Technical Requirements

### 12.1 Performance Requirements

| Metric            | Requirement  | Notes                 |
|-------------------|--------------|-----------------------|
| Page Load Time    | < 2 seconds  | 90th percentile       |
| Search Response   | < 500ms      | Inventory search      |
| Report Generation | < 10 seconds | Standard reports      |
| Concurrent Users  | 50+          | Without degradation   |
| Uptime            | 99.5%        | Excluding maintenance |

### 12.2 Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome for Android)

### 12.3 Mobile Considerations

- **Responsive Design:** All screens work on tablet/phone
- **Mobile-First for Warehouse:** Scanning, receiving optimized for mobile
- **Camera Integration:** Barcode/QR scanning via camera
- **Offline Consideration:** Future: offline mode for warehouse

### 12.4 Data Management

- **Backup:** Daily automated backups, 30-day retention
- **Data Export:** Full data export capability
- **Data Import:** Bulk import from CSV/Excel
- **Archive:** Archive old data to maintain performance

### 12.5 Integration APIs

REST API for external integrations:

| Endpoint Group | Operations                  | Use Case                  |
|----------------|-----------------------------|---------------------------|
| Inventory      | CRUD, Search, Status Update | Website sync, mobile apps |
| Customers      | CRUD, Search                | Marketing integration     |
| Orders         | Create, Read, Status Update | E-commerce integration    |
| Webhooks       | Event notifications         | Real-time sync            |

---

## 13. Development Phases

### 13.1 Phase 1: Foundation (MVP)

**Duration:** 12-16 weeks  
**Goal:** Core functionality to run basic operations

#### 13.1.1 Phase 1 Features

- **User Management:** Authentication, basic roles (Admin, Sales, Warehouse)
- **Inventory Core:** Slab CRUD, search, filtering, status management
- **Location Management:** Multiple locations, bin tracking
- **Customer Management:** Basic CRM, customer types, contacts
- **Sales Core:** Quotes, holds (basic), sales orders
- **Invoicing:** Invoice generation, PDF output
- **Basic Purchasing:** Purchase orders, supplier management
- **Basic Reporting:** Inventory list, sales summary

### 13.2 Phase 2: Operations Enhancement

**Duration:** 8-12 weeks  
**Goal:** Full purchasing and warehouse capabilities

#### 13.2.1 Phase 2 Features

- **Container Management:** Full container tracking, status workflow
- **Landed Cost:** Complete landed cost calculation and allocation
- **Receiving:** Full receiving workflow with discrepancy handling
- **Barcode/Labels:** Label design, printing, scanning
- **Delivery Management:** Scheduling, delivery tickets, POD
- **Advanced Holds:** All hold types, deposits, expiry automation
- **Enhanced Reports:** Full reporting suite

### 13.3 Phase 3: Financial and Integration

**Duration:** 8-12 weeks  
**Goal:** Financial tracking and external integrations

#### 13.3.1 Phase 3 Features

- **AR/AP Tracking:** Complete receivables/payables management
- **Payment Processing:** Record payments, partial payments, credits
- **QuickBooks Integration:** Full sync with QBO
- **Customer Tiers:** Automated tier management, pricing rules
- **Pricing Engine:** Full pricing hierarchy
- **Dashboard:** KPI dashboard with widgets
- **Custom Reports:** Report builder, scheduling

### 13.4 Phase 4: Advanced Features

**Duration:** Ongoing  
**Goal:** Competitive feature parity and differentiation

#### 13.4.1 Phase 4 Features

- **Customer Portal — Core:** Portal authentication, invitation system, inventory browsing with visibility controls, tier-based pricing display, favorites/shortlists (see Section 7.1–7.2)
- **Customer Portal — Holds & Orders:** Hold request workflow with sales rep review queue, hold visibility and management, order/document tracking, quote acceptance (see Section 7.3–7.4)
- **Customer Portal — Messaging:** Threaded messaging system with entity linking, rich attachments, notification system, internal routing and notes (see Section 7.6)
- **Customer Portal — Delivery Scheduling:** Available delivery window configuration, customer delivery requests with confirmation workflow (see Section 7.5)
- **Fabricator Sub-Portal:** Fabricator-to-end-customer invitation, curated slab selections, fabricator-set pricing/markup, scoped end customer experience (see Section 7.7)
- **Portal Administration:** Portal settings, visibility configuration, portal-specific analytics and KPIs (see Section 7.8)
- **Online Payments (Future):** Invoice and deposit payment through the portal — deferred due to complexity but planned for later in Phase 4 or Phase 5
- **Public Website:** Inventory showcase website builder
- **3D Visualizer:** Material visualization in room settings
- **Consignment:** Full consignment inventory management
- **SlabSmith Integration:** Import digital slab images
- **Email Marketing:** Newsletter and new arrival notifications
- **Mobile App:** Native mobile app for warehouse
- **API Expansion:** Full public API for integrations

---

## 14. Database Schema Overview

The following represents the core database tables and their relationships. Full schema details will be developed during implementation.

### 14.1 Core Entities

| Entity                             | Purpose                         | Key Relationships                                          |
|------------------------------------|---------------------------------|------------------------------------------------------------|
| users                              | System users and authentication | roles, customers (sales rep)                               |
| roles                              | User roles and permissions      | users, permissions                                         |
| customers                          | Customer accounts               | contacts, addresses, orders, invoices                      |
| contacts                           | Individual people               | customers                                                  |
| addresses                          | Physical addresses              | customers, locations                                       |
| suppliers                          | Vendor accounts                 | purchase_orders, slabs                                     |
| locations                          | Warehouses and storage          | slabs, inventory_movements                                 |
| materials                          | Material type catalog           | slabs                                                      |
| slabs                              | Individual slab inventory       | materials, bundles, locations, orders                      |
| bundles                            | Slab groupings                  | slabs                                                      |
| products                           | Non-slab inventory              | order_items                                                |
| containers                         | Import containers               | purchase_orders, slabs                                     |
| purchase_orders                    | Supplier orders                 | suppliers, containers, po_items                            |
| quotes                             | Customer quotes                 | customers, quote_items                                     |
| holds                              | Inventory reservations          | customers, slabs                                           |
| hold_requests                      | Portal hold requests            | customers, portal_users, slabs, holds                      |
| orders                             | Customer orders                 | customers, order_items, invoices                           |
| invoices                           | Customer invoices               | orders, payments                                           |
| payments                           | Payment records                 | invoices, customers                                        |
| portal_users                       | Portal authentication accounts  | contacts, customers, portal_roles                          |
| portal_invitations                 | Pending portal invitations      | customers, portal_users                                    |
| message_threads                    | Messaging conversations         | portal_users, users, holds, orders                         |
| messages                           | Individual messages             | message_threads, portal_users, users                       |
| message_attachments                | File and entity attachments     | messages, slabs, orders, invoices                          |
| delivery_requests                  | Portal delivery requests        | orders, customers, portal_users                            |
| portal_favorites                   | Customer slab shortlists        | portal_users, slabs                                        |
| fabricator_slab_pricing            | Fabricator markup/pricing       | customers (fabricator), slabs                              |
| fabricator_end_customer_selections | Curated slab visibility         | customers (fabricator), portal_users (end customer), slabs |

### 14.2 Key Indexes

- slabs: material_id, status, location_id, bundle_id, portal_visible
- orders: customer_id, status, created_at
- invoices: customer_id, status, due_date
- holds: customer_id, status, expiry_date
- hold_requests: customer_id, status, created_at
- message_threads: customer_id, entity_type, entity_id, updated_at
- messages: thread_id, created_at
- delivery_requests: order_id, customer_id, status, requested_date
- portal_users: customer_id, contact_id, role
- Full-text search index on slabs (material name, bundle number)

---

## 15. Appendix

### 15.1 Glossary

| Term             | Definition                                                                                               |
|------------------|----------------------------------------------------------------------------------------------------------|
| Bookmatch        | Adjacent slabs opened like a book to create mirror-image patterns                                        |
| Bundle           | Group of slabs cut from the same block, sharing visual characteristics                                   |
| CIF              | Cost, Insurance, Freight - price including delivery to port                                              |
| Consignment      | Inventory placed at customer location, still owned by distributor                                        |
| Container        | Shipping container (20ft or 40ft) used for importing slabs                                               |
| End Customer     | A fabricator's customer (typically a homeowner) with scoped portal access                                |
| Entity Reference | A structured, clickable link to an EarthWare object (slab, order, etc.) embedded within a portal message |
| Fabricator       | Business that cuts and installs countertops                                                              |
| FOB              | Free On Board - price including loading at origin                                                        |
| Hold             | Temporary reservation of slab(s) for customer consideration                                              |
| Hold Request     | A portal-initiated request for a hold, pending sales rep approval                                        |
| Landed Cost      | Total cost including purchase, freight, duty, and handling                                               |
| Portal           | The customer-facing interface of EarthWare for browsing, holds, messaging, and order management          |
| Remnant          | Partial slab remaining after cutting                                                                     |
| Slab             | Large flat piece of stone, typically 2-3cm thick                                                         |
| Square Footage   | Area measurement (length × width ÷ 144 for inches)                                                       |
| Sub-Portal       | The scoped portal experience a fabricator provides to their end customers                                |
| Trade Customer   | A direct wholesale customer (fabricator, builder, designer) with full portal access                      |
| Vein             | Natural linear pattern in stone, especially marble                                                       |

### 15.2 Document Control

| Version | Date          | Author        | Changes                                                                                                                                                                                                                                                                                                                      |
|---------|---------------|---------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 1.0     | January 2026  | Initial Draft | Complete PRD creation                                                                                                                                                                                                                                                                                                        |
| 1.1     | February 2026 | —             | Added Customer Portal Module (Section 7) with full requirements for portal access model, inventory browsing, hold requests, order tracking, delivery scheduling, messaging system, fabricator sub-portal, and portal administration. Updated section numbering, user roles, database schema, Phase 4 features, and glossary. |

### 15.3 Sign-Off

This document requires review and approval from key stakeholders before development begins.

| Role                 | Name | Signature | Date |
|----------------------|------|-----------|------|
| Product Owner        |      |           |      |
| Technical Lead       |      |           |      |
| Business Stakeholder |      |           |      |

---

*â€” End of Document â€”*
