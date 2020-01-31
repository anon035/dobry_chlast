<div class="product-list__filter">
    <h3>Price filter</h3>
    <span id="filter-price" data-prices="@json($prices)"></span>
</div>
@push('styles')
<link rel="stylesheet" href="/css/nouislider.min.css">
@endpush

@push('scripts')
<script type="text/javascript" src="/js/nouislider.js"></script>
<script src="{{ asset('js/Filter.js') }}"></script>
<script>
    let handlesSlider = document.getElementById('filter-price');
    let prices = JSON.parse(handlesSlider.dataset.prices);

    let min = 0;
    let max = Math.max(...prices) + 1;
    let step = (100.00 / prices.length);
    if (prices.length > 1) {
        prices.pop();
    }

    let rangeValues = {};
    rangeValues['min'] = min;
    rangeValues['max'] = max;

    let currentStep = step;
    for(let price of prices){
        if (price) {
        rangeValues[currentStep.toFixed(1) + '%'] = price;
        currentStep = parseFloat(currentStep) + parseFloat(step);
        }
    }

    noUiSlider.create(handlesSlider, {
        start: [min, max],
        tooltips: true,
        snap: true,
        connect: true,
        range: rangeValues,
        format: {
            // 'to' the formatted value. Receives a number.
            to: function (value) {
                return `${Math.round(value)}€`
            },
            // 'from' the formatted value.
            // Receives a string, should return a number.
            from: function (value) {
                return Number(value.replace(',-', ''));
            }
        }
    });

    function animateProducts(){
        const prodTarget = document.querySelectorAll(".product-list__products a");
        const prodOptions = {
            root: null,
            rootMargin: "-70px",
            treshold: 0.5
        }

        const prodObserver = new IntersectionObserver(function(items, observer){
            for(let item of items){
                if(item.intersectionRatio >= 0.01){
                    let productImage = item.target.children[0].children[0];
                    let imageSrc = productImage.dataset.src;
                    productImage.style.backgroundImage = "url(../" + imageSrc + ")";
                    item.target.children[0].classList.add("fade-in");
                }
            }
        }, prodOptions);

        for(let item of prodTarget){
            prodObserver.observe(item);
        }
    }

    let filter = new Filter();

    let json = {!! $json !!};
    handlesSlider.noUiSlider.on('change.one', function (e) {
        const min = parseInt(e[0].replace("€", "")) - 1;
        let max = parseInt(e[1].replace("€", "")) + 1;

        let filteredProducts = json
        .filter(product => parseInt(product.price) >= min && parseInt(product.price) <= max);
        filter.render(document.querySelector("{{ $selector }}"), filteredProducts);
        animateProducts();
    });
    filter.render(document.querySelector("{{ $selector }}"), json);
    animateProducts();


</script>
@endpush
