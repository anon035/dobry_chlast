"use strict";
import { CartItem } from "./CartItem.js";

export default class Cart {
    constructor(cartElement, cartSumElement, cartSwitchElement) {
        this.items = {};
        this.cartElements = [cartElement];
        this.cartSumElements = [cartSumElement];
        this.cartSwitchElement = cartSwitchElement;
        this.freeShippingElement = null;
    }

    createItem(id, name, price, stock, vip = false) {
        return new CartItem(id, name, price, stock, vip);
    }

    addItem(cartItem, count = 1, initial = false) {
        if (count > 0) {
            if (this.items[cartItem.id] === undefined) {
                if (initial) {
                    cartItem.count = count;
                } else {
                    if (count > cartItem.stock) {
                        return false;
                    }
                    cartItem.stock -= count;
                    cartItem.count += count;
                }
                this.items[cartItem.id] = cartItem;
            } else {
                if (initial) {
                    this.items[cartItem.id].count = count;
                } else {
                    if (count > this.items[cartItem.id].stock) {
                        return false;
                    }
                    this.items[cartItem.id].stock -= count;
                    this.items[cartItem.id].count += count;
                }
            }
        }
        this.save();
        return true;
    }

    removeItem(id, count = 1) {
        if (this.items[id] === undefined) {
            return false;
        }
        if (count > 0 && count < this.items[id].count) {
            this.items[id].count -= count;
            this.items[id].stock += count;
        } else {
            delete this.items[id];
        }
        this.save();
        return true;
    }

    clear() {
        this.items = {};
        this.render();
        this.save();
    }

    render() {
        for (let cartElement of this.cartElements) {
            cartElement.innerHTML = "";
            for (let itemId in this.items) {
                let item = this.items[itemId];
                let tr = item.render();
                tr.appendChild(this.createRemoveTd(item.id));
                cartElement.appendChild(tr);
            }
            if (!cartElement.innerHTML) {
                cartElement.innerHTML = `
                <tr>
                <td colspan="4">
                    You cart is empty. Just <a class="link-special desktop-link"
                        href="/categories">select category</a><a class="link-special mobile-link"
                        href="/">select category</a> and start
                    SHOPPING !
                </td>
            </tr>`;
            }
        }
        this.cartSwitchElement.parentNode.dataset.cartitems = this.totalCount();
        let sum = this.totalSum();
        sum = Math.round(sum * 100) / 100;
        for (let cartSum of this.cartSumElements) {
            cartSum.innerHTML = sum + "€";
        }
        if (this.freeShippingElement) {
            let fseWrapper = this.freeShippingElement.parentNode;
            if (sum > 99) {
                fseWrapper.innerHTML = "Yay you have a FREE shipping!";
            } else {
                fseWrapper.innerHTML = " more and get free shipping!";
                this.freeShippingElement.innerHTML = 100 - sum + "€";
                fseWrapper.prepend(this.freeShippingElement);
            }
        }
    }

    createRemoveTd(itemId) {
        let removeTd = document.createElement("td");
        let span = document.createElement("span");
        span.innerHTML = "&#x2716;";
        span.classList.add("items-table__delete-item");
        span.classList.add("cart-delete-button");
        span.addEventListener("click", () => {
            this.removeItem(itemId, -1);
            this.render();
        });
        removeTd.appendChild(span);
        return removeTd;
    }

    save() {
        let tempArr = [];
        for (let itemId in this.items) {
            tempArr.push(this.items[itemId].serialize());
        }
        sessionStorage.setItem("cart", JSON.stringify(tempArr));
    }

    load() {
        let tempArr = JSON.parse(sessionStorage.getItem("cart"));
        if (tempArr) {
            tempArr.forEach(item => {
                this.addItem(
                    this.createItem(item.id, item.name, item.price, item.stock),
                    item.count,
                    true
                );
            });
            this.render();
        }
    }

    totalCount() {
        let count = 0;
        for (let itemId in this.items) {
            count += parseInt(this.items[itemId].count);
        }
        return count;
    }

    totalSum() {
        let sum = 0;
        for (let itemId in this.items) {
            sum += parseFloat(this.items[itemId].getSum());
        }
        return sum.toFixed(2);
    }

    addCartElement(cartElement) {
        this.cartElements.push(cartElement);
    }

    addCartSumElement(cartSumElement) {
        this.cartSumElements.push(cartSumElement);
    }

    setFreeShippingElement(element) {
        this.freeShippingElement = element;
        this.render();
    }

    isVip = () => {
        console.log(this.items);

        if (this.items) {
            for (let item in this.items) {
                if (item.vip) {
                    return true;
                }
            }
        }
        return false;
    };
}
