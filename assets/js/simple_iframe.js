jQuery(document).ready(function() {

    var default_height = '300px';
    var default_width = '100%';

    jQuery("#simple_iframe_generate").click(function ()
    {
        var file_url = $("#simple-iframe-tab-contents #simple_iframe_url").val();
        var iframe_height = $("#simple-iframe-tab-contents #simple_iframe_height").val();
        var iframe_width = $("#simple-iframe-tab-contents #simple_iframe_width").val();

        if( !is_valid_url(file_url) ) {
            alert('Input valid URL');

            return false;
        }

        if( iframe_width.length === 0 ) {
            iframe_width = default_width;
        } else if( !is_valid_height_width(iframe_width) ) {
            alert('Input valid width. Like 600px or 100%.');

            return false;
        }

        if( iframe_height.length === 0 ) {
            iframe_height = default_height;
        } else if( !is_valid_height_width(iframe_height) ) {
            alert('Input valid height. Like 600px or 100%.');

            return false;
        }

        window.send_to_editor("<iframe  src=\"" + file_url + "\" width=\""+ iframe_width +"\" height=\""+ iframe_height +"\"></iframe>");

        jQuery("#simple-iframe-tab-contents #simple_iframe_url").val('');
        jQuery("#simple-iframe-tab-contents #simple_iframe_height").val( default_height );
        jQuery("#simple-iframe-tab-contents #simple_iframe_width").val( default_width );

        tb_remove();
    });

    function is_valid_url(url)
    {
        return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
    }

    function is_valid_height_width(text)
    {
        return /(\d+)(%|px)/.test(text);
    }

});