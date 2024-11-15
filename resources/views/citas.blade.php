@extends('layouts/template')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Agendar Cita</h2>

    <!-- Botón Agregar y Buscar -->
    <div class="d-flex justify-content-between mb-3">
        <div class="input-group w-25">
            <input type="text" id="buscar" class="form-control" placeholder="Buscar..." autocomplete="off">
            <button type="button" id="clearInput" class="btn btn-light">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus" aria-hidden="true"></i> Agendar Cita
        </button>
    </div>

    <!-- Tabla de Citas -->
    <table class="table table-striped table-bordered" id="citasTable">
        <thead>
            <tr>
                <th>Nombre Mascota</th>
                <th>Servicio</th>
                <th>Fecha y Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
            <tr>
                <td>{{ $cita->mascota->nombre }}</td>
                <td>{{ $cita->servicio->nombre }}</td>
                <td>{{ $cita->fecha }} - {{ $cita->hora }}</td>
                <td>{{ $cita->estado }}</td>
                <td>
                    <button class="btn btn-primary btn-edit" data-id="{{ $cita->id }}">
                        <i class="fa fa-pencil-alt" aria-hidden="true"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-delete" data-id="{{ $cita->id }}">
                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para Agendar Cita -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agendar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mascota_id" class="form-label">Mascota</label>
                        <select class="form-control" name="mascota_id" required>
                            @foreach ($mascotas as $mascota)
                                <option value="{{ $mascota->id }}">{{ $mascota->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="servicio_id" class="form-label">Servicio</label>
                        <select class="form-control" name="servicio_id" required>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control" name="hora" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" name="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Cita -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editMascotaId" class="form-label">Mascota</label>
                        <select class="form-control" id="editMascotaId" name="mascota_id" required>
                            @foreach ($mascotas as $mascota)
                                <option value="{{ $mascota->id }}">{{ $mascota->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editServicioId" class="form-label">Servicio</label>
                        <select class="form-control" id="editServicioId" name="servicio_id" required>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editFecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editFecha" name="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="editHora" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="editHora" name="hora" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEstado" class="form-label">Estado</label>
                        <select class="form-control" id="editEstado" name="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este servicio?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deleteForm" method="POST" action="" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Manejo de edición de citas
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            fetch(`/citas/${id}/edit`)
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editMascotaId').value = data.mascota_id;
                    document.getElementById('editServicioId').value = data.servicio_id;
                    document.getElementById('editFecha').value = data.fecha;
                    document.getElementById('editHora').value = data.hora;
                    document.getElementById('editEstado').value = data.estado;
                    document.getElementById('formEdit').action = `/citas/${data.id}`;
                    new bootstrap.Modal(document.getElementById('editModal')).show();
                })
                .catch(error => {
                    console.log('Datos de la cita:', data);
                    console.error('Error al editar la cita:', error);
                });
        });
    });

        const inputBuscar = document.getElementById('buscar');
        const clearInputBtn = document.getElementById('clearInput');
        
        inputBuscar.addEventListener('input', function () {
            let query = this.value;
            fetch(`/citas/search?query=${query}`) 
                .then(response => response.json())
                .then(data => {
                    updateTable(data.citas); 
                })
                .catch(error => console.error('Error al buscar:', error));
        });

        clearInputBtn.addEventListener('click', function () {
            inputBuscar.value = ''; 
            inputBuscar.dispatchEvent(new Event('input'));
        });

        function updateTable(citas) {
            const tableBody = document.querySelector('#citasTable tbody'); 
            tableBody.innerHTML = '';
            
            citas.forEach(cita => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${cita.mascota.nombre}</td>
                    <td>${cita.servicio.nombre}</td>
                    <td>${cita.fecha}</td>
                    <td>${cita.hora}</td>
                    <td>${cita.estado}</td>
                    <td>
                        <button class="btn btn-primary btn-edit" data-id="${cita.id}">
                            <i class="fa fa-pencil-alt"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="${cita.id}">
                            <i class="fa fa-trash"></i> Eliminar
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            const editButtons = document.querySelectorAll('.btn-edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    fetch(`/citas/${id}/edit`) 
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('editId').value = data.id;
                            document.getElementById('editMascotaId').value = data.mascota_id;
                            document.getElementById('editServicioId').value = data.servicio_id;
                            document.getElementById('editFecha').value = data.fecha;
                            document.getElementById('editHora').value = data.hora;
                            document.getElementById('editEstado').value = data.estado;
                            document.getElementById('formEdit').action = `/citas/${data.id}`;
                            new bootstrap.Modal(document.getElementById('editModal')).show();
                        });
                });
            });

            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const form = document.getElementById('deleteForm');
                    form.action = `/citas/${id}`; 
                    new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
                });
            });
        }
    });
</script>
</body>
</html>
@endsection
