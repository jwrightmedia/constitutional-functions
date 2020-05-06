# constitutional-functions
---

Custom functions outside of WordPress theme file, normally found in functions.php. This method of putting functions ensures that if you switch themes, something you might do while troubleshooting a problem, you won't lose widgets, custom post types, and other data. This is to serve as a base modification for custom theming.

**custom_post_type.php** - This adds custom post types and taxonomy to your theme. The include, found on constitutional-functions.php, is commented out and the custom_post_type.php file must be filled out with name of CPT and taxonomies as well as the body slug before you uncomment the include.

**sample.php** - This has all functions I've used up to now. Do NOT remove sample from the file name and use. It is just the dumping ground and I do not always use every function found here. Keep things lean and mean by only using what you need. Top part of file has default ordering of functions, after divider is additional that I don't include in the default file.

**constitutional-functions.php** - Modify this for use. This is the default functions which are used with your theme. Copy functions from the sample file for use here when you find something not needed. 

**shortcodes.php** - A shortcodes list/file I forked from a project I enherited. Couldn't find who originally used it, so I won't claim originality on it, but it combines work I've done to make layout more user-friendly for the non-code friendly person. Still a work in progress not currently called in the constitutional-functions.php file. Advanced Custom Fields has largely made this file obsolete. Will phase this out when Bootstrap 4 is added.

**wp_bootstrap_navwalker.php** - A Bootstrap navwalker that I've used in nearly every project that has dropdown menus. Probably eventually will be done away with once WP has better support for Bootstrap classes, or we stop using dropdowns. Not updated for Bootstrap 4. [Github link](https://github.com/wp-bootstrap/wp-bootstrap-navwalker)

## Creator

**Josh Wright**

-[https://www.twitter.com/_joshw](https://www.twitter.com/_joshw)

## Copyright and license

Code and documentation copyright 2014-2020 Josh Wright and jwrightmedia, LLC. Used on projects via the copyright owner's permission.