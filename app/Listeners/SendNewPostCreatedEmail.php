<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Mail\NewPostCreatedEmail;
use App\Models\Email;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewPostCreatedEmail
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public $post;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        //
        $this->post = $post;
    }

    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->post->subscribers as $subscriber){
            $mail_notification = Email::where('subscriber_id', $subscriber->id)->where('post_id', $event->post->id)->first();

            if (! empty($mail_notification)){
                continue;
            }

            Mail::to($subscriber->email)->send(
                new NewPostCreatedEmail($event->post)
            );

            // Save the record.
            Email::create([
                'subscriber_id' => $subscriber->id,
                'post_id' => $event->post->id,
            ]);
        }
    }
}
