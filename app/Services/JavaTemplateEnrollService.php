<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class JavaTemplateEnrollService
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
    public function enroll(?string $serverAddress, ?int $clientPort, string $template): array
    {
        //JAVA_TEMPLATE_ENROLL_JAR
        $jarPath = config('services.java_template_enroll.jar_path');
        $outPath = config('services.java_template_enroll.out_path');


        if (!file_exists($jarPath)) {
            return [
                'success' => false,
                'message' => "Java JAR not found at path: $jarPath", 
            ];
        } 
        //overwrite
        $jarPath ='enroll-to-server.jar';


        $templatePath=$outPath.$template;
        $outputTemplate=$templatePath;

        //overwrite
        $templatePath=$template;

        $serverArg = $serverAddress ? "-s {$serverAddress}:{$this->defaultServerPort}" : '';
        $clientPort = $clientPort ?? $this->defaultClientPort;
        $clientArg = "-c {$clientPort}";
        $templateArg = "-t {$templatePath}";

        $cmd = [
            '/usr/bin/java',
            //'-Djava.library.path=/var/www/html/alive/cdn/Lib/Linux_x86_64',
            //'-Djava.security.debug=properties',
            '-jar',
            $jarPath,
            ...explode(' ', trim("$serverArg $clientArg $templateArg"))
        ];

        if (!file_exists($templatePath)) {
            return [
                'cmd'=>implode(' ',$cmd),
                'success' => false,
                'message' => "Template file not found at: {$templatePath}", 
            ];
        } 

        $process = new Process($cmd,$outPath);
        $process->setEnv([
            'PATH' => '/usr/bin:/bin',
            'LD_LIBRARY_PATH'=>'/var/www/html/alive/cdn/Lib/Linux_x86_64',
            'JAVA_HOME' => '/usr/bin/java',  
        ]);
        $process->run();

        /*if (!$process->isSuccessful()) {
            Log::error("Java app failed: " . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();*/


        if (!$process->isSuccessful()) {
            return [
                'cmd'=>implode(' ',$cmd),
                'success' => false,
                'message' => 'Java process failed: ' . $process->getErrorOutput(),
                'message2'=>$process->getOutput(),
                'outputTemplatePath' => null,
            ];
        }

        return [
                'cmd'=>implode(' ',$cmd),
            'success' => true,
            'message' => 'Enrollment successful.', 
                'message2'=>$process->getOutput(),
            'verbose' => $outputTemplate,
        ];
    }
}
