$(document).ready(function () {
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
})

function placeRestaurant(map, restaurant) {
    if (restaurant.lat && restaurant.lng) {
        var lat = parseFloat(restaurant.lat), lng = parseFloat(restaurant.lng);
        var markerOptions = {
            position: {
                lat: lat, lng: lng
            },
            icon : {
                url: restaurant.isArestaurant && !restaurant.isAshop ? 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png': 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
            },
            map: map
        };
        return new google.maps.Marker(markerOptions);
    }
    return null;
}
