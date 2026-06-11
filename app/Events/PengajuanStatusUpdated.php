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
            new PrivateChannel('surat.'.$this->pengajuan->user_id),
            new Channel('pengajuan'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'status-updated';
    }

    public function broadcastWith(): array
    {
        return [
            'pengajuan_id' => $this->pengajuan->id,
            'status' => $this->pengajuan->status,
            'jenis_surat' => $this->pengajuan->jenisSurat?->nama_surat,
            'user_id' => $this->pengajuan->user_id,
            'updated_at' => $this->pengajuan->updated_at?->toIso8601String(),
        ];
    }
}
