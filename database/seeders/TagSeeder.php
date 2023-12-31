<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $aiTags = [
            ['tenant_id' => 1, 'name' => 'Machine Learning', 'slug' => 'machine-learning', 'description' => 'A subset of artificial intelligence that focuses on the development of algorithms and statistical models that enable computers to improve their performance on a task over time without being explicitly programmed.'],
            ['tenant_id' => 1, 'name' => 'Natural Language Processing', 'slug' => 'nlp', 'description' => 'The field of AI that deals with the interaction between computers and humans using natural language. It involves the development of algorithms to understand, interpret, and generate human language.'],
            ['tenant_id' => 1, 'name' => 'Deep Learning', 'slug' => 'deep-learning', 'description' => 'A subset of machine learning that involves the use of neural networks with multiple layers (deep neural networks). It is particularly effective for tasks such as image and speech recognition.'],
            ['tenant_id' => 1, 'name' => 'Computer Vision', 'slug' => 'computer-vision', 'description' => 'The field of AI that enables computers to interpret and make decisions based on visual data from the world, such as images and videos. Applications include facial recognition, object detection, and image classification.'],
            ['tenant_id' => 1, 'name' => 'Neural Networks', 'slug' => 'neural-networks', 'description' => 'A set of algorithms, modeled after the human brain, that is designed to recognize patterns. Neural networks are a key component of machine learning and deep learning.'],
            ['tenant_id' => 1, 'name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence', 'description' => 'The broader field of computer science that focuses on creating machines and systems that can perform tasks that typically require human intelligence. This includes learning, reasoning, problem-solving, and perception.'],
            ['tenant_id' => 1, 'name' => 'Robotics', 'slug' => 'robotics', 'description' => 'The interdisciplinary field that combines computer science and engineering to design, construct, operate, and use robots. Robots are programmable machines that can perform tasks autonomously or with human guidance.'],
            ['tenant_id' => 1, 'name' => 'Reinforcement Learning', 'slug' => 'reinforcement-learning', 'description' => 'A type of machine learning where an agent learns to make decisions by taking actions in an environment to achieve maximum cumulative reward. It is often used in scenarios where an agent interacts with an environment over time.'],
            ['tenant_id' => 1, 'name' => 'Data Science', 'slug' => 'data-science', 'description' => 'The interdisciplinary field that uses scientific methods, processes, algorithms, and systems to extract insights and knowledge from structured and unstructured data. Data science incorporates elements of statistics, machine learning, and domain expertise.'],
            ['tenant_id' => 1, 'name' => 'Predictive Analytics', 'slug' => 'predictive-analytics', 'description' => 'The use of statistical algorithms and machine learning techniques to analyze current and historical data to make predictions about future events or trends. It is commonly used in business and finance for forecasting.'],
            ['tenant_id' => 1, 'name' => 'Speech Recognition', 'slug' => 'speech-recognition', 'description' => 'The technology that converts spoken language into written text. It is used in various applications, including virtual assistants, transcription services, and voice-activated systems.'],
            ['tenant_id' => 1, 'name' => 'Chatbots', 'slug' => 'chatbots', 'description' => 'Computer programs designed to simulate conversation with human users, especially over the Internet. Chatbots are often used for customer service, information retrieval, and task automation.'],
            ['tenant_id' => 1, 'name' => 'Virtual Assistants', 'slug' => 'virtual-assistants', 'description' => 'AI-powered software applications that provide assistance and perform tasks for users. Virtual assistants can understand natural language and perform tasks such as setting reminders, answering questions, and making recommendations.'],
            ['tenant_id' => 1, 'name' => 'Autonomous Vehicles', 'slug' => 'autonomous-vehicles', 'description' => 'Vehicles equipped with AI and sensors that enable them to navigate and operate without human intervention. Autonomous vehicles include self-driving cars, drones, and unmanned aerial vehicles (UAVs).'],
            ['tenant_id' => 1, 'name' => 'Genetic Algorithms', 'slug' => 'genetic-algorithms', 'description' => 'An optimization technique inspired by the process of natural selection. Genetic algorithms use principles of natural selection, crossover, and mutation to find optimal solutions to problems in optimization and search.'],
            ['tenant_id' => 1, 'name' => 'Pattern Recognition', 'slug' => 'pattern-recognition', 'description' => 'The automated recognition of patterns and regularities in data. Pattern recognition is used in various fields, including image analysis, speech recognition, and medical diagnosis.'],
            ['tenant_id' => 1, 'name' => 'Fuzzy Logic', 'slug' => 'fuzzy-logic', 'description' => 'A mathematical framework that deals with uncertainty and imprecision. Fuzzy logic allows for the representation of vague or ambiguous information and is commonly used in control systems and decision-making.'],
            ['tenant_id' => 1, 'name' => 'Knowledge Representation', 'slug' => 'knowledge-representation', 'description' => 'The process of representing knowledge about the world in a form that a computer system can utilize. Knowledge representation is a fundamental aspect of AI systems that reason and make decisions.'],
            ['tenant_id' => 1, 'name' => 'Expert Systems', 'slug' => 'expert-systems', 'description' => 'Computer systems designed to mimic the decision-making abilities of a human expert in a particular domain. Expert systems use knowledge bases and inference engines to provide expert-level advice.'],
            ['tenant_id' => 1, 'name' => 'Blockchain AI', 'slug' => 'blockchain-ai', 'description' => 'The integration of artificial intelligence with blockchain technology. This combination is used to enhance security, transparency, and efficiency in various applications, including finance and supply chain.'],
            ['tenant_id' => 1, 'name' => 'AI Ethics', 'slug' => 'ai-ethics', 'description' => 'The study of ethical issues related to the design, development, and use of artificial intelligence. AI ethics addresses concerns such as bias, accountability, transparency, and the impact of AI on society.'],
            ['tenant_id' => 1, 'name' => 'Quantum Computing', 'slug' => 'quantum-computing', 'description' => 'A type of computing that takes advantage of the principles of quantum mechanics. Quantum computers use qubits to perform calculations much faster than traditional computers, potentially revolutionizing various fields, including AI.'],
            ['tenant_id' => 1, 'name' => 'Swarm Intelligence', 'slug' => 'swarm-intelligence', 'description' => 'Inspired by the collective behavior of social insects, swarm intelligence refers to the study of decentralized, self-organized systems. It is applied in AI to solve optimization problems through collaboration among agents.'],
            ['tenant_id' => 1, 'name' => 'Cognitive Computing', 'slug' => 'cognitive-computing', 'description' => 'An interdisciplinary field that combines artificial intelligence, neuroscience, and computer science to create systems that simulate human thought processes. Cognitive computing systems aim to understand, learn, and interact with humans in natural ways.'],
            ['tenant_id' => 1, 'name' => 'Emotion AI', 'slug' => 'emotion-ai', 'description' => 'A branch of artificial intelligence that focuses on recognizing, interpreting, and responding to human emotions. Emotion AI is used in applications such as sentiment analysis, affective computing, and human-computer interaction.'],
        ];

        $tags = Tag::insert($aiTags);
    }
}
