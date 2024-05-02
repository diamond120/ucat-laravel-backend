<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $section_types = [
            'Verbal Reasoning' => 'VR',
            'Decision Making' => 'DM',
            'Quantitative Reasoning' => 'QR',
            'Abstract Reasoning' => 'AR',
            'Situational Judgement' => 'SJ'
        ];
        $question_types = [
            'Multiple Choice' => 'MC',
            'Multiple Choice (SJ)' => 'MC',
            'Drag and Drop' => 'DD'
        ];

        $base_dir = './database/seeders/data/'; 
        $dir = dir($base_dir);
        
        while(($filename = $dir->read()) !== false) {
            $filepath = $base_dir . $filename;
            if(!is_file($filepath) || substr($filename, -5) !== '.json') continue;
            $content = file_get_contents($filepath);
            
            Log::info('parsing ' . $filename . ' ...');
            $package = json_decode($content);

            $package_id = DB::table('packages')->insertGetId([
                'name' => $package->name,
                'type' => $package->type
            ]);

            foreach($package->sections as $section) {       
                $section_id = DB::table('sections')->insertGetId([
                    'name' => $section->name,
                    'type' => $section_types[$section->type],
                    'time' => $section->time ?? null,
                    'time_sen' => $section->time_sen ?? null,
                    'package_id' => $package_id
                ]);

                foreach($section->situations as $situation) {
                    $situation_id = DB::table('situations')->insertGetId([
                        'text' => $situation->text ?? null,
                        'image_url' => $situation->image ?? null,
                        'split' => isset($situation->layout) && $situation->layout == 'side by side',
                        'section_id' => $section_id
                    ]);

                    foreach($situation->questions as $question) {
                        try {
                            DB::table('questions')->insert([
                                'text' => $question->text ?? null,
                                'image_url' => $question->image ?? null,
                                'type' => $question_types[$question->type],
                                'options' => json_encode($question->options),
                                'option_image_urls' => isset($question->option_images) ? json_encode($question->option_images) : null,
                                'answer' => json_encode($question->answer),
                                'explanation' => $question->explanation,
                                'situation_id' => $situation_id,
                                'section_id' => $section_id             
                            ]);
                        } catch(Exception $e) {
                            Log::info(json_encode($question));
                            throw $e;
                        }
                        
                    }

                }
            }          
            break;
        }
    }
}
