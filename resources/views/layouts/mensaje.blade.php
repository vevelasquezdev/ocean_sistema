@if (session("mensaje"))
<div class="alert alert-success alert-dismissible fade show" data-auto-dismiss="4000" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="fal fa-times"></i></span>
    </button>
    <div class="d-flex align-items-center">
        <div class="alert-icon width-2">
            <span class="icon-stack" style="font-size: 22px;">
                <i class="base-2 icon-stack-3x color-success-600"></i>                
                <i class="fal fa-check icon-stack-1x text-white"></i>
            </span>
        </div>
        <div class="flex-1">
            <span class="h5 m-0 fw-700">Mensaje sistema Villaverde!</span><br>
            {{ session("mensaje") }}
        </div>
    </div>
</div>
<script>
    (function(){
        'use strict';
        window.addEventListener('load', function()
        {                    
            initApp.playSound('{{asset("dist/media/sound")}}', 'smallbox');
        }, false);
    })();    
</script>
    
@endif