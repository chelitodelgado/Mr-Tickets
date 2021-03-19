<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $status = DB::table('status')->select('id', 'name')->get();
        /*
            Status:
                1 = Pendiente
                2 = En desarrollo
                3 = Terminado
                4 = Cancelado
        */
        $pendientes = DB::table('ticket')
                ->where('user_id', '=', Auth::user()->id)
                ->where('status_id', '=', 1)
                ->get();
        $enDesarrollo = DB::table('ticket')
                ->where('user_id', '=', Auth::user()->id)
                ->where('status_id', '=', 2)
                ->get();
        $terminado = DB::table('ticket')
                ->where('user_id', '=', Auth::user()->id)
                ->where('status_id', '=', 3)
                ->get();
        $cancelado = DB::table('ticket')
                ->where('user_id', '=', Auth::user()->id)
                ->where('status_id', '=', 4)
                ->get();


        return view('layouts.report.reportes',[
            'pendientes'   => $pendientes,
            'enDesarrollo' => $enDesarrollo,
            'terminado'    => $terminado,
            'cancelado'    => $cancelado,
            'status'       => $status
        ]);
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

        $date = date('Y-m-d');
        $data = DB::table('ticket')
            ->join('category', 'ticket.category_id', '=', 'category.id')
            ->join('priority', 'ticket.priority_id', '=', 'priority.id')
            ->join('status',    'ticket.status_id',  '=', 'status.id')
            ->join('kind',      'ticket.kind_id',    '=', 'kind.id')
            ->join('users',     'ticket.user_id',    '=', 'users.id')
            ->join('project',   'ticket.project_id', '=', 'project.id')
            ->select('ticket.*', 'category.name as category', 'priority.name as priority',
                     'status.name as status', 'kind.name as kind',
                     'users.name as nombre', 'project.name as project')
                     ->get()->where('id', '=', $id);

        /* return view('layouts.report.pdf', [
            'data' => $data,
            'date' => $date
        ]); */

        $pdf = PDF::loadView('layouts.report.pdf', [
            'data' => $data,
            'date' => $date,
        ]);

        $pdf->setPaper('A4', 'portrait');
        // $pdf->render();

        return $pdf->stream();
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
}
