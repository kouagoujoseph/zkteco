@extends('layout.master')
@section('content')
    <div class="m-content col-10 offset-md-2">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }
        </style>

        <table>
            <thead>
                <tr>
                    <th>IdEmployé</th>
                    <th>Nom</th>
                    <th>Role</th>
                    <th class="col-md-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employes as $employe)
                    {
                    <tr>
                        <td>{{ $employe['userid'] }}</td>
                        <td>{{ $employe['name'] }}</td>
                        <td>{{ $employe['role'] }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="" accept-charset="UTF-8" style="display:inline">
                                        @method('DELETE')
                                        @csrf
                                        <script>
                                            function deleteEmploye(employeId) {
                                                $.ajax({
                                                    type: 'DELETE',
                                                    url: '/supprimer-employe/' + employeId,
                                                    data: {
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    success: function(response) {
        
                                                        const Toast = Swal.mixin({
                                                            toast: true,
                                                            position: 'top-end',
                                                            showConfirmButton: false,
                                                            timer: 6000,
                                                            timerProgressBar: true,
                                                            didOpen: (toast) => {
                                                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                            }
                                                        });

                                                        Toast.fire({
                                                            icon: 'success',
                                                            title: response.message 
                                                        });
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error(xhr.responseText);
                                                    }
                                                });
                                            }
        
                                            function confirmDeleteEmploye(employeId) {
        
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: "You won't be able to revert this!",
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    
                                                        deleteEmploye(employeId);  
                                                    
                                                });
                                            }
                                        </script>
                                        <button type="button" class="btn btn-sm" title="Delete Student"
                                            onclick="confirmDeleteEmploye({{ $employe['uid'] }})">
                                            <i class="flaticon-delete" style="color: red;"></i>
                                        </button>
        
        
        
                                    </form>
                                </div>
                                    <div class="col">
                                        <button class="btn btn"
                                        onclick="setEmployeId('{{ $employe['userid'] }}'), putEmployeName('{{ $employe['name'] }}'),putEmployeRole('{{ $employe['role'] }}')"
                                        data-toggle="modal" data-target="#modifierModal"><i class="flaticon-edit"
                                            style="color: green;"></i>
                                      </button>
                                    </div>
                            </div>
                        </td>
                      
                          {{-- modal pour update --}}
                          <div class="modal fade" id="modifierModal" tabindex="-1" role="dialog"
                          aria-labelledby="modifierModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="modifierModalLabel">Modifier les données de l'employé</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form id="modifierForm">
                                          @csrf
                                          <div class="form-group">
                                              <label for="modifierName">Nom</label>
                                              <input type="text" value="" class="form-control" name="employe_name"
                                                  id="put_employe_name">
                                          </div>
                                          <div class="form-group">
                                            <label for="modifierName">Rôle</label>
                                            <input type="text" value="" class="form-control" name="employe_role"
                                                id="put_employe_role">
                                          </div>
                                          <!-- Add other form fields as needed -->
                                      </form>
                                  </div>
                                  <script>
                                      var filiereId;
                                      var put_employe_name;
                                      var put_employe_role;

                                      function putEmployeName(name) {
                                          put_employe_name = name
                                          $("#put_employe_name").val(put_employe_name);
                                      }

                                      function putEmployeRole(role) {
                                          put_employe_role = role
                                          $("#put_employe_role").val(put_employe_role);
                                      }

                                      function setEmployeId(id) {

                                          employeId = id;
                                      }

                                      function modifierEmploye() {
                                          // Récupérer l'ID de la filière
                                          // var employeId = $('#modifieremployeId').val();
                                          var id = employeId;
                                          $('#modifierSpinner').removeClass('d-none');

                                          var formData = $('#modifierForm').serialize();


                                          // Envoyer la requête Ajax
                                          $.ajax({
                                              type: 'POST',
                                              url: '/modifier-employe/' + id,
                                              data: formData,

                                              success: function(response) {
                                                  // Traitement du succès (par exemple, actualiser la page, fermer le modal, etc.)

                                                  //$('.msg-return').text(response.message);
                                                  const Toast = Swal.mixin({
                                                      toast: true,
                                                      position: 'top-end',
                                                      showConfirmButton: false,
                                                      timer: 6000,
                                                      timerProgressBar: true,
                                                      didOpen: (toast) => {
                                                          toast.addEventListener('mouseenter', Swal.stopTimer)
                                                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                      }
                                                  });

                                                  Toast.fire({
                                                      icon: 'success',
                                                      title: response.message // Assure-toi que la réponse de ton serveur contient un champ "message"
                                                  });
                                                  $('#modifierModal').modal('hide');
                                              },
                                              error: function(xhr, status, error) {
                                                  // Traitement des erreurs (affichage d'un message d'erreur, par exemple)
                                                  console.error(xhr.responseText);
                                              },
                                              complete: function() {
                                                  // Masquer le spinner après la requête
                                                  $('#modifierSpinner').addClass('d-none');
                                              }
                                          });

                                      }
                                  </script>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary"
                                          data-dismiss="modal">Fermer</button>
                                      <button type="submit" id="submitmodifier" class="btn btn-primary"
                                          onclick="modifierEmploye()"><i class="fa fa-plus" aria-hidden="true"></i>
                                          Modifier
                                          <span id="modifierSpinner" class="spinner-border spinner-border-sm d-none"
                                              role="status" aria-hidden="true"></span>
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      {{-- fin modal --}}
                    </tr>
                    }
                @endforeach
            </tbody>

        </table>
    </div>
@endsection
@section('script_jquey')
    <script>
        $(document).ready(function() {
            function deletePromotion(promotionId) {
                $.ajax({
                    type: 'DELETE',
                    url: '/supprimer-promotion/' + promotionId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {
                        // Traitez les erreurs ici
                        console.error(xhr.responseText);
                    }
                });
            }


        });
    </script>
@endsection
