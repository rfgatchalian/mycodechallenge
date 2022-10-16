<x-mail::message>
# Invitation

{{$mailData['name']}} has invited you. Click the button.

<x-mail::button :url="$url">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
