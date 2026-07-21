<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->services() as $index => $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                [...$service, 'sort_order' => $index, 'is_active' => true],
            );
        }
    }

    /**
     * @return list<array{
     *     name: string,
     *     slug: string,
     *     icon: string,
     *     excerpt: string,
     *     description: string,
     *     image_path: string,
     *     benefits: string,
     *     details: array{
     *         statement: string,
     *         service_items: list<array{title: string, description: string, icon: string}>,
     *         reasons: list<array{title: string, description: string, icon: string}>
     *     }
     * }>
     */
    private function services(): array
    {
        return [
            [
                'name' => 'IT Support Solutions',
                'slug' => 'it-support',
                'icon' => 'headset',
                'excerpt' => 'Reliable IT support that keeps your business running smoothly and your team productive.',
                'description' => 'Responsive remote and on-site support for day-to-day technology issues, user access, business devices, and preventive maintenance.',
                'image_path' => 'images/site/it-support-banner.webp',
                'benefits' => "Remote & On-Site Support\nHardware & Software Troubleshooting\nPreventive Maintenance",
                'details' => [
                    'statement' => 'Focus on your business while we take care of your IT.',
                    'service_items' => [
                        ['title' => 'Remote & On-Site Support', 'description' => 'Quick assistance wherever you need it.', 'icon' => 'desktop'],
                        ['title' => 'Hardware & Software Troubleshooting', 'description' => 'Diagnose and resolve hardware and software issues fast.', 'icon' => 'wrench'],
                        ['title' => 'Windows Installation & Configuration', 'description' => 'Install, configure, and keep your systems up to date.', 'icon' => 'windows'],
                        ['title' => 'Printer & Peripheral Support', 'description' => 'Set up and troubleshoot printers and peripherals.', 'icon' => 'printer'],
                        ['title' => 'User Account Management', 'description' => 'Manage user accounts, permissions, and access with ease.', 'icon' => 'users'],
                        ['title' => 'Email & Outlook Support', 'description' => 'Resolve email issues and optimize your Outlook experience.', 'icon' => 'envelope'],
                        ['title' => 'Network Connectivity Issues', 'description' => 'Troubleshoot network problems and restore connectivity.', 'icon' => 'wifi'],
                        ['title' => 'Preventive Maintenance', 'description' => 'Regular system checks to prevent issues before they happen.', 'icon' => 'shield'],
                        ['title' => 'IT Asset Management', 'description' => 'Track and manage your IT assets efficiently.', 'icon' => 'devices'],
                        ['title' => 'Help Desk Services', 'description' => 'Friendly help desk support whenever you need us.', 'icon' => 'headset'],
                    ],
                    'reasons' => [
                        ['title' => 'Fast Response Time', 'description' => 'We respond quickly to minimize downtime and keep your business moving.', 'icon' => 'stopwatch'],
                        ['title' => 'Experienced IT Engineers', 'description' => 'Certified engineers bring the expertise your business can rely on.', 'icon' => 'user'],
                        ['title' => 'Minimized Downtime', 'description' => 'We solve problems efficiently to protect productivity.', 'icon' => 'clock'],
                        ['title' => 'Business Continuity', 'description' => 'We help keep your systems available and reliable.', 'icon' => 'shield'],
                        ['title' => 'Professional Support', 'description' => 'Clear communication and dependable solutions you can trust.', 'icon' => 'headset'],
                    ],
                ],
            ],
            [
                'name' => 'Professional Networking Solutions',
                'slug' => 'networking',
                'icon' => 'network',
                'excerpt' => 'Build a fast, secure, and reliable network infrastructure that keeps your business connected and running at its best.',
                'description' => 'Business networks designed, installed, secured, monitored, and maintained as one dependable foundation.',
                'image_path' => 'images/site/networking-banner.webp',
                'benefits' => "Network Design & Implementation\nLAN & WAN Setup\nStructured Cabling",
                'details' => [
                    'statement' => 'Strong networks power successful businesses.',
                    'service_items' => [
                        ['title' => 'Network Design & Implementation', 'description' => 'Custom network solutions tailored to your business needs.', 'icon' => 'network'],
                        ['title' => 'LAN & WAN Setup', 'description' => 'Reliable and efficient local and wide area networks.', 'icon' => 'globe'],
                        ['title' => 'Wi-Fi Installation & Optimization', 'description' => 'Strong, stable, and high-speed wireless networks.', 'icon' => 'wifi'],
                        ['title' => 'Router & Switch Configuration', 'description' => 'Professional setup and configuration for optimal performance.', 'icon' => 'router'],
                        ['title' => 'Structured Cabling', 'description' => 'Neat and reliable cabling for a solid network foundation.', 'icon' => 'cable'],
                        ['title' => 'VLAN Configuration', 'description' => 'Segment and secure your network for better performance.', 'icon' => 'vlan'],
                        ['title' => 'Network Monitoring', 'description' => 'Proactive monitoring to ensure maximum uptime.', 'icon' => 'chart'],
                        ['title' => 'VPN Setup', 'description' => 'Secure remote access for your team and branches.', 'icon' => 'lock'],
                        ['title' => 'Network Troubleshooting', 'description' => 'Quick issue detection and resolution.', 'icon' => 'wrench'],
                        ['title' => 'Network Maintenance', 'description' => 'Regular maintenance to keep your network healthy.', 'icon' => 'cog'],
                    ],
                    'reasons' => [
                        ['title' => 'High-Speed Connectivity', 'description' => 'Fast, reliable connections keep your business moving.', 'icon' => 'gauge'],
                        ['title' => 'Secure Network Infrastructure', 'description' => 'Best-practice controls keep your network safe and protected.', 'icon' => 'shield'],
                        ['title' => 'Scalable Solutions', 'description' => 'Your network grows with your business and adapts to its needs.', 'icon' => 'chart'],
                        ['title' => 'Reduced Downtime', 'description' => 'Fewer interruptions and maximum network availability.', 'icon' => 'clock'],
                        ['title' => 'Reliable Performance', 'description' => 'Optimized performance supports smooth operations every day.', 'icon' => 'thumbs-up'],
                    ],
                ],
            ],
            [
                'name' => 'Cloud Solutions',
                'slug' => 'cloud-solutions',
                'icon' => 'cloud',
                'excerpt' => 'Modern cloud services designed to improve flexibility, security, and business productivity.',
                'description' => 'Secure cloud migration, infrastructure, backup, recovery, and management shaped around how your business works.',
                'image_path' => 'images/site/cloud-solutions-banner.webp',
                'benefits' => "Cloud Migration\nCloud Infrastructure Setup\nBackup & Disaster Recovery",
                'details' => [
                    'statement' => 'Move your business to the cloud with confidence.',
                    'service_items' => [
                        ['title' => 'Cloud Migration', 'description' => 'Seamlessly migrate your data and applications to the cloud with zero hassle.', 'icon' => 'cloud-upload'],
                        ['title' => 'Cloud Infrastructure Setup', 'description' => 'Design and deploy secure, scalable, high-performing cloud environments.', 'icon' => 'cloud-cog'],
                        ['title' => 'Microsoft Azure Services', 'description' => 'Build, run, and manage your applications with Microsoft Azure.', 'icon' => 'azure'],
                        ['title' => 'Cloud Backup Solutions', 'description' => 'Protect your data with automated and reliable cloud backup.', 'icon' => 'cloud-shield'],
                        ['title' => 'Virtual Machines', 'description' => 'Deploy and manage virtual machines tailored to your business needs.', 'icon' => 'server'],
                        ['title' => 'Hybrid Cloud Deployment', 'description' => 'Combine the best of on-premises and cloud environments.', 'icon' => 'hybrid'],
                        ['title' => 'Storage Solutions', 'description' => 'Secure, scalable, and cost-effective cloud storage for your business.', 'icon' => 'database'],
                        ['title' => 'Cloud Monitoring', 'description' => 'Real-time monitoring for optimal performance and availability.', 'icon' => 'chart'],
                        ['title' => 'Disaster Recovery', 'description' => 'Fast recovery solutions that keep your business running.', 'icon' => 'recycle'],
                        ['title' => 'Cloud Optimization', 'description' => 'Reduce costs and improve efficiency across your cloud resources.', 'icon' => 'optimize'],
                    ],
                    'reasons' => [
                        ['title' => 'Secure Cloud Environment', 'description' => 'Industry-leading security keeps your data safe and compliant.', 'icon' => 'shield'],
                        ['title' => 'Flexible Access Anywhere', 'description' => 'Access your data and applications anywhere, anytime.', 'icon' => 'globe'],
                        ['title' => 'Cost Optimization', 'description' => 'Pay for what you use and optimize cloud spending.', 'icon' => 'currency'],
                        ['title' => 'High Availability', 'description' => 'Maximize uptime and keep your business online.', 'icon' => 'chart'],
                        ['title' => 'Business Continuity', 'description' => 'Reliable solutions ensure your business never stops.', 'icon' => 'recycle'],
                    ],
                ],
            ],
            [
                'name' => 'Cybersecurity Services',
                'slug' => 'cybersecurity',
                'icon' => 'shield',
                'excerpt' => 'Protect your business from cyber threats with advanced security solutions and proactive monitoring.',
                'description' => 'Layered protection across networks, endpoints, identities, email, data, and people—continuously monitored and ready to respond.',
                'image_path' => 'images/site/cybersecurity-banner.webp',
                'benefits' => "Firewall Configuration\nEndpoint Protection\nSecurity Monitoring",
                'details' => [
                    'statement' => 'Protect today. Prevent tomorrow.',
                    'service_items' => [
                        ['title' => 'Firewall Configuration', 'description' => 'Secure your network perimeter with advanced firewall solutions.', 'icon' => 'firewall'],
                        ['title' => 'Endpoint Protection', 'description' => 'Protect endpoints from malware, ransomware, and zero-day threats.', 'icon' => 'desktop-shield'],
                        ['title' => 'Microsoft Defender', 'description' => 'Protect identities, devices, and data with Microsoft Defender.', 'icon' => 'shield'],
                        ['title' => 'Email Security', 'description' => 'Block phishing, spam, and malicious attachments before they reach your inbox.', 'icon' => 'mail-shield'],
                        ['title' => 'Multi-Factor Authentication (MFA)', 'description' => 'Add an extra layer of security to user accounts and data.', 'icon' => 'lock'],
                        ['title' => 'Security Assessments', 'description' => 'Identify vulnerabilities and risks with thorough security assessments.', 'icon' => 'clipboard'],
                        ['title' => 'Vulnerability Management', 'description' => 'Detect, prioritize, and remediate vulnerabilities before exploitation.', 'icon' => 'bug-search'],
                        ['title' => 'Data Protection', 'description' => 'Safeguard sensitive data with encryption and access controls.', 'icon' => 'database-shield'],
                        ['title' => 'Security Monitoring', 'description' => '24/7 monitoring and threat detection for maximum protection.', 'icon' => 'eye'],
                        ['title' => 'Security Awareness', 'description' => 'Train your team to recognize threats and build a security-first culture.', 'icon' => 'users'],
                    ],
                    'reasons' => [
                        ['title' => 'Advanced Threat Protection', 'description' => 'Multi-layered security defends against known and emerging threats.', 'icon' => 'shield'],
                        ['title' => 'Secure Business Data', 'description' => 'Protect critical data from breaches and data loss.', 'icon' => 'lock'],
                        ['title' => 'Compliance Support', 'description' => 'Support for industry standards and regulatory requirements.', 'icon' => 'clipboard'],
                        ['title' => 'Continuous Monitoring', 'description' => 'Proactive monitoring detects and responds to threats in real time.', 'icon' => 'eye'],
                        ['title' => 'Peace of Mind', 'description' => 'Focus on your business while we protect what matters most.', 'icon' => 'handshake'],
                    ],
                ],
            ],
            [
                'name' => 'CCTV & Surveillance Solutions',
                'slug' => 'cctv-systems',
                'icon' => 'camera',
                'excerpt' => 'Smart surveillance systems that keep your business secure around the clock.',
                'description' => 'Professional surveillance design, installation, remote access, recording, integration, and support for clear coverage and dependable protection.',
                'image_path' => 'images/site/cctv-systems-banner.webp',
                'benefits' => "CCTV Installation\nRemote Viewing Setup\nMaintenance & Support",
                'details' => [
                    'statement' => 'See everything. Secure everything.',
                    'service_items' => [
                        ['title' => 'CCTV Installation', 'description' => 'Professional installation of high-quality cameras tailored to your needs.', 'icon' => 'camera'],
                        ['title' => 'IP Camera Systems', 'description' => 'Advanced IP camera solutions for crystal-clear video and reliability.', 'icon' => 'camera'],
                        ['title' => 'NVR & DVR Configuration', 'description' => 'Seamless setup for recording and playback.', 'icon' => 'server'],
                        ['title' => 'Remote Viewing Setup', 'description' => 'Access your cameras anytime from your smartphone or PC.', 'icon' => 'devices'],
                        ['title' => 'Video Storage Solutions', 'description' => 'Secure and scalable storage options for important footage.', 'icon' => 'database'],
                        ['title' => 'Maintenance & Support', 'description' => 'Regular maintenance and dedicated support keep your system running.', 'icon' => 'wrench'],
                        ['title' => 'Camera Replacement', 'description' => 'Upgrade or replace cameras with current technology.', 'icon' => 'camera'],
                        ['title' => 'System Upgrades', 'description' => 'Enhance existing systems with advanced features and performance.', 'icon' => 'chart'],
                        ['title' => 'Surveillance Network Integration', 'description' => 'Integrate CCTV with your network for better control and management.', 'icon' => 'network'],
                        ['title' => 'Health Check & Troubleshooting', 'description' => 'System check-ups and fast troubleshooting for maximum uptime.', 'icon' => 'search'],
                    ],
                    'reasons' => [
                        ['title' => '24/7 Monitoring', 'description' => 'Keep an eye on your property day and night.', 'icon' => 'clock'],
                        ['title' => 'High-Definition Video', 'description' => 'Clear, sharp, and reliable video quality.', 'icon' => 'desktop'],
                        ['title' => 'Remote Access', 'description' => 'View live and recorded footage from anywhere.', 'icon' => 'phone'],
                        ['title' => 'Reliable Security', 'description' => 'Robust systems built to protect what matters most.', 'icon' => 'shield'],
                        ['title' => 'Professional Installation', 'description' => 'Expert installation with neat cabling and optimal camera placement.', 'icon' => 'hardhat'],
                    ],
                ],
            ],
            [
                'name' => 'Microsoft 365 Services',
                'slug' => 'microsoft-365-services',
                'icon' => 'grid',
                'excerpt' => 'Boost productivity and collaboration with secure Microsoft 365 solutions tailored for your business.',
                'description' => 'Setup, migration, security, licensing, backup, and ongoing management across the Microsoft 365 workplace.',
                'image_path' => 'images/site/microsoft-365-services-banner.webp',
                'benefits' => "Microsoft 365 Setup & Migration\nExchange Online\nMicrosoft Teams",
                'details' => [
                    'statement' => 'Empower your workforce with Microsoft 365.',
                    'service_items' => [
                        ['title' => 'Microsoft 365 Setup & Migration', 'description' => 'Seamless setup, migration, and deployment to Microsoft 365.', 'icon' => 'cloud-upload'],
                        ['title' => 'Exchange Online', 'description' => 'Professional email with advanced security and reliability.', 'icon' => 'envelope'],
                        ['title' => 'Microsoft Teams', 'description' => 'Improve teamwork and communication with Microsoft Teams.', 'icon' => 'users'],
                        ['title' => 'SharePoint Online', 'description' => 'Build smart intranets, manage content, and improve collaboration.', 'icon' => 'building'],
                        ['title' => 'OneDrive for Business', 'description' => 'Secure cloud storage and file sharing accessible from anywhere.', 'icon' => 'cloud'],
                        ['title' => 'Microsoft Intune', 'description' => 'Manage devices, applications, and data securely.', 'icon' => 'devices'],
                        ['title' => 'Microsoft Entra ID (Azure AD)', 'description' => 'Identity and access management for a secure environment.', 'icon' => 'azure'],
                        ['title' => 'License Management', 'description' => 'Optimize and manage Microsoft 365 licenses efficiently.', 'icon' => 'document'],
                        ['title' => 'Security & Compliance', 'description' => 'Protect data with advanced security and compliance tools.', 'icon' => 'lock'],
                        ['title' => 'Backup & Recovery Guidance', 'description' => 'Keep data safe and recoverable with practical guidance.', 'icon' => 'recycle'],
                    ],
                    'reasons' => [
                        ['title' => 'Secure Cloud Environment', 'description' => 'Enterprise-grade security protects your data and users.', 'icon' => 'lock'],
                        ['title' => 'Anywhere Access', 'description' => 'Work from anywhere, on any device, at any time.', 'icon' => 'globe'],
                        ['title' => 'Seamless Collaboration', 'description' => 'Empower your team to collaborate and achieve more together.', 'icon' => 'users'],
                        ['title' => 'Advanced Security', 'description' => 'Built-in security, compliance, and threat protection.', 'icon' => 'shield'],
                        ['title' => 'Expert Microsoft Support', 'description' => 'Certified experts support, manage, and optimize Microsoft 365.', 'icon' => 'headset'],
                    ],
                ],
            ],
        ];
    }
}
