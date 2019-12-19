<?php

namespace raplet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use raplet\Comment;
use raplet\Like;
use raplet\Post;
use raplet\Vote;


class InterractController extends Controller
{

    //Like comments
     public function likeComment(Request $request){
         if (Auth::check()){// CHECK IF USER IS AUTHED
             $user = Auth::user();


             $comment = Comment::where('id', $request['content_id'])->first();
             if (count($comment) > 0){// CHECK IF COMMENT DOES EXIST
                 $vote = $user->votes()->where('comment_id',$request['content_id'])->first();

                  if (count($vote) > 0){ // CHECKING TO SEE IF LIKE ALREADY EXISTS

                     if ($vote->vote == 1){// IT MEANS THE COMMENT WAS LIKED BEFORE
                          $vote->delete();
                         DB::table('comments')->where('id', $request['content_id'])->decrement('likecount');
                         DB::table('userprofiles')->where('id', $comment->user_id)->decrement('reputation');

                     }

                     else{// it means the comment was not liked before but disliked, so we need to like it now
                         $vote->vote = '1';
                         $vote->update();


                         DB::table('comments')->where('id', $request['content_id'])->increment('likecount');
                         DB::table('comments')->where('id', $request['content_id'])->decrement('dislikecount');
                         DB::table('userprofiles')->where('id', $comment->user_id)->increment('reputation');



                     }

                  }

                  else{// like does not exist
                       $vote = new Vote();

                       $vote->user_id = Auth::id();
                       $vote->comment_id = $request['content_id'];
                       $vote->vote = '1';

                       $vote->save();

                      DB::table('comments')->where('id', $request['content_id'])->increment('likecount');
                      DB::table('userprofiles')->where('id', $comment->user_id)->increment('reputation');



                  }


	             $notify_data = [
		             'content_id' => $comment->id,
		             'effected_user_id' => $comment->user_id,
		             'content_type' => '2',
		             'url' => route('entry', $comment->slug),
		             'notification_name' => 'commentLiked'
	             ];

	             $this->notifier($notify_data);

                 $commentupdated = Comment::where('id', $request['content_id'])->first();
                 $likecount = $commentupdated->likecount;
                 $dislikecount = $commentupdated->dislikecount;

                 $success = '1';
                 return response()->json(['success' => $success, 'likecount' => $likecount, 'dislikecount' => $dislikecount]);
             }


             else{// NO SUCH COMMENT IN DATAVASE. THOROW BAD BEHAVIOUR
                 $success = '0';
                 $message = trans('home.thereisnosuchdata');
                 return response()->json(['message' => $message]);
             }
         }
         else{// THERE IS NO AUTHECTICATED USER
             $success = '0';
             $message = trans('home.plzLogin');
             return response()->json(['message' => $message]);
         }


     }


     //Dislike comments
     public function dislikeComment(Request $request){
         if (Auth::check()){// CHECK IF USER IS AUTHED

             $user = Auth::user();

             $comment = Comment::where('id', $request['content_id'])->first();
             if (count($comment) > 0){// CHECK IF COMMENT DOES EXIST
                 $vote = $user->votes()->where('comment_id',$request['content_id'])->first();

                 if (count($vote) > 0){ // CHECKING TO SEE IF LIKE ALREADY EXISTS

                     if ($vote->vote == 0){// IT MEANS THE COMMENT WAS DISLIKED BEFORE
                         $vote->delete();

                         DB::table('comments')->where('id', $request['content_id'])->decrement('dislikecount');
                         DB::table('userprofiles')->where('id', $comment->user_id)->increment('reputation');


                     }

                     else{// it means the comment was not disliked before but liked, so we need to dislike it now
                         $vote->vote = '0';
                         $vote->update();

                         DB::table('comments')->where('id', $request['content_id'])->decrement('likecount');
                         DB::table('comments')->where('id', $request['content_id'])->increment('dislikecount');
                         DB::table('userprofiles')->where('id', $comment->user_id)->decrement('reputation');


                     }

                 }

                 else{// dislike does not exist
                     $vote = new Vote();

                     $vote->user_id = Auth::id();
                     $vote->comment_id = $request['content_id'];
                     $vote->vote = '0';

                     $vote->save();

                     DB::table('comments')->where('id', $request['content_id'])->increment('dislikecount');
                     DB::table('userprofiles')->where('id', $comment->user_id)->decrement('reputation');



                 }


                 $commentupdated = Comment::where('id', $request['content_id'])->first();
                 $likecount = $commentupdated->likecount;
                 $dislikecount = $commentupdated->dislikecount;

                 $success = '1';
                 return response()->json(['success' => $success, 'likecount' => $likecount, 'dislikecount' => $dislikecount]);
             }


             else{// NO SUCH COMMENT IN DATAVASE. THOROW BAD BEHAVIOUR
                 $success = '0';
                 $message = trans('home.thereisnosuchdata');
                 return response()->json(['message' => $message]);
             }
         }
         else{// THERE IS NO AUTHECTICATED USER
             $success = '0';
             $message = trans('home.plzLogin');
             return response()->json(['message' => $message]);
         }


     }

     public function likePost(Request $request){
         $post = Post::where('id', $request['content_id'])->first();

         if (count($post) > 0){// it means the post exicsts
             $like = Like::where('post_id', $request['content_id'])->where('user_id', Auth::id())->first();
             if (count($like) > 0){// it means the post was liked before
                 DB::table('posts')->where('id', $request['content_id'])->decrement('likecount');
                 DB::table('userprofiles')->where('user_id', $post->user_id)->decrement('reputation');
                 DB::table('userstats')->where('user_id', $post->user_id)->decrement('likercount');
                 DB::table('userstats')->where('user_id', Auth::id())->decrement('likecount');


                 $like->delete();

                 $success = '1';
                 $likecount = Post::where('id', $request['content_id'])->first()->likecount;
                 return response()->json(['success' => $success, 'likecount' => $likecount]);
             }
             else{// post being liked now
                 $newlike = new Like();
                 $newlike->post_id = $request['content_id'];
                 $newlike->user_id = Auth::id();

                 $newlike->save();
                 DB::table('posts')->where('id', $request['content_id'])->increment('likecount');
                 DB::table('userprofiles')->where('user_id', $post->user_id)->increment('reputation');
                 DB::table('userstats')->where('user_id', $post->user_id)->increment('likercount');
                 DB::table('userstats')->where('user_id', Auth::id())->increment('likecount');


	             $notify_data = [
		             'content_id' => $post->id,
		             'effected_user_id' => $post->user_id,
		             'content_type' => '1',
		             'url' => route('word', $post->slug),
		             'notification_name' => 'postLiked'
	             ];

	             $this->notifier($notify_data);


                 $success = '1';
                 $likecount = Post::where('id', $request['content_id'])->first()->likecount;
                 return response()->json(['success' => $success, 'likecount' => $likecount]);
             }
         }
         else{
             $success = '0';
             $message = trans('home.nosuchdata');

             return response()->json(['message' => $message, 'success' => $success]);
         }
     }

//     public function urlNotifyseen(Request $request){
//         $notify_id = $request['content_id'];
//         Notifications::where('id', $notify_id)->update(array("seen" => "1"));
//
//         return null;
//     }
}


















