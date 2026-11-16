# GI Pathology AI --- Laravel A→Z Execution Plan

cd C:\project_Robotna\pathology-ai\pathology_service
.\.venv\Scripts\Activate.ps1
python -m uvicorn app.main:app --host 127.0.0.1 --port 8001 --reload


cd C:\project_Robotna\pathology-ai
npm run dev

## Rules

-   Laravel 13 is the core.
-   Week 15 is the primary programming reference.
-   External tools are allowed only if they are simple, understandable,
    and add real value.
-   Main stack: Laravel 13, PHP 8.3+, MySQL, Blade, Tailwind CSS,
    Alpine.js, Vite, Pest, Postman.
-   Optional premium animation: GSAP + ScrollTrigger.
-   No React/Vue/Livewire unless a real requirement appears.
-   No unnecessary packages.
-   AI integration comes after the Laravel foundation.
-   Never invent database fields.
-   Every phase must pass its checklist before the next phase.
-   Every feature follows: Plan → Code → Run → Test → Fix → Security →
    Git Commit.

------------------------------------------------------------------------

# PHASE 1 --- Environment & Project

### Checklist

-   [-] PHP 8.3+
-   [-] Composer 2.x
-   [ ] Node.js 18+
-   [ ] MySQL
-   [ ] Laravel 13
-   [ ] Git
-   [ ] Create project
-   [ ] Configure `.env`
-   [ ] Run Laravel
-   [ ] Verify Vite
-   [ ] Verify Tailwind
-   [ ] Verify Pest

### Verification

``` bash
php -v
composer -V
node -v
php artisan --version
php artisan route:list
php artisan test
```

**Gate:** Laravel opens and tests run without errors.

------------------------------------------------------------------------

# PHASE 2 --- Laravel Architecture / MVC

### Understand

-   [ ] Routes
-   [ ] Controllers
-   [ ] Models
-   [ ] Blade Views
-   [ ] Middleware
-   [ ] Migrations
-   [ ] Seeders
-   [ ] Factories
-   [ ] Form Requests
-   [ ] Storage
-   [ ] `.env`
-   [ ] `bootstrap/app.php`

### Rule

`Route → Controller → Model → Database → Controller → View`

**Gate:** every new feature has a clear Laravel layer.

------------------------------------------------------------------------

# PHASE 3 --- Frontend Foundation

### Stack

Blade + Tailwind + Alpine.js + Vite

### Design system

-   [ ] Colors
-   [ ] Typography
-   [ ] Buttons
-   [ ] Cards
-   [ ] Inputs
-   [ ] Badges
-   [ ] Alerts
-   [ ] Modal
-   [ ] Spacing
-   [ ] Responsive rules
-   [ ] Animation rules

### Reusable layout

-   [ ] Navbar
-   [ ] Sidebar
-   [ ] Footer
-   [ ] Main layout
-   [ ] Reusable components

**Gate:** a new page can reuse the layout without copy-pasting it.

------------------------------------------------------------------------

# PHASE 4 --- Premium Animation

Use Alpine/CSS for normal UI interactions.

Optional: GSAP + ScrollTrigger for: - \[ \] Hero motion - \[ \] Scroll
animation - \[ \] Image transitions - \[ \] Parallax - \[ \] Premium
reveals

### Check

-   [ ] No layout jumping
-   [ ] Mobile works
-   [ ] Desktop works
-   [ ] No console errors
-   [ ] Animation never blocks usability

------------------------------------------------------------------------

# PHASE 5 --- Public Website

Route: `/`

### Sections

-   [ ] Hero
-   [ ] System concept
-   [ ] Digital pathology
-   [ ] AI-assisted analysis
-   [ ] How it works
-   [ ] Research/technology
-   [ ] Human + AI
-   [ ] CTA
-   [ ] Footer

### QA

-   [ ] Desktop
-   [ ] Tablet
-   [ ] Mobile
-   [ ] Images
-   [ ] Links
-   [ ] Animations
-   [ ] Console
-   [ ] Broken assets

