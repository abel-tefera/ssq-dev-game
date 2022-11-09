<?php

namespace App\Jobs;

use stdClass;
use App\Models\Kpi;
use Illuminate\Bus\Queueable;
use App\Http\Requests\KpiRequest;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessKpi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kpis;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($kpis)
    {
        $this->kpis = $kpis;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = new stdClass;
        // $kpiRequest = null;
        foreach ($this->kpis as $index => $kpi) {
            // $request->merge();
            $response->$index = new stdClass;
            try {
                $validator = Validator::make($kpi, KpiRequest::rules());
                $validator->validated();
                $response->$index->kpi = $kpi;
                $kpiModel = new Kpi;
                $kpiModel->email = $kpi['email'];
                $kpiModel->year = $kpi['year'];
                $kpiModel->month = $kpi['month'];
                $kpiModel->value = $kpi['value'];
                $kpiModel->type = $kpi['type'];
                $kpiModel->subtype = $kpi['subtype'];
                $kpiModel->save();
            } catch (\Illuminate\Validation\ValidationException $th) {
                $response->$index->kpi = $kpi;
                $response->$index->errors = $th->validator->errors();
            }
        }
    }
}
