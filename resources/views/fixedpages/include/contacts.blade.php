@if($cs_email != "")
    <i class="icofont-email fa-2x"></i>&nbsp;
    <span style="font-weight: 700">{{ $cs_email  }}</span>
    &nbsp;
@endif

@if($hq_phone != "")
    <i class="icofont-phone-circle fa-2x"></i>&nbsp;
    <span style="font-weight: 700">{{ $hq_phone }}</span>
    &nbsp;
@endif



@if($mobile_sms != "")
    <a style="color:green" target="_blank"
       href="https://api.whatsapp.com/send?phone={{$mobile_sms}}&text= Hi, LETUSCATER Customer Service">

        <i class="icofont-whatsapp fa-2x"></i>&nbsp;
        <span style="font-weight: 700"></span>Whatsapp Now</a>
    &nbsp;
@endif
