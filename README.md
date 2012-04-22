Portal Content Management System 
Version 2
====================

Build on [Fuel Framework](https://github.com/fuel/fuel)<br />
Using:<br />
[Nivo-Slider](https://github.com/gilbitron/Nivo-Slider)<br />
[elRTE](https://github.com/Studio-42/elRTE)<br />
[elFinder](https://github.com/Studio-42/elFinder)<br />
[colorbox](https://github.com/jackmoore/colorbox)<br />
[html5boilerplate](https://github.com/h5bp/html5-boilerplate)<br />
[jquery.swfobject](http://jquery.thewikies.com/swfobject/)<br />
[pie](https://github.com/lojjic/PIE)<br />

Features:
---------------------
* Multilanguage interface
* Multilanguage site
* Multi-Navigation ( with every up to 1 hirachie down)
* News
* Page management
* Textcontainer ( up to 3 columns )
* Linking to existing contents ( up to 3 columns )
* Flash (using jquery.swfobject plugin with picture replacement)
* Simple contactform
* Gallery ( slideshow, thumbnail and customizeable)
* Content Stacking ( multiple contents in 1 page )
* Multi-Account
* Simple Permission System
* Module management
* Asset management
* Customizeable Layout

Requirements:
---------------------
PHP 5.3

Install
---------------------
> 1. Download the files
> 2. Extract them into your root folder on your webserver
> 3. Install throught he install tool (http://localhost/projectname/public/admin/install)

Follow all three steps and login into (http://localhost/projectname/public/admin).<br />
*Notice*: you might have to create the bare database yourself.

Writing CSS:
---------------------
Portal CMS comes with a light sass,less,stylus-like scripting system.<br />
*Notice:* The script will be parsed line for line so you cant comment after a variable definition. Everything in the code below is valid. There can be multiple scripts at any place like in php.

#### Syntax:
<pre>
/*&gt;
; above is the opening tag
; this is a comment

; making a variable with permanent root folder in it
; will represent similiar to this http://localhost/portalcms/public
$root = "DOCROOT"

; using pie
$pie = "behavior:url(PIEPATH)"

$im_a_variable = "i contain any possible value"
im_also_a_variable = 'i contain another value'
[even_this_is_a_variable] = and im a value

; now creating c++ like structs/objects with properties
obj site
  $bg = "#ccc"
  ; you can nest them
  obj navigation
    $hover = "#cc0005"
  end
end

; below is the closing tag
&lt;*/

</pre>

#### Usage:
<pre>
body {
  background-color: site.$bg;
}

nav:hover {
  color: site.navigation.$hover;
}

p:after {
  content: "$im_a_variable";
  border-radius: 10px;
  $pie;
}
</pre>
