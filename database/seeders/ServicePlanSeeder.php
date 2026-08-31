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

        // The published ladder is the whole offer, so anything else attached to
        // the service is stale and must not keep showing on the public page.
        $service->plans()
            ->whereNotIn('name', array_column($this->plans(), 'name'))
            ->delete();
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
                'badge' => null,
                'badge_ar' => null,
                'is_featured' => false,
                'capacity' => 'Up to 15 Devices',
                'capacity_ar' => 'حتى 15 جهازًا',
                'price_monthly' => 1249,
                'price_yearly' => 12740,
                'price_suffix' => null,
                'currency' => 'EGP',
                'cta_label' => null,
                'cta_label_ar' => null,
                'features' => implode("\n", [
                    'Remote Support',
                    'Windows Support',
                    'Printer Support',
                    'Email & Outlook Support',
                    'Basic Network Support',
                    'Antivirus Management',
                    'User Account Management',
                    '1 On-site Visit / month',
                    'Business-hours support (response within 24h)',
                ]),
                'features_ar' => implode("\n", [
                    'دعم عن بُعد',
                    'دعم أنظمة ويندوز',
                    'دعم الطابعات',
                    'دعم البريد وأوتلوك',
                    'دعم الشبكة الأساسي',
                    'إدارة مكافحة الفيروسات',
                    'إدارة حسابات المستخدمين',
                    'زيارة ميدانية شهريًا',
                    'الدعم خلال ساعات العمل (استجابة خلال 24 ساعة)',
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
                'capacity' => 'Up to 30 Devices',
                'capacity_ar' => 'حتى 30 جهازًا',
                'price_monthly' => 2499,
                'price_yearly' => 25490,
                'price_suffix' => null,
                'currency' => 'EGP',
                'cta_label' => null,
                'cta_label_ar' => null,
                'features' => implode("\n", [
                    'Everything in Micro Care',
                    '2 On-site Visits / month',
                    'Network Troubleshooting',
                    'Microsoft 365 Support',
                    'IT Asset Management',
                    'Preventive Maintenance',
                    'Priority Support (response within 8h)',
                    'Monthly IT Report',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا الباقة المصغّرة',
                    'زيارتان ميدانيتان شهريًا',
                    'استكشاف أعطال الشبكة',
                    'دعم مايكروسوفت 365',
                    'إدارة أصول تقنية المعلومات',
                    'صيانة وقائية',
                    'دعم ذو أولوية (استجابة خلال 8 ساعات)',
                    'تقرير شهري',
                ]),
            ],
            [
                'name' => 'Business Care',
                'name_ar' => 'باقة الأعمال',
                'icon' => 'building',
                'accent_color' => '#EA580C',
                'badge' => null,
                'badge_ar' => null,
                'is_featured' => false,
                'capacity' => 'Up to 60 Devices',
                'capacity_ar' => 'حتى 60 جهازًا',
                'price_monthly' => 4999,
                'price_yearly' => 50990,
                'price_suffix' => null,
                'currency' => 'EGP',
                'cta_label' => null,
                'cta_label_ar' => null,
                'features' => implode("\n", [
                    'Everything in Essential Care',
                    '4 On-site Visits / month',
                    'Microsoft 365 Admin Support',
                    'User & Access Management',
                    'Windows Server Support',
                    'Active Directory Support',
                    'Firewall Support',
                    'Backup Monitoring',
                    'SLA: response within 4h',
                    'Monthly IT Health Report',
                ]),
                'features_ar' => implode("\n", [
                    'كل مزايا الباقة الأساسية',
                    '4 زيارات ميدانية شهريًا',
                    'دعم إدارة مايكروسوفت 365',
                    'إدارة المستخدمين والصلاحيات',
                    'دعم ويندوز سيرفر',
                    'دعم Active Directory',
                    'دعم الجدار الناري',
                    'مراقبة النسخ الاحتياطي',
                    'اتفاقية مستوى خدمة: استجابة خلال 4 ساعات',
                    'تقرير شهري لحالة الأنظمة',
                ]),
            ],
            [
                'name' => 'Enterprise Care',
                'name_ar' => 'باقة المؤسسات',
                'icon' => 'shield',
                'accent_color' => '#0F172A',
                'badge' => null,
                'badge_ar' => null,
                'is_featured' => false,
                'capacity' => '60+ Devices (Custom)',
                'capacity_ar' => 'أكثر من 60 جهازًا (حسب الطلب)',
                'price_monthly' => 18999,
                'price_yearly' => null,
                'price_suffix' => '+',
                'currency' => 'EGP',
                'cta_label' => 'Contact us',
                'cta_label_ar' => 'تواصل معنا',
                'features' => implode("\n", [
                    'Dedicated IT Engineer',
                    'Unlimited Remote Support',
                    'On-site Support (Custom)',
                    'Server & Network Admin',
                    'Advanced Security & Antivirus',
                    'Backup Monitoring',
                    'Asset Management',
                    'SLA: response within 1h',
                    'Custom IT Solutions',
                ]),
                'features_ar' => implode("\n", [
                    'مهندس تقنية معلومات مخصص',
                    'دعم عن بُعد غير محدود',
                    'دعم ميداني حسب الاتفاق',
                    'إدارة الخوادم والشبكات',
                    'حماية أمنية متقدمة ومكافحة الفيروسات',
                    'مراقبة النسخ الاحتياطي',
                    'إدارة الأصول',
                    'اتفاقية مستوى خدمة: استجابة خلال ساعة واحدة',
                    'حلول تقنية مخصصة',
                ]),
            ],
        ];
    }
}
