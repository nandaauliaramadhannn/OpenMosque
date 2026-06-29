<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Mosque;
use App\Models\PrayerSetting;
use App\Models\PrayerTime;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Super Admin User ===
        User::create([
            'name' => 'Admin',
            'email' => 'admin@openmosque.org',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'locale' => 'en',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // === Mosque Profile ===
        $mosque = Mosque::create([
            'name' => ['en' => 'Al-Noor Mosque', 'ar' => 'مسجد النور', 'id' => 'Masjid An-Nuur'],
            'description' => [
                'en' => 'A welcoming place of worship serving the community with prayer, education, and social services.',
                'ar' => 'مكان عبادة مرحب يخدم المجتمع بالصلاة والتعليم والخدمات الاجتماعية',
                'id' => 'Tempat ibadah yang ramah melayani masyarakat dengan shalat, pendidikan, dan layanan sosial.',
            ],
            'address' => '123 Peace Avenue, Springfield, IL 62701',
            'latitude' => 39.7817,
            'longitude' => -89.6501,
            'phone' => '+1 (555) 123-4567',
            'email' => 'info@alnoor-mosque.org',
            'website' => 'https://alnoor-mosque.org',
            'social_links' => ['facebook' => '#', 'instagram' => '#', 'youtube' => '#'],
            'timezone' => 'America/Chicago',
            'country_code' => 'US',
            'currency' => 'USD',
        ]);

        // === Prayer Settings ===
        PrayerSetting::create([
            'calculation_method' => 'ISNA',
            'asr_method' => 'Standard',
            'adjustments' => ['fajr' => 0, 'dhuhr' => 0, 'asr' => 0, 'maghrib' => 0, 'isha' => 0],
            'iqamah_offsets' => ['fajr' => 20, 'dhuhr' => 15, 'asr' => 10, 'maghrib' => 5, 'isha' => 15],
            'is_auto_calculated' => true,
            'jumuah_time' => '13:00',
            'jumuah_khutbah_time' => '12:30',
        ]);

        // === Today's Prayer Times (demo) ===
        PrayerTime::create([
            'date' => today(),
            'fajr' => '04:45', 'sunrise' => '06:10', 'dhuhr' => '12:35',
            'asr' => '16:15', 'maghrib' => '19:50', 'isha' => '21:15',
            'iqamah_fajr' => '05:05', 'iqamah_dhuhr' => '12:50',
            'iqamah_asr' => '16:25', 'iqamah_maghrib' => '19:55', 'iqamah_isha' => '21:30',
            'is_manual' => false,
        ]);

        // === Categories ===
        $catLecture = Category::create(['name' => ['en' => 'Lecture', 'ar' => 'محاضرة', 'id' => 'Ceramah'], 'slug' => 'lecture', 'type' => 'event', 'color' => '#10b981']);
        $catYouth = Category::create(['name' => ['en' => 'Youth', 'ar' => 'شباب', 'id' => 'Pemuda'], 'slug' => 'youth', 'type' => 'event', 'color' => '#3b82f6']);
        $catGeneral = Category::create(['name' => ['en' => 'General', 'ar' => 'عام', 'id' => 'Umum'], 'slug' => 'general', 'type' => 'announcement', 'color' => '#8b5cf6']);

        // === Announcements ===
        Announcement::create([
            'title' => ['en' => 'Ramadan Preparation Program', 'ar' => 'برنامج التحضير لرمضان', 'id' => 'Program Persiapan Ramadhan'],
            'slug' => 'ramadan-preparation',
            'body' => ['en' => 'Join us for our annual Ramadan preparation workshop. Learn about fasting tips, spiritual goals, and community iftar schedules.', 'ar' => 'انضم إلينا في ورشة التحضير السنوية لرمضان', 'id' => 'Bergabunglah dalam workshop persiapan Ramadhan tahunan kami.'],
            'excerpt' => ['en' => 'Annual workshop to prepare for the blessed month.', 'ar' => 'ورشة سنوية للتحضير للشهر المبارك', 'id' => 'Workshop tahunan untuk menyambut bulan suci.'],
            'category_id' => $catGeneral->id,
            'is_published' => true, 'is_pinned' => true,
            'published_at' => now()->subDays(2),
        ]);

        Announcement::create([
            'title' => ['en' => 'New Quran Classes Starting', 'ar' => 'بدء دروس القرآن الجديدة', 'id' => 'Kelas Al-Quran Baru Dimulai'],
            'slug' => 'quran-classes',
            'body' => ['en' => 'We are excited to announce new Quran memorization and tajweed classes for all age groups starting next week.', 'ar' => 'يسعدنا الإعلان عن دروس جديدة لحفظ القرآن والتجويد', 'id' => 'Kami senang mengumumkan kelas baru tahfidz dan tajwid Al-Quran.'],
            'excerpt' => ['en' => 'Quran memorization and tajweed for all ages.', 'ar' => 'حفظ القرآن والتجويد لجميع الأعمار', 'id' => 'Tahfidz dan tajwid untuk semua usia.'],
            'category_id' => $catGeneral->id,
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        Announcement::create([
            'title' => ['en' => 'Community Iftar Every Friday', 'ar' => 'إفطار مجتمعي كل جمعة', 'id' => 'Buka Puasa Bersama Setiap Jumat'],
            'slug' => 'community-iftar',
            'body' => ['en' => 'Join us every Friday for a community iftar dinner. All are welcome. Please RSVP to help us plan.', 'ar' => 'انضم إلينا كل جمعة لعشاء إفطار مجتمعي', 'id' => 'Bergabunglah buka puasa bersama setiap Jumat.'],
            'excerpt' => ['en' => 'Weekly community iftar dinner.', 'ar' => 'عشاء إفطار مجتمعي أسبوعي', 'id' => 'Buka puasa bersama mingguan.'],
            'category_id' => $catGeneral->id,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // === Events ===
        Event::create([
            'title' => ['en' => 'Friday Night Lecture: The Seerah', 'ar' => 'محاضرة ليلة الجمعة: السيرة', 'id' => 'Kajian Jumat Malam: Sirah Nabawiyah'],
            'slug' => 'friday-seerah-lecture',
            'description' => ['en' => 'Weekly lecture series on the life of Prophet Muhammad ﷺ', 'ar' => 'سلسلة محاضرات أسبوعية عن حياة النبي محمد ﷺ', 'id' => 'Kajian mingguan tentang kehidupan Nabi Muhammad ﷺ'],
            'category_id' => $catLecture->id,
            'start_date' => now()->next('Friday')->setTime(19, 30),
            'end_date' => now()->next('Friday')->setTime(21, 0),
            'location' => ['en' => 'Main Hall', 'ar' => 'القاعة الرئيسية', 'id' => 'Aula Utama'],
            'is_published' => true, 'is_featured' => true,
            'speaker' => ['en' => 'Sheikh Ahmad Hassan', 'ar' => 'الشيخ أحمد حسن'],
        ]);

        Event::create([
            'title' => ['en' => 'Youth Basketball Tournament', 'ar' => 'دورة كرة السلة للشباب', 'id' => 'Turnamen Basket Pemuda'],
            'slug' => 'youth-basketball',
            'description' => ['en' => 'Annual youth basketball tournament. Teams of 5, ages 13-18.', 'ar' => 'دورة كرة السلة السنوية للشباب', 'id' => 'Turnamen basket tahunan untuk pemuda usia 13-18.'],
            'category_id' => $catYouth->id,
            'start_date' => now()->addDays(10)->setTime(10, 0),
            'end_date' => now()->addDays(10)->setTime(16, 0),
            'location' => ['en' => 'Community Center Gym', 'ar' => 'صالة المركز المجتمعي', 'id' => 'Gedung Olahraga'],
            'is_published' => true, 'registration_required' => true, 'max_attendees' => 40,
        ]);

        Event::create([
            'title' => ['en' => 'Family Picnic Day', 'ar' => 'يوم نزهة عائلية', 'id' => 'Hari Piknik Keluarga'],
            'slug' => 'family-picnic',
            'description' => ['en' => 'Annual family fun day with food, games, and activities.', 'ar' => 'يوم ترفيهي عائلي سنوي', 'id' => 'Hari keluarga tahunan dengan makanan dan permainan.'],
            'category_id' => $catYouth->id,
            'start_date' => now()->addDays(21)->setTime(11, 0),
            'location' => ['en' => 'Central Park', 'ar' => 'الحديقة المركزية', 'id' => 'Taman Pusat'],
            'is_published' => true,
        ]);

        // === Campaigns ===
        Campaign::create([
            'title' => ['en' => 'Mosque Renovation Fund', 'ar' => 'صندوق ترميم المسجد', 'id' => 'Dana Renovasi Masjid'],
            'description' => ['en' => 'Help us renovate the prayer hall and expand capacity.', 'ar' => 'ساعدنا في ترميم قاعة الصلاة وتوسيع السعة', 'id' => 'Bantu kami merenovasi aula shalat.'],
            'goal_amount' => 50000, 'current_amount' => 32500,
            'start_date' => now()->subMonth(), 'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Campaign::create([
            'title' => ['en' => 'School Supplies for Children', 'ar' => 'مستلزمات مدرسية للأطفال', 'id' => 'Perlengkapan Sekolah Anak'],
            'description' => ['en' => 'Providing school supplies for underprivileged children.', 'ar' => 'توفير مستلزمات مدرسية للأطفال المحتاجين', 'id' => 'Menyediakan perlengkapan sekolah untuk anak kurang mampu.'],
            'goal_amount' => 10000, 'current_amount' => 7800,
            'start_date' => now()->subWeeks(2), 'end_date' => now()->addMonth(),
            'is_active' => true,
        ]);

        // === Services ===
        $servicesData = [
            ['name' => ['en' => 'Marriage (Nikah)', 'ar' => 'النكاح', 'id' => 'Pernikahan (Nikah)'], 'description' => ['en' => 'Islamic marriage ceremony services and counseling.', 'ar' => 'خدمات حفل الزواج الإسلامي', 'id' => 'Layanan akad nikah dan konseling.'], 'icon' => '💍', 'bookable' => true],
            ['name' => ['en' => 'Funeral (Janazah)', 'ar' => 'الجنازة', 'id' => 'Pemakaman (Jenazah)'], 'description' => ['en' => 'Complete funeral prayer and burial arrangement.', 'ar' => 'صلاة الجنازة وترتيبات الدفن', 'id' => 'Shalat jenazah dan pengaturan pemakaman.'], 'icon' => '🕊️', 'bookable' => true],
            ['name' => ['en' => 'Shahada (Conversion)', 'ar' => 'الشهادة', 'id' => 'Syahadat (Masuk Islam)'], 'description' => ['en' => 'Guidance and support for those embracing Islam.', 'ar' => 'التوجيه والدعم لمن يعتنق الإسلام', 'id' => 'Bimbingan bagi yang ingin memeluk Islam.'], 'icon' => '🌟', 'bookable' => true],
            ['name' => ['en' => 'Quran Classes', 'ar' => 'دروس القرآن', 'id' => 'Kelas Al-Quran'], 'description' => ['en' => 'Weekly Quran recitation and memorization classes.', 'ar' => 'دروس أسبوعية لتلاوة وحفظ القرآن', 'id' => 'Kelas tilawah dan tahfidz mingguan.'], 'icon' => '📖', 'bookable' => false],
            ['name' => ['en' => 'Counseling', 'ar' => 'الإرشاد', 'id' => 'Konseling'], 'description' => ['en' => 'Family and personal counseling services.', 'ar' => 'خدمات الإرشاد الأسري والشخصي', 'id' => 'Layanan konseling keluarga dan personal.'], 'icon' => '🤝', 'bookable' => true],
            ['name' => ['en' => 'Zakat Collection', 'ar' => 'جمع الزكاة', 'id' => 'Pengumpulan Zakat'], 'description' => ['en' => 'Zakat calculation and distribution services.', 'ar' => 'خدمات حساب وتوزيع الزكاة', 'id' => 'Layanan perhitungan dan distribusi zakat.'], 'icon' => '💰', 'bookable' => false],
        ];

        foreach ($servicesData as $i => $s) {
            Service::create(array_merge($s, ['sort_order' => $i, 'is_active' => true]));
        }

        // === Staff ===
        Staff::create([
            'name' => ['en' => 'Sheikh Ahmad Hassan', 'ar' => 'الشيخ أحمد حسن'], 'role_title' => ['en' => 'Head Imam', 'ar' => 'الإمام الرئيسي', 'id' => 'Imam Utama'],
            'bio' => ['en' => 'Sheikh Ahmad has been serving as Head Imam for over 15 years with expertise in Islamic jurisprudence.'], 'sort_order' => 0, 'is_active' => true,
        ]);
        Staff::create([
            'name' => ['en' => 'Ustadh Omar Farooq', 'ar' => 'الأستاذ عمر فاروق'], 'role_title' => ['en' => 'Youth Director', 'ar' => 'مدير الشباب', 'id' => 'Direktur Pemuda'],
            'bio' => ['en' => 'Ustadh Omar leads our vibrant youth programs and community engagement initiatives.'], 'sort_order' => 1, 'is_active' => true,
        ]);

        // === Default Settings ===
        $settings = [
            ['key' => 'site_name', 'value' => ['OpenMosque'], 'group' => 'general', 'type' => 'text'],
            ['key' => 'active_languages', 'value' => ['en', 'ar', 'id'], 'group' => 'general', 'type' => 'json'],
            ['key' => 'default_language', 'value' => ['en'], 'group' => 'general', 'type' => 'text'],
            ['key' => 'meta_title', 'value' => ['OpenMosque — Your Community Mosque'], 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_description', 'value' => ['A welcoming place of worship serving the community.'], 'group' => 'seo', 'type' => 'textarea'],
            ['key' => 'primary_color', 'value' => ['#10b981'], 'group' => 'appearance', 'type' => 'text'],
            ['key' => 'prayer_api_source', 'value' => ['aladhan'], 'group' => 'prayer', 'type' => 'text'],
        ];
        foreach ($settings as $s) { Setting::create($s); }
    }
}
