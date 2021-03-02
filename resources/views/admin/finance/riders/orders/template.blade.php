@push('script')

<script type="text/javascript">



               


</script>
  <script type="text/javascript">
    $(document).ready(function() {
      

// -------- all
    $('.visual_table').on('change', '.group-checkable', function() {
      var thischecked = null;
      var set = $(this).closest('table').find('td:first-child .checkable');
      var checked = $(this).is(':checked');
      if(checked == true)
        {
         getAmount('all'); 
        }
       else getAmount('none');
      $(set).each(function() {
        if (checked) {
          $(this).prop('checked', true);
        }
        else {
          $(this).prop('checked', false);
        }
      });
    });






//------------any
      $('.visual_table').on('change', '.checkable', function() {
       checkid = [];
       $.each($("input[name='checkable']:checked"), function () {  
       checkid.push($(this).val()); 
        });
      getAmount(checkid);
      });               



function getAmount(checkid){

          $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route('admin.getAjaxRiderPayment') }}',
                    method: 'get',
                    'data': {
                        checkid: checkid,
                        rider_id: '{{$rider->id}}'
                      },

                     beforeSend: function( xhr )
                    {
                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                       toastr.clear();
                       $('#amount').val(result.amount);
                      $('#checkid').val(result.checkid);

                    }
                });
           }


   });   
  </script>

@endpush