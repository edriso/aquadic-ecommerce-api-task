<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use App\Notifications\OrderPlaced;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class OrderPlacedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public Order $order)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send($this->user, new OrderPlaced($this->order));
    }
}