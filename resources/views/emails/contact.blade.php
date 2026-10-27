<h2>New Contact Message</h2>
<p>
    <strong>Name:</strong> {{ $contactMessage->full_name }}<br>
    <strong>Email:</strong> {{ $contactMessage->email }}<br>
    <strong>Phone:</strong> {!! $contactMessage->phone ? e($contactMessage->phone) : '&mdash;' !!}
</p>
<p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
<p><strong>Message:</strong><br>{!! nl2br(e($contactMessage->message)) !!}</p>
