<?php

namespace Database\Seeders;

use App\Models\DomainPricing;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\HostingPlan;
use App\Models\PlanCategory;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Seed Plan Categories
        $categories = [
            [
                'name' => 'Shared NVMe',
                'slug' => 'shared',
                'badge' => 'Recommended',
                'tagline' => 'High-performance shared NVMe cPanel hosting',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud Hosting',
                'slug' => 'cloud',
                'badge' => 'High Traffic',
                'tagline' => 'Isolated CloudLinux resources with LiteSpeed',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'NVMe VPS',
                'slug' => 'vps',
                'badge' => 'Root Access',
                'tagline' => 'Dedicated NVMe virtual machines with KVM',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'BDIX Connected',
                'slug' => 'bdix',
                'badge' => '8ms Latency',
                'tagline' => 'Direct Dhaka Internet Exchange peered network',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            PlanCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 1. Seed Hosting Plans
        $plans = [
            // Shared
            [
                'name' => 'Starter',
                'category' => 'shared',
                'tagline' => 'For blogs, light sites & personal portfolios.',
                'monthly_price' => 299,
                'yearly_price' => 2990,
                'badge' => null,
                'websites' => '1 Website',
                'storage' => '10 GB NVMe Gen-4',
                'bandwidth' => 'Unmetered',
                'cpu' => '1 vCPU',
                'ram' => '1 GB',
                'features' => ['1 Website', '10 GB NVMe Gen-4', 'Unmetered Bandwidth', '1 vCPU + 1 GB RAM', 'Free AutoSSL & cPanel'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Business',
                'category' => 'shared',
                'tagline' => 'For dynamic WooCommerce stores & traffic spikes.',
                'monthly_price' => 599,
                'yearly_price' => 5990,
                'badge' => 'RECOMMENDED',
                'websites' => '5 Websites',
                'storage' => '40 GB NVMe Gen-4',
                'bandwidth' => 'Unmetered',
                'cpu' => '2 vCPU',
                'ram' => '2 GB',
                'features' => ['5 Websites', '40 GB NVMe Gen-4', '2 vCPU + 2 GB RAM', 'Free Domain (.COM)', 'LiteSpeed + Daily Backup'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium',
                'category' => 'shared',
                'tagline' => 'For agencies, portals & multi-site networks.',
                'monthly_price' => 999,
                'yearly_price' => 9990,
                'badge' => null,
                'websites' => 'Unlimited Websites',
                'storage' => '100 GB NVMe Storage',
                'bandwidth' => 'Unmetered',
                'cpu' => '3 vCPU',
                'ram' => '4 GB',
                'features' => ['Unlimited Websites', '100 GB NVMe Storage', '3 vCPU + 4 GB RAM', '1 Free Dedicated IP', 'Redis Object Cache & SSL'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Cloud
            [
                'name' => 'Cloud Start',
                'category' => 'cloud',
                'tagline' => 'Dedicated cloud CPU container with auto-burst.',
                'monthly_price' => 1299,
                'yearly_price' => 12990,
                'badge' => null,
                'websites' => '10 Websites',
                'storage' => '60 GB Enterprise NVMe',
                'bandwidth' => 'Unmetered',
                'cpu' => '2 Dedicated vCPUs',
                'ram' => '4 GB Dedicated RAM',
                'features' => ['2 Dedicated vCPUs', '4 GB Dedicated RAM', '60 GB Enterprise NVMe', '10 Websites + Dedicated IP'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Cloud Business',
                'category' => 'cloud',
                'tagline' => 'High-transaction e-commerce & busy databases.',
                'monthly_price' => 2499,
                'yearly_price' => 24990,
                'badge' => 'CLOUD FLAGSHIP',
                'websites' => 'Unlimited Sites',
                'storage' => '140 GB Enterprise NVMe',
                'bandwidth' => 'Unmetered',
                'cpu' => '4 Dedicated vCPUs',
                'ram' => '8 GB Dedicated RAM',
                'features' => ['4 Dedicated vCPUs', '8 GB Dedicated RAM', '140 GB Enterprise NVMe', 'Unlimited Sites + Free Domain'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Cloud Pro',
                'category' => 'cloud',
                'tagline' => 'For mission-critical production stacks.',
                'monthly_price' => 4999,
                'yearly_price' => 49990,
                'badge' => null,
                'websites' => 'Unlimited Sites',
                'storage' => '300 GB NVMe',
                'bandwidth' => 'Unmetered',
                'cpu' => '8 Dedicated vCPUs',
                'ram' => '16 GB RAM',
                'features' => ['8 Dedicated vCPUs', '16 GB RAM + 300 GB NVMe', '2 Dedicated IPs + Anycast DNS'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // VPS
            [
                'name' => 'VPS Basic',
                'category' => 'vps',
                'tagline' => 'Root SSH access, choice of Ubuntu, Debian, AlmaLinux.',
                'monthly_price' => 1499,
                'yearly_price' => 14990,
                'badge' => null,
                'websites' => 'Full Server',
                'storage' => '50 GB NVMe',
                'bandwidth' => '3 TB Bandwidth',
                'cpu' => '2 vCPU Cores',
                'ram' => '4 GB DDR4 ECC RAM',
                'features' => ['2 vCPU Cores (3.4 GHz+)', '4 GB DDR4 ECC RAM', '50 GB NVMe + 3 TB Bandwidth', '1 Dedicated IPv4 + /64 IPv6'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'VPS Pro',
                'category' => 'vps',
                'tagline' => 'For Docker containers, microservices & backend APIs.',
                'monthly_price' => 2999,
                'yearly_price' => 29990,
                'badge' => 'DEVELOPER PICK',
                'websites' => 'Full Server',
                'storage' => '100 GB NVMe',
                'bandwidth' => '6 TB Bandwidth',
                'cpu' => '4 vCPU Cores',
                'ram' => '8 GB DDR4 ECC RAM',
                'features' => ['4 vCPU Cores High Frequency', '8 GB DDR4 ECC RAM', '100 GB NVMe + 6 TB Bandwidth', '2 Dedicated IPv4 Addresses'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'VPS Business',
                'category' => 'vps',
                'tagline' => 'For heavy relational databases & large scale operations.',
                'monthly_price' => 5999,
                'yearly_price' => 59990,
                'badge' => null,
                'websites' => 'Full Server',
                'storage' => '240 GB NVMe',
                'bandwidth' => '10 TB Bandwidth',
                'cpu' => '8 vCPU Cores',
                'ram' => '16 GB RAM',
                'features' => ['8 vCPU Cores', '16 GB RAM + 240 GB NVMe', '3 Dedicated IPv4 + Anti-DDoS'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // BDIX
            [
                'name' => 'BDIX Starter',
                'category' => 'bdix',
                'tagline' => 'Direct Dhaka peering for ultra-fast local loading.',
                'monthly_price' => 399,
                'yearly_price' => 3990,
                'badge' => null,
                'websites' => '1 Website',
                'storage' => '15 GB BDIX NVMe',
                'bandwidth' => '100 Mbps BDIX',
                'cpu' => '1.5 vCPU',
                'ram' => '2 GB RAM',
                'features' => ['1 Website', '15 GB BDIX NVMe', '1.5 vCPU + 2 GB RAM', 'cPanel + LiteSpeed'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'BDIX Business',
                'category' => 'bdix',
                'tagline' => 'For Bangladeshi news sites, portals & local stores.',
                'monthly_price' => 799,
                'yearly_price' => 7990,
                'badge' => 'LOCAL FAVORITE',
                'websites' => '5 Websites',
                'storage' => '50 GB BDIX NVMe',
                'bandwidth' => '1 Gbps BDIX',
                'cpu' => '2.5 vCPU',
                'ram' => '4 GB RAM',
                'features' => ['5 Websites', '50 GB BDIX NVMe', '2.5 vCPU + 4 GB RAM', 'Free Domain (.COM)'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'BDIX Premium',
                'category' => 'bdix',
                'tagline' => 'Dedicated BDIX IP routing for high volume traffic.',
                'monthly_price' => 1499,
                'yearly_price' => 14990,
                'badge' => null,
                'websites' => 'Unlimited Websites',
                'storage' => '120 GB NVMe Storage',
                'bandwidth' => '1 Gbps BDIX',
                'cpu' => '4 vCPU',
                'ram' => '6 GB RAM',
                'features' => ['Unlimited Websites', '120 GB NVMe Storage', '1 Dedicated BDIX IP', '4 vCPU + 6 GB RAM'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $p) {
            HostingPlan::updateOrCreate(
                ['name' => $p['name'], 'category' => $p['category']],
                $p
            );
        }

        // 2. Seed Domain Pricings
        $tlds = [
            ['tld' => '.com', 'price' => 1290, 'renewal_price' => 1450, 'badge' => 'Popular', 'is_popular' => true, 'is_active' => true, 'sort_order' => 1],
            ['tld' => '.net', 'price' => 1450, 'renewal_price' => 1650, 'badge' => 'Available', 'is_popular' => true, 'is_active' => true, 'sort_order' => 2],
            ['tld' => '.org', 'price' => 1390, 'renewal_price' => 1550, 'badge' => null, 'is_popular' => true, 'is_active' => true, 'sort_order' => 3],
            ['tld' => '.info', 'price' => 499, 'renewal_price' => 1890, 'badge' => 'Budget', 'is_popular' => true, 'is_active' => true, 'sort_order' => 4],
            ['tld' => '.io', 'price' => 3850, 'renewal_price' => 4200, 'badge' => 'Tech Favorite', 'is_popular' => true, 'is_active' => true, 'sort_order' => 5],
            ['tld' => '.xyz', 'price' => 250, 'renewal_price' => 1350, 'badge' => 'Promo', 'is_popular' => true, 'is_active' => true, 'sort_order' => 6],
        ];

        foreach ($tlds as $t) {
            DomainPricing::updateOrCreate(['tld' => $t['tld']], $t);
        }

        // 3. Seed Features
        $features = [
            ['title' => 'LiteSpeed Enterprise', 'icon' => 'fa-solid fa-bolt', 'description' => 'Native event-driven server handling 10,000+ simultaneous visitors with sub-80ms TTFB.', 'badge' => 'TURBO', 'is_highlight' => true, 'is_active' => true, 'sort_order' => 1],
            ['title' => 'NVMe Gen-4 Array', 'icon' => 'fa-solid fa-microchip', 'description' => 'PCIe 4.0 solid-state drives delivering 7,450 MB/s for instantaneous database lookups.', 'badge' => 'PCIe 4.0', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 2],
            ['title' => 'Free Wildcard SSL', 'icon' => 'fa-solid fa-lock', 'description' => 'Automated 256-bit certificates for all domains and subdomains with silent auto-renewal.', 'badge' => 'Auto-Renew', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 3],
            ['title' => 'Daily Acronis Backups', 'icon' => 'fa-solid fa-clock-rotate-left', 'description' => 'Automated off-site cloud snapshots taken every 24 hours with 1-click snapshot restore.', 'badge' => '30 Days', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 4],
            ['title' => 'Imunify360 Defense', 'icon' => 'fa-solid fa-shield-halved', 'description' => 'Machine-learning firewall defusing malware, brute-force attacks and zero-day exploits.', 'badge' => 'AI WAF', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 5],
            ['title' => 'Free Migration', 'icon' => 'fa-solid fa-truck-fast', 'description' => 'Our senior migration team transfers your websites and email inboxes with zero downtime.', 'badge' => 'Zero Downtime', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 6],
            ['title' => '99.99% Uptime SLA', 'icon' => 'fa-solid fa-satellite-dish', 'description' => 'Redundant N+2 power, multi-homed BGP fiber, backed by our financial guarantee.', 'badge' => 'SLA Backed', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 7],
            ['title' => '24/7 Expert Support', 'icon' => 'fa-solid fa-headset', 'description' => 'Direct chat with certified Linux system administrators in under 90 seconds.', 'badge' => '<90s Response', 'is_highlight' => false, 'is_active' => true, 'sort_order' => 8],
        ];

        foreach ($features as $f) {
            Feature::updateOrCreate(['title' => $f['title']], $f);
        }

        // 4. Seed Testimonials
        $testimonials = [
            [
                'client_name' => 'Tanvir Hossain',
                'role' => 'CTO',
                'company' => 'BazarDirect Logistics',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
                'rating' => 5,
                'review_text' => 'We migrated our multi-vendor store to NEXUSHOST BDIX Business. Our page load dropped from 2.9s to under 650ms. The speed difference for local customers is immediate.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Rafiqul Islam',
                'role' => 'Managing Director',
                'company' => 'PixelCraft Digital',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80',
                'rating' => 5,
                'review_text' => 'As an agency hosting 40+ client sites, support is paramount. Whenever we need assistance, their live chat responds in seconds. Real engineers, no canned scripts.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Samira Chowdhury',
                'role' => 'Head of Tech',
                'company' => 'FinFlow',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80',
                'rating' => 5,
                'review_text' => 'Their Cloud VPS handled our flash sale without a hitch. The NVMe Gen-4 read speeds are consistently above 7,000 MB/s. Solid, reliable architecture.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 5. Seed FAQs
        $faqs = [
            ['question' => 'Can I upgrade later?', 'answer' => 'Yes, upgrades are seamless with zero downtime. All files, databases, and mail accounts remain intact.', 'is_active' => true, 'sort_order' => 3],
            ['question' => 'Do you provide free SSL?', 'answer' => 'Yes, free 256-bit Let\'s Encrypt Wildcard SSL certificates are automatically installed and renewed for all domains and subdomains.', 'is_active' => true, 'sort_order' => 4],
            ['question' => 'Do you provide free migration?', 'answer' => 'Yes, our technical team migrates your website, databases, and emails from your existing host completely free with guaranteed zero downtime.', 'is_active' => true, 'sort_order' => 5],
            ['question' => 'Can I register a domain for multiple years?', 'answer' => 'Yes, you can register and renew domains for up to 10 consecutive years to lock in registration pricing.', 'is_active' => true, 'sort_order' => 6],
            ['question' => 'How does yearly hosting work?', 'answer' => 'Yearly hosting gives an automatic 25% discount (2 months free) plus a free .COM top-level domain on Business and Premium packages.', 'is_active' => true, 'sort_order' => 7],
            ['question' => 'What happens when my hosting expires?', 'answer' => 'We provide reminders starting 30 days prior and grant an automatic 15-day grace period where your data is safely retained.', 'is_active' => true, 'sort_order' => 8],
            ['question' => 'Do you provide cPanel?', 'answer' => 'Yes, official cPanel with Softaculous 1-click app installers, file managers, and phpMyAdmin is included on all shared and cloud accounts.', 'is_active' => true, 'sort_order' => 9],
            ['question' => 'Where are your servers located?', 'answer' => 'Our nodes are housed in Tier-IV facilities across Singapore (Equinix SG1), Dhaka (BDIX Connected), and Frankfurt (FRA1).', 'is_active' => true, 'sort_order' => 10],
            ['question' => 'Do you offer technical support?', 'answer' => 'Yes, 24/7/365 via live chat and ticket desk with certified Linux administrators. Average live chat response is under 90 seconds.', 'is_active' => true, 'sort_order' => 11],
            ['question' => 'What payment methods are accepted?', 'answer' => 'We accept bKash, Nagad, Rocket, Visa, Mastercard, American Express, PayPal, Stripe, and Direct Bank Wire Transfers with instant activation.', 'is_active' => true, 'sort_order' => 12],
        ];

        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], $f);
        }

        // 6. Seed Site Settings
        $settings = [
            'site_name' => 'NEXUSHOST',
            'hero_pill' => 'Tier-IV Certified · BDIX 8ms Latency',
            'hero_title' => 'Build Faster. Host Smarter.',
            'hero_description' => 'Engineered cloud hosting for modern web applications, agencies, and businesses. NVMe Gen-4 storage, automated failover, and sub-millisecond database queries.',
            'promo_code' => 'WELCOME20',
            'promo_title' => '20% OFF your first year of hosting.',
            'promo_discount' => '20',
            'bundle_title' => 'Everything you need to launch.',
            'bundle_price' => '4990',
            'bundle_savings' => '2400',
            'support_phone' => '+880 9610-NEXUS',
            'support_email' => 'support@nexus.com',
            'status_text' => 'All Global Datacenters Operational',

            // Header Settings
            'header_announcement_enabled' => '1',
            'header_announcement_badge' => 'BDIX 8ms',
            'header_announcement_text' => 'Tier-IV Infrastructure · High-Speed BDIX Routing · 99.99% Guaranteed Uptime',
            'header_cta_text' => 'Get Started',
            'header_cta_link' => '#pricing',

            // Footer Settings
            'footer_company_desc' => 'Engineered cloud hosting with enterprise NVMe Gen-4 storage, dedicated BDIX routing, and multi-tier DDoS mitigation for Bangladesh and global applications.',
            'footer_copyright' => '© 2026 NEXUSHOST Technologies Ltd. All rights reserved. Registered with BTRC & ICANN.',
            'footer_address' => 'Level 12, Crystal Tower, Gulshan-2, Dhaka 1212, Bangladesh',
            'footer_badge_text' => 'Tier-IV Certified · BDIX Member · ISO 27001',
            'footer_facebook' => 'https://facebook.com',
            'footer_twitter' => 'https://twitter.com',
            'footer_linkedin' => 'https://linkedin.com',
            'footer_github' => 'https://github.com',

            // Section Visibility Toggles (1 = Visible, 0 = Hidden)
            'section_hero_enabled' => '1',
            'section_promo_bar_enabled' => '1',
            'section_domain_enabled' => '1',
            'section_plans_enabled' => '1',
            'section_features_enabled' => '1',
            'section_infrastructure_enabled' => '1',
            'section_bundle_enabled' => '1',
            'section_testimonials_enabled' => '1',
            'section_faq_enabled' => '1',
            'section_cta_enabled' => '1',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }

    }
}
