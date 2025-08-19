<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class JavaFaceEnrollService3
{
    protected string $jarPath;
    protected string $defaultAddress = '127.0.0.1';
    protected int $defaultServerPort = 24932;
    protected int $defaultClientPort = 25452;

    public function __construct()
    {
        $this->jarPath = storage_path('app/java/enroll-to-server.jar');
    }

    /**
     * Call the Java application with the provided parameters.
     *
     * @param string|null $serverAddress
     * @param int|null $clientPort
     * @param string $templatePath
     * @return array Output from Java app
     * @throws \Exception
     */
    public function enroll(?string $serverAddress, ?int $clientPort, string $imagePath, ?string $templateId = null): array
    {
        //JAVA_TEMPLATE_ENROLL_JAR
        /*$jarPath = config('services.java_template_enroll.jar_path');
        $outPath = config('services.java_template_enroll.out_path');
        */
        $jarPath = config('services.java_face_enroll.jar_path');
        $outPath = config('services.java_face_enroll.out_path');


        //$templatePath=$outPath.$template;
        $outputTemplate = $templatePath = $outPath . $templateId;


        if (!file_exists($jarPath)) {
            return [
                'success' => false,
                'message' => "Java JAR not found at path: $jarPath", 
            ];
        }


/*
        if (!file_exists($templatePath)) {
            return [
                'success' => false,
                'message' => "Template file not found at: {$templatePath}", 
            ];
        } 
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found at: {$templatePath}");
        }
*/
        $serverArg = $serverAddress ? "-s {$serverAddress}:{$this->defaultServerPort}" : '';
        $clientPort = $clientPort ?? $this->defaultClientPort;
        $clientArg = "-c {$clientPort}";
        $inputArg = "-i {$imagePath}";
        $templateArg = "-t {$outPath}{$templatePath}";

        $cmd = [
            'java',
            '-jar',
            $this->jarPath,
            ...explode(' ', trim("$serverArg $clientArg $inputArg $templateArg"))
        ];

        $process = new Process($cmd);
        $process->run();

        /*if (!$process->isSuccessful()) {
            Log::error("Java app failed: " . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();*/


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
            'verbose' => $outputTemplate,
        ];
    }
}
