<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		// $recipient = 'steven@example.com';
		// Mail::to($recipient)->send(new OrderShipped($this->order));
		// Log::info('Emailed order ' . $this->order->id);

		// Allow only 2 emails every 1 second
        Redis::throttle('my-mailtrap')->allow(2)->every(1)->then(function () {

            $recipient = 'steven@example.com';
            Mail::to($recipient)->send(new OrderShipped($this->order));
            Log::info('Emailed order ' . $this->order->id);

        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(2);
        });
	}
}
