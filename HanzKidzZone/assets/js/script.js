const cartCount =
document.getElementById("cart-count");

const productsContainer =
document.getElementById("products");

const cartItems =
document.getElementById("cart-items");

const totalPrice =
document.getElementById("total-price");

const categoryButtonsContainer =
document.getElementById("category-buttons");

let cart = [];

let allProducts = [];

let selectedCategory = "All";

// SAVE CART
function saveCart(){

    localStorage.setItem(
        "cart",
        JSON.stringify(cart)
    );
}

// LOAD CART
function loadCart(){

    const savedCart =
    localStorage.getItem("cart");

    if(savedCart){

        cart = JSON.parse(savedCart);

    }else{

        cart = [];
    }
}

// LOAD PRODUCTS
async function loadProducts(){

    try{

        const response =
        await fetch(
            "products/getProducts.php"
        );

        const products =
        await response.json();

        allProducts = products;

        renderCategoryButtons();

        renderProducts(products);

        renderCart();

    }catch(error){

        console.error(
            "Failed to load products:",
            error
        );
    }
}

// RENDER PRODUCTS
function renderProducts(products){

    if(!productsContainer){

        return;
    }

    productsContainer.innerHTML = "";

    if(products.length === 0){

        productsContainer.innerHTML =

        `<p>No products found.</p>`;

        return;
    }

    products.forEach(product => {

        productsContainer.innerHTML += `

            <div class="card">

                <img
                src="${product.image}"
                alt="${product.name}">

                <h3>${product.name}</h3>

                <p>$${Number(product.price).toFixed(2)}</p>

                <button
                onclick="addToCart(${product.id})">

                    Add To Cart

                </button>

            </div>

        `;
    });
}

// ADD TO CART
function addToCart(productId){

    const existingProduct =

    cart.find(
        item => item.id == productId
    );

    if(existingProduct){

        existingProduct.quantity += 1;

    }else{

        cart.push({

            id: productId,

            quantity: 1
        });
    }

    saveCart();

    renderCart();

    alert("Product Added To Cart");
}

// REMOVE ITEM
function removeFromCart(index){

    cart.splice(index,1);

    saveCart();

    renderCart();
}

// INCREASE QUANTITY
function increaseQuantity(index){

    cart[index].quantity += 1;

    saveCart();

    renderCart();
}

// DECREASE QUANTITY
function decreaseQuantity(index){

    cart[index].quantity -= 1;

    if(cart[index].quantity <= 0){

        cart.splice(index,1);
    }

    saveCart();

    renderCart();
}

// RENDER CART
function renderCart(){

    if(!cartItems || !totalPrice){

        return;
    }

    cartItems.innerHTML = "";

    let total = 0;

    cart.forEach((cartItem,index)=>{

        const product =
        allProducts.find(
            p => p.id == cartItem.id
        );

        if(!product){

            return;
        }

        const itemTotal =

        Number(product.price)
        *
        cartItem.quantity;

        total += itemTotal;

        cartItems.innerHTML += `

            <div class="cart-item">

                <span>

                    ${product.name}

                    (${cartItem.quantity})

                    - $

                    ${itemTotal.toFixed(2)}

                </span>

                <div class="cart-buttons">

                    <button
                    onclick="increaseQuantity(${index})">

                        +

                    </button>

                    <button
                    onclick="decreaseQuantity(${index})">

                        -

                    </button>

                    <button
                    class="remove-btn"
                    onclick="removeFromCart(${index})">

                        Remove

                    </button>

                </div>

            </div>

        `;
    });

    totalPrice.innerText =

    "Total: $" +
    total.toFixed(2);

    if(cartCount){

        cartCount.innerText =

        cart.reduce(
            (total,item)=>

            total + item.quantity,

            0
        );
    }
}

// GET CATEGORIES
function getCategories(){

    const categories =

    new Set(

        allProducts.map(product => {

            const category =

            (
                product.category || ""
            ).trim();

            return category ||

            "Uncategorized";
        })
    );

    return [

        "All",

        ...categories
    ];
}

// RENDER CATEGORY BUTTONS
function renderCategoryButtons(){

    if(!categoryButtonsContainer){

        return;
    }

    const categories =
    getCategories();

    categoryButtonsContainer.innerHTML = "";

    categories.forEach(category => {

        const button =
        document.createElement("button");

        button.type = "button";

        button.className =
        "category-btn";

        if(
            category ===
            selectedCategory
        ){

            button.classList.add(
                "active"
            );
        }

        button.textContent =
        category;

        button.addEventListener(
            "click",
            () => {

                selectedCategory =
                category;

                updateCategoryButtons();

                applyFilters();
            }
        );

        categoryButtonsContainer
        .appendChild(button);
    });
}

// UPDATE CATEGORY BUTTONS
function updateCategoryButtons(){

    document
    .querySelectorAll(
        ".category-btn"
    )
    .forEach(button => {

        button.classList.toggle(

            "active",

            button.textContent ===
            selectedCategory
        );
    });
}

// APPLY FILTERS
function applyFilters(){

    const searchInput =

    document.getElementById(
        "search-input"
    );

    let searchValue = "";

    if(searchInput){

        searchValue =

        searchInput.value
        .toLowerCase();
    }

    const filteredByCategory =

    selectedCategory === "All"

    ?

    allProducts

    :

    allProducts.filter(product =>

        product.category ===
        selectedCategory
    );

    const filteredProducts =

    filteredByCategory.filter(
        product =>

        product.name
        .toLowerCase()
        .includes(searchValue)
    );

    renderProducts(
        filteredProducts
    );
}

// SEARCH PRODUCTS
function searchProducts(){

    applyFilters();
}

// CHECKOUT
async function checkout(){

    if(cart.length === 0){

        alert("Cart is Empty");

        return;
    }

    try{

        const response =

        await fetch(
            "checkout.php",
            {
                method:"POST",

                headers:{
                    "Content-Type":
                    "application/json"
                },

                body:JSON.stringify({

                    cart: cart
                })
            }
        );

        const result =
        await response.text();

        console.log(result);

        alert(result);

        if(

            result
            .toLowerCase()
            .includes(
                "order placed"
            )
        ){

            cart = [];

            saveCart();

            renderCart();
        }

    }catch(error){

        console.error(error);

        alert(
            "Checkout Failed"
        );
    }
}

// START
document.addEventListener(
    "DOMContentLoaded",
    () => {

        loadCart();

        loadProducts();

        const checkoutBtn =

        document.getElementById(
            "checkout-btn"
        );

        if(checkoutBtn){

            checkoutBtn.addEventListener(
                "click",
                checkout
            );
        }
    }
);