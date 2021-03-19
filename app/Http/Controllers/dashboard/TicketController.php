<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tickets = DB::table('ticket')
            ->join('category', 'ticket.category_id', '=', 'category.id')
            ->join('priority', 'ticket.priority_id', '=', 'priority.id')
            ->join('status',    'ticket.status_id',  '=', 'status.id')
            ->join('kind',      'ticket.kind_id',    '=', 'kind.id')
            ->join('users',     'ticket.user_id',    '=', 'users.id')
            ->join('project',   'ticket.project_id', '=', 'project.id')
            ->select('ticket.*', 'category.name as category', 'priority.name as priority',
                     'status.name as status', 'kind.name as kind',
                     'users.name as nombre', 'project.name as project')
            ->get();

        $kind     = DB::table('kind')->select('id','name')->get();
        $category = DB::table('category')->select('id','name')->get();
        $priority = DB::table('priority')->select('id','name')->get();
        $project  = DB::table('project')->select('id','name')->get();
        $status   = DB::table('status')->select('id','name')->get();
        $users    = DB::table('users')->select('id','name')->get();

        if (request()->ajax()) {

            return datatables()->of($tickets)
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
            "kind"     => $kind,
            "category" => $category,
            "priority" => $priority,
            "project"  => $project,
            "status"   => $status,
            "users"    => $users
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

        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required|max:255',
            'kind_id'     => 'required|min:1',
            'user_id'     => 'required|min:1',
            'project_id'  => 'required|min:1',
            'category_id' => 'required|min:1',
            'priority_id' => 'required|min:1',
            'status_id'   => 'required|min:1',
        ]);

        $form_data = array(
            'title'       => $request->title,
            'description' => $request->description,
            'code'        => TicketController::randomCode(8),
            'kind_id'     => $request->kind_id,
            'user_id'     => $request->user_id,
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
            'user_id'     => $request->user_id,
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

    public static function randomCode($long) {

        $abcMayus = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz";
        $code = "";

        for ($i=0; $i < $long; $i++) {
          $indice = rand(0, (strlen($abcMayus)-1));
          $code = $code.$abcMayus[$indice];
        }

        return $code;

    }

}
