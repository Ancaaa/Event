
$(document).ready(function(){

    var ids = [
        'filter-keyword',
        'filter-price-from',
        'filter-price-to',
        'filter-location',
        'filter-listing-categories',
        'filter-event-date-from',
        'filter-event-date-to'
    ]

    var clearEvents = function() {
        $('.products').empty()
        appEvents = []
    }

    var addEvent = function(event) {
        $('.products').append($(create_event_summary(event)))
    }

    var registerEvent = function(event) {
        appEvents.push(event)
    }

    var appEvents = []
    var sortBy = 'menu_order'

    var updateUI = function() {
        $('.products').empty()

        var sorted = appEvents.slice(0)

        $('#numResults').text(sorted.length)

        switch(sortBy) {
            default:
                break
            case 'popularity':
                sorted = sorted.sort(function(event1, event2) { return parseInt(event1.attendants) - parseInt(event2.attendants) }).reverse()
                break;
            case 'date':
                sorted = sorted.sort(function(event1, event2) { return  new Date(event1.created_at) - new Date(event2.created_at) }).reverse()
                break;
            case 'price':
                sorted = sorted.sort(function(event1, event2) { return  parseInt(event1.price) - parseInt(event2.price) })
                break;
            case 'price-desc':
                sorted = sorted.sort(function(event1, event2) { return  parseInt(event1.price) - parseInt(event2.price) }).reverse()
                break;
            case 'event_date':
                sorted = sorted.sort(function(event1, event2) { return  new Date(event1.startdate) - new Date(event2.startdate) })
                break;
        }

        sorted.forEach(addEvent)
    }

    // Validate & Update Data
    var updateData = function() {
        var searchParameters = {}

        ids.forEach(function(id) {
            var value = $("#" + id).val()
            if (value !== "") {
                searchParameters[id] = value
            }
        })

        var query = '?'
        var keysLength = Object.keys(searchParameters).length
        Object.keys(searchParameters).forEach(function(param, index) {
            query += param + "=" + encodeURI(searchParameters[param])
            if (index + 1 !== keysLength) {
                query += "&"
            }
        })

        $.get('/api/events/search' + query, function(data, idontcare, request) {
            if (request.status === 200) {
                try {
                    var json = JSON.parse(data)
                    var events = json.events

                    clearEvents()

                    if (!events) {
                        return
                    }

                    if (events.length > 0) {
                        events.forEach(registerEvent)
                    } else if (Object.keys(events).length > 0) {
                        Object.keys(events).forEach(function(key) { registerEvent(events[key]) })
                    }

                    updateUI()

                } catch(e) {
                    console.error(e)
                }
            }
            else {
                console.error('Server could not search for events.')
            }
        })
    }

    // Register Events
    $('#sortBy').on('change', function() { sortBy = $('#sortBy').val(); updateUI(); })
    ids.forEach(function(id) {
        $("#" + id).on('change', _.debounce(updateData, 100))
     //   $("#" + id).keypress(_.debounce(updateData, 100))
    })
    $('#search-button').click(_.debounce(updateData, 100))

    updateData()
})