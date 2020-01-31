"use strict";

class Filter {
    populateElement(item) {
        let a = document.createElement("a");
        let divWrapper = document.createElement("div");
        divWrapper.classList.add("product-wrapper");
        let divProductImage = document.createElement("div");
        divProductImage.classList.add("product-image");

        // Prepare for lazy loading
        divProductImage.style.background = "no-repeat center/contain";
        divProductImage.setAttribute("data-src", item.photo_path);

        let divQuickAdd = document.createElement("div");
        divQuickAdd.classList.add("quick-add-wrapper");
        let buttonQuickAddBtn = document.createElement("button");
        buttonQuickAddBtn.classList.add("quick-add-wrapper__btn");
        buttonQuickAddBtn.setAttribute(
            "alt",
            "Add " + item.name + " to the cart"
        );
        buttonQuickAddBtn.setAttribute("data-json", JSON.stringify(item));
        buttonQuickAddBtn.setAttribute("onclick", "handleAddToBag(event)");
        let divInfo = document.createElement("div");
        let divInfoTitle = document.createElement("h3");
        let divInfoPrice = document.createElement("p");
        divInfoTitle.innerHTML = item.name;
        divInfoPrice.innerHTML = item.price;
        divInfo.classList.add("product-info");
        divInfo.appendChild(divInfoTitle);
        divInfo.appendChild(divInfoPrice);

        divQuickAdd.appendChild(buttonQuickAddBtn);
        divProductImage.appendChild(divQuickAdd);
        divWrapper.appendChild(divProductImage);
        divWrapper.appendChild(divInfo);
        a.appendChild(divWrapper);
        // a.classList.add("fade-in");
        a.setAttribute("href", `/product/${item.id}`);

        return a;
    }

    noProductsFound() {
        const noProducts = document.createElement("h3");
        noProducts.style.textAlign = "center";
        noProducts.innerText = "No products found. \n (adjust the filter)";
        noProducts.classList.add("fade-in");

        return noProducts;
    }

    render(element, array) {
        element.innerHTML = "";
        if (array.length) {
            for (let item of array) {
                element.appendChild(this.populateElement(item));
            }
        } else {
            element.appendChild(this.noProductsFound());
        }
    }
}