**Gate:** public website is visually complete.

------------------------------------------------------------------------

# PHASE 6 --- Database Design

**Do not write migrations before designing the data model.**

### For every entity

-   [ ] Purpose
-   [ ] Every field
-   [ ] Field type
-   [ ] Required/nullable
-   [ ] Default
-   [ ] Unique?
-   [ ] Primary key
-   [ ] Foreign key
-   [ ] Relationship
-   [ ] Who creates it?
-   [ ] Who edits it?
-   [ ] Who can see it?
-   [ ] Is it sensitive?
-   [ ] Should API expose it?
-   [ ] Should it be hidden?

### Deliverable

-   [ ] ERD
-   [ ] Approved field list
-   [ ] Relationship list

**Gate:** only then create migrations.

------------------------------------------------------------------------

# PHASE 7 --- Migrations / Models / Eloquent

### Checklist per model

-   [ ] Migration
-   [ ] Model
-   [ ] `$fillable`
-   [ ] `$casts`
-   [ ] `$hidden` where needed
-   [ ] Relationships
-   [ ] Factory
-   [ ] Seeder
-   [ ] Migration test
-   [ ] Model test

### Laravel concepts

-   [ ] `foreignId`
-   [ ] `constrained`
-   [ ] `cascadeOnDelete`
-   [ ] `hasMany`
-   [ ] `belongsTo`
-   [ ] `belongsToMany` only if actually needed
-   [ ] Eager loading
-   [ ] Pagination

**Gate:** database can be rebuilt and seeded from code.
Relation:
Patient
   hasMany MedicalCases

MedicalCase
   belongsTo Patient
   belongsTo Doctor
   hasMany Slides
   hasMany AiAnalyses
   hasMany DoctorReviews
   hasMany Reports

Slide
   belongsTo MedicalCase

AiAnalysis
   belongsTo MedicalCase

DoctorReview
   belongsTo MedicalCase
   belongsTo Doctor

Report
   belongsTo MedicalCase
   belongsTo Doctor

User
   hasMany MedicalCases
   hasMany DoctorReviews
   hasMany Reports

------------------------------------------------------------------------

# PHASE 8 --- Authentication

Use Laravel Breeze with Blade + Alpine.

-   [ ] Login
-   [ ] Logout
-   [ ] Password hashing
-   [ ] Password reset if required 

-   [ ] Auth middleware 
-   [ ] Validation
-   [ ] Rate limiting مش ع كلشي طبقته  عليهن
-   [ ] Error handling

**Gate:** guests cannot access protected pages.

------------------------------------------------------------------------

# PHASE 9 --- Authorization

Define roles only after requirements are confirmed.

Possible: - `admin` - `doctor`

### Checklist

-   [ ] Role field
-   [ ] Role excluded from mass assignment
-   [ ] Role middleware
-   [ ] Middleware alias in `bootstrap/app.php`
-   [ ] Protected route groups
-   [ ] 403 page
-   [ ] Unauthorized tests
**Security rule:** never trust a submitted `role` value.

------------------------------------------------------------------------

# PHASE 10 --- Cases CRUD

First complete Laravel CRUD module.

### Features

-   [ ] Index
-   [ ] Show
-   [ ] Create
-   [ ] Store
-   [ ] Edit
-   [ ] Update
-   [ ] Delete / soft delete if required
-   [ ] Search
-   [ ] Filter
-   [ ] Pagination
-   [ ] Flash messages

### Laravel

-   [ ] Resource Controller
-   [ ] `Route::resource`
-   [ ] Route Model Binding
-   [ ] Form Request
-   [ ] Validation
-   [ ] Eloquent CRUD
-   [ ] Blade loops/conditions

**Gate:** Cases work end-to-end.

------------------------------------------------------------------------

# PHASE 11 --- Slide/File Management

For sensitive medical files, prefer private storage.

### Checklist

