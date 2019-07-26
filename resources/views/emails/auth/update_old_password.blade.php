@component('mail::message')
    You should update your password on website <a href="{{route('home')}}">Example.com</a>
    <br>
    Click on <a class="" href="{{route('update_old_password', ['token'=>$token])}}">link</a> for updating
    <br>
    @component('mail::button', ['url' => route('update_old_password', ['token'=>$token])])
        Update password
    @endcomponent
@endcomponent