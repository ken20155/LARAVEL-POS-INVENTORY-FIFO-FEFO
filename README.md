POS-INVENTORY-FIFO-FEFO

(Point of Sale & Inventory Management System)

📄 Description

POS-INVENTORY-FIFO-FEFO is a web-based Point of Sale and inventory management system designed to efficiently track product movement using FIFO (First-In, First-Out) and FEFO (First-Expired, First-Out) methods. The system ensures accurate stock handling, especially for perishable and time-sensitive items.

It integrates sales processing, automated email receipts, audit logging, analytics dashboards, and SMS notifications for low-stock alerts. Built with Laravel, this system is ideal for retail stores, warehouses, pharmacies, and small-to-medium businesses, as well as academic and portfolio projects.

🚀 Features
🛒 Point of Sale (POS)

Sales transaction processing

Real-time stock deduction

Digital receipt generation

Email receipt sending to customers

📦 Inventory Management (FIFO / FEFO)

FIFO stock handling for non-perishable goods

FEFO stock handling for perishable goods

Batch and expiration date tracking

Automatic stock prioritization

📧 Email Receipt

Automatic email receipt after successful transaction

Customizable receipt template

Transaction history reference

📊 Analytics & Reports

Sales performance charts

Inventory movement analytics

Best-selling and low-performing products

Date-based and category-based reports

🔍 Audit Logs

User activity tracking

Sales and inventory action logs

Timestamped system events

Improved accountability and traceability

📱 SMS Notifications

Automated SMS alerts for low stock items

Threshold-based notifications

Mobile-friendly alert system for admins

👥 User & Access Control

Secure authentication

Role-based access (Admin, Cashier, Manager)

User activity monitoring

🛠️ Tech Stack

Backend: Laravel

Frontend: Blade / Bootstrap 5

Database: MySQL / SQL Server

Charts: Chart.js / ApexCharts

Email: Laravel Mail

SMS: SMS Gateway API (Twilio / local provider)

Authentication: Laravel Auth

Server: Apache / Nginx / IIS

📂 Project Structure
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── web.php
│   └── api.php
├── resources/
│   ├── views/
│   └── js/
├── public/
├── .env
├── composer.json
└── README.md

⚙️ Installation & Setup
1️⃣ Clone the repository
git clone https://github.com/your-username/pos-inventory-fifo-fefo.git
cd pos-inventory-fifo-fefo

2️⃣ Install dependencies
composer install

3️⃣ Environment configuration
cp .env.example .env
php artisan key:generate


Update database and service credentials in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_inventory_db
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Run migrations
php artisan migrate

5️⃣ Run the application
php artisan serve


Open in browser:

http://127.0.0.1:8000

📬 Email Receipt Setup

Configure mail credentials in .env

Supports SMTP (Gmail, Outlook, custom mail servers)

Receipts are automatically sent after checkout

📱 SMS Low Stock Alert Setup

Configure SMS gateway credentials

Set minimum stock threshold per item

System sends SMS notifications when stock reaches critical level

🔐 User Roles

Admin – Full system control and configuration

Manager – Inventory monitoring and reports

Cashier – POS transactions only

🧪 Testing
php artisan test

📈 Future Enhancements

Mobile POS application

Barcode / QR code scanning

Supplier purchase order module

Multi-branch inventory support

Offline POS mode with sync

AI-based demand forecasting

🤝 Contribution

Contributions are welcome!

Fork the repository

Create a feature branch

Commit your changes

Submit a pull request

📄 License

This project is licensed under the MIT License.

👨‍💻 Author

Kee Ken
Laravel & ASP.NET Developer
📍 Philippines
