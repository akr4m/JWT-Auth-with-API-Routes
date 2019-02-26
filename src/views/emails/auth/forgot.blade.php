@component('mail::message')
# Dear customer

You have received this email because a change of password was requested on our website for accounts which are associated with your {{ $email }} email address.

> ## <center>{{ $token }}</center>

This reset link:

> {{ 'Website .com/reset/password?token=' . $token }}


If you didn’t make this change or if you believe an unauthorized person has accessed your account, go to your account to reset your password immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
