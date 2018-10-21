@extends('layouts.default')

@section('content')
	closed messages
@endsection  

@section('script')
<script type="text/javascript">
  $(".menu-curacall li").removeClass("active");
  $(".menu-messages").addClass('active');
  $(".submenu-curacall li").removeClass("active");
  $(".submenu-messages-closed-messages").addClass('active');
</script>
@endsection 
