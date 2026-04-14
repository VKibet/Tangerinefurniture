<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // General Questions
            [
                'question' => 'What is Guru Digital?',
                'answer' => 'Guru Digital is Kenya\'s premier destination for cutting-edge electronics and digital solutions. We offer a wide range of products including smartphones, laptops, TVs, gaming consoles, and accessories from top brands at competitive prices.',
                'category' => 'general',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'What are your business hours?',
                'answer' => 'Our customer service is available Monday to Friday from 8:00 AM to 6:00 PM, and Saturdays from 9:00 AM to 4:00 PM. We\'re closed on Sundays and public holidays.',
                'category' => 'general',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Do you have a physical store?',
                'answer' => 'Yes, we have a physical store located in Westlands, Nairobi. You can visit us to see products in person, get expert advice, and make purchases. Our address and directions are available on our contact page.',
                'category' => 'general',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'Are your products genuine?',
                'answer' => 'Absolutely! We only sell genuine, authentic products from authorized distributors and manufacturers. All our products come with official warranties and are guaranteed to be 100% authentic.',
                'category' => 'general',
                'order' => 4,
                'is_active' => true
            ],

            // Ordering Questions
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept M-Pesa, Airtel Money, bank transfers, credit/debit cards, and cash on delivery for orders under KES 100,000. All online payments are processed securely through our trusted payment partners.',
                'category' => 'ordering',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'Can I cancel my order?',
                'answer' => 'Yes, you can cancel your order within 2 hours of placing it by contacting our customer service. Once the order has been processed for shipping, cancellation may not be possible.',
                'category' => 'ordering',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Do you offer installment plans?',
                'answer' => 'Yes, we offer flexible installment plans through our partner financial institutions. You can choose from 3, 6, or 12-month payment plans with competitive interest rates.',
                'category' => 'ordering',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'How do I track my order?',
                'answer' => 'Once your order ships, you\'ll receive a tracking number via email and SMS. You can track your order status on our website or contact our customer service for updates.',
                'category' => 'ordering',
                'order' => 4,
                'is_active' => true
            ],

            // Shipping Questions
            [
                'question' => 'How much does shipping cost?',
                'answer' => 'Shipping is free for orders over KES 50,000. For smaller orders, shipping costs vary by location: Nairobi (KES 500), Major cities (KES 800), Other towns (KES 1,200), Remote areas (KES 1,500).',
                'category' => 'shipping',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'How long does delivery take?',
                'answer' => 'Standard delivery takes 3-5 business days. Express delivery (KES 1,500) takes 1-2 business days. Same-day delivery (KES 3,000) is available in Nairobi for orders placed before 2 PM.',
                'category' => 'shipping',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Do you deliver to all areas in Kenya?',
                'answer' => 'Yes, we deliver to all counties in Kenya. Delivery times and costs may vary depending on your location. For very remote areas, delivery may take up to 7 business days.',
                'category' => 'shipping',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'What if I\'m not home when delivery arrives?',
                'answer' => 'Our delivery team will call you before delivery. If you\'re not available, they\'ll attempt delivery again the next business day. You can also specify an alternative delivery address.',
                'category' => 'shipping',
                'order' => 4,
                'is_active' => true
            ],

            // Returns Questions
            [
                'question' => 'What is your return policy?',
                'answer' => 'We offer a 30-day return policy for all products in original condition with complete packaging. Returns are free for defective items or wrong products. Change of mind returns may incur shipping costs.',
                'category' => 'returns',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'How do I return an item?',
                'answer' => 'Contact our customer service to initiate a return. We\'ll provide a return authorization number and arrange pickup or provide a shipping label. Pack the item securely with all original packaging.',
                'category' => 'returns',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'How long does it take to process a refund?',
                'answer' => 'Refunds are processed within 5-7 business days after we receive and inspect the returned item. The refund will be issued to your original payment method.',
                'category' => 'returns',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'What items cannot be returned?',
                'answer' => 'Software, digital downloads, personalized items, gift cards, and items used beyond normal wear cannot be returned. Hygiene products and consumables are also non-returnable.',
                'category' => 'returns',
                'order' => 4,
                'is_active' => true
            ],

            // Technical Questions
            [
                'question' => 'Do you provide technical support?',
                'answer' => 'Yes, we provide comprehensive technical support for all products we sell. Our support team can help with setup, troubleshooting, and warranty claims. Contact us via phone, email, or live chat.',
                'category' => 'technical',
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'What warranty do your products come with?',
                'answer' => 'All products come with manufacturer warranty (typically 1 year). We also offer extended warranty options for most items. Warranty terms vary by product and manufacturer.',
                'category' => 'technical',
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Do you offer installation services?',
                'answer' => 'Yes, we offer free installation for TVs and large appliances in Nairobi. For other areas, installation services are available at an additional cost. Contact us for pricing.',
                'category' => 'technical',
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'Can you help me choose the right product?',
                'answer' => 'Absolutely! Our product experts can help you choose the right product based on your needs, budget, and requirements. Contact us for personalized recommendations.',
                'category' => 'technical',
                'order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
