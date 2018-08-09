@foreach(['success','danger','message'] as $msg)
    @if(Session::has($msg))
        @if($msg == 'message')
            {{ $msg = 'info' }}
        @endif
        <div class="alert alert-{{ $msg }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ Session::get($msg) }}
        </div>
    @endif
@endforeach