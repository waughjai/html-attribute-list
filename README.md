HTML Attribute List
=========================

A list o’ HTML attributes for easy HTML generation.

Just create an instance with a hash map with attribute names as keys & attribute values as values:

````
$attribute_list = new HTMLAttributeList
([
    'class' => 'footer',
    'id' => 'main-footer'
]);
````

& using it as a string or calling getAttributesText() will automatically give you HTML code for the attributes, starting with a space.

Use like this:

`<footer<?= $attribute_list; ?></footer>`

& it will give you this:

`<footer class="footer" id="main-footer"></footer>`

An optional 2nd argument allows you to give the object a whitelist o’ attribute keys, for an easy way to limit what attributes can be included:

````
$attribute_list = new HTMLAttributeList
(
    [
        'class' => 'footer',
        'id' => 'main-footer',
        'talk' => 'blah',
        'name' => 'jack'
    ],
    [
        'class',
        'id'
    ]
);
````

This will ignore the attributes ‘talk’ & ‘name’, giving the same HTML output as the last example.

Thus for any code that generates certain HTML tags, you can easily make a whitelist o’ valid attributes for that tag to apply to user-given attributes lists.

## Changelog

### 1.2.0
* Add methods for changing attribute values.

### 1.1.0
* Add method for getting hash map o' attribute keys & values.

### 1.0.0
* Initial stable version.
