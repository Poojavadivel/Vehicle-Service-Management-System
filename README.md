# Vehicle-Service-Management-System
🚗 Vehicle Service Center Management System

A complete web-based application designed to digitalize and simplify the workflow of a vehicle service center.
This system manages customer registration, vehicle service requests, staff assignment, service tracking, and payment updates in an organized manner.


---

🔥 Features

🧑‍💼 Admin

Login with secure credentials

View all service requests

Assign staff to each request

Track service progress

Send payment requests to customers

Manage customer and staff information


👤 Customer

New Customer: Register & submit vehicle details

Existing Customer: Log in using Customer ID & Vehicle ID

Track service status (Pending → In Progress → Completed)

View assigned staff

View payment request and complete payment


👨‍🔧 Staff

Login using Staff ID & Password

View assigned service jobs

Update service status

Progress automatically updates for Admin & Customer



---

🗄 Database Overview

The system uses the following core tables:

Table Name	Description

customer	Stores customer personal details
vehicle	Stores vehicle info & links to customers
service_request	Tracks service type, status, amount & staff assignment
staff	Stores staff details and login credentials
admin	Admin login credentials


Relationships ensure smooth service tracking across all modules.


---

🔧 Tech Stack

Frontend: HTML, CSS

Backend: PHP

Database: MySQL

Server: XAMPP / WAMP / Localhost



---

🎯 Purpose of the Project

This system is built to help small and medium service centers manage operations more efficiently.
It replaces manual processes with a fully digital workflow, making service monitoring easier for customers, staff, and admin.


---

📌 Project Flow (Summary)

1. Customer registers → gets Customer ID


2. Adds vehicle details → service request created automatically


3. Admin assigns staff


4. Staff updates service progress


5. Admin sends payment request


6. Customer views and completes payment
