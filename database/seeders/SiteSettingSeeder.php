<?php
namespace Database\Seeders;
use App\Models\SiteSetting;use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Cache;
class SiteSettingSeeder extends Seeder{public function run():void{$settings=[
'site.site_title'=>['site','اتاق اصناف شهرستان گرگان'],'site.site_description'=>['site','پایگاه اطلاع‌رسانی و خدمات الکترونیک اتاق اصناف شهرستان گرگان'],'site.phone'=>['site','۰۱۷۳۲۱۵۲۹۱۲'],'site.address'=>['site','گرگان، خیابان مطهری جنوبی، روبروی پمپ بنزین، ساختمان اتاق اصناف'],'site.email'=>['site','info@asnaf-gorgan.ir'],
'header.logo'=>['header','assets/img/asnaf-wordmark.svg'],'header.top_text'=>['header','اتاق اصناف شهرستان گرگان؛ پشتیبان کسب‌وکارهای صنفی'],'header.service_button_text'=>['header','سامانه خدمات صنفی'],'header.service_button_link'=>['header',route('systems.index')],'header.contact_button_text'=>['header','تماس با اتاق'],
'footer.logo'=>['footer','assets/img/asnaf-footer-mark.svg'],'footer.description'=>['footer','اتاق اصناف شهرستان گرگان، خانه مشترک اتحادیه‌های صنفی و پشتیبان فعالان اقتصادی شهر گرگان است.'],'footer.copyright'=>['footer','تمام حقوق مادی و معنوی این وبسایت متعلق به اتاق اصناف شهرستان گرگان می‌باشد'],'footer.social_links'=>['footer',['اینستاگرام'=>'#','تلگرام'=>'#','واتساپ'=>'#','ایتا'=>'#']]
];foreach($settings as $key=>$data){SiteSetting::updateOrCreate(['key'=>$key],['group'=>$data[0],'value'=>$data[1]]);}Cache::forget('site_settings.all');}}
