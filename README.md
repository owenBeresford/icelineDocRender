# icelineDocRender
Port of my ancient doc renderer into PHP7.1 &amp;&amp; Symfony3 

Objectives
* PHP code that people may see (for BE, you can't legally see most of what I did at other companies) 
* Add caching layer for pages
* Get performance benefits from using newer PHP & a better framework.  Get more features from Symfony 
* Be able to use things like DI as its now possible 

* (q) why do I have iceline in the name twice? it looks silly.
*     (a) the first renderer was called 'iceline', its the iceline file format document renderer.
* (q) Do I have something against twig?
*     (a) No, but its designed for HTML, not text.  Iceline is for large articles of text.  If someone wants to port my >200 article into twig they may (open commons licence), but I think this is faster/ less BORING/ more useful side effects 
* (q) Do I have something against markdown? 
*     (a) No, but iceline allows "import statements", and shared temnplate files, I am not aware of these features in markdown.  Iceline was started before I was aware of MD. I admit I disnt look that much in 2009; as I thought I needed PHP5 experience to get my next role. 
* (q) do you have something against DB?
*     (a) my current use case doesn't have concurrent edits, so a DBMS is unneeded.  NB, It wouldn't be much effort to map ResourceHash->setContentFromFile to a MongoDB (etc) document read.  It is simpler to not need an [R]DBMs, look at the source code for Wordpress before any critique on this sentence is accepted.
* (q) Why is there no Admin login, like, say Wordpress?
*     (a) I think text editing in a text editor or word processor is easier.  I use all the available tools in these text tools to produce better English. As such an 'Edit' GUI is a downgrade. Also single editor...


# Dependancies
* Connive whoever is sysadmin that I can be trusted with php7.1+
* Symfony3, may run on Symfony2.
* text_wiki installed from https://packagist.org/packages/mrcore/text_wiki 
* Swiftemailer which is part of Symfony 
* Unit tests require phpunit https://phpunit.de/manual/current/en/installation.html#installation.composer
* This is written to go on top of Apache, as the project is older than NginX. However, assuming an admin ports the *.htaccess file*, that is the only change needed for Nginx.
* Requires php-dom installed first
* Strongly recommend the use of composer; it will save you time.

# TODO:
* Update the JS to current standards (in particular, I can drop all the hacks for the 2008/2009 version of MSIE)
    * see other projects in github
* Update to newer CSS (see previous)
    * see other projects in github
* Add *composer.json, bower.json* etc.  Move standard JS libs to external deps, as this is now reliable.
* Add a better page test tool
    * I have been using the sitemap as an adhoc unit test to report for syntax error on anypage in one click.
* Decide if my planned local keyword cache is worth doing/ Or write a proper google integration
    * update: I don't think it is. I added relevant microformats to the page template in 2013.  I was dithering on keyword cache, as a 'legacy design concept' from 2001; but search has gotten better and better at ingestion  
  
 # UPDATE: 
* I am not proud enough to think that my "I need to show that an employers risk accessment on technology does not constrain my learning" project from 2009 would be interesting to anyone else (i.e. I should post it to packgist.net).  In 2008-2015 I did know PHP well enough to write very fast PHP, and use POSIX inside PHP easily; but am aware that golang or python3 are still faster (which I have since used).
* Obviously PHP7+ is a much better interpreter, as it now has an AST.
* I am adding the page cache now...
