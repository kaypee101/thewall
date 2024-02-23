function setCookie(name: string, value: string, daysToExpire: number) {
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + daysToExpire);

    // Create a string with the cookie name, value, and expiration date
    var cookieString =
        name +
        "=" +
        encodeURIComponent(value) +
        "; expires=" +
        expirationDate.toUTCString() +
        "; path=/";

    // Set the cookie
    document.cookie = cookieString;
}

function getCookie(name: string, default_val: string | null) {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();

        if (cookie.indexOf(name + "=") === 0) {
            return decodeURIComponent(cookie.substring(name.length + 1));
        }
    }

    return default_val;
}

export { setCookie, getCookie };
