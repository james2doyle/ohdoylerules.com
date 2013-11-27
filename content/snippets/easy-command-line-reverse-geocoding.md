/*
Title: Easy Command Line Reverse Geocoding
Description: Easily reverse geocode an address using the command line and the google maps API
Date: 2013-11-27
Category: Snippets,Web
Template: post
Keywords: reverse, geocode, command, line, cli, terminal, json, google, maps
*/

Using this function you can easily reverse geocode an address into a *lat and lang* position. This uses the [jq executable](http://stedolan.github.io/jq/) and the [Google Maps API](https://developers.google.com/maps/documentation/geocoding/#GeocodingRequests).

#### Requirements

This little snippet [requires jq to be installed](http://stedolan.github.io/jq/). It is very easy to install.

From the site:

> jq is a lightweight and flexible command-line JSON processor

It is multi-platform, so no worries for Windows users.

Here is the meat:

#### Function

```shell
function reverse-geocode() {
  # replace spaces with + signs
  STRING=$(echo $1 | tr ' ' '+')
  # save results
  CURLED=$(curl "http://maps.googleapis.com/maps/api/geocode/json?address=$STRING&sensor=true")
  # save lat and lng
  LANG=$(echo $CURLED | jq '.results[0].geometry.location.lng')
  LAT=$(echo $CURLED | jq '.results[0].geometry.location.lat')
  # echo them out
  echo "Lat: $LAT, Lang: $LANG"
}
```

#### Usage:

    reverse-geocode "998 Oxford Street E, London ON, N5Y 3K7"

This return the curl results as well as the Lat and Lang output for the location.
