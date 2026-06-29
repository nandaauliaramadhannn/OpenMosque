<p align="center">
  <div align="center">
    <div style="background: linear-gradient(135deg, #10b981, #0d9488); width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
        <span style="font-size: 40px;">🕌</span>
    </div>
  </div>
  <h1 align="center">OpenMosque (v0.1 - Under Development)</h1>
  <p align="center">
    <strong>An open-source, modern, and multilingual website platform built for the global Muslim community.</strong>
    <br />
    <em>Note: This project is currently in early active development (v0.1). Features are being added rapidly.</em>
    <br />
    <br />
    <a href="#features">Features</a>
    ·
    <a href="#tech-stack">Tech Stack</a>
    ·
    <a href="#installation">Installation</a>
    ·
    <a href="#contributing">Contributing</a>
  </p>
</p>

---

## 🌟 About The Project

Most mosques worldwide lack an affordable, modern web presence. **OpenMosque** is designed to bridge this gap by providing a completely free, self-hosted, and feature-rich CMS tailored specifically for mosques and Islamic centers. 

Whether you need to display daily prayer times, manage community events, announce news, or collect donations transparently, OpenMosque offers a beautiful and functional solution out-of-the-box.

### 🎯 Key Features

- 🌍 **Multilingual & RTL Support**: Native support for English, Arabic, Bahasa Indonesia, and more, with full Right-to-Left (RTL) layout handling.
- 🕌 **Prayer Times Management**: Display daily schedules, Iqamah times, and Jumuah timings. Supports both manual input and auto-calculation via API.
- 📅 **Events & Announcements**: Keep your congregation informed with rich-text announcements and event RSVP tracking.
- 💳 **Donation Campaigns**: Transparent financial tracking, multiple donation categories (Zakat, Sadaqah, Waqf), and visual progress bars for campaigns.
- 🤝 **Services Booking**: Manage requests for Nikah (Marriage), Janazah (Funeral), Counseling, and Shahada.
- 🎨 **Islamic-Inspired Design**: Beautiful premium UI featuring glassmorphism, geometric patterns, and a carefully curated Emerald & Gold color palette.
- 📱 **Mobile First**: Fully responsive design for both the public-facing website and the comprehensive Admin Panel.

---

## 🛠 Tech Stack

OpenMosque is built on a robust, modern, and highly scalable technology stack:

### Backend
- **Framework**: [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Architecture**: UUID primary keys, single-tenant structure, translatable JSON columns.

### Frontend (Public & Admin Panel)
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com) (Pure Tailwind, no heavy UI libraries)
- **Reactivity**: [Alpine.js](https://alpinejs.dev) (Lightweight JavaScript for interactivity)
- **Icons**: [Lucide Icons](https://lucide.dev)
- **Build Tool**: [Vite 7](https://vitejs.dev)

---

## 🚀 Installation

Follow these steps to set up OpenMosque locally or on your production server.

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0

### Step-by-step Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/nandaauliaramadhannn/OpenMosque.git
   cd OpenMosque
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the example `.env` file and configure your database settings.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   *Make sure to update the following variables in your `.env`:*
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=openmosque
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run Migrations & Database Seeder**
   This will create the database tables and populate it with sample mosque data, prayer times, events, and an Admin account.
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Frontend Assets**
   ```bash
   npm run build
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```

### 🔐 Default Admin Credentials

After running the seeder, you can log in to the Admin Panel at `http://localhost:8000/admin/login`:
- **Email**: `admin@openmosque.org`
- **Password**: `password`

*(Please remember to change these credentials in a production environment!)*

---

## 🛣 Roadmap

- [x] **Phase 1**: Foundation (Database schema, UUID, Multilingual setup, Admin/Public Layouts, Auth).
- [ ] **Phase 2**: Core Content (CRUD for Announcements, Events, Pages, Media Library).
- [ ] **Phase 3**: Engagement (Donation integration, Contact forms, Prayer Times API sync).
- [ ] **Phase 4**: Polish (Theme Customizer, SEO tools, PDF Exports, Documentation).

---

## 🤝 Contributing

Contributions make the open-source community an amazing place to learn, inspire, and create. Any contributions you make to OpenMosque are **greatly appreciated**!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  Built with ❤️ for the global Muslim community.
</p>
