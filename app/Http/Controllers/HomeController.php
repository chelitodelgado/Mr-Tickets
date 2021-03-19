<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $topTickets = DB::table('ticket')
            ->join('category', 'ticket.category_id', '=', 'category.id')
            ->join('status',   'ticket.status_id',   '=', 'status.id')
            ->join('project',  'ticket.project_id',  '=', 'project.id')
            ->select('ticket.*', 'status.name as status', 'project.name as project')
            ->get();

        $tickets  = DB::table('ticket')->count();
        $category = DB::table('category')->count();
        $project  = DB::table('project')->count();

        return view('home',[
            'tickets'    => $tickets,
            'category'   => $category,
            'project'    => $project,
            'topTickets' => $topTickets
        ]);
    }
}
