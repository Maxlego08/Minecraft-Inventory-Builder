# Minecraft Inventory Builder

Site for the zMenu plugin. The site will include a marketplace, an online inventory editor, and why not create a forum ?

Test site here: https://preprod.minecraft-inventory-builder.com/

## ToDo

Thing to develop to open the site

* [ ] Page to display a full update, currently there is only a preview of the update
* [ ] Added other pages for the creator dashboard (discord and gift)
* [ ] Check that each text is present in a translation file
* [ ] Adds all administration pages to manage the site
* [ ] Add role purchase
* [ ] Changing the home page
* [ ] Addition of static pages (terms, conditions etc.)
* [ ] Improve the user page. Add more information, change the style to have a few more complete things

# How do I contribute?

The site is developed with laravel, so you must have knowledge in Laravel, php, html and scss.<br>
To contribute you just need to clone the project, make your changes and create a pull request. You must always do your merge on the <b>develop branch !</b>

To install the Laravel app I advise you to use https://laravel.com/docs/10.x/homestead

Don’t forget to make the orders to install everything:
* ``composer install`` install php dependencies
* ``npm install`` install js dependencies
* ``npm run build`` create the css files
* ``php artisan storage:link`` create file link between storage and public

# .env

Content to add in your . env
````dotenv
TOKEN_NAME="API RESOURCE"
ABILITY_RESOURCE="resources:list"
VERSION="beta-0.1"

VITE_URL_ASSET=http://mib.test/
VITE_URL_API_IMAGE=http://mib.test/storage/images/
VITE_URL_UPLOAD_IMAGE=http://mib.test/profile/images/store

DISCORD_CLIENT_ID=<your discord client ID>
DISCORD_CLIENT_SECRET=<your discord client SECRET>
````
