<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckInJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $checkInData;

    public function __construct(array $checkInData)
    {
        $this->checkInData = $checkInData;
    }

    public function handle(): void
    {
        Log::channel('logstash')->info('CheckInJob is being processed.', [
            'data' => $this->checkInData,
            'job_id' => $this->job->getJobId(),
            'status' => 'started',
            'timestamp' => now()->toIso8601String(),
        ]);
        
        
        sleep(5);

        Log::channel('logstash')->info('CheckInJob has been completed.', [
            'job_id' => $this->job->getJobId(),
            'status' => 'completed',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

