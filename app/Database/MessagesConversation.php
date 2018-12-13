<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class MessagesConversation extends Model
{
  public $timestamps = true;
  protected $table = 'messages_conversation';
  protected $primaryKey = 'conversation_id';
}