-   [ ] Upload form
-   [ ] `multipart/form-data` مش فاهمها 
-   [ ] `@csrf`
-   [ ] File validation
-   [ ] File type validation
-   [ ] File size validation
-   [ ] Storage decision
-   [ ] Save path
-   [ ] Protected route
-   [ ] Authorization before serving
-   [ ] Delete/cleanup strategy
-   [ ] Invalid-file tests

**Gate:** only authorized users can access protected files.

------------------------------------------------------------------------

# PHASE 12 --- Case Details / Slide Viewer

### Screen

-   [ ] Case information
-   [ ] Approved patient fields
-   [ ] Specimen information
-   [ ] Slide information
-   [ ] Slide viewer لازم أفهم الكود يلي ضافو بالجافا سكربت وايش عمل ب env وشو ضاف وكيف خلاه السريفر يفهم العلاقات المودودة لحتى قدر يعرض الصورة 
-   [ ] Analysis status
-   [ ] Actions
-   [ ] Review status

**Gate:** doctor can understand the whole current case from one screen.
Doctor opens Case
        ↓
Laravel Blade page
        ↓
HTML creates empty Viewer area
        ↓
JavaScript / OpenSeadragon starts
        ↓
asks Laravel for slide information
        ↓
Laravel checks doctor authorization
        ↓
Laravel calls FastAPI
        ↓
FastAPI uses OpenSlide
        ↓
returns dimensions / levels
        ↓
OpenSeadragon decides which Tiles it needs
        ↓
asks Laravel:
/tiles/13/0/10
        ↓
Laravel checks permission again
        ↓
Laravel asks FastAPI
        ↓
OpenSlide reads that region from original TIFF
        ↓
temporary PNG tile
        ↓
FastAPI
        ↓
Laravel
        ↓
Browser
        ↓
OpenSeadragon places tile in correct position
------------------------------------------------------------------------

# PHASE 13 --- AI Integration Boundary

Laravel remains the main application.

``` text
Laravel
  ↓
Case / Slide
  ↓
Python model
  ↓
JSON result
  ↓
Laravel
  ↓
Database
```

### Before integration

-   [ ] Confirm model input
-   [ ] Confirm model output
-   [ ] Confirm Python environment
-   [ ] Confirm required packages
-   [ ] Confirm execution method
-   [ ] Run model independently
-   [ ] Define JSON contract

Example contract:

``` json
{
  "status": "...",
  "prediction": "...",
  "score": 0.0,
  "model_version": "..."
}
```

Only include fields the model actually returns.

**Gate:** model works independently before Laravel calls it.

------------------------------------------------------------------------

# PHASE 14 --- AI Analysis

-   [ ] Analysis request
-   [ ] Loading state
-   [ ] Timeout handling
-   [ ] Failure handling
-   [ ] Validate returned JSON
-   [ ] Save result
-   [ ] Save model/version information
-   [ ] Timestamp
-   [ ] Display result
-   [ ] Prevent accidental duplicate runs

**Gate:** analysis can be triggered from Laravel and stored correctly.

------------------------------------------------------------------------

# PHASE 15 --- Doctor Review

Keep AI output and doctor judgment separate.

-   [ ] Show AI result
-   [ ] Show score
-   [ ] Show case/slide
-   [ ] Doctor decision
-   [ ] Doctor notes
-   [ ] Save review
-   [ ] Reviewer identity
-   [ ] Timestamp
-   [ ] Validation
-   [ ] Authorization

**Gate:** AI result and doctor review are separate records/concepts.

------------------------------------------------------------------------

# PHASE 16 --- Alpine.js

Use Alpine for real UI interactions:

-   [ ] Mobile sidebar
-   [ ] Dropdowns
-   [ ] Modals
-   [ ] Delete confirmation
-   [ ] Loading state
-   [ ] Tabs
-   [ ] Flash messages
-   [ ] AI button state
-   [ ] Live search where useful

------------------------------------------------------------------------

# PHASE 17 --- AJAX / Fetch

