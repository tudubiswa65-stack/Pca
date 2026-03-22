<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseStorageService
{
    private string $url;
    private string $serviceKey;

    public function __construct()
    {
        $this->url = rtrim(config('services.supabase.url', ''), '/');
        $this->serviceKey = config('services.supabase.service_key', '');
    }

    public function uploadRaw(string $bucket, string $path, string $content, string $mimeType = 'application/pdf'): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->serviceKey}",
                'Content-Type' => $mimeType,
                'x-upsert' => 'true',
            ])->withBody($content, $mimeType)
              ->post("{$this->url}/storage/v1/object/{$bucket}/{$path}");

            if ($response->successful()) {
                return "{$this->url}/storage/v1/object/public/{$bucket}/{$path}";
            }
            Log::error("Supabase upload failed: " . $response->body());
        } catch (\Exception $e) {
            Log::error("Supabase upload error: " . $e->getMessage());
        }
        return null;
    }

    public function getSignedUrl(string $bucket, string $path, int $expiresInSeconds = 3600): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->serviceKey}",
                'Content-Type' => 'application/json',
            ])->post("{$this->url}/storage/v1/object/sign/{$bucket}/{$path}", [
                'expiresIn' => $expiresInSeconds,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->url . '/storage/v1' . ($data['signedURL'] ?? '');
            }
        } catch (\Exception $e) {
            Log::error("Supabase signed URL error: " . $e->getMessage());
        }
        return null;
    }

    public function delete(string $bucket, string $path): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->serviceKey}",
            ])->delete("{$this->url}/storage/v1/object/{$bucket}/{$path}");
            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Supabase delete error: " . $e->getMessage());
            return false;
        }
    }
}