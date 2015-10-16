/* 
|
|  This program is free software which I release under the GNU General Public
|  License. You may redistribute and/or modify this program under the terms
|  of that license as published by the Free Software Foundation; either
|  version 2 of the License, or (at your option) any later version.
|
|  This program is distributed in the hope that it will be useful,
|  but WITHOUT ANY WARRANTY; without even the implied warranty of
|  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
|  GNU General Public License for more details.  Version 2 is in the
|  COPYRIGHT file in the top level directory of this distribution.
| 
|  To get a copy of the GNU General Puplic License, write to the Free Software
|  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


The wrap plugin allows you to 'wrap' files (or entire websites) inside of e107.

UPGRADING FROM V0.8
===============================================================================
Refresh the plugin files as you normally would. Then, run a validity check on
the wrap table through e107's database tools. This should detect the
missing tables and allow you to fix them. 
===============================================================================


USAGE
===============================================================================
Page Title:  If you enter a title, your page will be shown inside an e107 menu, 
if it's blank, it will be rendered as presented.

Page URL:  URL to site/file you wish to display within the Iframe.

Scroll Bars: Show/Hide Horizontal & vertical scroll bars

Width: Width of the Iframe window, you can enter an absolute value or relative by adding a %

Height: Height of the Iframe Window

Auto Height: The height will automatically be set to the size of the external page.

Restrict to:  Select the class that can access the page.

PASSING DATA
Just add anything you want to pass under wrap_pass=
For example: http://yoursite.com/e107_plugins/wrap/wrap.php?9&wrap_pass=key1=value1&key2=value2

Wrap will attach the string contained in wrap_pass (key1=value1&key2=value2) and add it to the src tag of the iframe. 
So, for example, if wrapped page 9 had the url of http://yoursite.com/some_page.php the iframe call would that would be made:
http://yoursite.com/some_page.php?key1=value1 and so on and so forth…

Passing data is a little strange so here is a rough documenation example:

The data being passed to the wrapped page is not static, it is set when the url is called. When a wrapped page
is called it parses the Query string (url in your browser) and looks for "&wrap_pass". If it finds that string
it appends a ? and &wrap_pass... to the url address being called in the iframe. This is why you should never
add a ? to the wrap url page in the admin area unless you are 100% sure that you will not use wrap_pass.

So let me give an example. Let's say you create a new wrapped page with the url of "http://www.google.com/search",
and save. Now lets say that the incremental wrap id given to this page is id 9. You could make a search on google
for "dogs" by using this link:
http://www.yoursite.com/e107_plugins/wrap/wrap.php?9&wrap_pass=q=dogs

This should wrap the first page google would produce for dogs.
Thus, the actual url that would be used in the iframe would be this:
http://www.google.com/search?q=dogs


===============================================================================


Need to do:
- If urls are to long shorten them to a predifined # of characters so the page doesn't distort
	(http://yoursite.com/page.php?someva...) You know what I mean
	Display the full url using a mouse rollover?
- Admin page could use a little more work but it's not critical
	Seperate add/edit form to a seperate page
	Add a menu to the right (Add/View)

Revision history:
-----------------	  
	  
No history stored prior to 0.4

2/14/2004 ( v0.4 ) McFly
  + Updated to allow you to wrap local files as well.

2/27/2004 ( v0.5 ) McFly
  + Added code to allow reading of files using older versions of PHP.

4/31/2004 ( v0.6 ) Jeremy2
  + Added a quick refrence table at the bottom so you can see the ID #, title, location, etc..
  + Made it more frienldy with 616+ (with 616 it is easyer to change you plugins folder path,
    so now it will tell you the right path to the wrapped page... no more yoursite.com)
    
7/15/2004 ( v0.7 ) Juan
    Modification of files pluggin and wrap config and help with the aim of returning them multilingual  
4/28/2005 ( v0.8 ) SuS
  + Created two new icons and removed the old one.
    Replaced help.php with Cameron's sample help.php
    Changed the language files. There might be still double entries among other things.
    Included check for language file, if not found default to English. 
    Renamed wrap_conf.php to admin_config.php. This way the page renders OK in the new plugin manager.
    Changed the layout of the admin_config.php 
    Recreated the plugin.php to make sure the file is e107 0.7 compliant
    Corrected the way Juan commented to use // instead of ##
    Corrected the install path from wrap_07 to wrap 
    Added some comments (helps me keep track of events)
	
3/18/2006 ( v0.9 ) jmstacey
	+ Scroll bar control (Auto, Yes, or No)
	+ Width control (absolute or relative values accepted)
	+ Auto height functionality
	+ Ability to pass data to the external page
	+ English language file cleaned up
	+ help.php updated with new settings
	+ Admin interface updated
	
6/25/2006 ( v0.9.1 ) jmstacey
	+ Corrected incorrect text on Admin level
	+ Give URL to iframe blindly
	+ Enabled e107 database validity check
	+ Added passing data example to Help
	+ Removed non English languages since they were out of date

7/13/2006 ( v0.9.2 ) jmstacey
	+ Changed MySQL syntax ENGINE= to TYPE= in wrap.sql
	+ Added rough documentation example to readme