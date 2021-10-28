<?php

namespace App\Console\Commands;

use App\Events\SendPostNotificationCommandRecieved;
use App\Listeners\SendNewPostCreatedEmail;
use App\Models\Post;
use Illuminate\Console\Command;

class SendEmailToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:email {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to subscribers for a particular post.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $post_id = $this->argument('id');

        $post = Post::with('subscribers')->where('id', $post_id)->first();

        if(empty($post)){
            $this->error('Sorry! Post not found.');
            return 0;
        }

        event(new SendPostNotificationCommandRecieved($post));

        return 1;
    }
}
