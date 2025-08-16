<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class JavaFaceEnrollService
{
    private const NAME = 'enroll-face-from-image';
    private const VERSION = '13.1.0.0';
    private const DESCRIPTION = 'Demonstrates enrollment from one image';

    /**
     * Call the Java face enrollment app with the uploaded image.
     *
     * @param string $imagePath Path to the input image
     * @param string|null $outputTemplate Optional path to store the output template
     * @return array ['success' => bool, 'message' => string, 'outputTemplatePath' => string|null]
     */
    public function enroll(string $imagePath, ?string $outputTemplate = null): array
    {
        $outputTemplate = $outputTemplate ?? storage_path('app/public/output-template.dat');

        $command = [
            'java',
            '-jar',
            base_path('java-app/' . self::NAME . '.jar'),
            $imagePath,
            $outputTemplate,
        ];

        $process = new Process($command);
        $process->run();

        // Log for debugging
        Log::info("Running Java enrollment process", [
            'command' => implode(' ', $command),
            'output' => $process->getOutput(),
            'error' => $process->getErrorOutput(),
        ]);

        if (!$process->isSuccessful()) {
            return [
                'success' => false,
                'message' => 'Java process failed: ' . $process->getErrorOutput(),
                'outputTemplatePath' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Enrollment successful.',
            'outputTemplatePath' => $outputTemplate,
        ];
    }
}
