<?php

namespace App\Http\Controllers;

use stdClass;
use Exception;
use App\Models\Kpi;
use Illuminate\Http\Request;
use App\Http\Requests\KpiRequest;
use App\Jobs\ProcessKpi;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class KpiController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     
     * @OA\Post(
     * path="/kpi/upload",
     * summary="Bulk upload KPI from a file",
     * description="Store KPI object by using upload file",
     * operationId="uploadFile",
     * tags={"kpiUpload"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Upload the file",
     *    @OA\JsonContent(
     *       required={"file"},
     *       @OA\Property(property="file", type="file"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Successfully uploaded",
     *    @OA\JsonContent(
     *       @OA\Property(property="fileStatus", type="string", example="Sorry, wrong kpi format. Please try again"),
     *       @OA\Property(property="status", type="boolean", example="true")
     *        )
     *     )
     * )
     */
    public function store(KpiRequest $request)
    {

        $kpi = new Kpi;
        $kpi->email = $request->input('email'); //retrieving user inputs
        $kpi->year = $request->input('year');  //retrieving user inputs
        $kpi->month = $request->input('month'); //retrieving user inputs
        $kpi->value = $request->input('value'); //retrieving user inputs
        $kpi->type = $request->input('type'); //retrieving user inputs
        $kpi->subtype = $request->input('subtype'); //retrieving user inputs

        $kpi->save(); //storing values as an object
        // return $kpi; //returns the stored value if the operation was successful.
        return response()->json($kpi, 201);
    }

    public function uploadJob(KpiRequest $request)
    {
        $file = $request->file('file');

        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file->getClientOriginalName());

        $kpis = json_decode(file_get_contents($destinationPath . "/" . $file->getClientOriginalName()), true);

        ProcessKpi::dispatch($kpis);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Kpi::findorFail($id); //searches for the object in the database using its id and returns it.

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [ // the new values should not be null
            'email' => 'required',
            'year' => 'required',
            'month' => 'required',
            'value' => 'required',
            'type' => 'required',
            'subtype' => 'required',
        ]);

        $kpi = Kpi::findorFail($id); // uses the id to search values that need to be updated.
        $kpi->email = $request->input('email'); //retrieves user input
        $kpi->year = $request->input('year'); ////retrieves user input
        $kpi->month = $request->input('month'); ////retrieves user input
        $kpi->value = $request->input('value'); ////retrieves user input
        $kpi->type = $request->input('type'); ////retrieves user input
        $kpi->subtype = $request->input('subtype'); ////retrieves user input

        $kpi->save(); //saves the values in the database. The existing data is overwritten.
        // return $kpi; // retrieves the updated object from the database
        return response()->json($kpi, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kpi = Kpi::findorFail($id); //searching for object in database using ID
        if ($kpi->delete()) { //deletes the object
            return 'deleted successfully'; //shows a message when the delete operation was successful.
        }
    }


    /**
     * @OA\Post(
     * path="/kpi",
     * summary="Store KPI object",
     * description="Store KPI object by using form",
     * operationId="storeKpi",
     * tags={"kpi"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass kpi values",
     *    @OA\JsonContent(
     *       required={"email","year", "month", "value", "type", "subtype"},
     *       @OA\Property(property="email", type="string", format="email", example="somebody@hiring.ssq.nl"),
     *       @OA\Property(property="year", type="integer", example="2021"),
     *       @OA\Property(property="month", type="integer", example="1"),
     *       @OA\Property(property="value", type="integer", example="20"),
     *       @OA\Property(property="type", type="string", example="individual"),
     *       @OA\Property(property="subtype", type="string", example="hours"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong kpi response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong kpi format. Please try again"),
     *       @OA\Property(property="status", type="boolean", example="true")
     *        )
     *     )
     * )
     */
    public function upload(Request $request)
    {
        $response = new stdClass;
        // $kpiRequest = null;
        $file = $request->file('file');

        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file->getClientOriginalName());

        $kpis = json_decode(file_get_contents($destinationPath . "/" . $file->getClientOriginalName()), true);

        foreach ($kpis as $index => $kpi) {
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
        return response()->json($response, 201);
    }
}
