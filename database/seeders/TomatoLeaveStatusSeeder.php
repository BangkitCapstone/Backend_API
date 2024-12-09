<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TomatoLeaveStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            [
                'status_name' => 'bacterial_spot',
                'healing_steps' => 'Remove infected leaves immediately. Avoid overhead watering and ensure proper spacing for air circulation. Apply copper-based fungicides to prevent further spread.',
            ],
            [
                'status_name' => 'early_blight',
                'healing_steps' => 'Remove infected leaves and apply a fungicide containing chlorothalonil or copper. Rotate crops to reduce pathogen buildup in the soil.',
            ],
            [
                'status_name' => 'late_blight',
                'healing_steps' => 'Destroy infected plants to prevent the spread of the disease. Apply fungicides with active ingredients such as mancozeb or chlorothalonil.',
            ],
            [
                'status_name' => 'leaf_mold',
                'healing_steps' => 'Reduce humidity by increasing ventilation in the growing area. Apply fungicides like chlorothalonil or mancozeb to affected plants.',
            ],
            [
                'status_name' => 'septoria_leaf_spot',
                'healing_steps' => 'Remove and destroy infected leaves. Apply copper-based fungicides or fungicides containing chlorothalonil to control the spread.',
            ],
            [
                'status_name' => 'spider_mites two_spotted_spider_mite',
                'healing_steps' => 'Spray plants with water to remove mites. Use insecticidal soap or neem oil to manage infestations. Maintain adequate humidity to deter mites.',
            ],
            [
                'status_name' => 'target_spot',
                'healing_steps' => 'Remove infected plant material and avoid overhead watering. Use fungicides containing chlorothalonil or copper to control the disease.',
            ],
            [
                'status_name' => 'Tomato_yellow_leaf_curl_virus',
                'healing_steps' => 'Control whitefly populations as they spread the virus. Remove infected plants and use resistant varieties to reduce the impact.',
            ],
            [
                'status_name' => 'Tomato_mosaic_virus',
                'healing_steps' => 'Destroy infected plants immediately. Wash hands and tools thoroughly after handling infected plants to prevent the spread of the virus.',
            ],
            [
                'status_name' => 'healthy',
                'healing_steps' => 'Maintain healthy tomato leaves by providing consistent watering, ensuring proper spacing for air circulation, and using balanced fertilizers. Regularly inspect plants for pests or diseases.',
            ],
        ];

        // Insert statuses into the database
        DB::table('tomato_leave_status')->insert($statuses);
    }
}
