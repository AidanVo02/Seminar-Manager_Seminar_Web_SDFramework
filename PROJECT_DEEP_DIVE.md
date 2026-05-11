# Seminar Manager - Project Deep Dive

This document explains the whole project in one place so you can understand the system end to end without jumping through many files.

## 1. What This Project Is

Seminar Manager is a Laravel-based academic workflow app for university seminar classes.

It manages the full lifecycle of a seminar topic:

1. A lecturer creates a topic.
2. A student registers for that topic.
3. The lecturer approves or rejects the registration.
4. The student uploads a report.
5. The lecturer reviews the report and requests changes if needed.
6. The student resubmits the report.
7. The lecturer schedules the presentation.
8. The lecturer publishes the score and comment.
9. Admins can manage users and review the whole system.
10. The AI assistant helps explain the project and workflow.

The project is designed to be practical for a class seminar demo, but the structure is close to a real academic workflow system.

## 2. Why The Project Exists

The project was built to solve a simple classroom problem:

- seminar workflow is usually split across many manual steps
- topic tracking, registration, report review, and grading are hard to manage by hand
- teachers and students need a simple shared system
- the project also needs to demonstrate modern Laravel features and AI integration

So this app combines:

- role-based access control
- topic management
- registration workflow
- submission review
- presentation scheduling
- scoring
- analytics
- AI-assisted support

## 3. Current Runtime Setup

The codebase supports Laravel conventions and can be adapted to different database engines, but the current working local setup on this machine is:

- SQL Server 2022 Express
- Windows Authentication
- `sqlsrv` and `pdo_sqlsrv` PHP extensions
- Laravel 13
- PHP 8.3

The project was switched from SQLite local demo mode to SQL Server local mode because:

- SQL Server behaves more like a real production database
- it exposes schema issues that SQLite hides
- it gives more realistic multi-user persistence

## 4. User Roles

The app has four role levels:

### Guest

Guest users are not authenticated.

They can:

- see the login page

They cannot:

- open protected pages
- view topics
- register topics
- upload reports
- use AI chat
- manage users

### Student

Students are the main participants in the seminar workflow.

They can:

- browse topics
- search and filter topics
- register for a topic
- upload a report
- delete their own report
- resubmit after review
- see presentation schedule
- see score and lecturer feedback
- use AI chat

They cannot:

- create topics
- manage users
- review other students' reports
- schedule presentations
- publish final scores

### Lecturer

Lecturers manage the academic workflow.

They can:

- create and edit topics
- assign topics to themselves or other lecturers if allowed by the UI
- approve or reject registrations
- review reports
- request changes
- accept reports
- schedule presentations
- publish scores and comments
- use AI chat

They cannot:

- manage users
- edit student-only data
- delete other users' reports unless the controller explicitly allows admin-level actions

### Admin

Admins have the widest access.

They can:

- manage users
- manage topics
- review registrations
- view system-wide dashboard data
- access activity logs
- access AI chat
- download and delete reports as a management action

## 5. End-to-End Workflow

This is the core seminar lifecycle.

### Step 1: Lecturer logs in

The lecturer opens the login page and enters credentials.

Important files:

- `routes/web.php`
- `app/Http/Controllers/AuthController.php`
- `resources/views/auth/login.blade.php`

### Step 2: Lecturer creates a topic

The lecturer creates a seminar topic with:

- title
- description
- category
- capacity
- semester
- difficulty
- expected outcomes

Important files:

- `app/Http/Controllers/TopicController.php`
- `resources/views/topics/create.blade.php`
- `resources/views/topics/partials/form.blade.php`

### Step 3: Student opens the topic list

The student browses topics using search and filters.

Important files:

- `resources/views/topics/index.blade.php`
- `app/Http/Controllers/TopicController.php`

### Step 4: Student registers for a topic

The student registers for one topic.

The registration is the central record of the workflow.

Important files:

- `app/Http/Controllers/RegistrationController.php`
- `app/Models/Registration.php`

### Step 5: Lecturer approves or rejects

The lecturer reviews the registration and decides whether it is accepted.

Important files:

- `app/Http/Controllers/RegistrationController.php`
- notifications in `app/Support/SeminarNotifier.php`

### Step 6: Student uploads a report

The student uploads a document:

- PDF
- DOC
- DOCX

Important files:

- `app/Http/Controllers/SubmissionController.php`
- `app/Models/Submission.php`

### Step 7: Lecturer reviews the report

The lecturer can:

- accept the report
- request changes
- add review notes

Important files:

- `SubmissionController.php`
- `resources/views/topics/show.blade.php`

### Step 8: Student resubmits

If changes are requested, the student uploads a new version.

The system tracks revision numbers and review state.

### Step 9: Lecturer schedules the presentation

The lecturer sets:

- presentation date
- time
- room

Important files:

- `app/Http/Controllers/PresentationController.php`
- `resources/views/presentations/form.blade.php`

### Step 10: Lecturer publishes score

The lecturer enters:

- numeric score
- comment

Important files:

- `app/Http/Controllers/ScoreController.php`

### Step 11: System tracks activity

Important actions are stored in activity logs so the system is auditable.

Important files:

- `app/Http/Controllers/ActivityLogController.php`
- `app/Support/ActivityLogger.php`
- `resources/views/activity/index.blade.php`

### Step 12: AI assistant helps explain the system

The AI assistant can answer project questions, explain workflow, and summarize the app.

Important files:

- `app/Http/Controllers/AiChatController.php`
- `app/Support/SeminarAiChat.php`
- `app/Support/SeminarKnowledgeBase.php`
- `resources/views/ai-chat.blade.php`
- `resources/js/components/AiChat.jsx`

## 6. Database Overview

The main database tables are:

