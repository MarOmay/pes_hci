# HCI Performance Evaluation System

A Web-based system using PHP, JavaScript and Bootstrap used by approx. 2000 students and 40 teaching and non-teaching employees of Headwaters College - Elizabeth Campus Inc.

Source codes are intentionally hidden. Contact the institution for verification.

## Login Screen
- Students must register first using their LRN's, which also serves as their username
- Instructors must login using Admin-issued accounts (Default passwords are system-generated and may be changed once logged-in)
![Login](https://github.com/MarOmay/pes_hci/blob/main/login_screen.png)

## Homepage - Student (Student-to-Instructor) and Faculty (Peer-to-Peer)
- Students will only be able to evaluate instructors tagged with their respective Class Section
- Instructors will be able to evaluate all teaching and non-teaching employees enrolled in the system
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/homepage.png)

## Evaluation Form
- Allows users to give ratings and feedbacks to corresponding factors
- Evaluation per instructor can only be submitted once. 
- Submitting an evaluation will remove the name of the instruction from the dropdown selection for the respective user
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/eval_form.png)

## Navigation and Menu
- Allows users to give ratings and feedbacks to corresponding factors
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/nav.png)

## Admin Control Panel - Administrator's View
- Managing student accounts (Edit Info, Reset Password, Delete Account)
- Managing instructor accounts (Create New, Edit Info, Reset Password, Delete Account)
- Managing Sections (Add New, Delete, Remove faulty-section tagging)
- Managing evaluation factors (Adding new, modifying exiting, adjusting factor score weight, delete)
- Generating Reports (Summary of Evaluations, Positive and Negative Comments, Detailed reports)
- Reset Database (Recommended to be done after all evaluations are submitted and reports are generated)
![Control](https://github.com/MarOmay/pes_hci/blob/main/admin_home.png)

## Faculty accounts management
- Admins can create, modify, reset the password of, and delete the account of an instructor
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/manage_emp.png)

## Reports preview and Generation
- Evaluations submitted by students are generated separately from the faculty evaluations
- May be generated by Summary, Detailed or Comments only
- Reports are downloaded as Spreadsheets
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/report_summary.png)
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/report_comments.png)

## Reset Database
- Recommeded to be performed after all evaluations are submitted and reports are generated
- Removes all evaluations only
- Retains the Students and Faculty accounts
- Retains Section-Faculty tagging (use manage sections to remove all tagging)
![Homepage](https://github.com/MarOmay/pes_hci/blob/main/reset_db.png)

