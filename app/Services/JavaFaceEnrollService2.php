<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class JavaFaceEnrollService2
{
    private const NAME = 'enroll-face-from-image';
    private const VERSION = '13.1.0.0';
    private const DESCRIPTION = 'Demonstrates enrollment from one image';

    /**
     * Call the Java face enrollment app with the uploaded image.
     *
     * @param string $imagePath Path to the input image
     * @param string|null $templateId Optional path to store the output template
     * @return array
     */
    public function enroll(string $imagePath, ?string $templateId = null): array
    {
        $jarPath = config('services.java_face_enroll.jar_path');
        $outPath = config('services.java_face_enroll.out_path');

        if (!file_exists($jarPath)) {
            return [
                'success' => false,
                'message' => "Java JAR not found at path: $jarPath",
                'outputTemplatePath' => null,
            ];
        }
        $outputTemplate = $outPath . $templateId;

        //$outputTemplate = $outputTemplate ?? storage_path('app/public/output-template.dat');  

        $command = [
            'java',
            '-jar',
            $jarPath,
            $imagePath,
            $outputTemplate,
        ];

        $process = new Process($command);
        $process->run();

        /*Log::info("Running Java enrollment process", [
            'command' => implode(' ', $command),
            'output' => $process->getOutput(),
            'error' => $process->getErrorOutput(),
        ]);*/

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
