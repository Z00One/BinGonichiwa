<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ServeLocal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the local network';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ip = $this->getLocalIp();
        if (!$ip) {
            $this->error('Local IP address could not be found.');
            return;
        }
        $this->call('serve', ['--host' => $ip]);
    }

    private function getLocalIp()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $process = new Process(['ipconfig']);
        } elseif (PHP_OS_FAMILY === 'Darwin') { // macOS
            $process = new Process(['ifconfig', 'en0']);
        } else {
            $this->error('Unsupported OS.');
            return null;
        }

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        if (PHP_OS_FAMILY === 'Windows') {
            if (preg_match('/IPv4 Address[\. ]*: ([\d\.]+)/', $output, $matches)) {
                return $matches[1];
            }
        } else { // macOS
            if (preg_match('/inet (\d+\.\d+\.\d+\.\d+)/', $output, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
