<?php

namespace Src\Infrastructure\Commands;

use Exception;
use Illuminate\Console\Command as CommandResponse;
use Illuminate\Support\Facades\File;

class GenerateSwaggerDocsCommand extends CommandResponse
{
    protected $signature = 'swagger:generate-docs';
    protected $description = 'Generate Swagger documentation with environment variables';

    public function handle(): int
    {
        $openApiFile = base_path('src/Shared/Swagger/OpenApi.php');
        $originalContent = File::get($openApiFile);

        try {
            $appName = config('setting.app_name');
            $apiVersion = config('setting.api_version');
            $contactEmail = config('setting.contact_email');
            $appUrl = config('setting.app_url');
            $apiDescription = config('setting.doc_description');
            $this->info('Using environment values:');
            $this->table(
                ['Variable', 'Value'],
                [
                    ['APP_NAME', $appName],
                    ['API_VERSION', $apiVersion],
                    ['API_CONTACT_EMAIL', $contactEmail],
                    ['API_DESCRIPTION', $apiDescription],
                    ['APP_URL', $appUrl],
                ]
            );
            $content = $originalContent;
            $patterns = [
                '/@OA\\\\Info\\(\\s*version="[^"]*"/' => '@OA\\Info(\\n *     version="' . $apiVersion . '"',
                '/title="[^"]*"/' => 'title="' . $appName . '"',
//              '/description="[^"]*"/' => 'description="' . $apiDescription . '"',
                '/@OA\\\\Contact\\(\\s*email="[^"]*"/' => '@OA\\Contact(\\n *         email="' . $contactEmail . '"',
                '/@OA\\\\Server\\(\\s*url="[^"]*"/' => '@OA\\Server(\\n *     url="' . $appUrl . '/api/v1"'
            ];
            foreach ($patterns as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
            File::put($openApiFile, $content);
            $this->info('Generating Swagger documentation...');
            $this->call('l5-swagger:generate');
            File::put($openApiFile, $originalContent);
            $this->info('Documentation generated successfully!');
        } catch (Exception $e) {
            $this->error('Error generating documentation: ' . $e->getMessage());
            if (isset($originalContent)) {
                File::put($openApiFile, $originalContent);
            }
            return CommandResponse::FAILURE;
        }
        return CommandResponse::SUCCESS;
    }
}
