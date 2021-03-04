<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            return datatables()->of(Category::latest()->get())
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

        return view('layouts.category.category');
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
        //Validaciones
        /* $rules = array(
            'name'        => 'required|string|max:100',
            'description' => 'required|string|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        } */

        $form_data = array(
            'name'        => $request->name,
            'description' => $request->description
        );

        Category::create($form_data);


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
        // Busqueda de la categoria por id
        if ( request()->ajax() ) {
            $data = Category::findOrFail($id);
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
        //Validaciones
        $rules = array(
            'name'        => 'required|string|max:100',
            'description' => 'required|string|max:255'
        );

        $error = Validator::make( $request->all(), $rules );

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        => $request->name,
            'description' => $request->description
        );

        Category::whereId($request->hidden_id)->update($form_data);


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
        // Eliminando la categori por id
        $data = Category::findOrFail($id);
        $data->delete();
    }
}
