$(document).ready(function(){
	$("#twitter").getTwitter({
		userName: "midjejune",
		numTweets: 4,
		loaderText: "Loading tweets...",
		slideIn: false,
		slideDuration: 750,
		showHeading: true,
		showProfileLink: false,
		showTimestamp: false
	});
});