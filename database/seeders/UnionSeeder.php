<?php

namespace Database\Seeders;

use App\Models\GuildUnion;
use Illuminate\Database\Seeder;

class UnionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف خبازان', 'bakers-union', 'نانوایی‌ها و واحدهای مرتبط با تولید نان', 'سید رضا موسوی', '01732221001'],
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف چاپ و تکثیر', 'printing-copy-union', 'چاپخانه‌ها، تکثیر و خدمات چاپی', 'حسین احمدی', '01732221002'],
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف درودگران', 'woodworkers-union', 'تولید و خدمات چوب، کابینت و مصنوعات چوبی', 'مریم حسینی', '01732221003'],
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف قنادان', 'confectioners-union', 'شیرینی‌پزی، قنادی و تولید محصولات مرتبط', 'علی کاظمی', '01732221004'],
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف لبنیات', 'dairy-producers-union', 'تولید و عرضه لبنیات سنتی و صنعتی', 'رضا محمدی', '01732221005'],
            [GuildUnion::TYPE_PRODUCTION, 'اتحادیه صنف مصنوعات فلزی', 'metal-products-union', 'تولید مصنوعات فلزی، جوشکاری و خدمات وابسته', 'زهرا اکبری', '01732221006'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه صنف طلا و جواهر', 'gold-jewelry-union', 'واحدهای فروش، ساخت و تعمیرات طلا و جواهر', 'محمد صادقی', '01732221007'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه صنف پوشاک', 'clothing-union', 'فروشندگان پوشاک، منسوجات و محصولات مرتبط', 'فاطمه کریمی', '01732221008'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه خواربار و مواد غذایی', 'grocery-food-union', 'فروشگاه‌ها و واحدهای عرضه مواد غذایی', 'سعید مرادی', '01732221009'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه لوازم خانگی', 'home-appliances-union', 'عرضه‌کنندگان لوازم خانگی و کالای بادوام', 'نرگس رضایی', '01732221010'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه صنف میوه و تره‌بار', 'fruit-vegetable-union', 'فروشندگان میوه، سبزی و صیفی‌جات', 'حمید ناصری', '01732221011'],
            [GuildUnion::TYPE_DISTRIBUTION, 'اتحادیه صنف مصالح ساختمانی', 'building-materials-union', 'توزیع مصالح، ابزار و تجهیزات ساختمانی', 'سمیه یوسفی', '01732221012'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه تعمیرکاران خودرو', 'car-repair-union', 'خدمات تعمیر، صافکاری و امور فنی خودرو', 'حسن محمودی', '01732221013'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه مشاوران املاک', 'real-estate-union', 'خدمات خرید، فروش، رهن و اجاره املاک', 'الهام رستمی', '01732221014'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه صنف آرایشگران', 'hairdressers-union', 'خدمات آرایشی، پیرایشی و بهداشتی مجاز', 'مجید صفری', '01732221015'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه رستوران و اغذیه', 'restaurants-catering-union', 'رستوران‌ها، اغذیه‌فروشی‌ها و خدمات پذیرایی', 'لیلا جعفری', '01732221016'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه خدمات رایانه', 'computer-services-union', 'خدمات فنی، پشتیبانی و تعمیر تجهیزات رایانه‌ای', 'امیر صادقی', '01732221017'],
            [GuildUnion::TYPE_SERVICE, 'اتحادیه خدمات فنی ساختمان', 'building-technical-services-union', 'تأسیسات، شوفاژ، سرمایش و خدمات فنی ساختمان', 'مینا قاسمی', '01732221018'],
        ];

        foreach ($items as $index => [$type, $title, $slug, $shortDescription, $manager, $phone]) {
            GuildUnion::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'name' => $title,
                    'union_type' => $type,
                    'logo' => 'assets/img/asnaf-seal.svg',
                    'cover_image' => 'assets/img/asnaf-gorgan-default.jpg',
                    'description' => 'این اتحادیه با هدف ساماندهی واحدهای صنفی، رسیدگی به امور اعضا، آموزش، نظارت و پاسخگویی به شهروندان در شهرستان گرگان فعالیت می‌کند.',
                    'short_description' => $shortDescription,
                    'address' => 'گرگان، خیابان ولیعصر، ساختمان اتاق اصناف، طبقه '.(($index % 3) + 1),
                    'phone' => $phone,
                    'mobile' => '0911'.str_pad((string) (2000000 + $index), 7, '0', STR_PAD_LEFT),
                    'email' => str_replace('-', '.', $slug).'@asnaf-gorgan.ir',
                    'website' => 'https://asnaf-gorgan.ir',
                    'manager_name' => $manager,
                    'manager_image' => 'assets/img/asnaf-gorgan-default.jpg',
                    'working_hours' => 'شنبه تا چهارشنبه ۸ تا ۱۴',
                    'social_links' => ['تلگرام' => 'https://t.me/asnaf_gorgan', 'ایتا' => 'https://eitaa.com/asnaf_gorgan'],
                    'is_active' => true,
                    'complaint_enabled' => true,
                    'congratulations_enabled' => true,
                    'news_enabled' => true,
                    'announcements_enabled' => true,
                    'gallery_enabled' => true,
                    'videos_enabled' => true,
                    'members_enabled' => true,
                    'services_enabled' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
