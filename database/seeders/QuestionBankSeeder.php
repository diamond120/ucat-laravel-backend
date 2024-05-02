<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $base_dir = './database/seeders/test/'; 
        $dir = dir($base_dir);
        
        while(($filename = $dir->read()) !== false) {
            $filepath = $base_dir . $filename;
            if(!is_file($filepath) || substr($filename, -5) !== '.json') continue;
            $content = file_get_contents($filepath);
            
            Log::info('parsing ' . $filename . ' ...');
            $data = json_decode($content);
            
            $package = [
                'name' => substr($filename, 0, -5),
                'type' => "Practice Test",
                'sections' => []
            ];

            $times = [
                'Verbal Reasoning' => [21 * 60, 26 * 60 + 15],
                'Decision Making' => [31 * 60, 38 * 60 + 45],
                'Quantitative Reasoning' =>  [25 * 60, 31 * 60 + 15],
                'Abstract Reasoning' => [12 * 60, 15 * 60],
                'Situational Judgement' => [26 * 60, 32 * 60 + 30]
            ];

            foreach($data->sections as $section) {
                foreach($section->situations as $situation) {
                    unset($situation->category_id);
                    foreach($situation->questions as $question) {
                        unset($question->difficulty);
                    }
                }
                $package['sections'][] = [
                    'name' => $section->name,
                    'type' => $section->name,
                    'time' => $times[$section->name][0],
                    'time_sen' => $times[$section->name][1],
                    'situations' => $section->situations
                ];
            }
            
            file_put_contents($base_dir . '../' . $filename, json_encode($package));
        }
    }
}
