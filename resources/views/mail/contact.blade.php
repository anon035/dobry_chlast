<div style="max-width: 600px; height: 900px;">
    <div style="text-align: center; width: 100%;">
        <img width="200px; margin: auto;" src="{{ asset('images/email_logo.png') }}" alt="Dobry-chlast.sk">
    </div>
    <div style="width: 600px; text-align: center;">
        <h2>
            New message from contact form!
        </h2>
        <table>
            <tr>
                <td>Name: </td>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <td>Surname: </td>
                <td>{{ $surname }}</td>
            </tr>
            <tr>
                <td>Email: </td>
                <td>{{ $email }}</td>
            </tr>
        </table>
        <p style="white-space: pre-line; font-size: 20px;">
            {{ $body }}
        </p>
    </div>
</div>
