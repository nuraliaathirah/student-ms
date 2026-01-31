<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     * Updated to include 'database'.
     */
    public function via(object $notifiable): array
    {
        // This will now send an email AND save to the 'notifications' table
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = strtoupper($this->registration->status);
        $courseName = $this->registration->section->course->course_name;
        $courseCode = $this->registration->section->course->course_id;

        return (new MailMessage)
            ->subject("Registration Update: {$courseCode}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("Your registration status for **{$courseName} ({$courseCode})** has been updated.")
            ->line("New Status: **{$status}**")
            ->action('View Registration', route('student.registration.index'))
            ->line('Please check your portal for more details.');
    }

    /**
     * Get the array representation of the notification.
     * This is what gets saved in the 'data' column of your 'notifications' table.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Registration Updated',
            'message' => "Your registration for {$this->registration->section->course->course_id} is now " . strtoupper($this->registration->status),
            'registration_id' => $this->registration->registration_id,
            'status' => $this->registration->status,
            'icon' => $this->registration->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle',
            'color' => $this->registration->status === 'approved' ? 'text-success' : 'text-danger',
        ];
    }
}