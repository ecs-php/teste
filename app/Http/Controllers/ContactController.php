<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Models as Model;

class ContactController extends Controller {

    public function select($id) {
        try {
            if (isset($id)) {
                $contato = Model\Contacts::where('id_contact', array($id))->get()->toArray();
                if (count($contato) == 0) {
                    abort('404');
                } else {
                    return response()->json($contato);
                }
            } else {
                abort('404');
            }
        } catch (Exception $e) {
            abort('404');
        }
    }

    public function insert(Request $request) {
        try {
            $data = $request->all();
            if (isset($data['name'])) {
                $insertContact = New Model\Contacts();
                $insertContact->name = $data['name'];
                $insertContact->phone = $data['phone'];
                $insertContact->email = $data['email'];
                $insertContact->description = $data['description'];
                
                $statusContact = $insertContact->save();
                
                if ($statusContact) {
                    $json['id'] = DB::getPdo()->lastInsertId();
                    return response()->json($json, 201);
                } else {
                    abort('404');
                }
            } else {
                abort('404');
            }
        } catch (Exception $e) {
            abort('404');
        }
    }
    
    public function update(Request $request, $id) {
        try {
            $data = $request->all();
            
            if (isset($id) && is_numeric($id) && $id > 0) {
                $updateContact = New Model\Contacts();
                if (isset($data['name'])) {
                    $updateFields['name'] = $data['name'];
                }
                if (isset($data['phone'])) {
                    $updateFields['phone'] = $data['phone'];
                }
                if (isset($data['email'])) {
                    $updateFields['email'] = $data['email'];
                }
                if (isset($data['description'])) {
                    $updateFields['description'] = $data['description'];
                }
                
                $updateContact->id_contact = $id;
                $statusContact = $updateContact->where('id_contact', $id)->update($updateFields);

                if ($statusContact) {
                    $json['id'] = $id;
                    return response()->json($json, 201);
                } else {
                    abort('404');
                }
            } else {
                abort('404');
            }
        } catch (Exception $e) {
            abort('404');
        }
    }
    
    public function delete($id) {
        try {
            if (isset($id)) {
                $validateContact = Model\Contacts::where('id_contact', array($id))->get()->toArray();
                if (count($validateContact) == 0) {
                    abort('404');
                } else {
                    $idContact = $validateContact[0]['id_contact'];
                    $deleteContact = New Model\Contacts();
                    $deleteContact->id_contact = $idContact;

                    $statusContact = $deleteContact->destroy($idContact);

                    if ($statusContact) {
                        $json['id'] = $id;
                        return response()->json($json, 200);
                    } else {
                        abort('404');
                    }
                }
            } else {
                abort('404');
            }
        } catch (Exception $e) {
            abort('404');
        }
    }

}
