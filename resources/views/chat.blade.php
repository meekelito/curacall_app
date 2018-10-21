@extends('layouts.app')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Messages</span> - List</h4>
        </div>
        <div class="heading-elements">
            <form class="heading-form" action="#">
                <div class="form-group">
                    <div class="has-feedback">
                        <input type="search" class="form-control" placeholder="Search messages">
                        <div class="form-control-feedback">
                            <i class="icon-search4 text-size-small text-muted"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="#l"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="#">Messages</a></li>
            <li class="active">All messages</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<div class="content">
    <!-- Basic layout -->
    <div class="col-lg-8">
      <div class="panel panel-flat">
        <div class="panel-toolbar panel-toolbar-inbox">
            <div class="navbar navbar-default">
                <ul class="nav navbar-nav visible-xs-block no-border">
                    <li>
                        <a class="text-center collapsed" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse collapse" id="inbox-toolbar-toggle-single">
                    <div class="btn-group navbar-btn">
                        <button type="button" class="btn btn-default"><i class="icon-pencil7"></i> <span class="hidden-xs position-right">New</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-forward"></i> <span class="hidden-xs position-right">Forward</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-bin"></i> <span class="hidden-xs position-right">Delete</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-check"></i> <span class="hidden-xs position-right">Close</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-file-pdf"></i> <span class="hidden-xs position-right">PDF</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-file-excel"></i> <span class="hidden-xs position-right">Excel</span></button>
                    </div>

                    
                </div>
            </div>
        </div>
        <div class="panel-body" id="message-container">
            <input type="hidden" id="room" value="{{ $room_id }}">
            <chat-messages :messages="messages" :user="{{ Auth::user()->id }}" room_id="{{ $room_id }}"></chat-messages>
            <div style="height: 20px;">
            <span v-show="typing" class="help-block" style="font-style: italic;">
                @{{ user.fname }} is typing...
            </span>
            </div>
            <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}" room_id="{{ $room_id }}"></chat-form>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="panel panel-flat">
        <div class="panel-body" >
            <div style="text-align: center;">
              <span class="btn bg-brown-400 btn-rounded btn-icon btn-lg" title="title">
                <span class="letter-icon">{{ ucwords(substr($recipient_info[0]->fname, 0, 1)) }}</span>
              </span>
              
          <div style="font-size: 14px; margin: 10px 0 20px; font-weight: 500;">{{ ucwords($recipient_info[0]->fname.' '.$recipient_info[0]->lname) }}</div>
          </div>
          <table class="table" style="font-size: 12px;">
            <tr><td>Email</td><td>{{ $recipient_info[0]->email }}</td></tr>
            <tr><td>Tel.</td><td>732-638-8887</td></tr> 
            <tr><td>Language</td><td>English</td></tr>
            <tr><td>Address</td><td>78 John Miller WaySuite 425Kearny, NJ 07032</td></tr>
          </table>
        </div>
      </div>
    </div>
    <!-- /basic layout -->
</div>
@endsection
@section('script')
<script> 
  $(".menu-curacall li").removeClass("active");
  $(".menu-messages").addClass('active');
  $(".submenu-curacall li").removeClass("active");

  $(function(){
      $('.chat-list, .chat-stacked').scrollTop($(this).height());
  });
</script>

<script  src="{{ asset('js/app.js') }}" type="text/javascript" defer></script> 
@endsection