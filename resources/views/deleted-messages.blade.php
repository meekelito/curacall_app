@extends('layouts.app')

@section('content')
	deleted messages
@endsection  

@section('script')
<script type="text/javascript">
  $(".menu-curacall li").removeClass("active");
  $(".menu-messages").addClass('active');
  $(".submenu-curacall li").removeClass("active");
  $(".submenu-messages-deleted-messages").addClass('active');
</script>
@endsection 
