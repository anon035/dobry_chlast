function handleAddToBag(e, amountInput = null) {    
    e.preventDefault();
    let amount = 1;

    if (amountInput) {
        amount = parseInt(amountInput.value, 10);
    }
    const json = JSON.parse(e.target.dataset.json);

    // popup notification by sweet alert
    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2500
    });

    if (
        window.cartObj.addItem(
            window.cartObj.createItem(
                json.id,
                json.name,
                json.price,
                json.stock
            ),
            amount
        )
    ) {
        window.cartObj.render();

        if (amountInput) {
            amountInput.value = "1";
        }
        Toast.fire({
            type: "success",
            title: "Item added to cart! &#x21E2;"
        });
    } else {
        Toast.fire({
            type: "error",
            title: "Item is not in stock! &#x2717;"
        });
    }
}
