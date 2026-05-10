RORA Luxe - Premium E-commerce Platform ৳
RORA Luxe is a bespoke, high-end e-commerce solution designed specifically for the luxury retail market in Bangladesh. It features a sophisticated "Gold & Dark" aesthetic, specialized currency localization, and a robust administrative backend for seamless inventory management.

Key Features
Front-End (User Experience)
Localized for Bangladesh: Native support for the Taka symbol (৳) and local currency formatting.

Dynamic Filtering: Users can filter by main categories (Bags, Watches, Clothes) and subcategories.

Advanced Sorting: Real-time sorting capabilities (Price: High to Low, Price: Low to High, and Newest Arrivals).

Responsive Luxury UI: A clean, grid-based interface optimized for both desktop and mobile devices.

Back-End (Admin Command Center)
Animated Dashboard: Real-time data visualization using Chart.js to track inventory distribution.

Smart Inventory Management: Complete CRUD (Create, Read, Update, Delete) for products with secure image uploads.

Hierarchical Categories: Support for parent and subcategory relationships to organize premium collections.

Safety Guards: Logic-based protection to prevent the deletion of categories that still contain active products.

Tech Stack
Language: PHP 8.x

Database: MySQL

Frontend: HTML5, CSS3 (Custom Variables), JavaScript (Vanilla)

Charts: Chart.js (CDN)

Icons/Fonts: FontAwesome & Google Fonts

Project Structure
├── admin/
│   ├── categories.php       # Category & Subcategory management
│   ├── dashboard.php        # Admin overview with animated pie chart
│   ├── manage_products.php  # Product inventory list
│   └── add_product.php      # Product upload form
├── assets/
│   ├── css/                 # Global styles and luxury theme
│   ├── uploads/             # Product images (Git ignored)
│   └── images/              # Placeholders and brand assets
├── includes/
│   ├── db.php               # MySQLi connection
│   ├── header.php           # Public navigation
│   └── admin_header.php     # Admin sidebar and navigation
└── index.php                # Main storefront



