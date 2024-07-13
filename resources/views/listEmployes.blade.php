@extends('layout.master')
@section('content')
    <div class="m-content offset-md-2 col-10">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet_body">
          
                <div class="d-flex">
                    <a href="#" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air p-4 my-3" data-toggle="modal"
                    data-target="#filiereModal">
                    <span>
                        <i class="la la-plus"></i>
                        <span>Ajouter un employé</span>
                    </span>
                   </a>
                    <form class="p-3 my-2" id="form_set_time">
                        @csrf
                        <input class="input-form" type="datetime-local" name="date_time" value="<?php echo date('Y-m-d H:i:s',strtotime('+1 hour')); ?>">
                     
                    </form>
                    <button type="button" id="set_time" class="btn btn-info p-2 my-4">
                        <span id="SetSpinner" class="spinner-border spinner-border-sm d-none"role="status" aria-hidden="true"></span>
                        set time
                    </button>
                  
                </div>
                @php
                    use Carbon\Carbon;
                    use App\Models\Presence;
                    use App\Models\PresenceParSemaine;

                    echo '<style>
                            table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            th, td {
                                border: 1px solid black;
                                padding: 8px;
                                text-align: left;
                            }
                            th {
                                background-color: #f2f2f2;
                            }
                        </style>';

                    echo '<table>';
                    echo '<tr><th>Nom</th><th>Total Heures/jour:' . Carbon::now()->toDateString() .'</th><th>Total Heures/semaine</th><th>Total Heures/mois</th></tr>';
                    foreach ($presences as $presence) {
                        $heure = '';
                        $min = '';
                        $second = '';
                        $info = '';

                        if ( $presence['break-in'] != null &&
                            $presence['check-in'] != null  &&
                            $presence['check-out'] != null &&
                            $presence['break-out'] != null) 
                            {
                            $carbon1 = new DateTime($presence['check-in']);
                            $carbon2 = new DateTime($presence['break-in']);
                            $carbon3 = new DateTime($presence['break-out']);
                            $carbon4 = new DateTime($presence['check-out']);

                            $diff1 = $carbon1->diff($carbon2);
                            $diff2 = $carbon3->diff($carbon4);
                            $totalSeconds =
                                $diff1->s +
                                $diff1->i * 60 +
                                $diff1->h * 3600 +
                                $diff2->s +
                                $diff2->i * 60 +
                                $diff2->h * 3600;
                            $heure = floor($totalSeconds / 3600);
                            $min = floor(($totalSeconds % 3600) / 60);
                            $second = floor($totalSeconds % 60);
                        } else {
                            $info = 'Présence non complète';
                        }
                        if ($heure || $min || $second) {
                            $t=$heure .':'.$min .':'. $second ;
                            $timeByDay= Presence::Where('user_name','=',$presence['user_name'])->first();
                            $timeByDay->update(['time_by_day'=>$t]);
                            // PresenceParSemaine::create([
                            //  'user_name'=>$presence['user_name'],
                            //  'date_day'=>Carbon::now()->toDateString(),
                            //  'jour'=>'lundi',
                            //  'time_by_day'=>$t
                            // ]);
                            echo '<tr>
                            <td>' . $presence['user_name'] .'</td>
                            <td>' . $heure .  ':' . $min .':' .  $second .'</td>
                            <td>' .'00h' .'</td>
                            <td>' .'00h' .'</td>
                            </tr>';
                        } else {
                            echo '<tr>
                            <td>' .
                                $presence['user_name'] .
                                '</td>
                            <td>' .
                                $info .
                                '</td>
                            <td>' .
                                '00h' .
                                '</td>
                            <td>' .
                                '00h' .
                                '</td>
                            </tr>';
                        }
                    }
                    echo '</table>';

                @endphp
            </div>
        </div>
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Liste des présences faites: {{ count($attendances) }}
                        </h3>
                    </div>

                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <div class="modal fade" id="filiereModal" tabindex="-1" role="dialog"
                                aria-labelledby="filiereModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="filiereModalLabel">Ajouter un employé</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="filiereForm">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="Name">Nom&prénom</label>
                                                    <input type="text" class="form-control" id="Name"
                                                        name="name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="userid">Userid</label>
                                                    <input type="number" class="form-control" id="userid" name="userid"
                                                        value="{{ count($employes) + 1 }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="uid">Uid</label>
                                                    <input type="number" class="form-control" id="uid" name="uid"
                                                        value="{{ count($employes) + 1 }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="role">Rôle</label>
                                                    <input type="number" class="form-control" id="role" name="role"
                                                        value="0">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cardno">Cardno</label>
                                                    <input type="number" class="form-control" id="cardno" name="cardno"
                                                        value="0">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Fermer</button>
                                            <button type="button" id="submitFiliere" class="btn btn-primary"><i
                                                    class="fa fa-plus" aria-hidden="true"></i> Ajouter
                                                <span id="filiereSpinner" class="spinner-border spinner-border-sm d-none"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-portlet__nav-item"></li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                    <thead>
                        <tr>
                            <th>Employé ID</th>
                            <th>NumSerie ID</th>
                            <th>Type_auth</th>
                            <th>Heure</th>
                            <th>Type_présence</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance['id'] }}</td>
                                <td>{{ $attendance['uid'] }}</td>
                                <td>{{ $attendance['state'] }}</td>
                                <td>{{ $attendance['timestamp'] }}</td>
                                <td>{{ $attendance['type'] }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('script_jquey')
    <script>
        $(document).ready(function() {
            $('#submitFiliere').on('click', function() {
                $('#filiereSpinner').removeClass('d-none');
                var formData = $('#filiereForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/ajout-de-employe',
                    data: formData,
                    success: function(response) {
                        $('#filiereSpinner').addClass('d-none');
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 6000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        console.log(response.message);
                        $('#filiereModal').modal('hide');

                    },
                    error: function(error) {
                        console.error('Error:', error);
                        $('#filiereSpinner').addClass('d-none');
                    }
                });
            });

            $('#set_time').on('click', function() {
                $('#SetSpinner').removeClass('d-none');
                var formData = $('#form_set_time').serialize();
                $.ajax({
                    type: 'POST',
                    url: '/set-time',
                    data: formData,
                    success: function(response) {
                       // $('#form_set_time').addClass('d-none');
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
                        $('#SetSpinner').addClass('d-none');
                        console.log(response.message);

                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        })
    </script>
@endsection