- `users`
- `topics`
- `registrations`
- `submissions`
- `presentations`
- `scores`
- `activity_logs`
- `ai_chat_conversations`
- `ai_chat_messages`

Support tables from Laravel are also used:

- `cache`
- `jobs`
- `sessions` if database session mode is enabled

### Why `registrations` is the center

`registrations` connects:

- the student
- the topic
- the report submission
- the presentation schedule
- the final score

That is why this table acts as the hub of the workflow.

## 7. Important Table Relationships

### users

Stores all account types.

Fields include:

- name
- email
- password
- role
- department
- student_code
- cohort

### topics

Stores seminar topics.

Fields include:

- title
- description
- lecturer_id
- status
- category
- capacity
- semester
- difficulty
- expected_outcomes

### registrations

Links a student to a topic.

Fields include:

- topic_id
- student_id
- status
- timestamps

### submissions

Tracks uploaded reports.

Fields include:

- registration_id
- file_path
- original_name
- mime_type
- size
- note
- review_status
- review_note
- reviewed_by
- reviewed_at
- revision_number

### presentations

Stores the presentation schedule for a registration.

Fields include:

- registration_id
- presentation_date
- room
- time
- notes

### scores

Stores the final evaluation.

Fields include:

- registration_id
- score
- comment
- published_at

### activity_logs

Stores important events:

- topic created
- registration approved
- report uploaded
- report reviewed
- presentation scheduled
- score published

### AI chat tables

Stores conversation history for each user:

- `ai_chat_conversations`
- `ai_chat_messages`

## 8. Frontend Architecture

The project uses a hybrid frontend:

- Blade for most pages
- React for interactive dashboard analytics and AI chat components

### Why this hybrid approach was chosen

This keeps the project practical:

- Blade handles the core CRUD pages quickly
- React handles higher-interaction surfaces
- the app stays easy to explain in a class seminar
- no full SPA rewrite is needed

### Main UI surfaces

- login page
- dashboard
- topic list
- topic detail
- AI chat
- user management
- report form

## 9. Server-Side Architecture

The Laravel application is organized in the usual layers:

### Controllers

Controllers handle request validation and orchestration.

### Models

Models represent database records and relationships.

### Support classes

Custom support classes keep non-controller logic out of controllers.

Examples:

- `SeminarNotifier`
- `SeminarAiChat`
- `SeminarKnowledgeBase`
- `ActivityLogger`

### Views

Blade views render the UI.

### React components

React is used for the analytics panel and AI chat interface.

## 10. Key Routes

The most important routes are:

- `/login`
- `/dashboard`
- `/topics`
- `/topics/create`
- `/topics/{topic}`
- `/topics/{topic}/register`
- `/submissions`
- `/presentations`
- `/scores`
- `/activity`
- `/users`
- `/ai-chat`

These routes are protected by authentication and role middleware.

## 11. Permission Model

The app uses middleware and controller-level checks.

Important ideas:

- guests are blocked from protected pages
- students cannot create topics or manage users
- lecturers cannot access user management
- admins can access the broadest set of pages

This is covered in detail in `USER_PERMISSIONS.md`.

## 12. AI Chat Design

The AI assistant has two modes:

### Local demo mode

If no OpenAI key is configured, the assistant still replies using local knowledge.

### OpenAI mode

If OpenAI credentials are configured, the assistant can use the API while still being grounded by project context.

The assistant knows about:

- project overview
- database structure
- role permissions
- seminar workflow
- React dashboard
- SQL Server setup
- common error cases

## 13. SQL Server Setup Notes

The current local setup is SQL Server based.

What matters:

- SQL Server 2022 Express is installed
- the `sqlsrv` and `pdo_sqlsrv` PHP extensions are enabled
- the ODBC Driver 18 is installed
- the database `seminar_manager` exists
- Laravel `.env` points to SQL Server

### Why SQL Server was needed

SQLite was fine for quick demo work, but SQL Server is better for:

- persistence
- realistic multi-user behavior
- catching schema issues early
- matching a more production-like setup

### SQL Server-specific fixes made

SQL Server rejected some patterns that SQLite allowed.

Fixes included:

- making the lecturer foreign key nullable with `nullOnDelete()`
- changing `submissions.reviewed_by` to `NO ACTION`
- removing a nullable unique constraint from `student_code`
- renaming the presentations migration so dependencies run in the correct order

## 14. Common Mistakes And What They Mean

### Route says 404 for create topic

Usually means the route order or cached config is wrong.

### AI chat box does not show

Usually means Vite is not running or the fallback Blade form has not loaded.

### SQL Server migration fails with foreign key cascade path errors

This is a SQL Server constraint issue, not a Laravel syntax issue.

Usually fixed by:

- removing extra cascade paths
- using `nullOnDelete()`
- using `noActionOnDelete()`

### Unique index fails on nullable fields

SQL Server treats `NULL` differently from SQLite.

If a nullable column is unique in SQL Server, it may only allow one `NULL`.

### Vite / Tailwind fails on Windows

This is an environment issue, not the Laravel app itself.

The app can still run with Blade pages even if the frontend build is not available.

## 15. What To Read First

If you want the fastest understanding order:

1. `README.md`
2. `PROJECT_OVERVIEW.md`
3. `PROJECT_DEEP_DIVE.md` this file
4. `USER_PERMISSIONS.md`
5. `DATABASE.md`
6. `ARCHITECTURE.md`
7. `API_FLOW.md`
8. `AI_KNOWLEDGE_BASE.md`
9. `SEMINAR_SCRIPT.md`
10. `LECTURER_PRESENTATION.md`

## 16. One-Sentence Summary

Seminar Manager is a Laravel academic workflow system that manages seminar topics, registrations, submissions, reviews, scheduling, scores, analytics, and AI-assisted guidance in one project.
