<?php

namespace App\Observers;

use App\Models\Contract;
use App\Jobs\SendEmailConfirmContract;

class ContractObserver
{
    /**
     * Handle the contract "created" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function created(Contract $contract)
    {
        SendEmailConfirmContract::dispatch( $contract )
                                    ->delay( now()->addMinutes(5) );
    }

    /**
     * Handle the contract "updated" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function updated(Contract $contract)
    {
        //
    }

    /**
     * Handle the contract "deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function deleted(Contract $contract)
    {
        //
    }

    /**
     * Handle the contract "restored" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function restored(Contract $contract)
    {
        //
    }

    /**
     * Handle the contract "force deleted" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function forceDeleted(Contract $contract)
    {
        //
    }
}
