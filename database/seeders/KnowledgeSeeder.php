<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnowledgeSeeder extends Seeder
{
    public function run()
    {
        DB::table('knowledge')->truncate();

        // Información general de la web
        $webSections = [
            [
                'title' => 'Home',
                'description' => 'Clever Trading: The perfect solution for your business. The majority of our stocks come from advertising barter.',
                'additional_info' => 'International barter, Production surplus, Off-season products, Liquidation, cession and failure, Negative balance outcome, Overseas sale.'
            ],
            [
                'title' => 'About Us',
                'description' => 'Clever Trading is a leader in buying, selling and bartering commercial stock in Europe.',
                'additional_info' => 'International barter, European commercial network, Logistics management, Competitive prices.'
            ],
            [
                'title' => 'Our Services',
                'description' => 'Complete solutions for managing your stock.',
                'additional_info' => 'Stock Purchase, Stock Sale, International Barter, Stock Liquidation.'
            ],
            [
                'title' => 'Our Values',
                'description' => 'Advertising barter, Brand internationalization, Logistics and merchandise management, Marketing network.',
                'additional_info' => 'We convert your surplus products into services, expand the resale market, manage inventory, and provide sales support across Europe.'
            ],
            [
                'title' => 'Team',
                'description' => 'Emma Rodriguez – Senior Developer, Michael Torres – Creative Director, Sarah Mitchell – Project Manager.',
                'additional_info' => 'Responsible for web development, creative projects, and project coordination.'
            ],
            [
                'title' => 'Testimonials',
                'description' => 'Client testimonials from Emma Parker, David Miller, Michael Davis, Sarah Thompson, Robert Johnson, Lisa Williams.',
                'additional_info' => 'Highlights the quality, creativity, professionalism, and reliability of the team.'
            ],
            [
                'title' => 'Contact',
                'description' => 'C. de Manzanares, 4, Arganzuela, 28005 Madrid. Email: clevertradingmadrid@gmail.com. Phone: +34 617 12 41 01.',
                'additional_info' => 'Working Hours: Monday-Friday 9AM - 6PM. Form fields: First Name, Last Name, Country, City, Phone Number, Company Name, Email Address, Selected Categories, Your Message.'
            ]
        ];

        foreach ($webSections as $section) {
            DB::table('knowledge')->insert($section);
        }
    }
}
