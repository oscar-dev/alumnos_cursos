<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EstudianteResource;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use App\Models\Estudiante;
use Validator;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return response()->json(EstudianteResource::collection($estudiantes));
    }

    public function list()
    {
        return view('estudiantes');
    }

    public function show($estudiante_id)
    {
        $estudiante = Estudiante::find($estudiante_id);

        if( $estudiante == null )
        {
            return response()->json(['success' => false, 'message' => 'No existe el estudiante'], 404);
        }

        return response()->json(['success' => true, 'estudiante' => new EstudianteResource($estudiante)]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'nombre' => 'required|string|max:200',
            'apellido' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:estudiantes,email',
            'edad' => 'required|integer'
        ]);

        if ($validator->fails()) {

            $messages = implode(" | ", $validator->errors()->all());

            return response()->json([ 'success' => false, 'message' => $messages], 422);
        }

        $estudiante = Estudiante::create($inputs);

        return response()->json(['success' => true, 'estudiante' => new EstudianteResource($estudiante)], 200);
    }

    public function update(Request $request, $estudiante_id)
    {
        $inputs = $request->all();
        $estudiante = Estudiante::find($estudiante_id);

        if( $estudiante == null )
        {
            return response()->json([ 'success' => false, 'message' => 'No existe el estudiante'], 404);
        }

        $validator = Validator::make($inputs, [
            'nombre' => 'sometimes|string|max:200',
            'apellido' => 'sometimes|string|max:200',
            'email' => 'sometimes|email|max:200|unique:estudiantes,email,' . $estudiante->id,
            'edad' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            $messages = implode(" | ", $validator->errors()->all());
            
            return response()->json([ 'success' => false, 'message' => $messages], 422);
        }

        $estudiante->update($inputs);

        return response()->json(['success' => true, 'estudiante' => new EstudianteResource($estudiante)], 200);
    }

    public function destroy($estudiante_id)
    {
        $estudiante = Estudiante::find($estudiante_id);

        if( $estudiante == null )
        {
            return response()->json(['success' => false, 'message' => 'No existe el estudiante'], 404);
        }

        $estudiante->delete();

        return response()->json(['success' => true, 'message' => 'Estudiante eliminado correctamente']);
    }

    public function asignarCurso(Request $request, $estudiante_id)
    {
        $estudiante = Estudiante::find($estudiante_id);

        if( $estudiante == null )
        {
            return response()->json(['success' => false, 'message' => 'No existe el estudiante'], 404);
        }

        $validator = Validator::make($request->all(), [
            'curso_id' => 'required|exists:cursos,id'
        ]);

        if ($validator->fails()) {
            $messages = implode(" | ", $validator->errors()->all());

            return response()->json([ 'success' => false, 'message' => $messages], 422);
        }

        $estudiante->cursos()->attach($request->curso_id);
        return response()->json([ 'success' => true, 'message' => 'Curso asignado correctamente']);
    }

    public function cursos(Request $request, $estudiante_id)
    {
        $estudiante = Estudiante::find($estudiante_id);

        if( $estudiante == null )
        {
            return response()->json(['success' => false, 'errors' => 'No existe el estudiante'], 404);
        }

        $cursos = $estudiante->cursos;

        return response()->json(CursoResource::collection($cursos),);
    }
    
    public function cursosNoAsignados($estudiante_id)
    {
        $cursosAsignados = Estudiante::findOrFail($estudiante_id)->cursos()->pluck('cursos.id');
        
        $cursosNoAsignados = Curso::whereNotIn('id', $cursosAsignados)->get();

        return response()->json(CursoResource::collection($cursosNoAsignados));
    }
}
