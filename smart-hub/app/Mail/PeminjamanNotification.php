<?php

namespace App\Mail;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeminjamanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowing;

    // Menerima data borrowing dari controller
    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    // Mengatur judul email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Peminjaman Alat - Smart-Hub',
        );
    }

    // Mengarahkan ke file view yang tadi dibuat
    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}