Use only where a full page reload hurts UX.

Possible: - \[ \] Case search - \[ \] Filters - \[ \] AI status - \[ \]
Small UI updates

### Check

-   [ ] Endpoint
-   [ ] Validation
-   [ ] JSON response
-   [ ] Loading
-   [ ] Error
-   [ ] Empty state
-   [ ] CSRF where applicable
-   [ ] Debounce

------------------------------------------------------------------------

# PHASE 18 --- REST API

Only add API endpoints that have a real purpose.

### Laravel concepts

-   [ ] `php artisan install:api`
-   [ ] `routes/api.php`
-   [ ] `apiResource`
-   [ ] JSON
-   [ ] HTTP status codes
-   [ ] API Resources
-   [ ] Sanctum if authentication is needed

Potential resources are decided after the database design.

------------------------------------------------------------------------

# PHASE 19 --- Postman

For every API endpoint:

-   [ ] GET success
-   [ ] POST success
-   [ ] PUT/PATCH success
-   [ ] DELETE success
-   [ ] Validation failure
-   [ ] Unauthorized
-   [ ] Not found
-   [ ] Correct JSON
-   [ ] Correct status code
-   [ ] Sensitive fields absent

Test: `200, 201, 204, 400, 401, 404, 422, 500`.

------------------------------------------------------------------------

# PHASE 20 --- Validation

For every form/API input:

-   [ ] Required
-   [ ] Type
-   [ ] Length
-   [ ] Allowed values
-   [ ] Unique
-   [ ] File type
-   [ ] File size
-   [ ] Authorization
-   [ ] Friendly errors
-   [ ] Use validated data

------------------------------------------------------------------------

# PHASE 21 --- Security Audit

### Authentication

-   [ ] Protected routes
-   [ ] Rate limiting
-   [ ] Password hashing

### Authorization

-   [ ] Middleware
-   [ ] Resource-level authorization where needed
-   [ ] No IDOR

### Input

-   [ ] Validation
-   [ ] Mass assignment protection
-   [ ] Escaped Blade output
-   [ ] No unsafe raw HTML

### Files

-   [ ] Private storage for sensitive files
-   [ ] File validation
-   [ ] Authorization before file response

### Environment

-   [ ] `.env` not committed
-   [ ] Secrets outside code
-   [ ] `APP_DEBUG=false` in production
-   [ ] Server points to `public/`

### API

-   [ ] API Resources
-   [ ] No password/hash/internal fields exposed

------------------------------------------------------------------------

# PHASE 22 --- Error Handling

Create custom pages:

-   [ ] 403
-   [ ] 404
-   [ ] 419
-   [ ] 429
-   [ ] 500
-   [ ] 503 if needed

**Gate:** production never exposes raw stack traces.

------------------------------------------------------------------------

# PHASE 23 --- Performance

-   [ ] Pagination
-   [ ] Eager loading
-   [ ] Avoid N+1
-   [ ] Limit API payloads
-   [ ] Optimize public images
-   [ ] Lazy-load heavy visuals
-   [ ] Avoid loading huge slide files unnecessarily
-   [ ] Prevent duplicate AI calls
-   [ ] Production asset build

------------------------------------------------------------------------

# PHASE 24 --- Pest Testing

### Routes

-   [ ] Public pages
-   [ ] Protected pages
-   [ ] Unauthorized access

### Authentication

-   [ ] Login success
-   [ ] Login failure
-   [ ] Logout

### Cases

-   [ ] Create
-   [ ] Read
-   [ ] Update
-   [ ] Delete/restore
-   [ ] Validation
-   [ ] Authorization

### Files

-   [ ] Valid upload
-   [ ] Invalid upload
-   [ ] Unauthorized access

### AI

-   [ ] Request
-   [ ] Invalid response
-   [ ] Stored result
-   [ ] Failure handling

### API

-   [ ] Success
-   [ ] Validation
-   [ ] Auth
-   [ ] 404
-   [ ] JSON shape

