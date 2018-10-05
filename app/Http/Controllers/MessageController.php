<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Text;
use App\User;
use Auth;
use App\Notifications\MessageReceived;


class MessageController extends Controller
{
		
		public function messages(){
			$user = Auth::user();
			$role = $user->role()->first()->role;

			if($role == 'mama'){
				$msg  = Message::where('sender',$user->id)->with('userSender','userReceiver')
				                ->orderBy('created_at','aesc')
				                ->get();
			}else{
				$msg  = Message::where('receiver',$user->id)->with('userSender','userReceiver')
				                 ->orderBy('created_at','aesc')
				                 ->get();
			}

			return response()->json([
						'status' => 'success',
						'msg' =>'messages',
						'data' => $msg,
						'user'=> $user
					 ],200);
		}

		public function texts($id){
			$user = Auth::user();
			$message = Message::findOrFail($id);
			$texts = Text::where('message_id',$message->id)->with('message')
			               ->orderBy('created_at')->get();
			return response()->json([
						'status' => 'success',
						'data' =>$texts,
						'user'=> $user
					 ],200);

		}

		public function send(Request $request,$id){
			$request->validate([
				'message'=>'required'
			]);
			$user = User::find(Auth::id());
			$sender = Auth::id();
			$receiver = User::find($id);
			$message = Message::where('sender',$sender)
												->where('receiver',$receiver->id)
												->first();
			if($message == null){
					 $message = new Message();
					 $message->receiver= $receiver->id;
					 $user->messageSender()->save($message);

					 //text
					 $text = new Text();
					 $text->user_id = $sender;
					 $text->content = $request->get('message');
					 $message->texts()->save($text);
					 

			}else{
					 $message = Message::find($message->id); 
					 //text
					 $text = new Text();
					 $text->user_id = $sender;
					 $text->content = $request->get('message');
					 $message->texts()->save($text);
			}
			$sender =  Auth::user();
			//notify
			$receiver->notify(new MessageReceived($sender,$message));

			return response()->json([
						'status' => 'success',
						'msg' =>'Message sent!'
					 ],200);
		}

		public function sendText(Request $request,$id){

			$msg = Message::findOrFail($id);

			$content = $request->get('message');

			$text = new Text([
				'content'=>$content,
				'user_id'=> Auth::id()
			]);

			$msg->texts()->save($text);

			$sender = Auth::id();
			$source = Auth::user();

			$receiver = ($sender == $msg->sender )? User::find($msg->receiver):User::find($msg->sender);

			//notify
			$receiver->notify(new MessageReceived($source,$msg));

			return response()->json([
						'status' => 'success',
						'msg' =>'Message sent!'
					 ],200);

		}

		public function markAsRead($id){
      $msg = Message::find($id);
			$text = Text::where('message_id',$msg->id)
			              ->where('isRead',0)
			              ->get();
			foreach ($text as $t) {
				if($t->user_id != Auth::id()){
					$t->isRead = True;
			    $t->save();
				}
				
			}
			
			return response()->json([
						'status' => 'success',
						'msg' =>'Text read!'
					 ],200);

		}

		public function deleteText($id){
			$text = Text::findOrFail($id);
			$text->delete();

			return response()->json([
						'status' => 'success',
						'msg' =>'Text deleted!'
					 ],200);
		}

		public function deleteMessage($id){
			//delete text

			$message = Message::findOrFail($id);
			$message->delete();

			return response()->json([
						'status' => 'success',
						'msg' =>'Message deleted!'
					 ],200);
		}
}
