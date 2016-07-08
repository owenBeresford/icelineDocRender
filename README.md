# icelineDocRender
Port of my ancient doc renderer into PHP5.6 &amp;&amp; Symfony2  

Objectives
* PHP code that people may see (being BE, you can't legally see most of what I did at other companies) 
* Add caching layer for pages
* Get performance benefits from using newer PHP & a better framework.  Get more features from Symfony 
* Be able to use things like DI as its now possible 
* .
* (q) why do I have iceline in the name twice? it looks silly.
*     (a) the first renderer was called 'iceline', its the iceline file format document renderer.
* (q) Do I have something against twig?
*     (a) No, but its designed for HTML, not text.  Iceline is for large articles of text.
* (q) Do you have something against DB?
*     (a) my current use case doesn't have concurrent edits, so a DBMS is unneeded.  NB, It wouldn't be much effort to map ResourceHash->setContentFromFile to a MongoDB document read 
*

# Dependancies
* this project isn't completed yet, I need to write out all the project admin things
* Symfony (Will update this)
* This writes to app/cache/cache during operation (need to make this)
* text_wiki https://packagist.org/packages/mrcore/text_wiki 
* Swiftemailer is part of Symfony 
