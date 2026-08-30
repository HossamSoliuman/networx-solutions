<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServicePlan;
use Illuminate\Database\Seeder;

class ServicePlanSeeder extends Seeder
{
    /**
     * Seed the published IT support plans. Every value here is editable from
     * the admin panel; this only provides the launch content.
     */
    public function run(): void
    {
        $service = Service::query()->where('slug', 'it-support')->first();

        if (! $service instanceof Service) {
            return;
        }

        $service->update([
            'pricing_enabled' => true,
            'pricing_eyebrow' => 'Pricing plans',
            'pricing_eyebrow_ar' => 'خطط الأسعار',
            'pricing_title' => 'IT Support Plans',
            'pricing_title_ar' => 'خطط الدعم الفني',
            'pricing_subtitle' => 'Simple, reliable IT support plans designed to fit your business.',
            'pricing_subtitle_ar' => 'خطط دعم فني بسيطة وموثوقة مصممة لتناسب أعمالك.',
            'pricing_yearly_note' => 'Save up to 15% with annual plans',
            'pricing_yearly_note_ar' => 'وفّر حتى 15% مع الاشتراك السنوي',
            'pricing_footnote' => '* Hardware, software, licenses and additional on-site visits are billed separately.',
            'pricing_footnote_ar' => '* يتم احتساب الأجهزة والبرمجيات والتراخيص والزيارات الميدانية الإضافية بشكل منفصل.',
        ]);

        foreach ($this->plans() as $index => $plan) {
            ServicePlan::query()->updateOrCreate(
                ['service_id' => $service->id, 'name' => $plan['name']],
                [
                    ...$plan,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function plans(): array
    {
        return [
            [
                'name' => 'Micro Care',
                'name_ar' => 'الباقة المصغّرة',
                'icon' => 'desktop',
                'accent_color' => '#0045B3',
                'capacity' => 'Up to 5 Devices',
                'capacity_ar' => 'حتى 5 أجهزة',
                'price_monthly' => 499,
                'price_yearly' => 5090,
                'currency' => 'EGP',
                'features' => implode("\n", [
                    'Remote Support',
                    'Windows Support',
                    'Printer Support',
                    'Email & Outlook Support',
                    'Basic Network Support',
                    '1 On-site Visit / month',
                    'Business-hours support',
                ]),
                'features_ar' => implode("\n", [
                    'دعم عن بُعد',
                    'دعم أنظمة ويندوز',
                    'دعم الطابعات',
                    'دعم البريد وأوتلوك',
                    'دعم الشبكة الأساسي',
                    'زيارة ميدانية شهريًا',
                    'الدعم خلال ساعات العمل',
                ]),
            ],
            [
                'name' => 'Starter Care',
                'name_ar' => 'باقة البداية',
                'icon' => 'users',
                'accent_color' => '#0F9D74',
                'capacity' => 'Up to 10 Devices',
                'capacity_ar' => 'حتى 10 أجهزة',
                'price_monthly' => 999,
                'price_yearly' => 10190,
                'currency' => 'EGP',
                'features' => implode("\n", [
                    'Everything in Micro Care',
                    '1 On-site Visit / month',
                    'User Account Management',
                    'Preventive Maintenance',
                    'IT Asset Basic Tracking',
                    'Priority Support',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا الباقة المصغّرة',
                    'زيارة ميدانية شهريًا',
                    'إدارة حسابات المستخدمين',
                    'صيانة وقائية',
                    'تتبع أساسي لأصول تقنية المعلومات',
                    'دعم ذو أولوية',
                ]),
            ],
            [
                'name' => 'Essential Care',
                'name_ar' => 'الباقة الأساسية',
                'icon' => 'star',
                'accent_color' => '#0045B3',
                'badge' => 'Most Popular',
                'badge_ar' => 'الأكثر طلبًا',
                'is_featured' => true,
                'capacity' => 'Up to 20 Devices',
                'capacity_ar' => 'حتى 20 جهازًا',
                'price_monthly' => 1999,
                'price_yearly' => 20390,
                'currency' => 'EGP',
                'features' => implode("\n", [
                    'Everything in Starter Care',
                    '2 On-site Visits / month',
                    'Network Troubleshooting',
                    'Microsoft 365 Support',
                    'IT Asset Management',
                    'Preventive Maintenance',
                    'Monthly IT Health Check',
                    'Monthly IT Report',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا باقة البداية',
                    'زيارتان ميدانيتان شهريًا',
                    'استكشاف أعطال الشبكة',
                    'دعم مايكروسوفت 365',
                    'إدارة أصول تقنية المعلومات',
                    'صيانة وقائية',
                    'فحص شهري لحالة الأنظمة',
                    'تقرير شهري',
                ]),
            ],
            [
                'name' => 'Business Care',
                'name_ar' => 'باقة الأعمال',
                'icon' => 'building',
                'accent_color' => '#EA580C',
                'capacity' => 'Up to 40 Devices',
                'capacity_ar' => 'حتى 40 جهازًا',
                'price_monthly' => 3499,
                'price_yearly' => 35690,
                'currency' => 'EGP',
                'features' => implode("\n", [
                    'Everything in Essential Care',
                    '4 On-site Visits / month',
                    'Priority Remote Support',
                    'Microsoft 365 Admin Support',
                    'User & Access Management',
                    'Backup Monitoring (Basic)',
                    'Security Review (Basic)',
                    'Monthly IT Report',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا الباقة الأساسية',
                    '4 زيارات ميدانية شهريًا',
                    'دعم عن بُعد ذو أولوية',
                    'دعم إدارة مايكروسوفت 365',
                    'إدارة المستخدمين والصلاحيات',
                    'مراقبة النسخ الاحتياطي (أساسي)',
                    'مراجعة أمنية (أساسية)',
                    'تقرير شهري',
                ]),
            ],
            [
                'name' => 'Professional Care',
                'name_ar' => 'الباقة الاحترافية',
                'icon' => 'server',
                'accent_color' => '#7C3AED',
                'capacity' => 'Up to 70 Devices',
                'capacity_ar' => 'حتى 70 جهازًا',
                'price_monthly' => 6999,
                'price_yearly' => 71390,
                'currency' => 'EGP',
                'features' => implode("\n", [
                    'Everything in Business Care',
                    '8 On-site Visits / month',
                    'Network Administration',
                    'Windows Server Support',
                    'Active Directory Support',
                    'Backup Monitoring',
                    'Firewall Support',
                    'SLA & Priority Response',
                    'Monthly IT Health Report',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا باقة الأعمال',
                    '8 زيارات ميدانية شهريًا',
                    'إدارة الشبكات',
                    'دعم ويندوز سيرفر',
                    'دعم Active Directory',
                    'مراقبة النسخ الاحتياطي',
                    'دعم الجدار الناري',
                    'اتفاقية مستوى خدمة واستجابة ذات أولوية',
                    'تقرير شهري لحالة الأنظمة',
                ]),
            ],
            [
                'name' => 'Enterprise Care',
                'name_ar' => 'باقة المؤسسات',
                'icon' => 'shield',
                'accent_color' => '#0F172A',
                'capacity' => '70+ Devices',
                'capacity_ar' => 'أكثر من 70 جهازًا',
                'price_monthly' => 15000,
                'price_suffix' => '+',
                'currency' => 'EGP',
                'cta_label' => 'Contact us',
                'cta_label_ar' => 'تواصل معنا',
                'features' => implode("\n", [
                    'Dedicated IT Engineer',
                    'Unlimited Remote Support',
                    'On-site Support (Custom)',
                    'Server & Network Admin',
                    'Microsoft 365 Admin',
                    'Advanced Security',
                    'Backup & Disaster Recovery',
                    'Asset Management',
                    'SLA & Priority Response',
                    'Custom IT Solutions',
                ]),
                'features_ar' => implode("\n", [
                    'مهندس تقنية معلومات مخصص',
                    'دعم عن بُعد غير محدود',
                    'دعم ميداني حسب الاتفاق',
                    'إدارة الخوادم والشبكات',
                    'إدارة مايكروسوفت 365',
                    'حماية أمنية متقدمة',
                    'النسخ الاحتياطي واستعادة التشغيل',
                    'إدارة الأصول',
                    'اتفاقية مستوى خدمة واستجابة ذات أولوية',
                    'حلول تقنية مخصصة',
                ]),
            ],
        ];
    }
}
