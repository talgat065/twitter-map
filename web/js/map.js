ymaps.ready(init);

function init() {

    var myMap = new ymaps.Map("map", {
        center: [51.1801, 71.44598],
        zoom: 7
    });

    getTweets();

    getUserLocation();

    function getTweets() {
        $.ajax({
            url: '/tweets'
        }).done(function (tweets) {

            $.each(tweets, function (key, val) {
                var location = [
                    tweets[key]['lat'],
                    tweets[key]['lng']
                ];

                var content = {
                    hintContent: tweets[key]['author'],
                    balloonContent: tweets[key]['body']
                };

                myMap.geoObjects.add(new ymaps.Placemark(location, content));
            });
        });
    }

    function getUserLocation() {
        $.ajax({
            url: '/site/get-user-location'
        }).done(function (location) {
            console.log(location);

            myMap.setCenter([location[1], location[0]], 6);
        });
    }

    $('#update').on('click', function () {

        console.log('updating...');

        $.ajax({
            url: '/site/update'
        }).done(function (message) {
            alert(message);
            
            getTweets();
        })
    });
}




