# <img title='logo' width='300' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/georide_icon.png?raw=true'/>
It's a plug-in for Jeedom domotic that allow to exploit GeoRide API with the informations of your tracker (location, locked, in
movement, odometer, ...), but he provide too, the actions like lock and unlock your tracker with a widget on your dashboard or with a scenario.
## Prerequisite


- Tracker and account on [GeoRide](https://georide.fr/)

- Jeedom Server with WAN connection


## Getting Started

For deploy this plug-in :

Step 1: Rename your directory "GeoRide-Jeedom" to "georide" in lower case !

Step 2: Copy it in your "plugins" directory on your jeedom server.

Step 3: Enable the GeoRide plugin.

### Prerequisites

Jeedom 3.2 or 4

### Installing

In your menu navigate in Plugins > Security > GeoRide

<img title='menu' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/navigate.png?raw=true'/>

In "Configuration", you can set your email and password to get your authentication key. Your email and password will be not save. They are just
used to get information.

Uncheck/check the cycle (cron) of refresh for your informations on trackers.

<img title='configuration' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/configuration.PNG?raw=true'/>

After get and fill your authentication key you can save your configuration.

Enabled one or many CRON in your plugin for automatic get information from your tracker.

**! IMPORTANT ! If you change the authentication key you must refresh entierely your page (F5).**

Now, you can return to home page of GeoRide and add a equipment (tracker).

<img title='equipment' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/equip.PNG?raw=true'/>


For her configuration, you must enable and set her tracker id, you can get all tracker of your account with the button below, click on
the tracker that you need and save it.

If necessary you can change your wan domain/ip by the local alternative.

For use GeoLoc plugin with GeoRide you can specified your link in the field, he allow to update the location about your tracker. If you
do not use GeoLock, do not fill this field.
## Note

 ! The lock and unlock command are not available on GeoRide V3. !

## Demo

<img title='widget' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/widget.PNG?raw=true'/>
<img title='commands' src='https://github.com/ImoucheG/GeoRide-Jeedom/blob/master/assets/comand.PNG?raw=true'/>


## Contributing

[GeoRide](https://georide.fr/)

[Geoloc](https://jeedom.github.io/plugin-geoloc/fr_FR/)

## Version

1.1.0

## Authors

* ImoucheG - Initial work - [GitHub](https://github.com/ImoucheG)

## Contributors

* [Sigri44](https://github.com/Sigri44) 
