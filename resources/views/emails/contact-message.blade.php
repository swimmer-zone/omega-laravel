<h1>New contact message</h1>

<p>
    <strong>Name:</strong>
    {{ $contact['name'] }}
</p>

<p>
    <strong>Email:</strong>
    {{ $contact['email'] }}
</p>

<hr>

<p>
    {!! nl2br(e($contact['message'])) !!}
</p>
