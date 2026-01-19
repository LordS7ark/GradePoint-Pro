# 🎓 GradePoint Pro | Student Grading System

A specialized **Academic Management System** built with **PHP and MySQL**. Designed to help educators automate the calculation of student results, track performance across subjects, and generate printable report cards.



## 🌟 Key Features

* **Student Information Management:** Register and search for students using unique Registration Numbers.
* **Automated Grading Logic:** Input CA and Exam scores; the system instantly calculates:
    * Total Scores (CA + Exam)
    * Letter Grades (A, B, C, D, F) based on standard Nigerian grading scales.
* **Dynamic Search:** Real-time search bar to find students by Name or Reg No using SQL `LIKE` queries.
* **Professional Report Cards:** A dedicated view for each student that summarizes all subjects, calculates the **Grand Total**, and generates a **Percentage Average**.
* **Print-Optimized Layout:** Uses CSS `@media print` to ensure report cards look professional when printed or saved as PDF.

## 📊 Grading Scale Implemented

The system follows a standard academic scale:
- **70 - 100%**: A (Excellent)
- **60 - 69%**: B (Very Good)
- **50 - 59%**: C (Credit)
- **45 - 49%**: D (Pass)
- **0 - 44%**: F (Fail)

## 🛠️ Tech Stack

* **Backend:** PHP 8.x
* **Database:** MySQL (Relational)
* **Frontend:** HTML5, CSS3 (Custom Flexbox Layouts)
* **Server:** XAMPP / Apache

## ⚙️ Installation & Setup

1.  Clone the repository:
    ```bash
    git clone [https://github.com/LordS7ark/GradePoint-Pro.git](https://github.com/LordS7ark/GradePoint-Pro.git)
    ```
2.  Import the database: 
    - Open phpMyAdmin.
    - Create a database named `grading_db`.
    - Import the `grading_db.sql` file provided in this repo.
3.  Configure Connection: Update the `$conn` settings in `index.php` if your local MySQL credentials differ.
4.  Run: Access via `http://localhost/grading_system`.

## 🧠 Technical Highlights

- **Relational Integrity:** Implemented **Foreign Keys** with `ON DELETE CASCADE` to ensure that if a student is removed, their marks are cleaned up automatically.
- **SQL Aggregation:** Utilized `AVG()` and `SUM()` functions to generate performance summaries without heavy manual PHP processing.
- **Form Validation:** Integrated HTML5 constraints to ensure CA and Exam scores do not exceed their respective maximums (40 and 60).

---
Developed by **LordS7ark** 🚀