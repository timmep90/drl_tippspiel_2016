@if(session()->has('flash_message'))
    <div class="alert {{session('flash_message_level')}}">
        <h3>{{session('flash_message')}}</h3>
    </div>
@endif