# Icomoon Awesome
Convert the `style.css` file from an Icomoon zip package in to a set of LESS files based on Font Awesome.
### Installation
Install the latest Font Awesome package.
```bash
composer install
```
### Usage
* Navigate to the index file.
* Select your Icomoon `style.css` from the file input.
* Click convert.
### LESS
The converter will create a zip package with a the Font Awesome LESS files in an output directory. You will also be prompted for a download of the zip package.

Use the LESS files in your project by dropping them in a directory (icomoon for example). Create the following import statement in your LESS file.
```less
@import "[YOUR_DIRECTORY]/icomoon";
```
Everything will work like you are used to with Font Awesome, including all the modifiers (animation, transform, etc.). A few things are changed though.
* The CSS prefix is `im` instead of `fa`. You can always change this manually to taste.
* The base font size is `16px` instead of `14px`, because Icomoon works at 16px by default. If your specific font has another base value, you can change that manually in the LESS file or overwrite it in an external variables file.
* The font import doesn't include `woff2`, because Icomoon doesn't support that.
