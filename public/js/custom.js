// load the map in the services page
function loadServiceMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                // on success
                let pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                let mapDiv = document.getElementById("servicesMap");
                if (mapDiv !== null) {
                    let infowindow = new google.maps.InfoWindow();
                    let map = new google.maps.Map(mapDiv, {
                        zoom: 9,
                        center: pos
                    });
                    let marker = new google.maps.Marker({
                        position: pos,
                        map,
                        title: "Your Location",
                        label: "Your Location"
                    });
                    infowindow.setContent("Your Location");
                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                }
            },
            err => {
                // on error
                console.log(err);
            },
            { enableHighAccuracy: true } // options
        );
    } else {
        $.notify(
            {
                message: "Geolocation is not enabled!"
            },
            { type: "warning" }
        );
    }
}

$(document).ready(function() {
    // add event listeners to the location in the add services page of the admin page
    google.maps.event.addDomListener(window, "load", () => {
        let search_address = new google.maps.places.Autocomplete(
            document.getElementById("search_address")
        );
        // a callback function can be added the following line if you want
        // to extract the formatted adress and the names and the geometry
        google.maps.event.addListener(search_address, "place_changed");
    });

    // add markers to client service page
    function addMarkersToServiceMap({ lat, lng, map, m, pos }) {
        // add marker to point at the location of the service
        let marker = new google.maps.Marker({
            position: { lat, lng },
            map
        });
        let origin = new google.maps.LatLng(pos.lat, pos.lng);
        let destination = m.address;
        let service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
            {
                origins: [origin],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet
                // unitSystem: google.maps.UnitSystem.metric, // miles and feet
                avoidHighways: false,
                avoidTolls: false
            },
            callback
        );
        // get distance results
        function callback(response, status) {
            if (status != google.maps.DistanceMatrixStatus.OK) {
                $.notify(
                    {
                        message:
                            "<i class='fa fa-exclamation-circle'></i> Could not get Distance Results!"
                    },
                    { type: "danger" }
                );
            } else {
                if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                    $.notify(
                        {
                            message:
                                "<i class='fa fa-exclamation-circle'></i> Distance Results Unavailable!"
                        },
                        { type: "danger" }
                    );
                } else {
                    let distance = response.rows[0].elements[0].distance;
                    let duration = response.rows[0].elements[0].duration;
                    let distance_in_kilo = distance.value / 1000;
                    let distance_in_mile = distance.value / 1609.34;
                    let distance_text = distance.text;
                    let duration_text = duration.text;
                    // add info window
                    let infowindow = new google.maps.InfoWindow({
                        content: `
                            <h4>${m.address}</h4>
                            <br />
                            <strong>Details</strong>
                            <h5>Distance in Miles: <strong style="float: right;">${distance_in_mile.toFixed(
                                2
                            )}</strong></h5>
                            <h5>Distance in Kilometers: <strong style="float: right;">${distance_in_kilo.toFixed(
                                2
                            )}</strong></h5>
                            <h5>Distance: <strong style="float: right;">${distance_text}</strong></h5>
                            <h5>Duration: <strong style="float: right;">${duration_text}</strong></h5>
                            <h5>FROM: <strong style="float: right;">${
                                response.originAddresses[0]
                            }</strong></h5>
                            <h5>TO: <strong style="float: right;">${
                                m.address
                            }</strong></h5>
                        `
                    });
                    // click event for the marker
                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                }
            }
        }
    }

    // select a service in the client service page
    $("#select-service").on("change", function() {
        let ser_id = $(this).val();
        if (ser_id === "0") {
            $.notify(
                {
                    message:
                        "<i class='fa fa-exclamation-circle'></i> Select a Service!"
                },
                { type: "danger" }
            );
            return;
        }
        axios
            .get(`http://localhost:8000/users/service/getServices/${ser_id}`)
            .then(res => {
                let { isCompleted, msg } = res.data;
                if (isCompleted) {
                    if (msg.length === 0) {
                        $.notify(
                            {
                                message:
                                    "<i class='fa fa-exclamation-circle'></i> Selected Service Unavailable!"
                            },
                            { type: "danger" }
                        );
                        return;
                    }
                    // set the services to the other select input
                    let select = $("#select-service-names");
                    select
                        .empty()
                        .append(
                            '<option value="0" selected="selected">Chose...</option>'
                        );
                    msg.forEach(m => {
                        option = document.createElement("option");
                        option.value = option.text = m.address;
                        if (m.category === 3) {
                            option.text += ` - ${m.description}`;
                        }
                        select.append(option);
                    });
                    document.getElementById("service-div").style.display =
                        "block";
                    switch (ser_id) {
                        case "1":
                            $("#service-name").text("Fuel Station");
                            break;
                        case "2":
                            $("#service-name").text("Hospital");
                            break;
                        case "3":
                            $("#service-name").text("Mechanic");
                            break;
                        case "4":
                            $("#service-name").text("Police Station");
                            break;
                        default:
                            $("#service-name").text("Towing Van");
                            break;
                    }

                    // start adding the services as markers to the map
                    let options = {
                        zoom: 5,
                        center: { lat: 6.2209, lng: 6.937 }
                        // draggable: false
                    };
                    let map = new google.maps.Map(
                        document.getElementById("servicesMap"),
                        options
                    );
                    // set your location marker in the service map as well
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            // on success
                            let pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            if (
                                document.getElementById("servicesMap") !== null
                            ) {
                                let infowindow = new google.maps.InfoWindow();
                                let marker = new google.maps.Marker({
                                    position: pos,
                                    map,
                                    title: "Your Location",
                                    label: "Your Location"
                                });
                                infowindow.setContent("Your Location");
                                marker.addListener("click", () => {
                                    infowindow.open(map, marker);
                                });
                                // msg is the array of services
                                // loop through th msg and display the markers on the map
                                msg.forEach(m => {
                                    let location = m.address;
                                    axios
                                        .get(
                                            "https://maps.googleapis.com/maps/api/geocode/json",
                                            {
                                                params: {
                                                    address: location,
                                                    key:
                                                        "YOUR_API_KEY_HERE"
                                                }
                                            }
                                        )
                                        .then(res => {
                                            // res gives the whole data about the address from the map
                                            // now lets get the latitude and longitude of the location
                                            // so as to put a marker on the map to be displayed!
                                            let lat =
                                                res.data.results[0].geometry
                                                    .location.lat;
                                            let lng =
                                                res.data.results[0].geometry
                                                    .location.lng;
                                            addMarkersToServiceMap({
                                                lat,
                                                lng,
                                                map,
                                                m,
                                                pos
                                            });
                                        })
                                        .catch(err => {
                                            $.notify(
                                                {
                                                    message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                                                },
                                                { type: "danger" }
                                            );
                                        });
                                });
                            }
                        },
                        err => {
                            // on error
                            console.log(err);
                        },
                        { enableHighAccuracy: true } // options
                    );
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // select service to get the direction
    $("#select-service-names").on("change", function() {
        let ser_name = $(this).val();
        if (ser_name === "0") {
            $.notify(
                {
                    message:
                        "<i class='fa fa-exclamation-circle'></i> Please select a service!"
                },
                { type: "danger" }
            );
            return;
        }
        axios
            .get("https://maps.googleapis.com/maps/api/geocode/json", {
                params: {
                    address: ser_name,
                    key: "YOUR_API_KEY_HERE"
                }
            })
            .then(res => {
                // res gives the whole data about the address from the map
                // now lets get the latitude and longitude of the location
                // so as to put a marker on the map to be displayed!
                let des_pos = {
                    lat: res.data.results[0].geometry.location.lat,
                    lng: res.data.results[0].geometry.location.lng
                };
                navigator.geolocation.getCurrentPosition(position => {
                    // on success
                    let my_pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    init_directions_map(des_pos, my_pos);
                });
            });
    });

    // init directions map
    function init_directions_map(des_pos, my_pos) {
        let options = {
            zoom: 5,
            center: my_pos
        };
        let directionsMap = new google.maps.Map(
            document.getElementById("servicesMap"),
            options
        );
        let directionService = new google.maps.DirectionsService();
        let directionRenderer = new google.maps.DirectionsRenderer();
        directionRenderer.setMap(directionsMap);

        let request = {
            origin: my_pos,
            destination: des_pos,
            travelMode: google.maps.TravelMode.DRIVING,
            drivingOptions: {
                departureTime: new Date(Date.now()), // for the time N milliseconds from now.
                trafficModel: "pessimistic"
            },
            unitSystem: google.maps.UnitSystem.METRIC
        };
        directionService.route(request, function(response, status) {
            if (status === "OK") {
                directionRenderer.setDirections(response);
                console.log(response);
                const route = response.routes[0];
                let summaryPanel = "";

                // For each route, display summary information.
                for (let i = 0; i < route.legs.length; i++) {
                    const routeSegment = i + 1;
                    summaryPanel +=
                        "<b>Route Segment: " + routeSegment + "</b><br>";
                    summaryPanel += route.legs[i].start_address + " to ";
                    summaryPanel += route.legs[i].end_address + "<br>";
                    summaryPanel += route.legs[i].distance.text + "<br><br>";
                }
                console.log(summaryPanel);
            } else {
                $.notify(
                    {
                        message:
                            "<i class='fa fa-exclamation-circle'></i> Could not get directions!"
                    },
                    { type: "danger" }
                );
            }
        });
    }

    // set the javascript trigger for the tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //Initialize Select2 Elements
    $(".select2").select2();

    // delete products
    $(".delete-prds").on("click", function() {
        let id = $(this).attr("d-id");
        $.notify(
            {
                message: "Deleting..."
            },
            { type: "info" }
        );
        $.ajax({
            method: "DELETE",
            url: `http://localhost:8000/admin/products/${id}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: data => {
                let { isCompleted, msg } = data;
                if (isCompleted) {
                    $.notify(
                        {
                            message: msg
                        },
                        { type: "success" }
                    );
                    window.location = "http://localhost:8000/admin/products";
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            },
            error: err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            }
        });
    });

    // prevent the cart dropdown menu from closing when clicked on
    $("#hold").on("click", function(e) {
        e.stopPropagation();
    });

    // proceed to paymeent
    $("#btnConfirmOrder").on("click", function() {
        const items = JSON.parse(localStorage.getItem("items"));
        if (items.length === 0) {
            $.notify(
                {
                    message:
                        "<i class='fa fa-exclamation-circle'></i> Sorry, your cart is empty!"
                },
                { type: "danger" }
            );
            return;
        }
        axios
            .post("http://localhost:8000/shopping/confirmOrder", {
                items: JSON.stringify(items)
            })
            .then(res => {
                let { isCompleted, msg } = res.data;
                if (isCompleted) {
                    $.notify(
                        {
                            message: `<i class='fa fa-check-circle'></i> ${msg}`
                        },
                        { type: "success" }
                    );
                    while (items.length) {
                        items.pop();
                    }
                    localStorage.setItem("items", JSON.stringify(items));
                    location.assign("/shopping/orders");
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // change order status
    $(".ord-status").on("change", function() {
        $oid = $(this).attr("oid");
        $status = $(this).val();
        axios
            .post("http://localhost:8000/admin/orders/status/update", {
                oid: $oid,
                status: $status
            })
            .then(res => {
                let { isCompleted, msg } = res.data;
                if (isCompleted) {
                    $.notify(
                        {
                            message: `<i class='fa fa-check-circle'></i> ${msg}`
                        },
                        { type: "success" }
                    );
                    location.reload();
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // delete user order
    $(".delete-order").on("click", function() {
        $id = $(this).attr("o-id");
        axios
            .delete(`http://localhost:8000/users/orders/destroy/${$id}`)
            .then(res => {
                let { isCompleted, msg } = res.data;
                if (isCompleted) {
                    $.notify(
                        {
                            message: `<i class='fa fa-check-circle'></i> ${msg}`
                        },
                        { type: "success" }
                    );
                    location.reload();
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // load items to cart
    function loadCart() {
        let storedItems = JSON.parse(localStorage.getItem("items"));
        let items = ``;
        $(".num_of_items_in_cart").text(storedItems.length);
        storedItems.forEach((item, index) => {
            items += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <img class="img-responsive img-rounded" style="height: 25px; width: 35px; display: initial;" src="${
                            location.origin
                        }/storage/productImages/${
                item.image
            }" alt="Product Image">
                        <span>${item.name}</span>
                    </td>
                    <td>${item.reqQty}</td>
                    <td>
                        <span>&#8358</span> ${item.price}
                    </td>
                    <td>
                        <button user-id="{{ Auth::id() }}" class="btn btn-xs btn-warning btn-decr-qty" product-id="${
                            item.id
                        }">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button user-id="{{ Auth::id() }}" class="btn btn-xs btn-success btn-incr-qty" product-id="${
                            item.id
                        }">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        let html = `
            <li>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${items}
                        </tbody>
                    </table>
                </div>
            </li>
            <li class="footer">
                <a href="${location.origin}/shopping/cart" target="_blank">View All</a>
            </li>
        `;
        let hold = document.getElementById("hold");
        if (hold !== null) {
            hold.innerHTML = html;
        }
    }

    // load the cart on page load
    if (
        localStorage.getItem("items") === null ||
        JSON.parse(localStorage.getItem("items")).length === 0
    ) {
        let html = `
            <li class="header text-center">
                <span class="text-danger">Your cart is empty!</span>
                <a href="${location.origin}/shopping/products" class="btn btn-default">Start Shopping</a>
            </li>
            <li class="footer">
                <a href="${location.origin}/shopping/cart" target="_blank">View All</a>
            </li>
        `;
        $(".num_of_items_in_cart").text("0");
        if (document.getElementById("hold") !== null)
            document.getElementById("hold").innerHTML = html;
    } else {
        loadCart();
    }

    // add product to cart
    $("#add-to-cart").on("click", function() {
        let product_id = $(this).attr("product-id");
        $.notify(
            {
                message: "Loading..."
            },
            { type: "info" }
        );
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
        axios
            .get(`http://localhost:8000/shopping/products/get/${product_id}`)
            .then(res => {
                let { isCompleted, product } = res.data;
                if (isCompleted) {
                    let items = []; // items to be pushed to local storage
                    product.reqQty = 1;
                    // add this item as an array to local storage if the key is null
                    if (localStorage.getItem("items") === null) {
                        items.push(product);
                        localStorage.setItem("items", JSON.stringify(items));
                    } else {
                        // get the stored items in local storage and push to the
                        // array if the key is not null
                        let storedItems = JSON.parse(
                            localStorage.getItem("items")
                        );
                        storedItems.push(product);
                        localStorage.setItem(
                            "items",
                            JSON.stringify(storedItems)
                        );
                    }
                    document.getElementById("hold").innerHTML = "";
                    $.notify(
                        {
                            message: `${product.name} added to shoping cart!`
                        },
                        { type: "success" }
                    );
                    $(this).html("<i class='fa fa-cart-plus'></i> Add to Cart");
                    // loadCart();
                    window.location.assign(
                        `${location.origin}/shopping/products/${product.slug}`
                    );
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // increase the quantity of an item in the cart
    $(".btn-incr-qty").on("click", function() {
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
        let item_id = $(this).attr("product-id");
        const items = JSON.parse(localStorage.getItem("items"));
        const thisItem = items.filter(item => item.id === parseInt(item_id));
        if (thisItem.length === 0) {
            $.notify(
                {
                    message:
                        "<i class='fa fa-exclamation-circle'></i> Item not found in cart!"
                },
                { type: "danger" }
            );
            $(this).html("<i class='fa fa-plus'></i>");
        } else {
            if (thisItem[0].reqQty + 1 > thisItem[0].quantity) {
                $.notify(
                    {
                        message:
                            "<i class='fa fa-exclamation-circle'></i> Item out of stock!"
                    },
                    { type: "danger" }
                );
                $(this).html("<i class='fa fa-plus'></i>");
            } else {
                thisItem[0].reqQty += 1;
                // save the items to local storage again after incrementing the quantity of this item
                localStorage.setItem("items", JSON.stringify(items));
                $(this).html("<i class='fa fa-plus'></i>");
                location.reload();
            }
        }
    });

    // decrease the quantity of an item in the cart
    $(".btn-decr-qty").on("click", function() {
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
        let item_id = $(this).attr("product-id");
        const items = JSON.parse(localStorage.getItem("items"));
        const thisItem = items.filter(item => item.id === parseInt(item_id));
        if (thisItem.length === 0) {
            $.notify(
                {
                    message:
                        "<i class='fa fa-exclamation-circle'></i> Item not found in cart!"
                },
                { type: "danger" }
            );
            $(this).html("<i class='fa fa-minus'></i>");
        } else {
            if (thisItem[0].reqQty === 1) {
                const otherItems = items.filter(
                    item => item.id !== parseInt(item_id)
                );
                localStorage.setItem("items", JSON.stringify(otherItems));
            } else {
                thisItem[0].reqQty -= 1;
                // save the items to local storage again after decrementing the quantity of this item
                localStorage.setItem("items", JSON.stringify(items));
            }
            $(this).html("<i class='fa fa-minus'></i>");
            location.reload();
        }
    });

    // remove item from cart
    $(".btn-remove-item").on("click", function() {
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
        let item_id = $(this).attr("product-id");
        const items = JSON.parse(localStorage.getItem("items"));
        const otherItems = items.filter(item => item.id !== parseInt(item_id));
        localStorage.setItem("items", JSON.stringify(otherItems));
        $(this).html("<i class='fa fa-trash'></i>");
        location.reload();
    });

    // initialize the map in the view services page of the admin side
    function initMap(lat, lng, location) {
        let options = {
            zoom: 9,
            center: { lat: 6.2209, lng: 6.937 }
            // draggable: false
        };
        // new map
        let map = new google.maps.Map(document.getElementById("map"), options);
        // add marker to point at the location of the service
        let marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map
        });
        // add info window
        let infowindow = new google.maps.InfoWindow({
            content: `<h4>${location}</h4>`
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });
    }

    // view the address of the different services on the map
    $(".view-services").on("click", function() {
        let id = $(this).attr("v-id");
        $.notify(
            {
                message: "Loading..."
            },
            { type: "info" }
        );
        // use axios to get the details of the services
        axios
            .get(`http://localhost:8000/admin/services/${id}`)
            .then(res => {
                let { isCompleted, service } = res.data;
                if (isCompleted) {
                    $("#address_name").text(`${service.name}'s`);
                    let location = service.address;
                    axios
                        .get(
                            "https://maps.googleapis.com/maps/api/geocode/json",
                            {
                                params: {
                                    address: location,
                                    key:
                                        "YOUR_API_KEY_HERE"
                                }
                            }
                        )
                        .then(res => {
                            // res gives the whole data about the address from the map
                            // now lets get the latitude and longitude of the location
                            // so as to put a marker on the map to be displayed!
                            let lat = res.data.results[0].geometry.location.lat;
                            let lng = res.data.results[0].geometry.location.lng;
                            initMap(lat, lng, location);
                        })
                        .catch(err => {
                            $.notify(
                                {
                                    message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                                },
                                { type: "danger" }
                            );
                        });
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            })
            .catch(err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            });
    });

    // delete services
    $(".delete-services").on("click", function() {
        let id = $(this).attr("d-id");
        $.notify(
            {
                message: "Deleting..."
            },
            { type: "info" }
        );
        $.ajax({
            method: "DELETE",
            url: `http://localhost:8000/admin/services/${id}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: data => {
                let { isCompleted, msg } = data;
                if (isCompleted) {
                    $.notify(
                        {
                            message: msg
                        },
                        { type: "success" }
                    );
                    window.location = "http://localhost:8000/admin/services";
                } else {
                    $.notify(
                        {
                            message: `<i class='fa fa-exclamation-circle'></i> ${msg}`
                        },
                        { type: "danger" }
                    );
                }
            },
            error: err => {
                $.notify(
                    {
                        message: `<i class='fa fa-exclamation-circle'></i> ${err}`
                    },
                    { type: "danger" }
                );
            }
        });
    });
});
