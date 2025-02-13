@extends("layout")

@section('content')
<!-- Modal -->
<div class="modal fade" id="formEstudiantes" tabindex="-1" aria-labelledby="formEstudiantesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <input type='hidden' name='estudiante_id' id='estudiante_id' value='-1'>
      <div class="modal-header">
        <h5 class="modal-title" id="formEstudiantesLabel">Estudiante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre">
        </div>
        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido">
        </div>

        <div class="mb-3">
          <label for="edad" class="form-label">Edad</label>
          <input type="number" class="form-control" id="edad">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-Mail</label>
          <input type="email" class="form-control" id="email">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGrabarEstudiante">Grabar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <input type='hidden' name='d_estudiante_id' id='d_estudiante_id' value='-1'>

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

<!-- Modal -->
<div class="modal fade" id="asignarModal" tabindex="-1" aria-labelledby="asignarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <input type='hidden' name='a_estudiante_id' id='a_estudiante_id' value='-1'>

        <h5 class="modal-title" id="asignarModalLabel">Asignar curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
          <label for="nombre" class="form-label">Asignar Curso</label>
          <select id='cursos-no-asignados' class="form-control" name='cursos-no-asignados'></select>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnGrabarAsignacion" id="btnDeleteConfirm">Grabar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="listarModal" tabindex="-1" aria-labelledby="listarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="listarModalLabel">Cursos asignados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
      <table class="table">
                      <thead>
                        <tr>
                          <th style="width: 30px">#</th>
                          <th>Curso</th>
                        </tr>
                      </thead>
                      <tbody id='tbody-listar'>
                      </tbody>
                    </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
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
              <div class="col-sm-6"><h3 class="mb-0">Estudiantes</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
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
                  <div class="row" id="message">
                  </div>

                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>E-Mail</th>
                          <th>Edad</th>
                          <th>Cursos</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody id="estudiantes-body">
                        
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
  const formEstudiantes = new bootstrap.Modal(document.getElementById('formEstudiantes'));
  const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
  const asignarModal = new bootstrap.Modal(document.getElementById('asignarModal'));
  const listarModal = new bootstrap.Modal(document.getElementById('listarModal'));

  document.getElementById("btnGrabarAsignacion").addEventListener("click", function () {
    const estudiante_id  = document.getElementById("a_estudiante_id").value;
    const curso_id  = document.getElementById("cursos-no-asignados").value;

    fetch( "/api/estudiantes/" + estudiante_id + "/asignar-curso/", {
          method: "POST",
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify({ curso_id })
      })
      .then(response => response.json())
      .then(data => {
          alert("curso asignado exitosamente");

          asignarModal.hide()

          leerDatos();
      })
      .catch(error => console.error("Error al asignar curso:", error));

  })
  
document.getElementById("btnGrabarEstudiante").addEventListener("click", function () {
  const estudiante_id  = document.getElementById("estudiante_id").value;
  let url
  let method

  if( estudiante_id == -1 ) {
    method = "POST"
    url = "/api/estudiantes"
  } else {
    method = "PUT"
    url = "/api/estudiantes/" + estudiante_id
  }

  const nombre = document.getElementById("nombre").value;
  const apellido = document.getElementById("apellido").value;
  const edad = document.getElementById("edad").value;
  const email = document.getElementById("email").value;

      fetch( url, {
          method: method,
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify({ nombre, apellido, edad, email })
      })
      .then(response => response.json())
      .then(data => {

          if( data.success ) {
            formEstudiantes.hide()

            leerDatos();
          } else {
            alert(data.message)
          }
      })
      .catch(error => console.error("Error al crear el estudiante:", error));
});

document.getElementById("btnDeleteConfirm").addEventListener("click", function () {

  const estudiante_id = document.getElementById("d_estudiante_id").value;

  fetch("/api/estudiantes/" + estudiante_id, {
            method: "DELETE"
        })
        .then(response => response.json())
        .then(data => {
            confirmModal.hide()
            leerDatos();
        })
        .catch(error => console.error("Error al borrar el estudiante:", error));

});

function nuevoElemento() 
{
  document.getElementById("estudiante_id").value = -1
  document.getElementById("nombre").value = "";
  document.getElementById("apellido").value = "";
  document.getElementById("edad").value = "";
  document.getElementById("email").value = "";

  formEstudiantes.show();
}

function editarElemento(id) 
{

  fetch("/api/estudiantes/" + id, {
            method: "GET"
        })
        .then(response => response.json())
        .then(data => {
          if( data.success ) {
            document.getElementById("estudiante_id").value = data.estudiante.id;
            document.getElementById("nombre").value = data.estudiante.nombre;
            document.getElementById("apellido").value = data.estudiante.apellido;
            document.getElementById("edad").value = data.estudiante.edad;
            document.getElementById("email").value = data.estudiante.email;

            formEstudiantes.show();

          } else {
            alert(data.message)
          }
        })
        .catch(error => alert("Error consultando datos del estudiante:", error));
}

function borrarElemento(id) 
{
  document.getElementById("d_estudiante_id").value = id;

  confirmModal.show();
}

function asignarElemento(id) 
{

  fetch('/api/estudiantes/' + id + '/cursos-no-asignados')
        .then(response => response.json())
        .then(data => {
            const selectCursos = document.getElementById("cursos-no-asignados");
            selectCursos.innerHTML = ""; // Limpiar opciones previas

            // Agregar cursos como opciones
            data.forEach(curso => {
                const option = document.createElement("option");
                option.value = curso.id;
                option.textContent = curso.nombre;
                selectCursos.appendChild(option);
            });
        })
        .catch(error => console.error("Error al obtener cursos no asignados:", error));

  document.getElementById("a_estudiante_id").value = id;

  asignarModal.show();
}

function listarElemento(id) 
{
  fetch("/api/estudiantes/" + id + "/cursos/") // Reemplaza con la URL correcta de tu API
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("tbody-listar");
            tableBody.innerHTML = ""; // Limpiar contenido previo

            data.forEach(curso => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${curso.id}</td>
                    <td>${curso.nombre}</td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error al obtener estudiantes:", error));

  listarModal.show();
}

function leerDatos()
{
  fetch("/api/estudiantes") // Reemplaza con la URL correcta de tu API
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById("estudiantes-body");
            tableBody.innerHTML = ""; // Limpiar contenido previo

            data.forEach(estudiante => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${estudiante.nombre}</td>
                    <td>${estudiante.apellido}</td>
                    <td>${estudiante.email}</td>
                    <td>${estudiante.edad}</td>
                    <td>${estudiante.cursos}</td>
                    <td>
                    <button type="button" onClick='editarElemento(${estudiante.id})' class="btn btn-success btn-sm">Editar</button>
                    <button type="button" onClick='borrarElemento(${estudiante.id})' class="btn btn-danger btn-sm">Borrar</button>
                    <button type="button" onClick='asignarElemento(${estudiante.id})' class="btn btn-secondary btn-sm">Asignar Curso</button>
                    <button type="button" onClick='listarElemento(${estudiante.id})' class="btn btn-warning btn-sm">Listar Cursos</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error al obtener estudiantes:", error));
}

document.addEventListener("DOMContentLoaded", function () {
  leerDatos();
});

</script>
@stop