# constitutional-functions
---

Custom functions outside of WordPress theme file, normally found in functions.php. This method of putting functions ensures that if you switch themes, like you might during troubleshooting a problem, you won't lose widgets, custom post types, and other data. This is to serve as a base modification for custom theming.

**custom_post_type.php** - This adds custom post types and taxonomy to your theme. Include within constitutional-functions.php is commented out and the custom_post_type.php file must be filled out with name of CPT and taxonomies as well as the body slug before you uncomment.

**sample.php** - this has all functions I've used up to now. Do NOT remove sample from the file name and use. It is just the dumping ground. 

**constitutional-functions.php** - Modify this for use. Copy functions from the sample file for use here. Includes some bare minimums that I use on every project.

**shortcodes.php** - A shortcodes list/file I forked from a project I enherited. Couldn't find who originally used it, so I won't claim originality on it, but it combines work I've done to make things more user-friendly for the non-code friendly person. UNDER CONSTRUCTION AND NOT CURRENTLY CALLED IN THE constitutional-functions.php

**wp_bootstrap_navwalker.php** - A Bootstrap navwalker that I've used in nearly every project that has dropdown menus. Probably eventually will be done away with once WP has better support for Bootstrap classes, or we stop using dropdowns. (Github link on file)

#Creator
**Josh Wright**
-[https://www.twitter.com/_joshw](https://www.twitter.com/_joshw)

## Copyright and license

Code and documentation copyright 2014-2018 Josh Wright and jwrightmedia, LLC. Used on projects via the copyright owner's permission.