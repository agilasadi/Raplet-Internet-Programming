<?php

namespace raplet\Http\Controllers;

use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use function GuzzleHttp\describe_type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use raplet\Define;
use raplet\Keeper;
use raplet\Lang;
use raplet\Multilingual;
use raplet\Post;
use raplet\Rank;
use raplet\Rapletrules;
use raplet\User;
use raplet\Userprofile;
use raplet\Badge;



class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function submitNewRole(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'replimit' => 'required',
            'define' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        ///-------------------------------- validasyon basarili olunca ben --------------------------------///
        $postslug = new Slugify();
        $slug = $postslug->slugify($request['name']);

        //
        if (count(Multilingual::where('transname', $request['name'])->where('short_name', 'en')->where( 'content_id', 'LIKE', '5-%')->get())>0){
            $message = trans('home.spam');
            $success = '0';
            return response()->json(['message' => $message, 'success' => $success]);
        }

        else{



            $lang = Lang::where('short_name', 'en')->first();


            //-------------------------------------- Rutbe olusturuluyor ------------------------------------//
            $rank = new Rank();
            $rank->name = $slug;
            $rank->slug = $slug;
            $rank->replimit = $request['replimit'];
            $rank->define_id =  '0';

            $rank->save();

            //------------------------- once isimi lingualwords tablosuna ekleyelim -------------------------//
            $lingual = new Multilingual();

            $lingual->content_id = '5-'.$rank->id;
            $lingual->short_name = 'en';
            $lingual->transname = $request['name'];

            $lingual->save();



            //------------------------------------ Aciklama olusturuluyor -----------------------------------//
            $defineSlug = new Slugify();
            $defslugresult = $defineSlug->slugify($request['define']);

            $define = new Define();

            $define->name = $request['define'];
            $define->slug = $defslugresult;
            $define->content_id = '5-'.$rank->id;
            $define->lang_id = $lang->id;      ///define type 0 Rank icin kullanilacak

            $define->save();






            $message = trans('home.success');
            $success = '1';
            return response()->json(['message' => $message, 'success' => $success]);
        }


    }

    public function makeItAdmin(Request $request){
            $userprofile = Userprofile::where('user_id', $request['content_id'])->first();

            $adminerole = Rank::where('name', 'admin')->first();

            $userprofile->role_id = $adminerole->id;
            $userprofile->update();


	    $notify_data = [
		    'content_id' => $request['content_id'],
		    'effected_user_id' => $request['content_id'],
		    'content_type' => '0',
		    'url' => route('profile', $userprofile->slug),
		    'notification_name' => 'youBecameAdmin'
	    ];

	    $this->notifier($notify_data);

    }

    public function index()
    {
        $posts = Post::all();
        $langs = Lang::all();
        $ranks = Rank::all();
        $users = User::orderBy('id', 'desc')->paginate('150');
        return view('admin.admin', ['langs' => $langs, 'posts' => $posts, 'ranks' => $ranks, 'users' => $users]);
    }

    public function badgeCreator(){
        $badges = Badge::all();
        $ranks = Rank::all();

        return view('admin.badge', ['badges' => $badges, 'ranks' => $ranks]);
    }
    public function createBadge(Request $request){
        $badgecheck = Badge::where('class', $request['badge_classes'])->first();
        if (count($badgecheck) > 0){
           $message = trans('home.badgeexcists');
           $success = '0';

           return response()->json(['success' => $success, 'message' => $message]);
        }

        else{    //content_type: 0->user; 1->post; 2->comment; 3->userban; 4->badge ...
            $badgeslug = new Slugify();
            $slug = $badgeslug->slugify($request['badge_name']);


            $badge = new Badge();
            $badge->name = $request['badge_name'];
            $badge->slug = $slug;
            $badge->badge_type = $request['badge_type'];
            $badge->class = $request['badge_classes'];
            $badge->badge_style = $request['badge_style'];
            $badge->badge_reqs = $request['badge_reqs'];
            $badge->badge_ruler = $request['badge_ruler'];
            $badge->badge_buff = $request['badge_buff'];
            $badge->badge_image= $request['badge_image'];
            $badge->save();

            $multilingual = new Multilingual();
            $multilingual->content_id = '4-'.$badge->id;
            $multilingual->short_name = 'en';
            $multilingual->transname = $request['badge_name'];
            $multilingual->save();

            $message = trans('home.success');
            $success = '1';

            return response()->json(['success' => $success, 'message' => $message]);
        }
    }

    public function badgelist(){
        $badges = Badge::orderBy('badge_reqs', 'desc')->get();

        return view('admin.badgelist', ['badges' => $badges]);
    }

    public function badgetranslations(){
        $badges = Badge::orderByDesc('id')->get();
        $linguals = Multilingual::where('content_id', 'like', '4-%')->get();
        $registeredLangs = Lang::orderByDesc('id')->get();
        return view('admin.badgetranslations', ['badges' => $badges, 'linguals' => $linguals, 'registeredLangs' => $registeredLangs]);
    }

    /// creating translation meanings of badge names
    public function createBadgeTranslation(Request $request){
        $lingualCheck = Multilingual::where('content_id', "4-".$request['content_id'])->where('short_name', $request['short_name'])->first();

        if (count($lingualCheck) > 0) {
            $lingualCheck->content_id = "4-".$request['content_id'];
            $lingualCheck->short_name = $request['short_name'];
            $lingualCheck->transname = $request['currentContent'];

            $lingualCheck->update();

            $message = trans('home.success');
            $success = '1';
            return response()->json(['success' => $success, 'message' => $message]);
        }
        else{
            $lingual = new Multilingual();
            $lingual->content_id = "4-".$request['content_id'];
            $lingual->short_name = $request['short_name'];
            $lingual->transname = $request['currentContent'];

            $lingual->save();

            $message = trans('home.success');
            $success = '1';
            return response()->json(['success' => $success, 'message' => $message]);
        }
    }

    public function termstranslations($id = null)
    {
        if($id == null){
            $selectedLang = Lang::where('short_name', 'en')->first();
        }
        else{
            $selectedLang = Lang::where('id', $id)->first();
        }
        $registeredLangs = Lang::orderByDesc('id')->get();
        $ruleContent = Rapletrules::where('lang_id', $selectedLang->id)->first();
        if ($ruleContent === null){
            $ruleTranslated = 0;
        }
        else{
            $ruleTranslated = $ruleContent->content;
        }


        return view('admin.termstranslations', ['registeredLangs' => $registeredLangs, 'selectedLang' => $selectedLang, 'ruleTranslated' => $ruleTranslated]);
    }

    public function termstranslate(Request $request){
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:50',
            'lang_id' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $theRulePage = Rapletrules::where('lang_id', $request['lang_id'])->first();
        if ($theRulePage == null){
            $newRulePage = new Rapletrules();
            $newRulePage->content = $request['content'];
            $newRulePage->lang_id = $request['lang_id'];

            $newRulePage->save();

            $message = trans('home.success');
            $success = '1';

            return response()->json(['success' => $success, 'message' => $message]);
        }
        else{
            $theRulePage->content = $request['content'];

            $theRulePage->update();

            $message = trans('home.success');
            $success = '2';

            return response()->json(['success' => $success, 'message' => $message]);
        }

    }

    public function keeperCreatePage(){
        $langs = Lang::orderBy('name', 'desc')->get();
        $today = Carbon::tomorrow()->format('Y-m-d');
        $ranks = Rank::orderBy('id', 'desc')->get();

        return view('admin.keeperCreatePage', ['langs' => $langs, 'today' => $today, 'ranks' => $ranks]);
    }

    public function keeperEditPage($langname = null){
        $ranks = Rank::orderBy('id', 'desc')->get();
        $allKeepers = Keeper::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        $langs = Lang::orderBy('name', 'desc')->get();

        if($langname == null){
            return view('admin.keeperEditPage', ['langs' => $langs, 'allKeepers' => $allKeepers, "ranks" => $ranks]);
        }
        else{ // return translations for selected files
            $multilingual = "1";

            $selectedlang = Lang::where('id', $langname)->first();


            if ($selectedlang === null){
                $message = "There is no such language in database";
                Session::flash('message', $message);
            }


            return view('admin.keeperTranslatePage', ['langs' => $langs, 'allKeepers' => $allKeepers, 'multilingual' => $multilingual, "selectedlang" => $selectedlang, "ranks" => $ranks]);
        }
    }

    public function createNewKeeper(Request $request){


        $newKeeper = new Keeper();

        if($request->hasFile('messageImg')){
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

            $newKeeper->image = $fileNameToStore;
        }
        else{
            $newKeeper->image = "0";

        }


        $newKeeper->content = $request['messageContent'];
        $newKeeper->link_text = $request['linkText'];
        $newKeeper->link_url = $request['linkUrl'];
        $newKeeper->type = $request['messageType'];
        $newKeeper->status = $request['messageStatus'];
        $newKeeper->lang_short = $request['message_lang'];
        $newKeeper->user_type = $request['user_type'];
        $newKeeper->expire = $request['messageExpireDate'];

        if ($newKeeper->save()){
                $message = trans('home.success');
                $success = '1';

                return response()->json(['message' => $message, 'success' => $success]);
        }
        else{
                $message = trans('home.failiur');
                $success = '0';

                return response()->json(['message' => $message, 'success' => $success]);
        }


    }

    public function editTheKeeper(Request $request){
        $theKeeper = Keeper::where('id', $request['keeperId'])->first();


        if($request['keeperCoverName'] == "1"){

                if ($theKeeper->image != 0){
                    Storage::delete('storage/keepers/'.$theKeeper->image);
                }
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

                $theKeeper->image = $fileNameToStore;
        }
        else if ($request['keeperCoverName'] == "0"){
            if ($theKeeper->image != "0"){

                unlink('storage/keepers/'.$theKeeper->image);
                $theKeeper->image = "0";

            }
        }


        $theKeeper->content = $request['messageContent'];
        $theKeeper->link_text = $request['linkText'];
        $theKeeper->link_url = $request['linkUrl'];
        $theKeeper->type = $request['messageType'];
        $theKeeper->status = $request['messageStatus'];
        $theKeeper->user_type = $request['user_type'];
        $theKeeper->expire = $request['messageExpireDate'];


        $theKeeper->update();

        return response()->json(['message' => "&#xf14a The Keeper has been updated", 'success' => "1"]);
    }


}




























