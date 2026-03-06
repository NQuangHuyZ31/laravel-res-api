<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerationFormRequest;
use App\Http\Resources\ImageGenerationResource;
use App\Models\ImageGeneration;
use App\Services\OpenAiService;

class ImageGenerationController extends Controller
{
    public function __construct(private OpenAiService $openAiService)
    {
    }

    public function index() 
    {
        return ImageGenerationResource::collection(ImageGeneration::all());
    }

    /**
     * Generation image from prompt
     */
    public function store(GenerationFormRequest $request) 
    {
        $user = $request->user();
        $image = $request->file("image");

        $originalName = $image->getClientOriginalName();
        $sanitizedName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $extension = $image->getClientOriginalExtension();
        $safeFilename = $sanitizedName . '_' . time() .'.'. $extension;
        $imagePath = $image->storeAs('uploads/images', $safeFilename, 'public');

        $generatedPrompt = $this->openAiService->generatePromptFromImage($image);

        $imageGeneration = $user->imageGenerations()->create([
            'image_path' => $imagePath,
            'generated_prompt' => $generatedPrompt,
            'original_name' => $originalName,
            'file_size' => $image->getSize(),
            'mime_type' => $image->getMimeType(),
        ]);

        return new ImageGenerationResource($imageGeneration);
    }
}
