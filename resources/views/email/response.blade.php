Merhaba {{ $name }},
<p>
{!! $response  !!}
</p>
<p>
    <strong>İletişim formundan gelen mesajınız:</strong>
</p>
<p>
İsim: {{ $name }}
 <br>
Telefon: {{ $phone }}
<br>
Email: {{ $email }}
<br>
Message: {!! $user_message !!}
</p>