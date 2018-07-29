ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [55.76, 37.64],
        zoom: 7
    });

    $.ajax({
        url: '/tweets'
    }).done(function(tweets){
        $.each(tweets, function (key, val) {
            var location = [
                tweets[key]['lat'],
                tweets[key]['lng']
            ];

            var content = {
                hintContent: tweets[key]['author'],
                balloonContent : tweets[key]['body']
            };

            myMap.geoObjects.add(new ymaps.Placemark(location, content));
        });
    });
}
