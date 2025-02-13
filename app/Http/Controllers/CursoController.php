<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use App\Models\Estudiante;
use Validator;

class CursoController extends Controller
{
     public function index()
    {
        $cursos = Curso::all();
        return response()->json(CursoResource::collection($cursos),);
    }

    public function list()
    {
        return view('cursos');
    }
    public function show($curso_id)
    {
        $curso = Curso::find($curso_id);

        if( $curso == null )
        {
            return response()->json(['success' => false, 'message' => 'No existe el curso'], 404);
        }

        return response()->json(['success' => true, 'curso' => new CursoResource($curso)]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'nombre' => 'required|string|max:200',
            'horario' => 'required|string|max:200',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        if ($validator->fails()) {
            $messages = implode(" | ", $validator->errors()->all());

            return response()->json(['success' => false, 'message' => $messages], 422);
        }

        $curso = Curso::create($inputs);

        return response()->json(['success' => true, 'curso' => new CursoResource($curso)]);
    }

    public function update(Request $request, $curso_id)
    {
        $curso = Curso::find($curso_id);
        $inputs = $request->all();

        if( $curso == null ) {
            return response()->json(['errors' => "El curso no existe"], 404);
        }

        $validator = Validator::make($inputs, [
            'nombre' => 'sometimes|string|max:200',
            'horario' => 'sometimes|string|max:200',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after:fecha_inicio'
        ]);

        if ($validator->fails()) {
            $messages = implode(" | ", $validator->errors()->all());

            return response()->json(['success' => false, 'message' => $messages], 422);
        }

        $curso->update($inputs);

        return response()->json(['success' => true, 'curso' => new CursoResource($curso)]);
    }

    public function destroy($curso_id)
    {
        $curso = Curso::find($curso_id);

        if( $curso == null ) {
            return response()->json(['success' => false, 'message' => "El curso no existe"], 404);
        }
        
        $curso->delete();
        return response()->json(['success' => true, 'message' => 'Curso eliminado correctamente']);
    }

}
