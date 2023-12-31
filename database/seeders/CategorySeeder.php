<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flatCategories = [
            [
                'tenant_id' => 1,
                'id' => 1,
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'The general field of AI',
                'parent_id' => null,
            ],
            [
                'tenant_id' => 1,
                'id' => 2,
                'name' => 'Machine Learning',
                'slug' => 'machine-learning',
                'description' => 'Algorithms that enable machines to learn from data',
                'parent_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'id' => 3,
                'name' => 'Supervised Learning',
                'slug' => 'supervised-learning',
                'description' => 'Learning with labeled training data',
                'parent_id' => 2,
            ],
            [
                'tenant_id' => 1,
                'id' => 4,
                'name' => 'Unsupervised Learning',
                'slug' => 'unsupervised-learning',
                'description' => 'Learning without labeled training data',
                'parent_id' => 2,
            ],
            [
                'tenant_id' => 1,
                'id' => 5,
                'name' => 'Natural Language Processing',
                'slug' => 'natural-language-processing',
                'description' => 'AI for understanding and generating human language',
                'parent_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'id' => 6,
                'name' => 'Speech Recognition',
                'slug' => 'speech-recognition',
                'description' => 'Converting spoken language into text',
                'parent_id' => 5,
            ],
            [
                'tenant_id' => 1,
                'id' => 7,
                'name' => 'Text Summarization',
                'slug' => 'text-summarization',
                'description' => 'Generating concise summaries of text',
                'parent_id' => 5,
            ],
            [
                'tenant_id' => 1,
                'id' => 8,
                'name' => 'Computer Vision',
                'slug' => 'computer-vision',
                'description' => 'AI for interpreting and understanding visual information',
                'parent_id' => 1,
            ],
            [
                'tenant_id' => 1,
                'id' => 9,
                'name' => 'Image Recognition',
                'slug' => 'image-recognition',
                'description' => 'Identifying and categorizing objects in images',
                'parent_id' => 8,
            ],
            [
                'tenant_id' => 1,
                'id' => 10,
                'name' => 'Object Detection',
                'slug' => 'object-detection',
                'description' => 'Locating and classifying objects in images',
                'parent_id' => 8,
            ],
            [
                'tenant_id' => 1,
                'id' => 11,
                'name' => 'Robotics',
                'slug' => 'robotics',
                'description' => 'The intersection of AI and robotics',
                'parent_id' => null,
            ],
            [
                'tenant_id' => 1,
                'id' => 12,
                'name' => 'Autonomous Robots',
                'slug' => 'autonomous-robots',
                'description' => 'Robots capable of operating without human intervention',
                'parent_id' => 11,
            ],
            [
                'tenant_id' => 1,
                'id' => 13,
                'name' => 'Human-Robot Interaction',
                'slug' => 'human-robot-interaction',
                'description' => 'Study of interactions between humans and robots',
                'parent_id' => 11,
            ],
            [
                'tenant_id' => 1,
                'id' => 14,
                'name' => 'Expert Systems',
                'slug' => 'expert-systems',
                'description' => 'Computer systems that emulate the decision-making ability of a human expert',
                'parent_id' => null,
            ],
            [
                'tenant_id' => 1,
                'id' => 15,
                'name' => 'AI Ethics',
                'slug' => 'ai-ethics',
                'description' => 'Ethical considerations in the development and deployment of AI',
                'parent_id' => null,
            ],
        ];

        Category::insert($flatCategories);
    }
}
