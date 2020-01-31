"use strict";

export class CartItem {
    constructor(id, name, price, stock, vip = false) {
        this.id = id;
        this.name = name;
        this.stock = stock;
        this.price = price;
        this.vip = vip;
        this.count = 0;
    }

    serialize(){
        return {
            id: this.id,
            name: this.name,
            price: this.price,
            stock: this.stock,
            vip: this.vip,
            count: this.count,
        };
    };

    createRegulateBtn (type = "+") {
        let button = document.createElement("button");
        button.classList.add("regulate-button");
        button.innerHTML = type;
        if (type === "+") {
            button.addEventListener("click", () => {
                window.cartObj.addItem(this);
                window.cartObj.render();
            });
        } else {
            button.addEventListener("click", () => {
                window.cartObj.removeItem(this.id);
                window.cartObj.render();
            });
        }
        return button;
    };

    render() {
        let tr = document.createElement("tr");
        const span = document.createElement("span");
        span.innerHTML = this.count;
        tr.appendChild(this.getTd(this.name));
        tr.appendChild(
            this.getTd([
                this.createRegulateBtn("+"),
                span,
                this.createRegulateBtn("-")
            ], {
                class: "cart-count-td"
            })
        );
        tr.appendChild(
            this.getTd(String(this.getSum()).replace(".", ",") + " €")
        );
        return tr;
    };

    getSum () {
        return (
            parseFloat(this.price.replace(",", ".")) * parseInt(this.count)
        ).toFixed(2);
    };

    getTd (value, attributes = {}) {
        let td = document.createElement("td");
        if (Array.isArray(value)) {
            for (let item of value) {
                if (typeof item != "object") {
                    item = document.createTextNode(item);
                }
                td.appendChild(item);
            }
        } else {
            if (typeof value == "string") {
                value = document.createTextNode(value);
            }
            td.appendChild(value);
        }
        for (let attrName in attributes) {
            td.setAttribute(attrName, attributes[attrName]);
        }
        return td;
    };
}
