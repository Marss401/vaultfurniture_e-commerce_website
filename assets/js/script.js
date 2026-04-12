let cartItems = JSON.parse(localStorage.getItem("vaultfurniture")) || [];

$(function () {
  if (window.location.search) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }
  // Handle any image preview
  $("#image").on("change", function () {
    const file = this.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    const data = new Promise((resolve, reject) => {
      reader.onload = () => resolve(reader.result);
      reader.onerror = (error) => reject(error);
    });
    data.then((data) =>
      $("#imagePreview").attr({ src: data, alt: "user_image" }),
    );
  });

  // global variable for navbar
  const $navbar = $("#navbar");

  // Navbar toggle
  $("#navbarToggle").on("click", function (e) {
    e.stopPropagation();
    $navbar.toggleClass("left-full");
    $navbar.toggleClass("left-0");
  });

  // Toggle profile menu
  $("#profileToggle").click(function (e) {
    e.stopPropagation(); // prevent bubbling
    $("#profileMenu").toggleClass("hidden");
  });

  // Close when clicking outside
  $(document).click(function (e) {
    if (!$(e.target).closest("#profileToggle, #profileMenu").length) {
      $("#profileMenu").addClass("hidden");
    }
  });

  // Close any modal
  $("#closeModal").on("click", function () {
    $(this).closest("dialog").hide();
    $(this).closest("form").trigger("reset");
  });

  //SideBar Toggle Class
  $("#siderBarToggle").on("click", function () {
    $("#sideBar").toggleClass("-translate-x-full w-0");
  });

  //Search button class
  $("#searchBtn").on("click", function () {
    const keyword = $("#searchInput").val().trim();
    const category = $("#searchCategory").val();

    if (!keyword) {
      swal("Please enter something to search");
      return;
    }
    window.location.href = `/vaultfurniture/search_product.php?search=${encodeURIComponent(keyword)}&category=${category}`;
  });
  //Search Logic
  $("#searchInput").on("keypress", function (e) {
    if (e.which === 13) {
      $("#searchBtn").click();
    }
  });

  //Signup Logic
  $("#signupForm").on("submit", function (e) {
    e.preventDefault();
    const dot = $("#role").val() === "user" ? "" : ".";

    const formData = new FormData(this);
    formData.append("trigger_signup", "1");

    $.ajax({
      type: "POST",
      url: `${dot}./api/auth.php`,
      contentType: false,
      processData: false,
      data: formData,
      success: (res) => {
        const data = JSON.parse(res);
        console.log(data);

        swal(data.message, { icon: data.error ? "error" : "success" });

        if (!data.error) {
          setTimeout(() => {
            window.location.replace(`${dot}./signin`);
          }, 1500);
        }
      },
      error: function (xhr) {
        console.log("RAW:", xhr.responseText);
      },
    });
    return false;
  });

  //Login Logic
  $("#signinForm").on("submit", function (e) {
    e.preventDefault();

    const email = $("#email").val(),
      password = $("#password").val();

    $.ajax({
      type: "POST",
      url: "./api/auth.php",
      //dataType: "json",
      data: { trigger_signin: true, email, password },
      success: (res) => {
        const data = JSON.parse(res);
        console.log(data);

        swal(data.message, { icon: data.error ? "error" : "success" });
        if (!data.error) {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1500);
        }
      },
      error: function (xhr) {
        console.log("RAW:", xhr.responseText);
      },
    });
    return false;
  });

  //Products logic
  $("#createProduct").on("click", function () {
    $("#productModal").show();
    const form = $("#productForm")[0];
     form.reset();
    $("#formTitle").html("New Product");
  });

  $("#productForm").on("submit", function () {
    const form = this;
    const button = $(this).find("button");
    const buttonText = button.text();

    $.ajax({
      type: "POST",
      url: "../api/product.php",
      processData: false,
      contentType: false,
      cache: false,
      data: new FormData(form),
      beforeSend: () => {
        button.text("Processing...");
        button.attr("disabled", true);
      },
      success: (res) => {
        button.text(buttonText);
        button.removeAttr("disabled");
        const data = JSON.parse(res);
        swal(data.message, { icon: data.error ? "error" : "success" });
        if (!data.error) {
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
    });
    return false;
  });
  //Products Edit Button
  $(".editProductBtn").on("click", function () {
    $("#productModal").show();
    const product = $(this).data("products");

    console.log(product); // always debug first

  $("#productId").val(product.id);
  $("#productAction").val("update");
  $("#oldImage").val(product.image);

  $("#name").val(product.product_name);
  $("#price").val(product.price);
  $("#qty_available").val(product.qty_available);
  $("#description").val(product.description);
  $("#status").val(product.status);
  $("#category").val(product.category_id);

  $("#imagePreview").attr("src", "../assets/images/products/" + product.image);

  $("#formTitle").html("Edit Product");
  });
  //Create Category Logic
  $("#createCategory").on("click", function () {
    $("#categoryModal").show();
    $("#formTitle").html("New Category");
    $("#categoryAction").val("create");
    $("#categoryForm")[0].reset();
  });

  $("#categoryForm").on("submit", function (e) {
    e.preventDefault();

    const form = this;
    const button = $(this).find("button");
    const buttonText = button.html();

    $.ajax({
      type: "POST",
      url: "../api/category.php",
      data: new FormData(form),
      processData: false,
      contentType: false,
      beforeSend: () => {
        button.html("Processing...");
        button.attr("disabled", true);
      },
      success: (res) => {
        button.html(buttonText);
        button.removeAttr("disabled");

        const data = JSON.parse(res);

        swal(data.message, {
          icon: data.error ? "error" : "success",
        });

        if (!data.error) {
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
    });
    return false;
  });

  //Category Edit Button
  $(".editCategoryBtn").on("click", function () {
  $("#categoryModal").show();
  const data = $(this).data("categories");
  console.log(data);

  $("#categoryId").val(data.id);
  $("#name").val(data.name);
  $("#categoryAction").val("update");
  $("#formTitle").html("Edit Category");

  });

  // Handle Edit User
  $("#userForm").on("submit", function () {
    const form = this;
    const button = $(this).find("button");
    const buttonText = button.val();

    $.ajax({
      type: "POST",
      url: "../api/user.php",
      processData: false,
      contentType: false,
      cache: false,
      data: new FormData(form),
      beforeSend: () => {
        button.val("Processing...");
        button.attr("disabled", true);
      },
      success: (res) => {
        button.val(buttonText);
        button.removeAttr("disabled");
        const data = JSON.parse(res);
        swal(data.message, { icon: data.error ? "error" : "success" });
        if (!data.error) {
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
    });
    return false;
  });

  //User Edit Button
  $(".editUserBtn").on("click", function () {
    $("#userModal").show();
    const user = $(this).data("users");
    console.log(user);
    $("#trigger_edit").val(user.id);
    $("#fullname").val(user.name);
    $("#email").val(user.email);
    $("#role").val(user.role);
    $("#formTitle").html("Edit User");
  });

    // Handle Edit Admin
  $("#adminForm").on("submit", function () {
    const form = this;
    const button = $(this).find("button");
    const buttonText = button.val();

    $.ajax({
      type: "POST",
      url: "../api/admin.php",
      processData: false,
      contentType: false,
      cache: false,
      data: new FormData(form),
      beforeSend: () => {
        button.val("Processing...");
        button.attr("disabled", true);
      },
      success: (res) => {
        button.val(buttonText);
        button.removeAttr("disabled");
        const data = JSON.parse(res);
        swal(data.message, { icon: data.error ? "error" : "success" });
        if (!data.error) {
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
    });
    return false;
  });

  //Admin Edit Button
  $(".editAdminBtn").on("click", function () {
    $("#adminModal").show();
    const user = $(this).data("users");
    console.log(user);
    $("#trigger_edit").val(user.id);
    $("#fullname").val(user.name);
    $("#email").val(user.email);
    $("#role").val(user.role);
    $("#formTitle").html("Edit Admin");
  });

  // Delete Button
  $(".deleteBtn").on("click", function () {
    const button = $(this);
    const id = $(this).data("id");
    const endPoint = $(this).data("page");
    swal({
      title: "Are you sure you want to delete this?",
      text: "Once deleted, you will not be able to recover this!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",
          url: `../api/${endPoint}`,
          // url: "../api/" + endPoint, // can also be written this way
          data: {
            trigger_delete: true,
            deleteId: id,
          },
          success: (res) => {
            const data = JSON.parse(res);
            swal(data.message, { icon: data.error ? "error" : "success" });
            if (!data.error) {
              button.closest("tr").remove();
            }
          },
        });
      } else {
        swal("Action cancelled!");
      }
    });
  });

  //Items logic to update the page

  $(".filter-btn").click(function () {
    let category = $(this).data("category");

    $.ajax({
      url: "./api/fetch_item.php",
      type: "POST",
      data: { category_id: category },
      success: function (res) {
        $("#products-container").html(res);
        // console.log(category);
        // loadProducts(true);
      },
    });
  });

  // SETTINGS PAGE
  $("#profileForm").on("submit", function () {
    const form = this;
    const button = $(this).find("button");
    const buttonText = button.val();
    $.ajax({
      type: "POST",
      url: "../api/setting.php",
      processData: false,
      cache: false,
      contentType: false,
      data: new FormData(form),
      beforeSend: () => {
        button.attr("disabled", true);
        button.val("Processing...");
      },
      success: (res) => {
        button.val(buttonText);
        button.removeAttr("disabled");
        const data = JSON.parse(res);
        swal(data.message, { icon: data.error ? "error" : "success" });
        if (!data.error) {
          setTimeout(() => {
            location.reload();
          }, 1500);
        }
      },
    });
    return false;
  });

  $(".accordion-header").click(function () {
    const parent = $(this).closest(".accordion-item");
    const content = parent.find(".accordion-content");
    const icon = $(this).find(".toggle-icon");

    // Close all others
    $(".accordion-content").not(content).slideUp(200);
    $(".toggle-icon").not(icon).text("+");

    // Toggle current
    content.slideToggle(200);

    // Toggle icon
    if (icon.text() === "+") {
      icon.html(`<i class="fa-solid fa-xmark"></i>`);
    } else {
      icon.html(`<i class="fa-solid fa-plus"></i>`);
    }
  });

  //Add to Cart
  $(".cartBtn").on("click", function (e) {
    e.preventDefault();

    const data = $(this).data("product");
    console.log(data);

    //Check if item exist
    const findProduct = cartItems.find((el) => el.id === data.id);
    if (findProduct) {
      swal("Duplicate Order", "Product already in cart", { icon: "error" });
    } else {
      const product = {
        id: data.id,
        name: data.name,
        image: data.image,
        price: data.price,
        qty: 1,
        qty_available: data.qty_available,
      };
      cartItems.unshift(product);
      $(".cartTotal").html(cartItems.length);
      localStorage.setItem("vaultfurniture", JSON.stringify(cartItems));
      swal("Order Successful", "Product added to cart successfully", {
        icon: "success",
      });
      toggleCartBtnVisibility(data.id);
    }
  });
      // ORDERS PAGE
    $(".viewOrderBtn").on("click", function () {
        const data = $(this).data("order");
        $("#orderModal").show()
        // console.log({data})
        $("#order_status").html(data.order_status)
        $(".orderContainer").html(`
            <input type="hidden" id="order_id" value="${data.order_id}">
            <div class="flex items-center gap-4">
                <figure class="relative h-20 w-20 mx-auto block flex-shrink-0 bg-slate-200 rounded-md">
                    <img id="imagePreview" src="../assets/images/profile/${data.user_image}" alt="user_image" class="absolute top-0 left-0 w-full h-full object-cover object-center">
                </figure>
                <div class="flex-1 flex flex-col divide-y divide-slate-200 justify-center text-slate-400">
                    <p class="flex items-center gap-2 text-sm p-1"><span class="w-16 text-xs font-semibold">Full Name:</span> ${data.user_name}</p>
                    <p class="flex items-center gap-2 text-sm p-1"><span class="w-16 text-xs font-semibold">Email:</span> ${data.user_email}</p>
                </div>
            </div>
            <div class="flex-1 flex flex-col mt-1 divide-y divide-slate-200 justify-center text-slate-400 border-y border-slate-200">
                <p class="flex items-center justify-between gap-2 text-sm p-1"><span class="w-20 text-xs font-semibold">Address:</span> ${data.order_destination}</p>
                <p class="flex items-center justify-between gap-2 text-sm p-1"><span class="w-20 text-xs font-semibold">Total Items:</span> ${data.total_orders}</p>
                <p class="flex items-center justify-between gap-2 text-sm p-1"><span class="w-20 text-xs font-semibold">Total Price:</span> &#8358;${data.total_price.toLocaleString()}</p>
                <p class="flex items-center justify-between gap-2 text-sm p-1"><span class="w-20 text-xs font-semibold">Date Ordered:</span> ${data.order_date}</p>
            </div>    
        `)
    })

    $("#orderForm").on("submit", function () {
        const status = $("#status").val()
        const id = $("#order_id").val()
        swal({
            title: `Are you sure you want to update to ${status}?`,
            text: `Once updated, the customer would get an email!`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(willChange => {
            if (willChange) {
                $.ajax({
                    type: "POST",
                    url: `../api/placeorder.php`,
                    // url: "../api/" + endPoint, // can also be written this way
                    data: {
                        trigger_status: true,
                        orderId: id,
                        status
                    },
                    success: (res) => {
                        const data = JSON.parse(res)
                        swal(data.message, { icon: data.error ? "error" : "success" })
                        if (!data.error) {
                            location.reload()
                        }
                    }
                })
            }
            else {
                swal("Action cancelled!");
            }
        })
        return false;
    })

  //CHECKOUT PAGE
  $("#checkoutForm").on("submit", function(e){
    e.preventDefault();
    // const total = cartItems.reduce((oldValue, el) => (el.price * el.qty_available) + oldValue, 0), email = $("#email").val()
    //         let handler = PaystackPop.setup({
    //             key: 'pk_test_5d993f12d6b0ee3955a3c2f4698227130872216d', // Replace with your public key
    //             email: email,
    //             amount: amount * 100,
    //             ref: 'RwS'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    //             // label: "Optional string that replaces customer email"
    //             onClose: function(){
    //                 swal('Payment Cancelled!', 'Your payment request has been stopped');
    //             },
    //             callback: function(response){
    //                 location.href = `http://localhost/vaultfurniture/verify?reference=${response.reference}&email=${email}&amount=${amount};`
    //                 let message = 'Payment complete! Reference: ' + response.reference;
    //             },

    //         });
    //         handler.openIframe();

        const location = $("#location").val()
        const button = $(this).find("button")
        const buttonText = button.val()
        const form = $(this);
        if(cartItems.length < 1) {
            swal("You have no item in your cart", { icon: "error" })
            return false;
        }
        $.ajax({
            type: "POST",
            url: "./api/placeorder.php",
            data: {
                trigger_order: true,
                location,
                cartItems: JSON.stringify(cartItems),
            },
            beforeSend: () => {
                button.attr("disabled", true)
                button.val("Processing...")
            },
            success: res => {
                button.removeAttr("disabled")
                button.val(buttonText)
                const data = JSON.parse(res)
                swal(data.message, { icon: data.error ? "error" : "success" })
                if (!data?.error) {
                    $(".cartTotal").html(0)
                    localStorage.removeItem("vaultfurniture") // remove cart history from localStorage
                    showCartContent([]) // Reset cart view in the browser/UI
                    showCheckoutContent([]) // Reset checkout view in the browser/UI
                    form[0].reset() // Reset Checkout Form
                    setTimeout(() => {
                        location.href = "../dashboard/orders"
                    }, 1500);
                }
            }
        })
        return false;
    });
     // CONTACT PAGE
    $("#contactForm").on("submit", function () {
        const fullname = $("#fullname").val()
        const email = $("#email").val()
        const phone = $("#phone").val()
        const message = $("#message").val()
        const button = $(this).find("button")
        const buttonText = button.html()
        const form = $(this);
        $.ajax({
            type: "POST",
            url: "./api/contact.php",
            data: {
                trigger_contact: true,
                fullname, email, phone: "0" + phone, message
            },
            beforeSend: () => {
                button.toggleClass("opacity-80")
                button.attr("disabled", "true")
                button.html(`<span class='animate-spin border-2 border-white border-r-transparent rounded-full h-4 w-4 grid place-items-center flex-shrink-0'></span> Loading...`)
            },
            success: res => {
                button.removeAttr("disabled")
                button.toggleClass("opacity-80")
                button.val(buttonText)
                const data = JSON.parse(res)
                swal(data.message, { icon: data.error ? "error" : "success" })
                form[0].reset() // Reset/Empty Contact Form
            }
        })
        return false;
    })
});



// Handle Cart Change
function handleCartChange(input, id) {
  const value = input.value;
  cartItems.forEach((el, i) => {
    if (el.id == id) {
      cartItems[i].qty = value;
      input.value = value;
    }
  });
  showCartContent(cartItems);
}
// Remove from Cart
function removeFromCart(id) {
  cartItems.forEach((el, i) => {
    if (el.id.toString() === id.toString()) cartItems.splice(i, 1);
  });
  showCartContent(cartItems);
}

// Show Cart Preview
showCartContent(cartItems);

//Increment button
$(document).on("click", ".cartPlus", function () {
  const container = $(this).closest(".btnContainer");
  const input = container.find(".input_qty");

  let value = parseInt(input.val()) || 1;
  const max = parseInt(input.attr("max"));
  const id = input.data("id");

  if (value < max) {
    value++;
    input.val(value);
    console.log(input[0], input.val(), id);
    handleCartChange(input[0], id);
  }
});

//Decrement button
$(document).on("click", ".cartMinus", function () {
  const container = $(this).closest(".btnContainer");
  const input = container.find(".input_qty");

  let value = parseInt(input.val()) || 1;
  const id = input.data("id");

  if (value > 1) {
    value--;
    input.val(value);
    console.log(input[0], input.val(), id);
    handleCartChange(input[0], id);
  }
});

//Cart content dynamic Logic
function showCartContent(items) {
  $(".cartContainer").empty();
  items.map((el) => {
    $(".cartContainer").append(`
        <aside class="py-4 px-2 md:px-4 flex gap-2 text-text bg-white my-1 shadow-xl">
            <a href="./single_product.php?id=${el.id}" class="flex gap-2 items-center text-text bg-primary flex-1">
                <figure class="w-12 sm:w-14 md:w-16 rounded-sm overflow-hidden bg-primary shrink-0">
                    <img src="./assets/images/products/${el.image}" alt="${el.name}" class="w-full h-full left-0 top-0 object-cover" />
                </figure>
                <div class="relative py-2 flex-1">
                <h3 class="text-dark-text text-sm md:text-base font-medium">${el.name}</h3>
                <p class="text-primary text-xs font-medium">&#8358;${el.price.toLocaleString()}</p>
                </div>
            </a>
            <div class="relative space-y-1 flex-1">
            <button onclick="removeFromCart('${el.id}')" class="cursor-pointer mt-2 text-text text-xs font-medium p-2 bg-[#f66] text-primary rounded-md border leading-2 flex items-center gap-2">
                    <i class="fa-regular fa-trash-can"></i> Remove
                </button>
                <div class="flex gap-2 mb-4 btnContainer">
                  <button class="cartMinus h-8 w-8 rounded-md grid place-items-center cursor-pointer text-slate-500 bg-primary hover:bg-gray-200 hover:text-white text-lg border border-gray-300">-</button>
                    <div class="overflow-hidden w-10 border border-slate-300 rounded-md">
                      <input data-id="${el.id}" type="number" value="${el.qty}" min="1" max="${el.qty_available}" readonly class="cartQty input_qty h-8 w-16 pl-2.5 rounded-md bg-white outline-none text-slate-500">
                    </div>
                  <button class="cartPlus h-8 w-8 rounded-md grid place-items-center cursor-pointer text-slate-500 bg-primary hover:bg-gray-200 hover:text-white text-lg border border-gray-300">+</button>
                </div>
            </div>
            <p class="cartPrice text-dark-text text-sm text-right font-semibold flex-1">&#8358;${(el.qty * el.price).toLocaleString()}  </p>
        </aside>
        `);
  });
  const grandTotal = items.reduce(
    (oldTotal, el) => el.price * el.qty + oldTotal,
    0,
  );
  const discount = (20 / 100) * grandTotal; // 20%
  const finalTotal = grandTotal - discount;

  $(".cartGrandTotal").html(`&#8358;${grandTotal.toLocaleString()}`);
  $(".cartDiscountTotal").html(`&#8358;${discount.toLocaleString()}`);
  $(".cartFinalTotal").html(`&#8358;${finalTotal.toLocaleString()}`);
  $(".cartTotal").html(cartItems.length); // To update the cart total shown in the header and above the cart items layout (in the cart.php page)
  localStorage.setItem("vaultfurniture", JSON.stringify(items));
}

// Handle Cart Button Visiblity
function toggleCartBtnVisibility(id) {
  $(".btnContainer").removeClass("hidden");
  const findFood = cartItems.find((el) => el.id === id);
  if (!findFood) {
    $(".btnContainer").toggleClass("hidden");
  } else {
    $(".cartQty").val(findFood.qty);
    $(".cartSingleBtn").toggleClass("hidden");
  }
}

// Show Checkout Contents
function showCheckoutContent(items) {
    $(".checkoutContainer").empty();
    items.map(el => {
        $(".checkoutContainer").append(`
        <figure class="py-4 px-2 md:px-4 flex gap-2 text-text bg-white my-1 shadow-xl">
            <div class="w-12 sm:w-14 md:w-16 rounded-sm overflow-hidden bg-primary">
                <img src="./assets/images/products/${el.image}" alt="${el.name}" class="w-full h-full left-0 top-0 object-cover" />
            </div>
            <div class="relative py-2 flex-1">
            <h3 class="text-dark-text text-sm md:text-base font-medium">${el.name}</h3>
            <p class="text-slate-500 text-xs font-medium">&#8358;${el.price.toLocaleString()} x (${el.qty})</p>
            </div>
            <p class="cartPrice text-slate-500 text-sm text-right font-semibold flex-1">&#8358;${(el.qty * el.price).toLocaleString()}  </p>
        </figure>
        `)
    })
    const grandTotal = items.reduce((oldTotal, el) => el.price * el.qty + oldTotal, 0)
    const discount = ((20 / 100) * grandTotal) // 20%
    const finalTotal = (grandTotal - discount)

    $(".cartFinalTotal").html(`&#8358;${finalTotal.toLocaleString()}`)
    $(".cartTotal").html(cartItems.length) // To update the cart total shown in the header and above the cart items layout (in the cart.php page)
    localStorage.setItem("vaultfurniture", JSON.stringify(items))
}
showCheckoutContent(cartItems)
