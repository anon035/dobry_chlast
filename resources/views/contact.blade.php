@extends('layouts.base')

@section('content')
<section class="contact">
    <h2 class="contact__title">
        &#x2709; Contact
    </h2>
    <div class="contact__content">
        <div class="info-form">
            <div class="info">
                <p>
                    dasédoasodéa
                </p>
                <p>
                    dasokoakodas
                </p>
                <p>
                    daokdoaskod 0902901
                </p>
                <p>
                    dkoaskdoakodkaos
                </p>
            </div>
            <h4>
                Feel free to contact us
            </h4>
            <br>
            <form method="POST" class="form" action="{{ route('contact.send') }}">
                @csrf
                <input placeholder="Name" name="name" type="text">
                <input placeholder="Surname" name="surname" type="text">
                <input placeholder="Email address" name="email" type="text">
                <textarea placeholder="What you would like to tell us." name="body" id="" cols="30"
                    rows="10"></textarea>
                <div class="submit">
                    <button type="submit">Send &#x276F;</button>
                </div>
            </form>
        </div>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2632.428175156588!2d21.216282380981458!3d48.716409619508866!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x338171519e77ab21!2sCHEERS%20KVP%20Alko-Nealko-V%C3%ADno-Pivo!5e0!3m2!1sen!2ssk!4v1570388535499!5m2!1sen!2ssk"
            width="100%" height="475" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>
</section>
</div>
@endsection

@push('scripts')
<script>
    let success = {{ $success }};

     const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 2500
        });

    if (success == 1) {
        Toast.fire({
                type: 'success',
                title: 'Your message was sent successfuly'
                });
    } else if (success == 0) {
Toast.fire({
        type: 'warning',
        title: 'Your message was not sent successfuly'
        });
    }
</script>
@endpush
