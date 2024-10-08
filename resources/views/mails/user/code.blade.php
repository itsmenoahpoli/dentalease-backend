@component('mail::message')
<h1>Forgot your password?</h1>

If you've lost your password or wish to reset it, use the code below to verify
your e-mail address.

<div
    style="
        background-color: #f3f3f3;
        padding: 20px 10px;
        border: solid 1px #eee;
        border-radius: 5px;
    "
>
    {{ $code }}
</div>
@endcomponent
