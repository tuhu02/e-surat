<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengajuan;

class PengajuanStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pengajuan;

    /**
     * Create a new event instance.
     */
    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan->loadMissing('user', 'jenisSurat'); 
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('pengajuan'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'status-updated';
    }
}
