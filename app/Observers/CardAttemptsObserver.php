<?php

namespace App\Observers;

use App\CardAttempt;

class CardAttemptsObserver
{
    /**
     * Handle the card attempt "created" event.
     *
     * @param  \App\CardAttempt  $cardAttempt
     * @return void
     */
    public function created(CardAttempt $cardAttempt)
    {
        //
    }

    /**
     * Handle the card attempt "updated" event.
     *
     * @param  \App\CardAttempt  $cardAttempt
     * @return void
     */
    public function updated(CardAttempt $cardAttempt)
    {
        logger()->info('actualizado');
        $cardAttempt->attempts += 1;
        $cardAttempt->save();
    }

    /**
     * Handle the card attempt "deleted" event.
     *
     * @param  \App\CardAttempt  $cardAttempt
     * @return void
     */
    public function deleted(CardAttempt $cardAttempt)
    {
        //
    }

    /**
     * Handle the card attempt "restored" event.
     *
     * @param  \App\CardAttempt  $cardAttempt
     * @return void
     */
    public function restored(CardAttempt $cardAttempt)
    {
        //
    }

    /**
     * Handle the card attempt "force deleted" event.
     *
     * @param  \App\CardAttempt  $cardAttempt
     * @return void
     */
    public function forceDeleted(CardAttempt $cardAttempt)
    {
        //
    }
}
