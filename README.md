# Warehouse Management System (WMS)

ระบบจัดการคลังสินค้า (WMS) พัฒนาด้วย Laravel 11 และ Tailwind CSS ระบบนี้ถูกออกแบบมาเพื่อจัดการความเคลื่อนไหวของสินค้าภายในคลังอย่างเป็นระบบ พร้อมฟีเจอร์การรันหมายเลขล็อต (Batch) และซีเรียลนัมเบอร์ (Serial) โดยอัตโนมัติ

## ฟีเจอร์หลัก (Key Features)
- **🏢 จัดการคลังสินค้า (Warehouses):** เพิ่ม ลบ แก้ไข คลังสินค้าต้นทางและปลายทาง
- **📦 จัดการสินค้า (Products):** กำหนดรูปแบบการติดตามสินค้าได้ (รองรับระบบ Batch และ Serial)
- **👥 จัดการพนักงาน (Employees):** เก็บฐานข้อมูลพนักงานผู้ทำรายการเพื่อการตรวจสอบย้อนหลัง
- **🔄 ระบบทำรายการ (Transactions):** รองรับการ รับเข้า (IN) และ จ่ายออก (OUT)
- **⚙️ ระบบอัตโนมัติ (Automation):** ระบบจะสร้างเลข Batch หรือ Serial ให้อัตโนมัติเมื่อทำรายการรับเข้า

## ความต้องการของระบบ (Prerequisites)
- PHP >= 8.2
- Composer
- Node.js และ npm
- Git

## วิธีการติดตั้ง (Installation Guide)

1. **โคลนโปรเจกต์ (Clone the repository)**
   ```bash
   git clone https://github.com/boingKung/warehouse-system-laravel.git
   cd warehouse-system-laravel

2. **ติดตั้งไลบรารีของ PHP (Install PHP Dependencies)**
   ```bash
   composer install

3. **ติดตั้งแพ็กเกจของ Node.js และคอมไพล์ CSS/JS (Install Node Dependencies)**
   ```bash
   npm install
   npm run build

4. **ตั้งค่า Environment (Environment Setup)**
   คัดลอกไฟล์ .env.example เป็น .env และสร้าง App Key
   ```bash
   cp .env.example .env
   php artisan key:generate

5. **ตั้งค่าฐานข้อมูล (Database Setup - SQLite)**
   เข้าไปที่ไฟล์ `.env` และปรับค่าการเชื่อมต่อฐานข้อมูลให้เป็น SQLite:
   ```env
   DB_CONNECTION=sqlite
   # ลบบรรทัด DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD ทิ้งไปเลย

6. **จากนั้นทำการรัน Migration เพื่อสร้างตารางในฐานข้อมูล**
   ```bash
   php artisan migrate

7. **เปิดใช้งานเซิร์ฟเวอร์จำลอง (Run the application)**
   ```bash
   php artisan serve

8. **เปิดใช้งานเคำสั่งเพื่อแสดงผลหน้าจอของ Tailwind**
    เปิด cmd อีกหนึ่งหน้าเพื่อ run คำสั่ง
   ```bash
   npm run dev

เข้าถึงเว็บไซต์ได้ที่: `http://127.0.0.1:8000`
## การเริ่มต้นใช้งาน (Getting Started)
1. เข้าไปที่หน้าเว็บ และพิมพ์ URL `/register` หรือกดปุ่ม register เพื่อสมัครบัญชีผู้ดูแลระบบ (Admin) บัญชีแรก
2. ตั้งค่าข้อมูลพื้นฐาน ได้แก่ พนักงาน, คลังสินค้า และ สินค้า
3. เริ่มต้นทำรายการที่เมนู "รับ / จ่าย / ย้าย"
    

