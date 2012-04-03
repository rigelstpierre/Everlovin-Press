=== SlideDeck 2 Pro for WordPress ===
Contributors: dtelepathy, kynatro, jamie3d, dtrenkner, oriontimbers
Donate link: http://www.slidedeck.com/
Tags: Slider, dynamic, slide show, slideshow, widget, Search Engine Optimized, seo, jquery, plugin, pictures, slide, skinnable, skin, posts, video, photo, media, image gallery, iPad, iphone, vertical slides, touch support, theme
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: trunk

Create SlideDecks on your WordPress blogging platform. Manage SlideDeck content and insert them into templates and posts.

== Description ==

The SlideDeck WordPress slider plugin allows you to easily create a content slider widget or slideshow on your WordPress blog without having to write any code. Just create a new slider with the SlideDeck control panel tool and insert the widget into your post via the WYSIWYG editor with the TinyMCE plugin SlideDeck picker. 

**Requirements:** PHP5+, WordPress 3.3+

**Important Links:**

* [More Details](http://www.slidedeck.com/)
* [Knowledge Base](https://dtelepathy.zendesk.com/categories/20031167-slidedeck-2)
* [Support](http://dtelepathy.zendesk.com/)

== Installation ==

1. Upload the `slidedeck2` folder and all its contents to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a new SlideDeck from the new menu in the control panel sidebar
1. Insert a SlideDeck in your post or page by clicking on the `Embed a SlideDeck` button in the rich text editor or the button in the sidebar in the post/page view. 

== Changelog ==
= 2.0.20120327 =
* Improved menu positioning to be less conflicting with some themes like Thesis
* Improved validation of license key routine to provide better fallbacks for certain server configurations
* Improved how JavaScript files are loaded in preview and IFrame mode SlideDecks to prevent problems with sub-folder embedded SlideDecks 
* Added Google map images and custom titles for Google Plus Posts check-ins.
* Added an option to the WordPress Posts type that allows overriding the content with the excerpt.
* Addressed another issue where post_thumbnail support was not being checked for.

= 2.0.20120323 =
* Addressed an issue where post_thumbnail support was not being checked for
* Added new "slidedeck_after_get" filter for post-processing SlideDeck array when loading single SlideDecks in the SlideDeck::get() method
* Added some logic that tries to retrieve the right sized image from your WordPress posts source
* Removed the "Featured" selection from the WordPress Posts content source
* Replaced all JavaScript calls to jQuery.on() with jQuery.bind() or jQuery.delegate()
* Fixed issue with Internet Explorer 8 and the content source flyouts

= 2.0.20120322 =
* Made accommodation for systems that do not have the mbstring PHP module enabled
* Attempted to fix a license key issue for servers with connection issues

= 2.0.20120319 =
* Addressing an issue with vertical SlideDecks and video

= 2.0.20120316 =
* Gold release

= 2.0.0beta3 =
* Third beta release
* Fixed issue with image retrieval for GPlus posts
* Design craft implementations
* Various bug fixes
* Some IE 7/8 improvements

= 2.0.0beta2 =
* Second beta release
* Lots of design polish
* Options groups table organization for usability and consistency
* New cover designs
* Tons of bug fixes
* SlideDeck 2 now runs side-by-side with SlideDeck 1

= 2.0.0beta1 =
* Initial beta release.

== Upgrade Notice ==
= 2.0.20120327 =
Improved IFrame loading and added ability to override WordPress content with excerpt content, compatibility fixes 

= 2.0.20120323 =
Compatibility for WordPress themes without featured thumbnail support and new filter addition

= 2.0.20120322 =
Compatibility bug fixes for certain PHP configurations

= 2.0.20120319 =
Addressing an issue with vertical SlideDecks and video

= 2.0.20120316 =
Gold release

= 2.0.0beta3 =
Third beta release

= 2.0.0beta2 =
Second beta release

= 2.0.0beta1 =
Initial private beta release