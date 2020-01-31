<footer class="footer">
    <div class="footer-wrapper">
        <div class="footer-wrapper__menu">
            <ul>
                <li>
                    <a href="{{ route('contact.show') }}">Contact</a>
                </li>
                <li>
                    <a href="{{ route('categories.user-view') }}">Categories</a>
                </li>
                <li>
                    <a href="{{ route('terms') }}#payments">Payments</a>
                </li>
                <li>
                    <a href="{{ route('terms') }}">Terms and conditions</a>
                </li>
            </ul>
        </div>
        <div class="footer-wrapper__contact">
            <p>
                KVZ s.r.o.
            </p>
            <p>
                Tel: +421907333880
            </p>
            <p>
                Email: <a href="mailto:obchod@dobry-chlast.sk">obchod@dobry-chlast.sk</a>
            </p>
            <p>
                IČO: 50565290<br />
                IČ DPH: SK2120379767
            </p>
        </div>
        <div class="footer-wrapper__payment">
            <h6>
                We accept payments
            </h6>
            {{-- <div>Icons made by <a href="https://www.flaticon.com/authors/icongeek26" title="Icongeek26">Icongeek26</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
            <div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
            <div>Icons made by <a href="https://www.flaticon.com/authors/monkik" title="monkik">monkik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> --}}
            <div class="cards">
                <div class="card">
                    <img title="Cash payment" alt="Cash payment" src="{{ asset('images/payments/cash-payment.svg') }}">
                </div>
                <div class="card">
                    <img title="Card payment" alt="Card payment" src="{{ asset('images/payments/card-payment.svg') }}">
                </div>
                <div class="card">
                    <img title="Online payment" alt="Online payment" src="{{ asset('images/payments/online-payment.svg') }}">
                </div>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
<script src="https://kit.fontawesome.com/4d134b56aa.js" crossorigin="anonymous"></script>
{{-- <script src='https://kit.fontawesome.com/a076d05399.js'></script> --}}
@endpush