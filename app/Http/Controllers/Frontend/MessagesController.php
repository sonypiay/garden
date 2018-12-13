<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Messages;
use App\Database\MessagesConversation;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
  public function sendmessage( Request $request, Messages $messages, MessagesConversation $conversation )
  {
    $vendor = $request->vendor;
    $customer = $request->customer;
    $message = $request->message;

    $getmessage = $messages->where([
      ['vendor_id', '=', $vendor],
      ['customer_id', '=', $customer]
    ]);
    $from = Cookie::get('hasLoginVendor') ? $vendor : $customer;
    $to = Cookie::get('hasLoginVendor') ? $customer : $vendor;

    if( $getmessage->count() === 1 )
    {
      $msgid = $getmessage->first();
      $conversation->msg_id = $msgid->msg_id;
      $conversation->message_from = $from;
      $conversation->message_to = $to;
      $conversation->messages = $message;
      $conversation->save();
    }
    else
    {
      $msgid = $messages->count() + 1;
      $messages->vendor_id = $vendor;
      $messages->customer_id = $customer;
      $messages->save();

      $conversation = new $conversation;
      $conversation->msg_id = $msgid;
      $conversation->message_from = $from;
      $conversation->message_to = $to;
      $conversation->messages = $message;
      $conversation->save();
    }

    $res = [
      'status' => 200,
      'statusText' => 'Pesan terkirim'
    ];

    return response()->json( $res );
  }
}
