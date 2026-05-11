# User Permissions Guide

This document explains what each user role can do and what it cannot do in Seminar Manager.

## 1. Roles in the System

The application uses three main roles:

- `admin`
- `lecturer`
- `student`

These roles are enforced both in the UI and in the route middleware.

## 2. Admin

### What Admin Can Do

- log in and access the dashboard
- view system-wide seminar statistics
- manage all users
- create, edit, and delete users
- create seminar topics
- edit seminar topics
- delete seminar topics
- assign a lecturer to a topic
- approve or reject registrations
- review report submissions
- download any report for moderation or review
- delete seminar reports as an admin maintenance action
- request changes on submissions
- schedule presentations
- assign or update scores
- view activity logs
- open printable topic summaries
- use AI chat

### What Admin Cannot Do

- register as a student for a topic
- upload seminar reports as a student
- act as the owner of a student submission workflow
  - student-only upload and resubmission routes are protected by middleware

### Typical UI Access

- dashboard
- topics
- user management
- activity logs
- AI chat

## 3. Lecturer

### What Lecturer Can Do

- log in and access the dashboard
- create seminar topics
- edit seminar topics
- delete seminar topics
- view the topics they supervise
- approve or reject student registrations for their topics
- review seminar reports
- download reports for topics they supervise
- request changes on a report
- accept a report
- schedule presentations
- assign or update scores
- open printable topic summaries
- view activity logs for related workflow actions
- use AI chat

### What Lecturer Cannot Do

- create or manage user accounts
- act as a student registration owner
- upload seminar reports as a student
- access admin-only user management pages

### Typical UI Access

- dashboard
- topics
- topic details
- presentation forms
- score forms
- activity logs
- AI chat

## 4. Student

### What Student Can Do

- log in and access the dashboard
- browse topics
- search and filter topics
- view topic details
- register for an open topic
- upload a seminar report
- replace or delete their own report
- download their own report
- resubmit after feedback
- see review notes
- see presentation schedule
- see score and comment
- use AI chat

### What Student Cannot Do

- create or edit seminar topics
- delete seminar topics
- assign lecturers
- approve or reject registrations
- review other students' reports
- schedule presentations
- assign scores
- manage users
- access admin-only pages

### Typical UI Access

- dashboard
- topic list
- topic detail
- AI chat

## 5. Guest / Not Logged In

### What a Guest Can Do

- open the login page
- submit login credentials

### What a Guest Cannot Do

- access the dashboard
- open topics
- use AI chat
- manage topics or users
- submit reports

## 6. Route Protection Summary

The project uses route-level protection so actions are not only hidden in the UI, but also blocked on the server.

Examples:

- `role:admin`
- `role:lecturer,admin`
- `role:student`

This means the UI and backend both enforce the same business rules.

## 7. Why This Matters

This role design keeps the seminar workflow clear:

- students only do student work
- lecturers only do academic supervision work
- admins oversee the whole system

That makes the project easier to explain in class and safer in real use.
