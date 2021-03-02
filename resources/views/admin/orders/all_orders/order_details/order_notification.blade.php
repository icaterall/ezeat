  @can('manager_privilege')
     @include('admin.orders.all_orders.order_details.whatsapp')
  @endcan

<!-- notification -->
<!-- Order Status -->
<div class="alert alert-warning">
  <p class="order_note_font">
 
       Order Status : {{$order->order_status_note}}
 
</p>
</div>


@if($order_driver_status != null)
<div class="alert alert-warning" style="background: #F4761B">
  <p class="status_message message_yellow_info">
    Rider Status : {{$order_driver_status}}
  </p>
</div>
@endif




@push('script')

<script type="text/javascript">
$(document).ready(function () {

//Decline Order Ajax request.
            $('.update_order_status').click(function(e) {
                e.preventDefault();  
                var $this = $(this); 
                var $old_btn_text = $(this).text();        
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: $(this).attr('data-url'),
                    method: 'Post',
                    beforeSend: function( xhr )
                    {
                       $this.text('Please Wait...');
                       $this.prop('disabled', true);

                      Command: toastr["info"]("Uploading Data ...", "Sending Request");
                    },

                    success: function(result) {
                      $this.prop('disabled', false);
                       toastr.clear(); 
                        $('#decline-modal').hide();
                        $('.modal-backdrop').css('display','none');
                        Command: toastr ["success"] ("Decline completed successfully", "Decline status");
                        setTimeout(function() { location.reload();}, 100);
                    }
                });
            });
    });

</script>

@endpush