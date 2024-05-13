<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
    //
    public function createField(Request $request){
        $field = New Field();

        $field->fieldName = $request->fieldName;

        $field->save();
        return;
    }

    public function editField(Request $request){
        $field = Field::find($request->fieldId);

        $field->fieldName = $request->fieldName;

        $field->save();
        return;
    }

    public function getFields(){
        $fields = Field::all(['id',  DB::raw('fieldName as name')]);
     

        return $fields;
    }

    public function deleteField(Request $request){
        $field = Field::where('id', $request->fieldId);
        $field->delete();
       $users = User::whereRaw("CONCAT(',', field, ',') LIKE '%,$request->fieldId,%'")->get();


   
        foreach ($users as $user) {
        // Get the current field value
        $currentField = $user->field;

        // Remove the fieldIdToDelete from the field value
        $fieldArray = explode(',', $currentField);
        $fieldArray = array_diff($fieldArray, [$request->fieldId]);
        $updatedField = implode(',', $fieldArray);

     

        // Update the user's field value
        $user->field = $updatedField;
        $user->save();

   
    }
        

        return;
    }
}
