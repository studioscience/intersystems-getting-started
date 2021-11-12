function sandbox_reset() {
    if ( window.confirm("Delete your sandbox? You will lose any code and data you created.") ) {
        reset_info = {}
        reset_info['action'] = 'sandbox_reset'
        jQuery(document).ready(function($){
            $.ajax({
                url: ajax_url, 
                type: 'POST', 
                async: true, 
                data: reset_info, 
                success: function(results) {
                    console.log('sandbox_reset: successful!')
                    location.reload()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("sandbox_reset: request failed: ")
                    if (textStatus==="timeout") {
                        console.log("Call has timed out")
                    } else {
                        console.log("response text: " + errorThrown)
                    }
                }
            })
        })
    }
}

function sandbox_config_save(config_info) {
    config_info['action'] = 'sandbox_config_cb'
    jQuery(document).ready(function($){
        $.ajax({
            url: ajax_url, 
            type: 'POST', 
            async: true, 
            data: config_info, 
            success: function(results) {
                console.log('sandbox_config_save: user meta updated!')
                location.reload()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("sandbox_config_save: request failed: ")
                if (textStatus==="timeout") {
                    console.log("Call has timed out")
                } else {
                    console.log("response text: " + errorThrown)
                }
            }
        })
    })
}

/**
 * Uses the "Containers Status" API to wait for the containers to be built
 * https://usconfluence.iscinternal.com/pages/viewpage.action?pageId=352778629
 * @param {String} pollurl 
 * @param {String} token authorization token
 */
function sandbox_build_progress(pollurl, token) {
    jQuery(document).ready(function($){
        $.ajax({
            dataType: "json", 
            url: pollurl, 
            type: 'GET', 
            headers: {
                "Authorization": token, 
            },
            success: function(response, status, xhr) {
                resp = response['state']
                resp = resp.toLowerCase()
                console.log("Polling response: " + resp)
                if ( resp == "action" || resp == "new" || resp == "building" ) {
                    setTimeout(sandbox_build_progress, 2000, pollurl, token)
                } else if ( resp == "success" ) {
                    console.log("Polling done, saving config info")
                    console.log(JSON.stringify(response.data, undefined, 4))
                    sandbox_config_save(response.data)
                } else {
                    console.log("ERROR IN POLLING: ")
                    console.log("state: " + resp)
                    console.log("status: " + status)
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                var emsg = '<code>Error: <b>' + errorMessage + '</b>'
                emsg += '<br/>' + textStatus + '</code>'
                $('#isc-waiting-area').html(emsg)
            }
        })
    })
}

function launcheval(sandbox_meta_url, token) {
    if (!token || token.length == 0) 
        console.log("launcheval: NULL AUTHORIZATION TOKEN!")
        
    jQuery(document).ready(function($){ 
        $('#isc-launch-eval-btn').hide()
        let waitingcontent = '<video autoplay="true" height="360" width="640" src="/wp-content/themes/isctwentyeleven/assets/images/sandbox_launch.mp4" type="video/mp4">'
        $('#isc-waiting-area').html(waitingcontent)

        $.ajax({
            url: sandbox_meta_url, 
            data: {}, 
            type: 'POST', 
            headers: {
                "Authorization": token, 
            },
            success: function(data, status, xhr) {
                var pollurl = xhr.getResponseHeader("Location")
                console.log("Success getting polling URL:")
                console.log(pollurl)
                sandbox_build_progress(pollurl, token)
            },
            error: function(jqXhr, textStatus, errorMessage) {
                var emsg = '<code>' + textStatus + ': <b>' + errorMessage + '</b>'
                $('#isc-waiting-area').html(emsg)
            }
        })
    })
}
