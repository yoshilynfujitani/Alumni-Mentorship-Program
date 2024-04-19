<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

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
        return Field::all();
    }

    public function deleteField(Request $request){
        $field = Field::where('id', $request->fieldId);
        $field->delete();

        return;
    }
}
