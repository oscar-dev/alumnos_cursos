@extends("layout")

@section('content')
<!-- Modal -->
<div class="modal fade" id="formCursos" tabindex="-1" aria-labelledby="formCursosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <input type='hidden' name='curso_id' id='curso_id' value='-1'>
      <div class="modal-header">
        <h5 class="modal-title" id="formCursosLabel">Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre">
        </div>
        <div class="mb-3">
          <label for="horario" class="form-label">Horario</label>
          <input type="text" class="form-control" id="horario">
        </div>

        <div class="mb-3">
          <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
          <input type="date" class="form-control" id="fecha_inicio">
        </div>

        <div class="mb-3">
          <label for="fecha_fin" class="form-label">Fecha Final</label>
          <input type="date" class="form-control" id="fecha_fin">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGrabarCurso">Grabar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <input type='hidden' name='d_curso_id' id='d_curso_id' value='-1'>
        <h5 class="modal-title" id="exampleModalLabel">Confirmacion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Esta seguro que desea eliminar al registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btnDeleteConfirm">Si</button>
      </div>
    </div>
  </div>
</div>



        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Cursos</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item active" aria-current="page">Cursos</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->


            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Listado</h3></div>
                  <!-- /.card-header -->
                  <div class="card-header">
                    <button type="button" onClick="nuevoElemento()" class="btn btn-primary mb-2">Agregar Registro</button>
                    </div>
                  <div class="card-body">


                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Horario</th>
                          <th>Fecha Inicio</th>
                          <th>Fecha Final</th>
                          <th>Estudiantes</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody id="cursos-body">
 
                      </tbody>
                    </table>

                  </div>
                  <!-- /.card-body -->

                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>

          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
@stop

@section('script')
<script>
  const formCursos = new bootstrap.Modal(document.getElementById('formCursos'));
  const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

document.getElementById("btnGrabarCurso").addEventListener("click", function () {
  const curso_id  = document.getElementById("curso_id").value;
  let url
  let method

  if( curso_id == -1 ) {
    method = "POST"
    url = "/api/cursos"
  } else {
    method = "PUT"
    url = "/api/cursos/" + curso_id
  }

  const nombre = document.getElementById("nombre").value;
  const horario = document.getElementById("horario").value;
  const fecha_inicio = document.getElementById("fecha_inicio").value;
  const fecha_fin = document.getElementById("fecha_fin").value;

      fetch( url, {
          method: method,
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify({ nombre, horario, fecha_inicio, fecha_fin })
      })
      .then(response => response.json())
      .then(data => {
        if( data.success ) 
        {
          formCursos.hide()

          leerDatos();
        } else {
          alert(data.message)
        }

      })
      .catch(error => console.error("Error al crear el curso:", error));
});

document.getElementById("btnDeleteConfirm").addEventListener("click", function () {

  const curso_id = document.getElementById("d_curso_id").value 

  fetch("/api/cursos/" + curso_id, {
            method: "DELETE"
        })
        .then(response => response.json())
        .then(data => {

          if(data.success) {
            confirmModal.hide()

            leerDatos();
          } else {
            alert(data.message)
          }
        })
        .catch(error => console.error("Error al borrar el curso:", error));

});

function nuevoElemento() 
{
  document.getElementById("curso_id").value = -1

  document.getElementById("nombre").value = '';
  document.getElementById("horario").value = '';
  document.getElementById("fecha_inicio").value = '';
  document.getElementById("fecha_fin").value = '';
  formCursos.show();
}

function editarElemento(id) 
{

  fetch("/api/cursos/" + id, {
            method: "GET"
        })
        .then(response => response.json())
        .then(data => {
          let partes = data.curso.fecha_inicio.split("/");
          const fecha_inicio = partes[2] + '-' + partes[1] + '-' + partes[0];
         partes = data.curso.fecha_fin.split("/");
         const fecha_fin = partes[2] + '-' + partes[1] + '-' + partes[0];

          console.log(fecha_inicio)
          if( data.success ) {
            document.getElementById("curso_id").value = data.curso.id;
            document.getElementById("nombre").value = data.curso.nombre;
            document.getElementById("horario").value = data.curso.horario;
            document.getElementById("fecha_inicio").value = fecha_inicio;
            document.getElementById("fecha_fin").value = fecha_fin;
          } else {
            alert(data.message)
          }

        })
        .catch(error => console.error("Error consultando datos del curso:", error));

    formCursos.show();
}

function borrarElemento(id) 
{
  document.getElementById("d_curso_id").value = id

  confirmModal.show();
}

function leerDatos()
{
  fetch("/api/cursos")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("cursos-body");
            tableBody.innerHTML = ""; // Limpiar contenido previo

            data.forEach(cursos => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${cursos.nombre}</td>
                    <td>${cursos.horario}</td>
                    <td>${cursos.fecha_inicio}</td>
                    <td>${cursos.fecha_fin}</td>
                    <td>${cursos.estudiantes}</td>
                    <td>
                    <button type="button" onClick='editarElemento(${cursos.id})' class="btn btn-success btn-sm">Editar</button>
                    <button type="button" onClick='borrarElemento(${cursos.id})' class="btn btn-danger btn-sm">Borrar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error al obtener cursos:", error));
}

document.addEventListener("DOMContentLoaded", function () {
  leerDatos();
});

</script>
@stop