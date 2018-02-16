(function(window){
    var listeners = {};

    function on(event, fn) {
        if (!listeners[event]) {
            listeners[event] = [];
        }

        if (fn && fn instanceof Function) {
            listeners[event].push(fn);
        }
    }

    function emit() {
        var args = Array.prototype.slice.call(arguments);
        var event = args.shift();
        var eventListeners = listeners[event];

        if (!eventListeners) {
            throw new Error("Event: '" + event + "' is not registered into events");
        }

        var limit = eventListeners.length;

        for(var i = 0; i < limit; i++) {
            var handler = eventListeners[i];
            if (handler && handler instanceof Function) {
                handler.apply(null, args);
            }
        }
    }

    var PubSub = {
        on,
        emit
    };

    window.PubSub = PubSub;
})(window);