Portal Content Management System 
Version 2
====================

#Very unfinished!

## This repository keeps being empty till the [base](https://github.com/hendrik-weiler/portalcms2-base) is far enough developed to create the actual cms

Build on [FuelPHP Framework](https://github.com/fuel/fuel)<br />
Using:<br />
[Nivo-Slider](https://github.com/gilbitron/Nivo-Slider)<br />
[colorbox](https://github.com/jackmoore/colorbox)<br />
[Twitter Bootstrap](http://twitter.github.com/bootstrap/)<br />
[jquery.swfobject](http://jquery.thewikies.com/swfobject/)<br />
[pie](https://github.com/lojjic/PIE)<br />

Features:
---------------------
* Haml, CoffeeScript, Sass, Scss parsing/caching
* Extendable backend

Requirements:
---------------------
PHP 5.3

Install
---------------------
> 1. Download the files
> 2. Extract them into your root folder on your webserver
> 3. Install throught he install tool (http://hostname/install)

Follow all four steps and login into (http://hostname/logincenter).<br />
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
