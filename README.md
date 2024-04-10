# Minecraft Inventory Builder

Site for the zMenu plugin. The site will include a marketplace, an online inventory editor, and why not create a forum ?

Test site here: https://preprod.minecraft-inventory-builder.com/

## ToDo

Thing to develop to open the site

* [ ] Page to display a full update, currently there is only a preview of the update
* [ ] Added other pages for the creator dashboard (discord and gift)
* [ ] Check that each text is present in a translation file
* [ ] Adds all administration pages to manage the site
* [x] Add role purchase
* [ ] Improve the homepage by adding images and video. Improve the texts.
* [ ] Addition of static pages (terms, conditions etc.)
* [ ] Improve the user page. Add more information, change the style to have a few more complete things
* [ ] Management of users who will create a dispute or be refunded a payment (remove access)
* [ ] Add an AD system. A div will be displayed with a cross to delete the message, and the display information will be stored in a table. So when the player clicks to delete the ad, it will be deleted and added to the database.
* [ ] Add a full log system on review, review response, and resource update changes
* [x] Add a system to allow you to close your private messages.
* [x] Add a system to automatically reply to the first message sent in private message
* [ ] Add configuration of itemstacks and buttons
* [ ] Add the possibility to create an addon from a resource
* [ ] Add the ability to create buttons for the addon
* [ ] Create a table "configuration button" with the name of the item to configure, the type of value it wants (string, int, boolean, double, list)
* [ ] Create the code to configure the buttons according to their configuration type
* [ ] Create the code to generate the YAML according to each type of button
* [ ] Add next to each configuration item one? , when the user will hover or click on the? This will display more information about this configuration item.
* [ ] Add paypal payments. The configuration is already done but the PaymentManager of Paypal not.
* [ ] Sort materials by % of uses (similar to an AI of autocompletion)
* [ ] Be able to duplicate an item (you often use the same lore...)
* [ ] Auto Completions of placeholders (PAPI)
* [ ] Mistletoe presets for the glass
* [ ] Added a way to have a tutorial on how to use the builder
* [x] Be able to move in the inventory with the directional keys
* [x] Ability to navigate between multiple pages
* [ ] To be able to put your inventory in public, unregistered and private. If the inventory is public it will be listed on the public inventory page. If it is not listed it will be accessible only from a link.

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
PAYMENT_INFO_ADMIN_ID=1
CURRENCY_ADMIN_ID=1
ADMIN_DISCORD_ID=1
STRIPE_ENDPOINT_SECRET=""
ZMENUPLUS_RESOURCE_ID=1

TOKEN_NAME="API RESOURCE"
ABILITY_RESOURCE="resources:list"
VERSION="beta-0.1"

VITE_APP_ENV=local
VITE_REACT_APP_API_URL=http://mib.test/builder/api
VITE_URL_ASSET=http://mib.test/
VITE_URL_API_IMAGE=http://mib.test/storage/images/
VITE_URL_UPLOAD_IMAGE=http://mib.test/profile/images/store

DISCORD_CLIENT_ID=<your discord client ID>
DISCORD_CLIENT_SECRET=<your discord client SECRET>
````

# Inventory Builder

The inventory editor is developed with React. You will find the rendered.json file in storage/app/ with all the item information of each minecraft version. If you find an error on the file do not hesitate to make an issue or a PR 
