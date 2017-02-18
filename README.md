# icelineDocRender
Port of my ancient doc renderer into PHP7.1 &amp;&amp; Symfony3 

Objectives
* PHP code that people may see (being BE, you can't legally see most of what I did at other companies) 
* Add caching layer for pages
* Get performance benefits from using newer PHP & a better framework.  Get more features from Symfony 
* Be able to use things like DI as its now possible 

* (q) why do I have iceline in the name twice? it looks silly.
*     (a) the first renderer was called 'iceline', its the iceline file format document renderer.
* (q) Do I have something against twig?
*     (a) No, but its designed for HTML, not text.  Iceline is for large articles of text.  If someone wants to port my >200 article into twig they may (open commons licence), but I think this is faster/ less BORING/ more useful side effects 
* (q) do you have something against DB?
*     (a) my current use case doesn't have concurrent edits, so a DBMS is unneeded.  NB, It wouldn't be much effort to map ResourceHash->setContentFromFile to a MongoDB (etc) document read.  It is simpler to not need an [R]DBMs, look at the source code for Wordpress before any critique on this sentence is accepted.
* (q) Why is there no Admin login, like, say Wordpress?
*     (a) I think text editing in a text editor or word processor is easier.  I use all the available tools in these text tools to produce better English. As such an 'Edit' GUI is a downgrade. Also single editor...


# Dependancies
* Connive whoever is sysadmin that I can be trusted with php7.1
* Symfony3, may run on Symfony2.
* text_wiki installed from https://packagist.org/packages/mrcore/text_wiki 
* Swiftemailer which is part of Symfony 
* Unit tests require phpunit https://phpunit.de/manual/current/en/installation.html#installation.composer
* This is written to go on top of Apache, as the project is older than NginX. However, assuming an admin ports the *.htaccess file*, that is the only change needed for Nginx.

# TODO:
* update the JS to current standards (in particular, I can drop all the hacks for the 2008/2009 version of MSIE)
* update to newer CSS (see previous)
* add *composer.json, bower.json* etc.  Move standard JS libs to external deps, as this is now reliable.
* add a better page test tool
* decide if my planned local keyword cache is worth doing/ Or write a proper google integration

