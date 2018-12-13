<?php

namespace App\Http\Controllers\Frontend\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\FunctionApp\CustomFunction;
use App\Database\Vendors;
use App\Database\Customers;
use App\Database\Messages;
use App\Database\MessagesConversation;
use App\Http\Controllers\Controller;

class MessagesVendor extends Controller
{
  use CustomFunction;

  public function index( Request $request )
  {
    if( Cookie::get('hasLoginVendor') )
    {
      $datavendor = $this->getvendors( new Vendors, Cookie::get('vendor_id') );
      return response()->view('frontend.pages.vendors.messages', [
        'request' => $request,
        'sessiondata' => Cookie::get(),
        'myaccount' => $datavendor
      ]);
    }
    else
    {
      return response()->view('frontend.pages.vendors.login', [
        'request' => $request
      ]);
    }
  }

  public function messagelist( Request $request, MessagesConversation $messages )
  {
    $rows = $request->rows;
    $messages = $messages->select(
      'messages.msg_id',
      'messages.vendor_id',
      'messages.customer_id',
      'messages.created_at',
      'messages.updated_at',
      'messages_conversation.message'
    )
    ->join('messages', 'messages_conversation.msg_id', '=', 'messages.msg_id')
    ->where([
      ['messages.vendor_id', '=', Cookie::get('vendor_id')]
    ])
    ->orderBy('messages.updated_at', 'desc')
    ->paginate( $rows );

    return response()->json( $messages );
  }
}
