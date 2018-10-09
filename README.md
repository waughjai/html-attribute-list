HTML Attribute List
=========================

A list o' HTML attributes for easy HTML generation.

Just create an instance with a hash map with attribute names as keys & attribute values as values:

````
$attribute_list = new HTMLAttributeList
([
    'class' => 'footer',
    'id' => 'main-footer'
]);
````

& using it as a string or calling GetAttributesText() will automatically give you HTML code for the attributes, starting with a space.

Use like this:

`<footer<?= $attribute_list; ?></footer>`

& it will give you this:

`<footer class="footer" id="main-footer"></footer>`
