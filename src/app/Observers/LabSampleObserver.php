<?php

namespace App\Observers;

use App\Mail\SampleCompletedMail;
use App\Models\LabSample;
use Mail;

class LabSampleObserver
{
    /**
     * Handle the LabSample "created" event.
     */
    public function created(LabSample $labSample): void
    {
        //
    }

    /**
     * Handle the LabSample "updated" event.
     */

    public function updated(LabSample $sample): void
    {
        // Only trigger if status changed to 'completed'
        if ($sample->isDirty('status') && $sample->status === 'completed') {
            $manufacturer = $sample->manufacturer;

            if ($manufacturer && $manufacturer->email) {
                Mail::to($manufacturer->email)->send(new SampleCompletedMail($sample));
            }
        }
    }
    /**
     * Handle the LabSample "deleted" event.
     */
    public function deleted(LabSample $labSample): void
    {
        //
    }

    /**
     * Handle the LabSample "restored" event.
     */
    public function restored(LabSample $labSample): void
    {
        //
    }

    /**
     * Handle the LabSample "force deleted" event.
     */
    public function forceDeleted(LabSample $labSample): void
    {
        //
    }
}
