var create_event_summary = function(event) {
    if (!event) {
        return ""
    }

    var date = moment(event.startdate)
    var template = '\
        <li class="product summ">\
            <a href="' + event.href + '" class="woocommerce-LoopProduct-link">\
            <div class="product-image-wrapper">\
                <img width="400" height="340" src="'+ event.image +'" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="">\
            </div>\
            \
            <div class="product-date">\
                <span class="day">'+date.format('DD')+'</span><span class="month">'+date.format('MMMM')+'</span><span class="year">'+date.format('YYYY')+'</span>\
                <span class="day">'+event.starttime.split(':')[0]+'</span><span class="year">'+event.starttime.split(':')[1]+'</span>\
            </div>\
            \
            <h3>'+event.title+'</h3>\
            \
            <div class="product-location loc">\
                <i class="lnr lnr-map-marker"></i>\
                '+event.location+'\
            </div>\
            \
            <div class="product-location loc">\
                <i class="lnr lnr-hourglass"></i>\
                '+event.when+'\
            </div>\
            \
            <span class="onsale">'+event.duration+'</span>\
            <span class="price">\
                <span class="woocommerce-Price-amount amount">\
                    '+(event.price === 0 ? 'Free' : (event.price + ' ' + event.currency))+'\
                </span>\
            </span>\
            </a>\
        </li>'

    return template
}