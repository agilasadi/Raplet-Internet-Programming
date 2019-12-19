<div class="messagesBox">
    @if(Session::has('message'))
        <div class="alert alert-success">
            <i class="fas fa-info-circle"></i>&nbsp;&nbsp;{{session('message')}}
            <button class="closeMessage messageCloser"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    @endif
    @if(Session::has('problem'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;&nbsp;{{session('problem')}}
            <button class="closeProblem messageCloser"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{session('error')}}
        </div>
    @endif

</div>
<script>
    $('.closeProblem').on('click', function(){
        $(this).closest(".alert-danger").remove();
    });
    $('.closeMessage').on('click', function(){
        $(this).closest(".alert-success").remove();
    });
</script>
