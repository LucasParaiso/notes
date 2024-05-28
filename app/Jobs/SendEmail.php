<?php

namespace App\Jobs;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Note $note)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $noteUrl = config('app.url') . '/notes/' . $this->note->id;

        $emailContent = "Olá, você recebeu uma nova anotação. Veja aqui: { $noteUrl }";

        Mail::raw($emailContent, function ($message) {
            $message->from('lucas1001lucas11@gmail.com', 'SendNotes')
                ->to($this->note->recipient)
                ->subject('Você tem uma nova Anotação de ' . $this->note->user->name);
        });
    }
}
