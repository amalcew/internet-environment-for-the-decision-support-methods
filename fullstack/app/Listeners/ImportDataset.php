<?php

namespace App\Listeners;

use App\Events\AfterDatasetCreated;
use App\Imports\DatasetImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataset
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AfterDatasetCreated $event): void
    {
        $dataset = $event->dataset;
        Excel::import(new DatasetImport($dataset->id), $event->file);

    }
}
