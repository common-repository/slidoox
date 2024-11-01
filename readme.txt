=== slidoox ===
Contributors: mickael
Link: http://devoox.com
Tags: slide,moootools,box
Requires at least: 2.0.2
Tested up to: 2.6.2
Stable tag: 0.1

A custom slider for your blog.
You can add text, html,images...

== Description ==

A custom slider for your blog.
You can add text, html,images...
This plugin is really easy to install an custom. 
The script was done by creativepony.com and edited by devoox.com

FEAT:
You can use 4 effects:Bounce, Cubic,Quart,Circ.
It can start onmouseover or onclick.
You can change size, color, background from the sylesheet
See the FAQ for see how to custom

we are waiting for your feedback.
You can see an exemple on the top page here : http://devoox.com/bluvoox/
Version: 0.1
Author: devoox
Author URI: devoox.com

== Installation ==
Unzip this folder to your plugin folder.
In the place you want to show the slideshow, put this code on your template: `<?=contenu();?>`

== Frequently Asked Questions ==

= HOW TO ADD A TAB  ? =
Go to you admin page.
Click on manage and on Slidoox Manager.

= HOW TO CHANGE THE EFFECT  ? =
Open the /js/sliding-tabs.js file.
Search for this line:"CHOOSE BETWEEN YOU EFFECT START"
Now, the Bounce effect is active. 

	transition: Fx.Transitions.Bounce.easeOut,//BOUNCE EFFECT
	//transition: Fx.Transitions.Cubic.easeOut,//CUBIC EFFECT
	//transition: Fx.Transitions.Quart.easeOut,//QUART EFFECT
	//transition: Fx.Transitions.Circ.easeOut,//CIRC EFFECT

For exemple, if you want use the cubic effect, just uncomment the transition line:
	
	//transition: Fx.Transitions.Bounce.easeOut,//BOUNCE EFFECT
	transition: Fx.Transitions.Cubic.easeOut,//CUBIC EFFECT
       //transition: Fx.Transitions.Quart.easeOut,//QUART EFFECT
       //transition: Fx.Transitions.Circ.easeOut,//CIRC EFFECT

= HOW TO SET THE ANIMATION TO START ONMOUSEOVER ?=
Open the /js/sliding-tabs.js file.

Replace this two line:
activationEvent: 'click', 
    //activationEvent: 'mouseover', 

by:
//activationEvent: 'click', 
    activationEvent: 'mouseover', 

= HOW TO CHANGE BACKGROUND,SIZE,COLOR... ? =
Open the css/style.css file and play with.
There are a few comment inside too.
== Screenshots ==
Please, check this app at http://devoox.com/bluvoox





