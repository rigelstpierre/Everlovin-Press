jQuery(document).ready(function($) {
	jQuery(function($){
        $(".tweet").tweet({
            username: "midjejune",
            join_text: "auto",
            count: 3, 
            template: "{text}{time}",
            loading_text: "loading tweets..."
        });
    });
    // API Ref: http://api.dribbble/players/:id/shots
    $.jribbble.getShotsByPlayerId('tomfroese', function (playerShots) {
        var html = [];
        $.each(playerShots.shots, function (i, shot) {
            html.push('<a href="' + shot.url + '"><img src="' + shot.image_url + '" ');
            html.push('alt="' + shot.title + '"></a>');
        });
            
        $('#dribbble').html(html.join(''));
    }, {page: 1, per_page: 1});
	

});
