@extends('managedashboard.layouts.master')

@section('title', 'SpoonGate :: Login to your account')
@section('css')
<!-- BEGIN PAGE LEVEL PLUGINS -->


<!-- END PAGE LEVEL PLUGINS -->
@endsection

@section('content')
@yield('local_content')
@endsection

@section('script')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/icaterall/admindashboard/js/functional.js"></script>

<script type="text/javascript">

  // Listen for clicks in the document
        document.addEventListener('click', function (event) {

            // Check if a password selector was clicked
            var selector = event.target.getAttribute('data-show-pw');
            if (!selector) return;

            // Get the passwords
            var passwords = document.querySelectorAll(selector);

            // Toggle visibility
            Array.from(passwords).forEach(function (password) {
                if (event.target.checked === true) {
                    password.type = 'text';
                } else {
                    password.type = 'password';
                }
            });
        }, false);


$(document).ready(function() {
 $(document).on('click','#storeslist li', function(){
  var store_id=$(this).data('value');
  $("#store_id").val(store_id);
});
  });

    </script>


@endsection
