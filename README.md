# 📚 BookMaster

BookMaster is a web-based inventory and sales management system designed for bookstores or similar businesses. It allows administrators to manage products, employees, roles, and sales efficiently through an intuitive dashboard.

> **📌 Note**: The interface is in **Spanish**, as this project was developed for a university course in a Spanish-speaking environment.

## 🚀 Features

- ✅ User authentication (login/logout)
- 📦 Product management (add, edit, delete)
- 👥 Employee and role management
- 🛒 Sales module with dynamic sale details
- 📊 Basic data visualization and sales summary
- 🔐 Role-based access control

## 🧩 Technologies Used

- **PHP (with PDO)** – Secure and object-oriented database interaction
- **MySQL** (Database)
- **JavaScript & jQuery** (Frontend interaction)
- **Bootstrap** (UI Components)
- **Font Awesome** (Icons)

## 🛠️ Folder Structure
```
BookMaster/ 
  ├── 📁 app/ 
  │   ├── 📁 controllers/ 
  │   ├── 📁 Models/ 
  |   ├── 📁 Services/ # fetchs towards the controllers
  │   ├── 📁 Views/ 
  |   |     ├── 📁 assets/ 
  │   |     |     ├── 📁 css/ 
  │   |     |     ├── 📁 fonts/
  │   |     |     ├── 📁 img/ 
  │   |     |     └── 📁 js/ 
  |   |     ├── 📁 customer/
  |   |     ├── 📁 employee/
  |   |     ├── 📁 includes/
  |   |     ├── 📁 product/
  |   |     ├── 📁 role/
  |   |     ├── 📁 sale/
  |   |     ├── 📁 supplier/
  |   ├── index.php (dashboard)
  │   └── logout.php # close session
  ├── 📁 conf/ 
  │     ├── conf.php # db connection
  │     └── funciones.php # utitilies functions
  ├── index.php (login page)
```

## 👤 Default Roles

The application supports **three user roles** by default:

- **Administrator** – Full access to the system (CRUD on all modules)
- **Manager** – Limited access (sales, products, suppliers, customers)
- **Seller** – Focused on sales operations (can create sales, add customers)

> ⚠️ The role logic is enforced in both frontend and backend for security.

## 🌐 Live Demo

Access the application here:  
🔗 [https://bookmaster.wuaze.com](https://bookmaster.wuaze.com)

### 🔐 Demo Login

You can try the system with a limited access test account:

- **Username**: `visitor`  
- **Password**: `visitor`  

This account has a **Seller** role, and can access the sales module and basic client functionality only.

> 🚨 For security reasons, please avoid entering real or sensitive data in the demo.

## 🔒 Security Notes

- All admin pages are protected by session checks.
- Passwords are hashed using `md5()` (⚠️ consider using `password_hash()` for production).
- Database queries are handled securely using **PHP PDO** with prepared statements.

## 📌 Future Improvements

- Export reports to PDF/Excel
- Use `password_hash()` for more secure logins

## 📧 Contact

If you have any questions or suggestions, feel free to reach out!
---





  
