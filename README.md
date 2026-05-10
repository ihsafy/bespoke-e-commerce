# RORA Luxe - Premium E-commerce Platform

## ৳ Overview

RORA Luxe is a bespoke, high-end e-commerce solution designed specifically for the luxury retail market in Bangladesh.

It features a sophisticated **Gold & Dark** aesthetic, specialized currency localization, and a robust administrative backend for seamless inventory management.

---

# ✨ Key Features

## Front-End (User Experience)

### 🇧🇩 Localized for Bangladesh
- Native support for the Taka symbol (৳)
- Local currency formatting

### 🔍 Dynamic Filtering
Users can filter products by:
- Main categories
  - Bags
  - Watches
  - Clothes
- Subcategories

### ⚡ Advanced Sorting
Real-time sorting capabilities:
- Price: High to Low
- Price: Low to High
- Newest Arrivals

### 📱 Responsive Luxury UI
- Clean grid-based interface
- Optimized for desktop and mobile devices
- Premium luxury-inspired design system

---

# 🛠 Back-End (Admin Command Center)

## 📊 Animated Dashboard
- Real-time inventory visualization
- Interactive analytics using Chart.js

## 📦 Smart Inventory Management
Complete CRUD operations:
- Create products
- Read products
- Update products
- Delete products

Includes:
- Secure image uploads
- Product management tools

## 🗂 Hierarchical Categories
Supports:
- Parent categories
- Subcategories
- Organized premium collections

## 🛡 Safety Guards
Logic-based protection to:
- Prevent deletion of categories
- Ensure categories with active products remain protected

---

# 💻 Tech Stack

| Technology | Usage |
|---|---|
| PHP 8.x | Backend Language |
| MySQL | Database |
| HTML5 | Structure |
| CSS3 | Styling |
| JavaScript (Vanilla) | Frontend Functionality |
| Chart.js | Data Visualization |
| FontAwesome | Icons |
| Google Fonts | Typography |

---

# 📁 Project Structure

```bash
├── admin/
│   ├── categories.php         # Category & Subcategory management
│   ├── dashboard.php          # Admin overview with animated pie chart
│   ├── manage_products.php    # Product inventory list
│   └── add_product.php        # Product upload form
│
├── assets/
│   ├── css/                   # Global styles and luxury theme
│   ├── uploads/               # Product images (Git ignored)
│   └── images/                # Placeholders and brand assets
│
├── includes/
│   ├── db.php                 # MySQLi connection
│   ├── header.php             # Public navigation
│   └── admin_header.php       # Admin sidebar and navigation
│
└── index.php                  # Main storefront
```

---

# 🚀 Future Improvements

- User authentication system
- Payment gateway integration
- Wishlist functionality
- Order tracking system
- Multi-vendor support
- REST API integration

---

# 📄 License

This project is developed for educational and commercial portfolio purposes.
