<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will resend all unsent messages';

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
        $messages = Message::where('is_sent', false)->get();
        $bar = $this->output->createProgressBar(count($messages));
        $count = 0;
        foreach ($messages as &$message) {
            $response = Http::get(route('send1'),[
                'id' => $message->id,
                'number' => $message->number,
                'body' => $message->body
            ]);
            if($response->successful()) {
                $count += 1;
            }
            $bar->advance();
        }
        $bar->finish();
        dump("$count messages succesfully sent!");
    }
}
