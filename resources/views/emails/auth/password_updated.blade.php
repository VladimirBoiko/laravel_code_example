@component('mail::message')
    Congratulation!
    <br>
    Your password was updated.
    <br>
    @component('mail::button', ['url' => route('home')])
        On Home Page
    @endcomponent
@endcomponent