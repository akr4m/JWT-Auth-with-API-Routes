@component('mail::message')
# Dear {{ $user['name'] }}

Your password has been changed successfully.


If you didn’t make this change or if you believe an unauthorized person has accessed your account, go to your account to reset your password immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