------------------------------------------------------------------------

# PHASE 25 --- Manual QA

### Doctor journey

`Login → Dashboard → Cases → Case → Slide → AI Analysis → Result → Review → Save`

### Checklist

-   [ ] Buttons
-   [ ] Forms
-   [ ] Links
-   [ ] Refresh
-   [ ] Back navigation
-   [ ] Empty states
-   [ ] Error states
-   [ ] Loading states
-   [ ] Desktop
-   [ ] Tablet
-   [ ] Mobile
-   [ ] Browser console

------------------------------------------------------------------------

# PHASE 26 --- Code Review

For every file:

-   [ ] One responsibility
-   [ ] Correct Laravel layer
-   [ ] Validation present
-   [ ] Authorization present
-   [ ] No trusted raw user input
-   [ ] No duplicated logic
-   [ ] No unnecessary package
-   [ ] Named routes
-   [ ] Correct relationships
-   [ ] Efficient queries
-   [ ] Sensitive fields protected

------------------------------------------------------------------------

# PHASE 27 --- Git Checkpoints

Commit every stable phase.

Examples:

``` text
chore: initialize Laravel project
feat: add application layout
feat: add public landing page
feat: add authentication
feat: add case management
feat: add slide upload
feat: add AI integration
feat: add doctor review
test: add case feature tests
test: add API tests
fix: security audit findings
```

------------------------------------------------------------------------

# PHASE 28 --- Production

-   [ ] Production `.env`
-   [ ] `APP_DEBUG=false`
-   [ ] Production database
-   [ ] Storage
-   [ ] HTTPS
-   [ ] Server points to `/public`
-   [ ] `npm run build`
-   [ ] Migrations
-   [ ] Logs
-   [ ] Backups
-   [ ] Permissions
-   [ ] Production smoke test

------------------------------------------------------------------------

# PHASE 29 --- Final Demo

``` text
Landing
→ Login
→ Dashboard
→ Cases
→ Case
→ Slide
→ AI Analysis
→ Result
→ Doctor Review
→ Saved Review
```

### Demo checklist

-   [ ] Demo account
-   [ ] Demo case
-   [ ] Demo slide
-   [ ] AI ready
-   [ ] Stable demo data
-   [ ] Backup plan for technical failure
-   [ ] No real patient-identifying data
-   [ ] Final browser test

------------------------------------------------------------------------

# Feature Definition of Done

A feature is complete only when:

``` text
Requirement
↓
Design
↓
Code
↓
Run
↓
Validation
↓
Authorization
↓
Security
↓
Pest test
↓
Manual test
↓
Responsive test
↓
Git commit
```

------------------------------------------------------------------------

# CURRENT START

We start with **PHASE 1 only**.

Do NOT build: - Dashboard - Database - AI - API - Patient fields

yet.

First verify the environment, create Laravel 13, run it, verify
Vite/Tailwind/Pest, initialize Git, and make the first clean commit.

After Phase 1 passes, move to Phase 2.

            OUTSIDE YOUR APP
────────────────────────────────────────────

Patient
   ↓
Biopsy / specimen
   ↓
Histopathology lab
   ↓
FFPE processing
   ↓
H&E staining
   ↓
Glass Slide
   ↓
WSI Scanner
   ↓
TIFF

               YOUR PLATFORM
────────────────────────────────────────────

Doctor Login
   ↓
Create Case
   ↓
Patient + Clinical Information
   ↓
Upload TIFF
   ↓
Private Storage
   ↓
Preprocessing
   ↓
HSV Tissue Detection
   ↓
Generate x/y Coordinates
   ↓
Virtual Patches
   ↓
MIL Inference
   ↓
Cancer / Non-Cancer + Probability
   ↓
WSI Viewer
   ↓
Doctor Reviews Slide + AI
   ↓
Diagnosis
Conclusion
Differential Diagnosis
etc.
   ↓
Final Report
   ↓
Completed
