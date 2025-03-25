<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\UploadedFile;

class processPostImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    protected $post_id;
    protected $images;

    public function __construct($post_id,UploadedFile $images)
    {
        $this->post_id = $post_id;
        $this->images = $images;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
