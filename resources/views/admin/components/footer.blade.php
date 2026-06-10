<footer class="footer">
    <div class="d-flex justify-content-between">
        <span class="float-none float-sm-left d-block mt-1 mt-sm-0 text-center text-primary"> Copyright © 2023.
            @if(settings('copyright_url'))
                <a class="text-primary font-weight-bold" href="{{ settings('copyright_url') }}" target="_blank">{{ settings('copyright') }} </a>
            @else
            N/A
            @endif
            All rights reserved.
        </span>
        <span class="float-none float-sm-left d-block mt-1 mt-sm-0 text-center text-primary"> {{ settings('version') ? settings('version') : '' }} </span>

        <a href="https://websolutionfirm.com" target="_blank"><i class="fa fa-laptop"></i> <span> NCloud Solutions
 </span> </a>
    </div>
</footer>
