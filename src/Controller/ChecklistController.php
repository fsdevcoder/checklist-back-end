<?php
// src/Controller/ChecklistController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\ChecklistService;

class ChecklistController extends AbstractController
{
    /**
     * @Route("/api/checklist", name="api_checklist", methods={"POST"})
     */
    public function checklistAction(Request $request, ChecklistService $checklistService)
    {
        $reqBody=json_decode($request->getContent());

        if (!$reqBody && !isset($reqBody->content)) {
            return new JsonResponse([
                "error" => "Invalid input: Missing content!"
            ], 400);
        }

        $analyzedResult = $checklistService->doAnalyze($reqBody->content);

        if (!$analyzedResult) {
            $min_number_of_words = $checklistService->getMinNumberOfWords();
            return new JsonResponse([
                "error" => "Invlid content: It must contain more than $min_number_of_words words."
            ], 400);
        }

        return new JsonResponse($analyzedResult);
    }
}