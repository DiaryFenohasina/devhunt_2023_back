<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class resolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resolution (Request $request){
        $validator = validator::make($request->all(),[
            'premier' => 'number|required',
            'seconde' => 'number|required',
            'troisieme' => 'number|required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $premier = $request->premier;
        $second = $request->seconde;
        $troisieme = $request->troisieme;

        $delta = ($second*$second) - 4*($premier * $troisieme);
        if($delta > 0){
            $x = ((-$second) - (sqrt($delta))) / (2* $premier);
            $y = ((-$second) - (sqrt($delta))) / (2* $premier);

            return response()->json([
                'msg' => 'les resultats sont',
                'x' => $x,
                'y' => $y
            ]);
        }
        if($delta = 0){
            $x = (- ($second)) / (2*$premier);

            return response()->json([
                'msg' => 'tokana ny valiny',
                'x' => $x,
            ]);
        }
        if($delta < 0){
            return response()->json([
                'msg' => 'pas de solution',
            ]);
        }
    }
}
