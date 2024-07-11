<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatbotController extends AbstractController
{
    #[Route('/chatbot', name: 'chatbot', methods: ['POST'])]
    public function handleChatbotRequest(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = $data['message'] ?? '';
        $reply = $this->getReply($message);

        return new JsonResponse(['reply' => $reply]);
    }

    private function getReply(string $message): string
    {
        $message = strtolower($message);

        // Exercise-related responses
        if (strpos($message, 'exercise') !== false || strpos($message, 'exercises') !== false) {
            if (strpos($message, 'arms') !== false) {
                return 'For arms, you can do bicep curls, tricep dips, and push-ups.';
            } elseif (strpos($message, 'legs') !== false) {
                return 'For legs, you can do squats, lunges, and deadlifts.';
            } elseif (strpos($message, 'chest') !== false) {
                return 'For chest, you can do push-ups, bench press, and chest flyes.';
            } elseif (strpos($message, 'core') !== false) {
                return 'For core strength, try planks, crunches, and Russian twists.';
            } elseif (strpos($message, 'back') !== false) {
                return 'For back muscles, you can do pull-ups, rows, and lat pulldowns.';
            } else {
                return 'Here are some exercises you can do: push-ups, squats, and lunges.';
            }
        }

        // Diet-related responses
        if (strpos($message, 'diet') !== false) {
            if (strpos($message, 'lose weight') !== false) {
                return 'To lose weight, focus on a diet rich in vegetables, lean proteins, and whole grains. Avoid sugary drinks and snacks.';
            } elseif (strpos($message, 'healthy diet') !== false) {
                return 'A healthy diet includes a balance of vegetables, fruits, proteins, and whole grains. Limit processed foods and sugars.';
            } elseif (strpos($message, 'protein') !== false) {
                return 'Foods high in protein include chicken, fish, beans, lentils, and Greek yogurt.';
            } elseif (strpos($message, 'snacks') !== false) {
                return 'Healthy snacks for energy include nuts, fruits, and yogurt.';
            } else {
                return 'For a healthy diet, try to include a balance of proteins, carbs, and fats. Avoid processed foods.';
            }
        }

        // Default response
        return 'I am sorry, I can only answer questions about exercises and diets. Could you ask something specific?';
    }
}
