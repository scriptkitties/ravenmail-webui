The person owning the email address {{ $origin }} has requested an alias to
your email address, {{ $destination }}. In order for this alias to be enabled
on the mail service, it has to be verified. This is required to ensure that no
spam is relayed by abusing aliases.

If you did not request an alias for {{ $origin }} to {{ $destination }}, please
report this to the contact of {{ $domain }}. You can reach this contact at
{{ $contact }}. Please include the offender's email address ({{ $origin }})
in your report.

If you did request this alias, please activate it by visiting the following
url:

{{ $url }}

@include('mail.footer')
