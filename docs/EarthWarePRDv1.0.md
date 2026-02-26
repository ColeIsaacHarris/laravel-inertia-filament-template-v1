# EarthWare

## Stone Slab Wholesale & Import Management Platform

### Product Requirements Document

**Version:** 1.0  
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
7. [Warehouse Operations Module](#7-warehouse-operations-module)
8. [Financial Tracking Module](#8-financial-tracking-module)
9. [Reporting and Analytics Module](#9-reporting-and-analytics-module)
10. [User Management and Security](#10-user-management-and-security)
11. [Technical Requirements](#11-technical-requirements)
12. [Development Phases](#12-development-phases)
13. [Database Schema Overview](#13-database-schema-overview)
14. [Appendix](#14-appendix)

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
- **Customer Dashboard:** Dedicated customer dashboard for managing holds, communicating with wholesaler, viewing inventory, and more...

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

### 2.2 Core Modules Overview

The platform consists of seven core modules that work together to provide comprehensive business management capabilities:

| Module                | Primary Function          | Key Features                                       |
|-----------------------|---------------------------|----------------------------------------------------|
| Inventory Management  | Track slabs and products  | Individual slab records, locations, status, images |
| Purchasing & Import   | Manage procurement        | POs, container tracking, landed cost calculation   |
| Sales & Orders        | Process customer orders   | Quotes, holds, sales orders, invoices              |
| Customer Management   | CRM functionality         | Customer profiles, tiers, history, communications  |
| Warehouse Operations  | Physical operations       | Receiving, transfers, picks, cycle counts          |
| Financial Tracking    | Revenue and cost tracking | AR/AP tracking, payment processing, reporting      |
| Reporting & Analytics | Business intelligence     | Dashboards, custom reports, KPIs                   |

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
| Square Footage | Decimal (calc) | Calculated from L × W                               | Auto     |
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
| Cost Per SqFt | Decimal (calc) | Landed cost ÷ square footage       |
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
| Ocean Freight      | By container, then by sqft  | $8,000 ÷ total sqft  |
| Import Duty        | By value (ad valorem)       | 6% of FOB value      |
| Customs Brokerage  | Per container, then by sqft | $350 ÷ total sqft    |
| Insurance          | By value or flat            | 0.5% of total value  |
| Drayage            | Per container, then by sqft | $800 ÷ total sqft    |
| Handling/Unloading | Per container or per slab   | $200 ÷ slab count    |
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
| Per Square Foot | Price × total sqft of slab     | Most common, industry standard |
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

### 6.5 Customer Portal (Future Enhancement)

A self-service portal allowing customers to browse inventory, place holds, and track orders:

- Browse available inventory with images
- Request holds on slabs
- View quotes and approve
- Track order status
- View and pay invoices
- Download documents

---

## 7. Warehouse Operations Module

The Warehouse module supports physical inventory operations including receiving, storage, picking, and shipping.

### 7.1 Barcode/QR Label System

#### 7.1.1 Label Contents

| Element       | Purpose                     | Format                  |
|---------------|-----------------------------|-------------------------|
| QR Code       | Quick scan for full details | URL to slab detail page |
| Barcode       | Scanner-friendly ID         | Code 128                |
| Slab ID       | Human-readable identifier   | Text                    |
| Material Name | Quick identification        | Text                    |
| Dimensions    | Size reference              | L × W × T               |
| Bundle/Slab # | Bundle reference            | Text                    |
| Location      | Current bin/slot            | Text                    |

#### 7.1.2 Label Printing

- **Batch Printing:** Print labels for entire container
- **Individual Reprint:** Replace damaged labels
- **Size Options:** 2×4 inch standard, larger for yard visibility
- **Weather Resistant:** Support for durable outdoor labels

### 7.2 Inventory Movements

#### 7.2.1 Movement Types

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

#### 7.2.2 Movement Recording

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

### 7.3 Cycle Counting

Regular cycle counts maintain inventory accuracy:

- **Scheduled Counts:** Set frequency by location/material value
- **Random Counts:** System-generated sample counts
- **Full Physical:** Complete inventory verification
- **Discrepancy Workflow:** Investigate and resolve differences
- **Adjustment Approval:** Require approval for significant adjustments

### 7.4 Delivery Management

#### 7.4.1 Delivery Scheduling

- Calendar view of scheduled deliveries
- Route optimization suggestions
- Truck capacity planning
- Customer time window management
- Driver assignment

#### 7.4.2 Delivery Documentation

- **Delivery Ticket:** List of slabs being delivered
- **Packing List:** Detailed item list with dimensions
- **Proof of Delivery:** Signature capture, photos
- **Damage Documentation:** Record any delivery damage

---

## 8. Financial Tracking Module

The Financial module provides tracking for accounts receivable, accounts payable, and basic financial reporting. Note: This is not a full accounting system but integrates with external accounting software.

### 8.1 Accounts Receivable

#### 8.1.1 AR Tracking

- Invoice aging (Current, 30, 60, 90+ days)
- Customer balance tracking
- Credit limit monitoring
- Collection workflow
- Statement generation

#### 8.1.2 Payment Processing

- Record payments against invoices
- Partial payment handling
- Payment method tracking (check, wire, card)
- Deposit application
- Credit memo/refund processing

### 8.2 Accounts Payable

#### 8.2.1 AP Tracking

- Supplier invoice entry
- PO matching
- Payment due date tracking
- Expense categorization
- Payment recording

### 8.3 Accounting Integration

EarthWare integrates with popular accounting software to avoid duplicate data entry:

#### 8.3.1 QuickBooks Online Integration

- Sync customers and vendors
- Push invoices to QBO
- Pull payments from QBO
- Push bills to QBO
- Map chart of accounts

#### 8.3.2 Other Integrations (Future)

- Xero
- Sage
- Generic export (CSV, Excel)

---

## 9. Reporting and Analytics Module

### 9.1 Dashboard

The main dashboard provides at-a-glance visibility into key business metrics:

#### 9.1.1 Key Performance Indicators

| KPI                        | Description                  | Target/Benchmark |
|----------------------------|------------------------------|------------------|
| Total Inventory Value      | Current value at cost        | Varies           |
| Inventory Turns            | Annual sales ÷ avg inventory | 4-6× per year    |
| Days Inventory Outstanding | Avg days to sell             | 60-90 days       |
| Gross Margin               | Revenue − COGS ÷ Revenue     | 25-35%           |
| AR Days Outstanding        | Avg days to collect          | 30-45 days       |
| Hold Conversion Rate       | Holds → Orders %             | >60%             |
| Container Fill Rate        | Actual vs expected receipt   | >95%             |

#### 9.1.2 Dashboard Widgets

- Sales trend chart (daily/weekly/monthly)
- Inventory by status (pie chart)
- Containers in transit timeline
- Expiring holds alert
- Top customers this month
- Low stock alerts
- Recent activity feed

### 9.2 Standard Reports

#### 9.2.1 Inventory Reports

| Report              | Description               | Filters                  |
|---------------------|---------------------------|--------------------------|
| Inventory Valuation | All slabs with cost/value | Location, material, date |
| Inventory Aging     | Time in inventory by slab | Age buckets, material    |
| Slow Moving         | Slabs over threshold age  | Days threshold, material |
| Stock Status        | Available vs committed    | Location, status         |
| Container Contents  | Slabs by container        | Container, status        |

#### 9.2.2 Sales Reports

| Report            | Description                  | Filters                   |
|-------------------|------------------------------|---------------------------|
| Sales Summary     | Revenue, margin by period    | Date range, rep           |
| Sales by Customer | Customer purchase history    | Customer, date range      |
| Sales by Material | Performance by material type | Material, date range      |
| Sales by Rep      | Rep performance              | Rep, date range           |
| Hold Analysis     | Conversion rates, expiry     | Date range, customer type |
| Quote Analysis    | Quote to order conversion    | Date range, rep           |

#### 9.2.3 Financial Reports

| Report               | Description                      | Filters              |
|----------------------|----------------------------------|----------------------|
| AR Aging             | Outstanding by age bucket        | Customer, as-of date |
| AP Aging             | Payables by age bucket           | Supplier, as-of date |
| Gross Margin         | Margin by sale/material/customer | Date range, grouping |
| Landed Cost Analysis | Cost breakdown by container      | Container, supplier  |

### 9.3 Custom Reports

- **Report Builder:** Drag-and-drop interface for custom reports
- **Saved Reports:** Save configurations for reuse
- **Scheduled Reports:** Email reports on schedule
- **Export Options:** PDF, Excel, CSV export

---

## 10. User Management and Security

### 10.1 User Roles

| Role              | Description             | Key Permissions                         |
|-------------------|-------------------------|-----------------------------------------|
| Admin             | Full system access      | All features, settings, user management |
| Sales Manager     | Sales team oversight    | All sales, pricing, customer, reports   |
| Sales Rep         | Direct sales activities | Quotes, holds, orders, own customers    |
| Warehouse Manager | Warehouse oversight     | All inventory, receiving, shipping      |
| Warehouse Staff   | Physical operations     | Scan, move, count inventory             |
| Purchasing        | Procurement             | Suppliers, POs, containers, receiving   |
| Accounting        | Financial               | Invoices, payments, AR/AP, reports      |
| Read Only         | View only access        | View all, no create/edit/delete         |

### 10.2 Permission Categories

| Category   | Actions                                                                        |
|------------|--------------------------------------------------------------------------------|
| Inventory  | View, Create, Edit, Delete, Transfer, Adjust                                   |
| Sales      | View, Create Quotes, Create Holds, Create Orders, Edit, Cancel, Price Override |
| Customers  | View, Create, Edit, Delete, View Financial                                     |
| Purchasing | View, Create PO, Receive, Edit, Cancel                                         |
| Financial  | View AR, View AP, Record Payment, Issue Credit, View Reports                   |
| Reports    | View Standard, Create Custom, Export, Schedule                                 |
| Settings   | View, Edit Company, Edit Users, Edit System                                    |

### 10.3 Security Features

- **Authentication:** Email/password with optional 2FA
- **Session Management:** Configurable timeout, device tracking
- **Audit Log:** All actions logged with user, timestamp, details
- **Data Encryption:** Sensitive data encrypted at rest
- **IP Restrictions:** Optional IP whitelist for admin access

---

## 11. Technical Requirements

### 11.1 Performance Requirements

| Metric            | Requirement  | Notes                 |
|-------------------|--------------|-----------------------|
| Page Load Time    | < 2 seconds  | 90th percentile       |
| Search Response   | < 500ms      | Inventory search      |
| Report Generation | < 10 seconds | Standard reports      |
| Concurrent Users  | 50+          | Without degradation   |
| Uptime            | 99.5%        | Excluding maintenance |

### 11.2 Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome for Android)

### 11.3 Mobile Considerations

- **Responsive Design:** All screens work on tablet/phone
- **Mobile-First for Warehouse:** Scanning, receiving optimized for mobile
- **Camera Integration:** Barcode/QR scanning via camera
- **Offline Consideration:** Future: offline mode for warehouse

### 11.4 Data Management

- **Backup:** Daily automated backups, 30-day retention
- **Data Export:** Full data export capability
- **Data Import:** Bulk import from CSV/Excel
- **Archive:** Archive old data to maintain performance

### 11.5 Integration APIs

REST API for external integrations:

| Endpoint Group | Operations                  | Use Case                  |
|----------------|-----------------------------|---------------------------|
| Inventory      | CRUD, Search, Status Update | Website sync, mobile apps |
| Customers      | CRUD, Search                | Marketing integration     |
| Orders         | Create, Read, Status Update | E-commerce integration    |
| Webhooks       | Event notifications         | Real-time sync            |

---

## 12. Development Phases

### 12.1 Phase 1: Foundation (MVP)

**Duration:** 12-16 weeks  
**Goal:** Core functionality to run basic operations

#### 12.1.1 Phase 1 Features

- **User Management:** Authentication, basic roles (Admin, Sales, Warehouse)
- **Inventory Core:** Slab CRUD, search, filtering, status management
- **Location Management:** Multiple locations, bin tracking
- **Customer Management:** Basic CRM, customer types, contacts
- **Sales Core:** Quotes, holds (basic), sales orders
- **Invoicing:** Invoice generation, PDF output
- **Basic Purchasing:** Purchase orders, supplier management
- **Basic Reporting:** Inventory list, sales summary

### 12.2 Phase 2: Operations Enhancement

**Duration:** 8-12 weeks  
**Goal:** Full purchasing and warehouse capabilities

#### 12.2.1 Phase 2 Features

- **Container Management:** Full container tracking, status workflow
- **Landed Cost:** Complete landed cost calculation and allocation
- **Receiving:** Full receiving workflow with discrepancy handling
- **Barcode/Labels:** Label design, printing, scanning
- **Delivery Management:** Scheduling, delivery tickets, POD
- **Advanced Holds:** All hold types, deposits, expiry automation
- **Enhanced Reports:** Full reporting suite

### 12.3 Phase 3: Financial and Integration

**Duration:** 8-12 weeks  
**Goal:** Financial tracking and external integrations

#### 12.3.1 Phase 3 Features

- **AR/AP Tracking:** Complete receivables/payables management
- **Payment Processing:** Record payments, partial payments, credits
- **QuickBooks Integration:** Full sync with QBO
- **Customer Tiers:** Automated tier management, pricing rules
- **Pricing Engine:** Full pricing hierarchy
- **Dashboard:** KPI dashboard with widgets
- **Custom Reports:** Report builder, scheduling

### 12.4 Phase 4: Advanced Features

**Duration:** Ongoing  
**Goal:** Competitive feature parity and differentiation

#### 12.4.1 Phase 4 Features

- **Customer Portal:** Self-service inventory browsing, holds, orders
- **Public Website:** Inventory showcase website builder
- **3D Visualizer:** Material visualization in room settings
- **Consignment:** Full consignment inventory management
- **SlabSmith Integration:** Import digital slab images
- **Email Marketing:** Newsletter and new arrival notifications
- **Mobile App:** Native mobile app for warehouse
- **API Expansion:** Full public API for integrations

---

## 13. Database Schema Overview

The following represents the core database tables and their relationships. Full schema details will be developed during implementation.

### 13.1 Core Entities

| Entity          | Purpose                         | Key Relationships                     |
|-----------------|---------------------------------|---------------------------------------|
| users           | System users and authentication | roles, customers (sales rep)          |
| roles           | User roles and permissions      | users, permissions                    |
| customers       | Customer accounts               | contacts, addresses, orders, invoices |
| contacts        | Individual people               | customers                             |
| addresses       | Physical addresses              | customers, locations                  |
| suppliers       | Vendor accounts                 | purchase_orders, slabs                |
| locations       | Warehouses and storage          | slabs, inventory_movements            |
| materials       | Material type catalog           | slabs                                 |
| slabs           | Individual slab inventory       | materials, bundles, locations, orders |
| bundles         | Slab groupings                  | slabs                                 |
| products        | Non-slab inventory              | order_items                           |
| containers      | Import containers               | purchase_orders, slabs                |
| purchase_orders | Supplier orders                 | suppliers, containers, po_items       |
| quotes          | Customer quotes                 | customers, quote_items                |
| holds           | Inventory reservations          | customers, slabs                      |
| orders          | Customer orders                 | customers, order_items, invoices      |
| invoices        | Customer invoices               | orders, payments                      |
| payments        | Payment records                 | invoices, customers                   |

### 13.2 Key Indexes

- slabs: material_id, status, location_id, bundle_id
- orders: customer_id, status, created_at
- invoices: customer_id, status, due_date
- holds: customer_id, status, expiry_date
- Full-text search index on slabs (material name, bundle number)

---

## 14. Appendix

### 14.1 Glossary

| Term           | Definition                                                             |
|----------------|------------------------------------------------------------------------|
| Bundle         | Group of slabs cut from the same block, sharing visual characteristics |
| Bookmatch      | Adjacent slabs opened like a book to create mirror-image patterns      |
| Container      | Shipping container (20ft or 40ft) used for importing slabs             |
| Consignment    | Inventory placed at customer location, still owned by distributor      |
| Fabricator     | Business that cuts and installs countertops                            |
| FOB            | Free On Board - price including loading at origin                      |
| CIF            | Cost, Insurance, Freight - price including delivery to port            |
| Hold           | Temporary reservation of slab(s) for customer consideration            |
| Landed Cost    | Total cost including purchase, freight, duty, and handling             |
| Remnant        | Partial slab remaining after cutting                                   |
| Slab           | Large flat piece of stone, typically 2-3cm thick                       |
| Square Footage | Area measurement (length × width ÷ 144 for inches)                     |
| Vein           | Natural linear pattern in stone, especially marble                     |

### 14.2 Document Control

| Version | Date         | Author        | Changes               |
|---------|--------------|---------------|-----------------------|
| 1.0     | January 2026 | Initial Draft | Complete PRD creation |

### 14.3 Sign-Off

This document requires review and approval from key stakeholders before development begins.

| Role                 | Name | Signature | Date |
|----------------------|------|-----------|------|
| Product Owner        |      |           |      |
| Technical Lead       |      |           |      |
| Business Stakeholder |      |           |      |

---

*— End of Document —*
