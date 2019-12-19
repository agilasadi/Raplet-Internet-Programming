<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use raplet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use raplet\Keepertrans;
use raplet\Lang;
use Illuminate\Support\Facades\Storage;

class KeeperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

   public function createAKT(Request $request){

        $extraMessage = "";
        $validator = Validator::make($request->all(), [
            'messageContent' => 'required',
            'message_lang' => 'required',
            'keeper_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $keeperCheck=Keepertrans::where("keeper_id", $request["keeper_id"])->where("lang_id",$request["message_lang"])->first();
        if($keeperCheck!=null){
            $success = "0";
            $message = "This keeper already exist.";
            return response()->json(['message' => $message, 'success' => $success]);
        }

        $keeperTranslateion = new Keepertrans();
        $keeperTranslateion->content = $request['messageContent'];
        $keeperTranslateion->lang_id = $request['message_lang'];
        $keeperTranslateion->keeper_id = $request['keeper_id'];
        $keeperTranslateion->link_text = $request['linkText'];
        $keeperTranslateion->link_url = $request['linkUrl'];


        if($request['coverName'] == "1"){

            // Get filename with the extension
            $filenameWithExt = $request->file('messageImg')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('messageImg')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('messageImg')->move('storage/keepers', $fileNameToStore);

            $keeperTranslateion->image = $fileNameToStore;
            $extraMessage = ". And we have a new Cover!";
        }
        else{
            $keeperTranslateion->image = $request['coverName'];
        }

        $keeperTranslateion->save();

        $success = "1";
        $message = "Translation has been Created".$extraMessage;
        return response()->json(['message' => $message, 'success' => $success]);
    }

    public function updateAKT(Request $request){

        $extraMessage = "";
        $validator = Validator::make($request->all(), [
            'messageContent' => 'required',
            'trans_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $keeperTranslateion = Keepertrans::where('id', $request['trans_id'])->first();

        $keeperTranslateion->content = $request['messageContent'];
        $keeperTranslateion->link_text = $request['linkText'];
        $keeperTranslateion->link_url = $request['linkUrl'];


        if($request['coverName'] == "1"){

            // Get filename with the extension
            $filenameWithExt = $request->file('messageImg')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('messageImg')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('messageImg')->move('storage/keepers', $fileNameToStore);

            $keeperTranslateion->image = $fileNameToStore;
            $extraMessage = ". And we have a new Cover!";
        }
        else{
            $keeperTranslateion->image = $request['coverName'];
        }

        $keeperTranslateion->update();

        $success = "1";
        $message = "Updated".$extraMessage;
        return response()->json(['message' => $message, 'success' => $success]);
    }
}
