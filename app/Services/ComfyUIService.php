<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class ComfyUIService
{
    private string $baseUrl = 'http://127.0.0.1:8188';

    public function generateImage(
        string $prompt,
        string $language = 'en'
    ): string {
        $workflowPath = storage_path(
            'app/ai-workflows/lesson_image_workflow.json'
        );

        if (!file_exists($workflowPath)) {
            throw new RuntimeException(
                'ComfyUI workflow JSON file was not found.'
            );
        }

        $workflow = json_decode(
            file_get_contents($workflowPath),
            true
        );

        if (!is_array($workflow)) {
            throw new RuntimeException(
                'Invalid ComfyUI workflow JSON.'
            );
        }

        // Update actual workflow nodes
        $workflow['73']['inputs']['text'] = $prompt;

        $workflow['75']['inputs']['text'] =
            'blurry, low quality, distorted objects, extra objects, ' .
            'messy background, dark image, scary characters, ' .
            'realistic photography, watermark';

        $workflow['76']['inputs']['seed'] = random_int(
            1,
            999999999999999
        );

        // Keep image size suitable for your 4GB GPU
        $workflow['77']['inputs']['width'] = 512;
        $workflow['77']['inputs']['height'] = 512;
        $workflow['77']['inputs']['batch_size'] = 1;

        // Submit workflow to ComfyUI
        $response = Http::timeout(30)->post(
            $this->baseUrl . '/prompt',
            [
                'prompt' => $workflow,
                'client_id' => (string) Str::uuid(),
            ]
        );

        if (!$response->successful()) {
            throw new RuntimeException(
                'ComfyUI submission failed: ' . $response->body()
            );
        }

        $promptId = $response->json('prompt_id');

        if (!$promptId) {
            throw new RuntimeException(
                'ComfyUI did not return a prompt ID.'
            );
        }

        // Wait for image generation
        $history = null;

        for ($attempt = 0; $attempt < 180; $attempt++) {
            sleep(2);

            $historyResponse = Http::timeout(15)->get(
                $this->baseUrl . '/history/' . $promptId
            );

            if (!$historyResponse->successful()) {
                continue;
            }

            $history = $historyResponse->json($promptId);

            if (!empty($history['outputs']['79']['images'])) {
                break;
            }

            if (!empty($history['status']['status_str']) &&
                $history['status']['status_str'] === 'error') {
                throw new RuntimeException(
                    'ComfyUI image generation failed.'
                );
            }
        }

        $images = $history['outputs']['79']['images'] ?? [];

        if (empty($images)) {
            throw new RuntimeException(
                'Image generation timed out or returned no image.'
            );
        }

        $image = $images[0];

        // Download generated image from ComfyUI
        $imageResponse = Http::timeout(60)->get(
            $this->baseUrl . '/view',
            [
                'filename' => $image['filename'],
                'subfolder' => $image['subfolder'] ?? '',
                'type' => $image['type'] ?? 'output',
            ]
        );

        if (!$imageResponse->successful()) {
            throw new RuntimeException(
                'Unable to download generated image.'
            );
        }

        // Save image inside Laravel storage
        // $directory = storage_path('app/ai-generated/lesson-images');
        $directory = storage_path('app/public/ai-generated/lesson-images');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::uuid() . '.png';

        $fullPath = $directory . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($fullPath, $imageResponse->body());

        return 'ai-generated/lesson-images/' . $filename;
    }
}
