<?php

namespace App\Http\Controllers;

use App\Services\BookRecommendationService;
use Illuminate\Http\Request;

class BookRecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(BookRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function recommend($userId)
    {
        $recommendations = $this->recommendationService->recommendBooks($userId);
        return response()->json($recommendations);
    }
}
