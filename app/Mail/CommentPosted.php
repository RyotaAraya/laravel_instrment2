<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Comment $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    public function build()
    {
        return $this
            ->subject('コメントありがとうございます')
            ->view('emails.comments.posted');
    }
}
