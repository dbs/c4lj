=== DOAJ Export ===
Contributors: jbrinley, emorgan
Tags: doaj, open-access, metadata, xml, journal, periodical, OAI, OAI-PMH
Requires at least: 2.3
Tested up to: 2.6
Stable tag: 1.0

Adds a feed for exporting your data using the DOAJ article XML schema.

== Description ==

This plugin adds a feed to your site that uses the [DOAJ article XML schema](http://www.doaj.org/doaj?func=loadTempl&templ=070509). The XML file it creates would be suitable for uploading to the [Directory of Open Access Journals](http://www.doaj.org/).

= Known Problems =

1. The language code cannot be changed from "eng".
1. Does not play well with the FeedBurner FeedSmith plugin (which redirects you to your FeedBurner feed, so you never see the DOAJ XML output).

== Installation ==
1. Unzip and copy the files to your plugins directory.
1. Activate the plugin.
1. If appropriate, set the publisher name, ISSN, and eISSN on the DOAJ Export settings page.

== Frequently Asked Questions ==

= How do I access this feed? =

Add the query string `?feed=doaj` to the end of the URL for any page on your site.
    http://example.com/?feed=doaj
    http://example.com/tags/foo?feed=doaj
    http://example.com/?s=bar&feed=doaj

If mod_rewrite is enabled on your site (_i.e._, you have pretty URLs), you can also access the feed by appending `/feed/doaj` to your URL.
    http://example.com/feed/doaj
    http://example.com/tags/foo/feed/doaj
    http://example.com/feed/doaj?s=bar
    
= Where do the volume/issue numbers come from? =

The plugin assumes you have a category for each issue named "Issue #", where # is the number of the issue. The issue categories should be child categories of either an "Issues" category or of a "Volume #" category. If the former, the output won't include a volume number. If the latter, the volume number will come from the volume's category name.

= My site is not in English. How do I change the language code? =

Short answer: you can't.

Long answer: The DOAJ article XML schema requires language codes from ISO 639-2. WordPress only gives them in ISO 639-1 (using `bloginfo('language');`). So for now, the "eng" language code is hard coded into the template. If you need to change this, edit the file "doaj-template.php" in the plugin's directory, replacing the four instances of "eng" with the three-letter code for the language of your choice.