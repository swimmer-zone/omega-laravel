<h1>Thanks for getting in touch, {{ $contact['name'] }}!</h1>

<p>
    I've received your message and will get back to you as soon as I can.
</p>

<p>
    Your message was:
</p>

<blockquote>
    {!! nl2br(e($contact['message'])) !!}
</blockquote>

<p>
    Cheers,<br>
    Sander
</p>
