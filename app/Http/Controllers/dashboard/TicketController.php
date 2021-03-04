<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kind     = DB::table('kind')->select('id','name')->get();
        $category = DB::table('category')->select('id','name')->get();
        $priority = DB::table('priority')->select('id','name')->get();
        $project  = DB::table('project')->select('id','name')->get();
        $status   = DB::table('status')->select('id','name')->get();

        if (request()->ajax()) {

            return datatables()->of(Ticket::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer; color: green;" name="edit" id="' . $data->id . '"
                    class="edit"><i class="fa fa-edit"></i></a> ';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer; color: red;" name="delete" id="' . $data->id . '"
                    class="delete"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('layouts.ticket.tickets',[
            "kind"    => $kind,
            "category" => $category,
            "priority" => $priority,
            "project"  => $project,
            "status"   => $status
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
        $form_data = array(
            'title'        => $request->title,
            'description' => $request->description,
            'kind_id'     => $request->kind_id,
            'user_id'     => 1, //TODO: Asignar el usuario que creo el ticket
            'project_id'  => $request->project_id,
            'category_id' => $request->category_id,
            'priority_id' => $request->priority_id,
            'status_id'   => $request->status_id,
        );

        Ticket::create($form_data);


        return response()->json(['success' => 'OK']);
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
        if ( request()->ajax() ) {
            $data = Ticket::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $form_data = array(
            'title'       => $request->title,
            'description' => $request->description,
            'kind_id'     => $request->kind_id,
            'user_id'     => 1, //TODO: Asignar el usuario que creo el ticket
            'project_id'  => $request->project_id,
            'category_id' => $request->category_id,
            'priority_id' => $request->priority_id,
            'status_id'   => $request->status_id,
        );

        Ticket::whereId($request->hidden_id)->update($form_data);


        return response()->json(['success' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Ticket::findOrFail($id);
        $data->delete();
    }
}
