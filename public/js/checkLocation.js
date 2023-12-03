let isWithinGatherRadius = document.getElementById("isWithinGatherRadius");

function requestLocationPermission() {
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
}

function checkIfWithinRadius(position) {
    const userLocation = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
    };

    const gatheringPointUrl = "{{ $activity->gatheringPointUrl ?? '' }}"; // retrieve gatheringPointUrl from blade view
    const maxDistance = 2; // 2 km max range

    // Check if the Google Maps link contains latitude and longitude
    const match = gatheringPointUrl.match(/@([-0-9.]+),([-0-9.]+)/);

    if (match) {
        // If latitude and longitude are found in the URL, use them directly
        const gatheringPoint = {
            latitude: parseFloat(match[1]),
            longitude: parseFloat(match[2]),
        };
        const distance = calculateDistance(
            userLocation.latitude,
            userLocation.longitude,
            gatheringPoint.latitude,
            gatheringPoint.longitude
        );

        if (distance <= maxDistance) {
            console.log("User is nearby the gathering point.");
            isWithinGatherRadius.value = true;
        } else {
            console.log("User is not nearby the gathering point.");
            isWithinGatherRadius.value = false;
        }
        console.log("isWithinGatherRadius:", isWithinGatherRadius.value);
    } else {
        // If latitude and longitude are not found in the URL, use the Geocoding API
        getLatLngFromGoogleMapsLink(gatheringPointUrl)
            .then((gatheringPoint) => {
                const distance = calculateDistance(
                    userLocation.latitude,
                    userLocation.longitude,
                    gatheringPoint.latitude,
                    gatheringPoint.longitude
                );
                if (distance <= maxDistance) {
                    console.log("User is nearby the gathering point.");
                } else {
                    console.log("User is not nearby the gathering point.");
                }
            })
            .catch((error) => {
                console.error(
                    "Error getting latitude and longitude from Google Maps link:",
                    error
                );
            });
    }
}

function successCallback(position) {
    console.log("Geolocation success callback triggered.");
    checkIfWithinRadius(position);
}

function errorCallback(error) {
    console.error("Geolocation error:", error);

    // Handle errors or provide user instructions here
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    // Haversine formula:
    const R = 6371; // Radius of the Earth in km
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) *
            Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    const distance = R * c;
    return distance;
}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

async function getLatLngFromGoogleMapsLink(googleMapsLink) {
    try {
        const response = await fetch(
            `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(
                googleMapsLink
            )}&key=YOUR_GOOGLE_MAPS_API_KEY`
        );
        const data = await response.json();
        const location = data.results[0].geometry.location;

        return {
            latitude: location.lat,
            longitude: location.lng,
        };
    } catch (error) {
        throw error;
    }
}

window.onload = function () {
    console.log("Page has loaded!");
    requestLocationPermission();
};
