<?php

namespace Modules\Admin\Emails;

use Cartalyst\Sentinel\Reminders\EloquentReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EloquentReminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('admin::email.passwordreset')->with([
            'url' => route('admin.resetpassword', $this->reminder->code)
        ]);
    }
}
