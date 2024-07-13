<?php

namespace App\Http\Controllers;

use DateTime;
use Rats\Zkteco\Helpers\ZKTecoManager;
use Exception;
use App\Models\Employe;
use App\Models\Attendance;
use App\Models\Presence;
use Illuminate\Auth\Events\Verified;
use Rats\Zkteco\Lib\ZKTeco;
use Rats\Zkteco\Lib\Util;
use Illuminate\Http\Request;

class ZktecoController extends Controller
{
    public function ConnexionMethod()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        try {
            $zk->testVoice();
            $utlisateurs = $zk->getUser();

            dd($utlisateurs);

            if ($zk->restart()) {
                return response()->json(['message' => 'appareil a été redémarré avec succès.']);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur' . $e->getMessage()]);
        } finally {
            $zk->disconnect();
        }
    }

    public function Shutdown()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        $zk->shutdown();
        if ($zk->shutdown()) {
            return back();
        } else {
            return response()->json(['message' => 'l\'appareil n\'est pas  éteint']);
        }
    }

    public function ListeAction()
    {
        return view('action_zkteco');
    }
    public function Restart()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        try {
            $zk->restart();
            return back();
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur' . $e->getMessage()]);
        } finally {
            $zk->disconnect();
        }
    }

    public function Alarm()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        try {
            $zk->testVoice();
            return back();
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur' . $e->getMessage()]);
        } finally {
            $zk->disconnect();
        }
    }

    public function Attendance()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        try {
            $employes = $zk->getUser();
            $attendances = $zk->getAttendance();
            foreach ($attendances as $attendance) {
                if ($attendance['id'] != 0) {
                    $user_name_device = $employes[$attendance['id']]['name'];
                    $user_name_local = Presence::Where('user_name', '=', $user_name_device)->first();
                    if (!$user_name_local) {
                        if ($attendance['type'] == '0') {
                            Presence::create([
                                'check-in' => $attendance['timestamp'],
                                'user_name' => $employes[$attendance['id']]['name'],
                            ]);
                        }
                        if ($attendance['type'] == '2') {
                            Presence::create([
                                'break-in' => $attendance['timestamp'],
                                'user_name' => $employes[$attendance['id']]['name'],
                            ]);
                        }
                        if ($attendance['type'] == '3') {
                            Presence::create([
                                'break-out' => $attendance['timestamp'],
                                'user_name' => $employes[$attendance['id']]['name'],
                            ]);
                        }
                        if ($attendance['type'] == '1') {
                            Presence::create([
                                'check-out' => $attendance['timestamp'],
                                'user_name' => $employes[$attendance['id']]['name'],
                            ]);
                        }
                    } else {
                        if ($attendance['type'] == '0') {
                            $user_name_local->Update([
                                'check-in' => $attendance['timestamp'],
                            ]);
                        }

                        if ($attendance['type'] == '2') {
                            $user_name_local->Update([
                                'break-in' => $attendance['timestamp'],
                            ]);
                        }

                        if ($attendance['type'] == '3') {
                            $user_name_local->Update([
                                'break-out' => $attendance['timestamp'],
                            ]);
                        }

                        if ($attendance['type'] == '1') {
                            $user_name_local->Update([
                                'check-out' => $attendance['timestamp'],
                            ]);
                        }
                    }
                }
            }


            $presences = Presence::all();
            return view('listEmployes', compact('attendances', 'presences', 'employes'));
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur' . $e->getMessage()]);
        }
    }

    public function AddUser(Request $request)
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        $validated = $request->validate([
            'uid' => 'required|numeric|max:65535',
            'userid' => 'required|numeric|max:9',
            'name' => 'required|string|max:24',
           // 'password' => 'required|numeric|max:8',
        ]);
        try {
            $uid = $request->input('uid');
            $userid = $request->input('userid');
            $name = $request->input('name');
            $password = $request->input('password');
            $role = $request->input('role');
            if ($validated) {
                $result = $zk->setUser($uid, $userid, $name, $password,$role);
                if ($result=="") {
                    return response()->json(['success' => true, 'message' => 'Employé ajouté avec succès']);
                } else {
                    return response()->json(['success' => false, 'message' => "Une erreur s'est produite lors de l'ajout" . $result]);
                }
            } else {
                $errors = $request->session()->get('errors');
                foreach ($errors->all() as $error) {
                    echo $error . "\n";
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Erreur lors de l'ajout de l'employé: " . $e->getMessage()]);
        }
    }

    public function Action()
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();

        $employes = $zk->getUser();

        return view('action', compact('employes'));
    }

    public function SupprimerEmploye($employeId)
    {
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        $existingUser = $zk->getUser($employeId);
        if ($existingUser) {
            try {
                $delete = $zk->removeUser($employeId);
                if ($delete) {
                    return response()->json(['message' => 'employé supprimé avec succès']);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Une erreur est survenue']);
            }
        }
    }

    public function ModifierEmploye($id)
    {

    }

    public function SetTime(Request $request)
    {
       
        $zk = new ZKTeco('192.168.10.54');
        $zk->connect();
        $t=$request->input('date_time');
        if (1) {
            return response()->json(['message'=>'Heure definie avec succès']);
        }else {
            return response()->json(['message'=>'Heure non définie']);
        }
        
    }
}
