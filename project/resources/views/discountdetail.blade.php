@extends('includes.newmaster')
@section('content')

<style type="text/css">
    
</style>

 <div class="body-content">
    <div class="container">
        <div class="row ">
            <div class="discount_detail">
                <div class="code_box">
                    <div class="code_box_header">
                        <h4>{{trans('app.CopyCouponCode')}}</h4>
                    </div>
                    <div class="code_box_body">
                        <p id="vcode" style="display: none;">{{$discount[0]->code}}</p>
                        <button class="btn btn-default" onclick="copyToClipboard('#vcode')">{{$discount[0]->code}}</button>
                        <h4 id="code_copy" style="margin-top: 10px;"></h4>
                    </div>
                </div>
                @if($discount[0]->title != '')
                    <h4 class="text-center"><b>{{$discount[0]->title}}</b></h4>
                @endif
                @if($discount[0]->description != '')
                <div class="detail">
                    <h4 class="text-center">Details</h4>
                    <p>{{$discount[0]->description}}</p>
                    <ul>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop
@section('footer')

<script type="text/javascript">

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#code_copy').show();
    $('#code_copy').text('Code Copied!').delay(2000).fadeOut();
}

</script>
@stop