(function($){
    var target = '.rwmb-map-field';
    var mapReference = null;
    var map, marker = null

    function MapHandler() {
        var isTargetLoaded = $(target);

        this.loader(isTargetLoaded);
    }

    MapHandler.prototype.loader = function(targetLoaded) {
        var attemps = 0;
        var maxAttemps = 10;

        var interval = setInterval(function(){
            if (targetLoaded.length) {
                mapReference = targetLoaded.data('mapController');

                if (mapReference || (attemps === maxAttemps)) {
                    this.init();
                    return clearInterval(interval);
                }

                attemps++;
            }
        }.bind(this), 500);
    }

    MapHandler.prototype.init = function(){
        this.executeListeners();
    }

    MapHandler.prototype.executeListeners = function(){
        var s = google.maps.event.clearListeners(mapReference.map);
        mapReference.map.addListener('click', function(event){
            console.log(event);
        });
    }

    $(document).ready(function(){
        // init class to handle map if it is exists
        new MapHandler();
    });

    var _attemps = 0;
    var _timer = setInterval(function(){
        var id = '#antours_mtx_trip_price_package';
        var field = $(id);

        if (field.length > 0 || (_attemps > 10)) {
            new AutoNumeric(id, { currencySymbol : '$' });
            return clearInterval(_timer);
        }

        _attemps++;
    }, 500);
})(jQuery);